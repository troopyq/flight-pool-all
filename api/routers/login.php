<?php


// Роутер
function route($method, $urlData, $formData) {
  
  // POST /register
  if ($method === 'POST' && empty($urlData)) {

    session_start();
    require_once './connect_db.php';
    require_once './functions/response.php';


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
            $errors["error"]["code"] = 401;
            $errors["error"]["messages"] = "Unauthorized";
            $errors["error"]["errors"]["password"] = "password incorrect";

            response(401, $errors);
            exit();
          }

          $token = $user["api_token"];

          // setcookie('token', $token, strtotime("+30 days"));
          // $_SESSION['user'] = $user;
          // $_SESSION['token'] = $token;
          
          $response = [
            "data" => [
              "message" => "success",
              "token" => $token,
            ],
          ];

          response(200, $response);
          

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


      

    return;
  }

  // Возвращаем ошибку
  response(422, ["errors" => ["ощибка метода"]]);

}





