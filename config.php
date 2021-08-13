<?php

// Start Connection To DataBase

# Connection Variables

$host = 'localhost';
$user = 'root';
$pass = '';
$dbname = 'instafollowers';

# Conn

@$conn = mysqli_connect($host, $user, $pass, $dbname);

if (!$conn) {
  echo 'Connection Faild Cause -> ' . mysqli_connect_error();
}
