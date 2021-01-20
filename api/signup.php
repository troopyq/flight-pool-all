<?php
header('Content-Type: application/json');

require_once('./connect_db.php');
require_once './functions/response';


$POST = json_decode(file_get_contents('php://input'), TRUE);


if (isset($POST)) {

  $first_name = trim(htmlspecialchars($POST['first_name']));
  $last_name = trim(htmlspecialchars($POST['last_name']));
  $phone = trim(htmlspecialchars($POST['phone']));
  $password = trim(htmlspecialchars($POST['password']));
  $repeat_password = trim(htmlspecialchars($POST['repeat_password']));
  $document_number = trim(htmlspecialchars($POST['document_number']));
  // setcookie('test', $phone, time() + 4323042);
  $errors = [
    "error" => [
      "code" => 422,
      "message" => "Validation error",
      "errors" => [
        
      ],
    ],
  ];

  if ($first_name !== '' && $last_name !== '' && $password !== '' && $document_number !== '' && $phone !== '') {
    
    if (strlen($document_number) !== 10) {

      $errors["error"]["errors"]["document_number"] = "Неверный номер паспорта";
      response(422, $errors);
      exit();
      
    } elseif ($password !== $repeat_password) {
      
      $errors["error"]["errors"]["repeat_password"] = "Повторный пароль невереный";
      response(422, $errors);
      exit();
      
    }
    
    //проверяем наличие такого номера и паспорта в базе
    $check_users = mysqli_query($db, "SELECT * FROM `users` WHERE `phone` = '$phone' OR `document_number` = '$document_number'");
    
    if (mysqli_num_rows($check_users) > 0) {

      $errors["error"]["errors"]["phone"] = "Такой пользователь существует";
      response(422, $errors);
      exit();
      
    }
    
    $password = password_hash($password, PASSWORD_DEFAULT);
    $token = md5($phone . $document_number . $password);
    //добавляем в базу нового юзера
    
    mysqli_query(
      $db,
      "INSERT INTO `users` ( `first_name`, `last_name`, `phone`, `password`, `document_number`, `api_token`)
    VALUES ('$first_name', '$last_name', '$phone', '$password', '$document_number', '$token') "
    );
    
    
    $response = [
      "data" => [
        "message" => "Registration succes",
        "token" => $token,
      ],
    ];
    
    setcookie('token', $token, strtotime("+30 days"));

    response(200, $response);

  }
} else {
  $errors = [
    "error" => [
      "code" => 422,
      "message" => "Fields empty",
      "errors" => [
        "validation" => [],
        ""
      ],
    ],
  ];

  response(422, $errors);

  exit();
}
