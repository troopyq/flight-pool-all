<?php


// Роутер
function route($method, $urlData, $formData) {
  
  // POST /register
  if ($method === 'GET' || $method === 'POST' && empty($urlData)) {

    include_once './functions/response.php';

    session_start();
    unset($_SESSION['user']);
    session_destroy();
    // unset($_COOKIE['token']);
    // setcookie('token', null, -1, '/');

    response(200, ["data" => ["message" => "Logout"]]);

    // header('Location: /index.html');
    
    
    return;
  }

  // Возвращаем ошибку
  response(422, ["errors" => ["ощибка метода"]]);

}





