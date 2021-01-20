<?php

// Роутер
function route($method, $urlData, $formData) {
  // POST /register
  if ($method === 'GET') {

  require_once './functions/response.php';
  require_once './connect_db.php';
  

  $user = getUserDataByToken();
  
  if ($urlData[0] == 'booking'){
    $booking = getUserBooking($user);

  }

  
  

    
  
  

    return;
  }

  // Возвращаем ошибку
  response(422, ["errors" => ["ошибка метода"]]);

}

function getUserBooking($user){
  $db = db();

  $res = [
    'data' => [
      'items' => []
    ]
    ];

  $document_number = $user['document_number'];

  $check_pass = mysqli_query($db, "SELECT * FROM `passengers` WHERE `document_number` = '$document_number'");

  $check_pass = isAvialable($check_pass);
  $pass = $check_pass[0];
  if ($check_pass[1]){

    foreach ($pass as $p => $p_data){
      $booking_id = $p_data['booking_id'];
      $check_booking = mysqli_query($db, "SELECT * FROM `bookings` WHERE `id` = '$booking_id'");

      $check_booking = isAvialable($check_booking);
      $booking = $check_booking[0];

      
      foreach ($booking as $b => $b_data){
        $item = $b_data;
        unset($item["created_at"]);
        unset($item["updated_at"]);

        $booking_id2 = $b_data['id'];
        $check_booking2 = mysqli_query($db, "SELECT * FROM `passengers` WHERE `booking_id` = '$booking_id2'");
  
        $check_booking2 = isAvialable($check_booking2);
        $booking2 = $check_booking2[0];

        foreach ($booking2 as $bp => $bp_data){
          unset($bp_data["created_at"]);
          unset($bp_data["updated_at"]);
          $item['passengers'][] = $bp_data;
        }

        array_push($res['data']['items'], $item);

      }

    }
    response(200, $res);
    /*
    *TODO:
    1. ОСТАВИТЬ ИЗ B_DATA ТОЛЬКО CODE БРОНИРОВАНИЯ, ОСТАЛЬНОЕ НАДО ВОССОЗДАТЬ
    2. УБРАТЬ ИЗ ITEM ID, А ИЗ PASSENGERS BOOKING_ID
    */
  }

  
}


function getUserDataByToken(){
  $db = db();

  $headers = getallheaders()['Authorization'] ?? getallheaders()['authorization'];
  $token = explode(' ', $headers)[1];
  
  $check_user = mysqli_query($db, "SELECT * FROM `users` WHERE `api_token` = '$token'");
  if (mysqli_num_rows($check_user) > 0) {
    $user = mysqli_fetch_assoc($check_user);
    
    $response = [
      "first_name" => $user["first_name"],
      "last_name" => $user["last_name"],
      "phone" => $user["phone"],
      "document_number" => $user["document_number"],
    ];

    response(200, $response);
    
    return $response;

    exit();
    
  } else {
    $errors["error"]["code"] = 401;
    $errors["error"]["messages"] = "Unauthorized";
    $errors["error"]["errors"]["token"] = "token incorrect";
    
    response(401, $errors);
    exit();
  }
}