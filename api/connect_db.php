<?php

$db = mysqli_connect('localhost', 'root', 'root', 'a0490169_dima');

function db(){
  $db = mysqli_connect('localhost', 'root', 'root', 'a0490169_dima');
  return $db;
}
