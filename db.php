<?php

$host="localhost";
$username="root";
$password="";
$database="database";

$conn=mysqli_connect($host, $username, $password, $database);

if(!$conn)
{
  echo "Connection Failed";
}
?>