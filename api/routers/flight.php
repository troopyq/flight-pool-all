<?php

// Роутер
function route($method, $urlData, $formData) {
  require_once './functions/response.php';
  require_once './connect_db.php';
  
  // GET /flight
  if ($method === 'GET') {


    $err = [
      "error" => [
        "code" => 422,
        "message" => "Validation error",
        "errors" => [
    
        ]
      ]
        ];
    
    if (isset($_GET) && isset($_GET["from"]) && isset($_GET["to"]) && isset($_GET["date1"]) && isset($_GET["passengers"])){
      
    
      $query = $_GET;
      
      $from = $query['from'];
      $to = $query['to'];
      $date1 = $query['date1'];
      $date2 = $query['date2'];
      $passengers = (int) $query['passengers'];
    
      if (!isset($date1)){
        $date1 = date("Y-m-d");  
      }
    
      if (!isset($from)){
        $err["error"]["errors"] += [
          "from" => "Invalid from",
        ];
        response(422, $err);
      } elseif (!isset($to)){
        $err["error"]["errors"] += [
          "to" => "Invalid to",
        ];
        response(422, $err);
      } elseif (!isset($date1)){
        $err["error"]["errors"] += [
          "date1" => "Invalid date1",
        ];
        response(422, $err);
      }elseif (!($passengers >= 1 && $passengers <= 8)){
        $err["error"]["errors"] += [
          "passenger" => "Invalid amount passengers",
        ];
        response(422, $err);
      }
    
      if (isset($date2)){
        // var_dump($db);
        $back_check = mysqli_query($db, 
        "SELECT `flights`.`id` as f_id,
                        `flight_code`,
                        `from`.`city` as from_city,
                        `from`.`name` as from_name,
                        `from`.`iata` as from_iata,
                        `to`.`city` as to_city,
                        `to`.`name` as to_name,
                        `to`.`iata` as to_iata,
                        `time_from`,
                        `time_to`,
                        `cost`
                FROM flights
                  INNER JOIN airports as `from` on from_id = `from`.`id`
                   
                  INNER JOIN airports as `to` on to_id = `to`.`id`
                  WHERE
                  (`from`.`city` LIKE '%".$to."%'
                   OR
                  `from`.`name` LIKE '%".$to."%'
                   OR
                  `from`.`iata` LIKE '%".$to."%')
                   AND
                  (`to`.`city` LIKE '%".$from."%'
                   OR
                 `to`.`name` LIKE '%".$from."%'
                   OR
                  `to`.`iata` LIKE '%".$from."%')");
      }
       
      $search_check = mysqli_query($db, 
      "SELECT `flights`.`id` as f_id,
                      `flight_code`,
                      `from`.`city` as from_city,
                      `from`.`name` as from_name,
                      `from`.`iata` as from_iata,
                      `to`.`city` as to_city,
                      `to`.`name` as to_name,
                      `to`.`iata` as to_iata,
                      `time_from`,
                      `time_to`,
                      `cost`
              FROM flights
                INNER JOIN airports as `from` on from_id = `from`.`id`
                 
                INNER JOIN airports as `to` on to_id = `to`.`id`
                WHERE
                (`from`.`city` LIKE '%".$from."%'
                 OR
                `from`.`name` LIKE '%".$from."%'
                 OR
                `from`.`iata` LIKE '%".$from."%')
                 AND
                (`to`.`city` LIKE '%".$to."%'
                 OR
               `to`.`name` LIKE '%".$to."%'
                 OR
                `to`.`iata` LIKE '%".$to."%')
      ");
      
    
      if (mysqli_num_rows($search_check) > 0){
        $search = mysqli_fetch_all($search_check, MYSQLI_ASSOC);
        $response = [];
        
        $response = addResponse($search, $response, 'to', $date1, $from, $to, $passengers);
        
        if (isset($back_check) && mysqli_num_rows($back_check) > 0){
          $back = mysqli_fetch_all($back_check, MYSQLI_ASSOC);
          $response = addResponse($back, $response, 'back', $date2, $from, $to, $passengers);
        }
        response(200, $response);
      }
    
    } else { //если в $_GET ничего нет
      $err["error"]["errors"] += [
        "from" => "Empty",
        "to" => "Empty",
        "date1" => "Empty",
        "passenger" => "Empty",
      ];
    
      response(422, $err);
    }



    
    return;
  }

  // Возвращаем ошибку
  response(422, ["errors" => ["ощибка метода"]]);

}

function addResponse($array, $res, $where_to, $date, $from, $to, $pass_amount){
  // global $db;
  $db = db();

  $free_check = mysqli_query($db,
    "SELECT
      `from`.`flight_code` as `flight_from`,
      `from`.`flight_code` as `flight_back`,
      `bookings`.`date_from` as `date_from`,
      `bookings`.`date_back` as `date_back`
     FROM `bookings`
     INNER JOIN `flights` as `from` on `bookings`.`flight_from` = `from`.`id`
     INNER JOIN `flights` as `back` on `bookings`.`flight_back` = `back`.`id`
    ");

  $free = mysqli_fetch_all($free_check, MYSQLI_ASSOC);

  foreach ($array as $obj){
    $arr = []; 
    foreach ($obj as $key => $value) {
      switch ($key) {
        case 'from_city':
          $arr["from"]["city"] = $value;
          break;
        case 'from_name':
          $arr["from"]["airport"] = $value;
          break;
        case 'from_iata':
          $arr["from"]["iata"] = $value;
          break;
        case 'time_from':
          $arr["from"]["date"] = $date;
          $arr["from"]["time"] = $value;
          break;
  
        case 'to_city':
          $arr["to"]["city"] = $value;
          break;
        case 'to_name':
          $arr["to"]["airport"] = $value;
          break;
        case 'to_iata':
          $arr["to"]["iata"] = $value;
          break;
        case 'time_to':
          $arr["to"]["date"] = $date;
          $arr["to"]["time"] = $value;
          break;
        
        default:
          $arr[$key] = $value;
          break;
      }
  }
  
  $availability = 56;
  if ($where_to == 'to'){
    foreach ($free as $obj) {
      foreach ($obj as $key => $val) {
        if (($key == "flight_from" && $val == $arr["flight_code"]) 
              &&
            ($obj["date_from"] == $date)) {
            --$availability;
        }   
      }
    }
   
    if ($availability >= $pass_amount){
      $arr["availability"] = $availability;
      $res["data"]["flights_to"][] = $arr;
    } else {
      $res["data"]["flights_to"] = [];
    }

  } elseif ($where_to == 'back'){
    foreach ($free as $obj) {
      foreach ($obj as $key => $val) {
        if (($key == "flight_back" && $val == $arr["flight_code"]) 
              &&
            ($obj["date_back"] == $date)) {
            --$availability;
        }   
      }
    }

    if ($availability >= $pass_amount){
      $arr["availability"] = $availability;
      $res["data"]["flights_back"][] = $arr;
    } else {
      $res["data"]["flights_back"] = [];
    }
  }

}
return $res;
}



