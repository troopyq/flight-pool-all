<?php 
// необходимые HTTP-заголовки 
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

require_once './functions/response.php';

// Определяем метод запроса
$method = $_SERVER['REQUEST_METHOD'];
// Получаем данные из тела запроса
$formData = getFormData($method);

// Разбираем url
$url = (isset($_GET['q'])) ? $_GET['q'] : '';
$url = rtrim($url, '/');
$urls = explode('/', $url);

// Определяем роутер и url data
$router = $urls[0];
$urlData = array_slice($urls, 1);

if (!empty($router)){
  
  // Подключаем файл-роутер и запускаем главную функцию
  try {
    // init bootstrapping phase
    $config_file_path = 'routers/' . $router . '.php';
 
    if (!file_exists($config_file_path))
    {
      throw new Exception("Configuration file not found.");
    }
    
    include_once 'routers/' . $router . '.php';
    route($method, $urlData, $formData); 
    // continue execution of the bootstrapping phase
} catch (Exception $e) {
    header("Content-Type: text/html");
    echo "<div style='display:flex;justify-content:center;align-items:center;flex-direction:column;width:100%;height:100%;'>
          <h1><strong>404 Error</strong></h1><br>" . $e->getMessage() . "</div>";
    die();
  }
}

// Получение данных из тела запроса
function getFormData($method) {
 
  // GET или POST: данные возвращаем как есть
  if ($method === 'GET') return $_GET;
  if ($method === 'POST') return $_POST;

  // PUT, PATCH или DELETE
  $data = array();
  $exploded = explode('&', file_get_contents('php://input'));

  foreach($exploded as $pair) {
      $item = explode('=', $pair);
      if (count($item) == 2) {
          $data[urldecode($item[0])] = urldecode($item[1]);
      }
  }

  return $data;
}