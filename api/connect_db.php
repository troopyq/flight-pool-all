<?php

$db = mysqli_connect('localhost', 'root', 'root', 'test');

function db(){
  $db = mysqli_connect('localhost', 'root', 'root', 'test');
  return $db;
}
