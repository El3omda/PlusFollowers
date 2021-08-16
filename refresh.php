<?php

require_once 'config.php';


// Sql Update Total Followers

session_start();

$InstaUser = $_SESSION['InstaUser'];
$followers = $_SESSION['followers'];
$sqlUpdateFollowers = "UPDATE orders SET NewFollowers = '$followers' WHERE OrderOwner = '$InstaUser'";
mysqli_query($conn, $sqlUpdateFollowers);


// Get old Followers Count

$sqlGetOldFollowers = "SELECT * FROM orders WHERE OrderOwner = '$InstaUser'";
$resultOldFollowers = mysqli_query($conn, $sqlGetOldFollowers);
$rowOldFollowers = $resultOldFollowers->fetch_assoc();

$oldfollowers = $rowOldFollowers['OldFollowers'];

// Get New Followers Count

$newfollowers = $rowOldFollowers['NewFollowers'];

// Get Requests Followers

$rfollowers = $rowOldFollowers['RFollowers'];

// Calculate Current Followers

$cfollowers = (int)$newfollowers - (int)$oldfollowers;

// Update Curennt Followers

$sqlUpdateCF = "UPDATE orders SET CFollowers = '$cfollowers' WHERE OrderOwner = '$InstaUser'";
mysqli_query($conn, $sqlUpdateCF);

// Change Order Status If Finished

if ($cfollowers == $rfollowers) {
  $sqlUpdateStatus = "UPDATE orders SET OrderStatus = 'Success' WHERE OrderOwner = '$InstaUser'";
  mysqli_query($conn, $sqlUpdateStatus);
}

header("Location:Shop.php?su");
