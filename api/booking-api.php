<?php
require_once './functions/response.php';
header("Content-Type: application/json");
$err = [
  "error" => [
    "code" => 422,
    "message" => "Validation error",
    "errors" => [
    ]
  ]
];

$_POST = json_decode(file_get_contents('php://input'), TRUE);

if (isset($_POST)){
  require_once('./connect_db.php');
  $flight_from = $_POST["flight_from"];
  $flight_back = $_POST["flight_back"];
  $passengers = $_POST["passengers"];

  foreach ($passengers as $obj) {

    foreach ($obj as $key => $value) {
      if (!empty($value)){
        switch ($key) {
          case 'first_name':
            break;
          case 'last_name':
            break;
          case 'birth_date':
            break;
          case 'document_number':
            if (strlen($value) != 10){
              $err["error"]["errors"] += [
                $key => "Invalid value"
              ];
              response(422, $err);
            }
            break;
          default:
            break;
          }
          
      } else{
        $err["error"]["errors"] += [
          $key => "Field empty"
        ];
        
        response(422, $err);
      }
  }
  }

  $availability_from = 56;
  $availability_back = 56;
  $flight_from_id = $flight_from["id"];
  $flight_from_date = $flight_from["date"];
  $flight_back_id = $flight_back["id"];
  $flight_back_date = $flight_back["date"];

  $free_from_check = mysqli_query($db, "SELECT COUNT(id) as `count` FROM bookings
   WHERE flight_from = '$flight_from_id' AND date_from = '$flight_from_date'");
  $free_back_check = mysqli_query($db, "SELECT COUNT(id) as `count` FROM bookings
   WHERE flight_back = '$flight_back_id' AND date_back = '$flight_back_date'");

  if (mysqli_num_rows($free_from_check) > 0){
    $count_from = (int) mysqli_fetch_assoc($free_from_check)['count'];
    $availability_from -= ($count_from + count($passengers));
    if (!($availability_from >= 0)){
      $err["error"]["errors"] += [
        "passengers" => "Not enough space to from"
      ];
      response(422, $err);
    }
    var_dump($availability_from);
  }
  if (mysqli_num_rows($free_back_check) > 0){
    $count_back = (int) mysqli_fetch_assoc($free_back_check)['count'];
    $availability_back -= ($count_back + count($passengers));
    if (!($availability_back >= 0)){
      $err["error"]["errors"] += [
        "passengers" => "Not enough space to back"
      ];
      response(422, $err);
    }
    // var_dump($availability_back);
    
  }

  $chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
  $code = substr(str_shuffle($chars), 0, 5);

  do{
    $code_check = mysqli_query($db, "SELECT code FROM bookings");
    if (mysqli_num_rows($code_check) > 0){
      $code_check = mysqli_fetch_all($code_check, MYSQLI_ASSOC);
      foreach ($code_check as $obj) {
        foreach ($obj as $key => $code_ch) {
          // var_dump($code_ch);
          // var_dump($code);
        }
      }
    }
  } while ($code == $code_ch);

}