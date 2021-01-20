<?php 
// ответить клиенту
function response($code = 200, $response = null){
  http_response_code($code);
  if (isset($response)){
    $res = json_encode($response, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_NUMERIC_CHECK);
    echo $res;
  }
}
//проверяет на наличие записей в бд
//получаем запрос от mysqli и возвращаем массив, где первый элемент это данные запроса
function isAvialable($response){
  if (mysqli_num_rows($response) > 0) {
    $res = mysqli_fetch_all($response, MYSQLI_ASSOC);
    
    return [$res, true];
  } else {
    return [[], false];
  }
}

