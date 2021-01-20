<?php
session_start();
require_once './connect_db.php';
require_once './functions/response';


header('Content-Type: application/json');

if (isset($_COOKIE['token'])){
  $token = $_COOKIE['token'];
  $check_user = mysqli_query($db, "SELECT * FROM `users` WHERE `api_token` = '$token' ");

  // print_r($check_user);
  if (mysqli_num_rows($check_user) > 0) {
    $user = mysqli_fetch_assoc($check_user);
    $_SESSION['user'] = $user;
    $response = [
      "data" => [
        "message" => "success",
        "token" => $user['api_token'],
      ],
    ];
    response(200, $response);
    exit();
  }
}


$POST = json_decode(file_get_contents('php://input'), TRUE);


if (isset($POST)) {


  $phone = trim(htmlspecialchars($POST['phone']));
  $password = trim(htmlspecialchars($POST['password']));


  $errors = [
    "error" => [
      "code" => 422,
      "message" => "Validation error",
      "errors" => [
        
      ],
    ],
  ];

  if ($password !== '' && $phone !== '') {

    //проверяем наличие такого номера и паспорта в базе
    $check_user = mysqli_query($db, "SELECT * FROM `users` WHERE `phone` = '$phone'");

    if (mysqli_num_rows($check_user) > 0) {
      $user = mysqli_fetch_assoc($check_user);

      if (!password_verify($password, $user['password'])){
        http_response_code(401);
        $errors["error"]["code"] = 401;
        $errors["error"]["messages"] = "Unauthorized";
        $errors["error"]["errors"]["password"] = "password incorrect";
        echo json_encode($errors, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_NUMERIC_CHECK);
        exit();
      }

      $token = $user["api_token"];

      setcookie('token', $token, strtotime("+30 days"));
      $_SESSION['user'] = $user;
      
      $response = [
        "data" => [
          "message" => "success",
          "token" => $token,
        ],
      ];

      response(200, $response)
      
      // echo "<script>location.href = '../frontend/profile.html';</script>";
      // header("Location: /frontend/profile.html", true, 303);
      // echo "<script>window.location = '/frontend/profile.html'</script>";
      exit();
      
    } else {
      $errors["error"]["code"] = 401;
      $errors["error"]["messages"] = "Unauthorized";
      $errors["error"]["errors"]["phone"] = "phone incorrect";
      
      response(401, $errors);
      exit();
    }
    
  
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
