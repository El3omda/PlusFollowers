<?php

require_once 'config.php';

session_start();

$USEREMAil = $_SESSION['UserEmail'];

// Change User Status To OffLine

$sqlOff = "UPDATE users SET Online = 'No' WHERE UserEmail = '$USEREMAil'";
mysqli_query($conn, $sqlOff);

session_destroy();


header("Refresh:3;url=sign-in.php");

if (empty($_SESSION)) {
  header("Location:sign-in.php");
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>يتم تسجيل الخروج ..</title>
  <link rel="stylesheet" href="css/sign.css">
</head>

<body>

  <div class="sign-out">

    <div class="logo">
      <span class="letter">P</span>lus<span class="letter">F</span>ollowers
    </div>

    <p>تم تسجيل خروجك بنجاح</p>

  </div>

</body>

</html>