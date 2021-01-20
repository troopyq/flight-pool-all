<?php

// Роутер
function route($method, $urlData, $formData) {
  // POST /user /user/booking
  if ($method === 'GET') {

  require_once './functions/response.php';
  require_once './connect_db.php';
  
  //получаем данные о юзере
  $user = getUserDataByToken();
  
  // если вторым запросом идет бронирование, то выдаем бронирование
  if ($urlData[0] == 'booking'){
    $booking = getUserBooking($user);
    /* FIXME: работает, но в тестовом режиме */
  }

    return;
  }
  // Возвращаем ошибку
  response(422, ["errors" => ["ошибка метода"]]);

}

// получение бронирований
function getUserBooking($user){
  //подключение к базе данных
  $db = db();

  $res = [
    'data' => [
      'items' => []
    ]
    ];

  $document_number = $user['document_number'];
  //ищем пассажиров по паспорту
  $check_pass = mysqli_query($db, "SELECT * FROM `passengers` WHERE `document_number` = '$document_number'");

  $check_pass = isAvialable($check_pass);
  $pass = $check_pass[0];
  if ($check_pass[1]){
    //если пассажир бронировал 1 или несколько мест, перебираем их, и для каждого смотрим его бронирование
    foreach ($pass as $p => $p_data){
      $booking_id = $p_data['booking_id'];
      $check_booking = mysqli_query($db, "SELECT * FROM `bookings` WHERE `id` = '$booking_id'");

      $check_booking = isAvialable($check_booking);
      $booking = $check_booking[0]; //массив бронирований юзера

      //перебираем все брони и ищем какие пассажиры на них забронированы
      foreach ($booking as $b => $b_data){
        $item = $b_data;
        //удаляем лишние данные
        unset($item["created_at"]);
        unset($item["updated_at"]);

        $booking_id2 = $b_data['id'];
        $check_booking2 = mysqli_query($db, "SELECT * FROM `passengers` WHERE `booking_id` = '$booking_id2'");
  
        $check_booking2 = isAvialable($check_booking2);
        $booking2 = $check_booking2[0];
        //перебираем пассажиров и  добавляем к брони
        foreach ($booking2 as $bp => $bp_data){
          //удаляем лишние данные
          unset($bp_data["created_at"]);
          unset($bp_data["updated_at"]);
          //добавляем пассажира к брони
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

//получаем данные юзера по http token
//возвращает объект данных юзера
function getUserDataByToken(){
  $db = db();

  $headers = getallheaders()['Authorization'] ?? getallheaders()['authorization']; // получаем контент авторизации
  $token = explode(' ', $headers)[1]; //получаем сам токен
  
  $check_user = mysqli_query($db, "SELECT * FROM `users` WHERE `api_token` = '$token'");
  if (mysqli_num_rows($check_user) > 0) {
    $user = mysqli_fetch_assoc($check_user);
    
    $response = [
      "first_name" => $user["first_name"],
      "last_name" => $user["last_name"],
      "phone" => $user["phone"],
      "document_number" => $user["document_number"],
    ];
    //отдаем объект данных
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