<?php
header("Content-Type: application/json"); 
require_once './functions/response';
  if (isset($_GET)){
    require_once('connect_db.php');
  
    $query = trim(htmlspecialchars($_GET['query']));

  
    $airports_check = mysqli_query($db, 
    "SELECT `id`,`name`, `iata` FROM `airports` WHERE `city`  LIKE '%". $query ."%'
     OR 
     `name` LIKE '%". $query ."%'
     OR
     `iata` LIKE '%". $query ."%'");
  
    if (mysqli_num_rows($airports_check) > 0){
      $airports = mysqli_fetch_all($airports_check, MYSQLI_ASSOC);
      // echo "<pre>";
      // print_r($airports);
      // echo "</pre>";
      $response = [];
  
      foreach ($airports as $key => $value) {
        $response["data"]["items"][$key] = $value;
      }
      response(200, $response);

    } else {
      $response["data"]["items"] = [];
      response(200, $response);
    }
  
  }
