<?php


// Роутер
function route($method, $urlData, $formData) {
  
  // POST /register
  if ($method === 'GET') {

  require_once './functions/response.php';

  if (isset($_GET)){
    require_once './connect_db.php';
    //получаем запрос на аэропорты
    $query = trim(htmlspecialchars($_GET['query']));

    $airports_check = mysqli_query($db, 
    "SELECT `id`,`name`, `iata` FROM `airports` WHERE `city`  LIKE '%". $query ."%'
     OR 
     `name` LIKE '%". $query ."%'
     OR
     `iata` LIKE '%". $query ."%'");

    // если нашлись, перебираем и отдаем их клиенту
    if (mysqli_num_rows($airports_check) > 0){
      $airports = mysqli_fetch_all($airports_check, MYSQLI_ASSOC);

      $response = [];
  
      foreach ($airports as $key => $value) {
        $response["data"]["items"][$key] = $value;
      }
      response(200, $response);

    } else {
      //если ничего не нашлось
      $response["data"]["items"] = [];
      response(200, $response);
    }
  
  }
    return;
  }

  // Возвращаем ошибку
  response(422, ["errors" => ["ошибка метода"]]);

}





