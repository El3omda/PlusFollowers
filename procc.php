<?php
session_start();
require_once 'config.php';

// echo "<pre>";
// print_r($_SESSION);
// echo "</pre>";

$InstaUser = $_SESSION['InstaUser'];

$scrape = file_get_contents("https://privatephotoviewer.com/usr/" . $InstaUser);
// To Get User Follows

$StartscrapeFollows = explode('<span id="following">', $scrape);
$endscrapePoFollows = explode('</span><span>Following</span>', $StartscrapeFollows[1]);
$CFollows = $endscrapePoFollows[0];
$OFollows = $_SESSION['follows'];

// To Get User Followers

$StartscrapeFollowers = explode('<span class="followerCount">', $scrape);
$endscrapePoFollowers = explode('</span><span>Followers</span>', $StartscrapeFollowers[1]);

$CFollowers = $endscrapePoFollowers[0];

if (((int)$CFollows - (int)$OFollows) == 1) {
  // Update User Followers And Follows
  $sqlUpdateFoll = "UPDATE users SET Followers = '$CFollowers', Follows = '$CFollows' WHERE InstaUser = '$InstaUser'";
  mysqli_query($conn, $sqlUpdateFoll);

  // Get Old Coins

  $sqlGetOldC = "SELECT * FROM users WHERE InstaUser = '$InstaUser'";
  $resultOC = mysqli_query($conn, $sqlGetOldC);
  $rowOC = $resultOC->fetch_assoc();
  $oldCoin = $rowOC['Coins'];
  $newCoin = (int)$oldCoin + 5;

  // Update Coin

  $sqlUpdateC = "UPDATE users SET Coins = '$newCoin' WHERE InstaUser = '$InstaUser'";
  if (mysqli_query($conn, $sqlUpdateC)) {
    $_SESSION['msg'] = "تم اضافة 5 نقاط";
  } else {
    $_SESSION['msg'] = "لم تقم بالمطلوب";
  }
} else {
  $_SESSION['msg'] = "لم تقم بالمطلوب";
}


header("Refresh:1;url=dashboard.php");

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>تتم معالجة الطلب . . .</title>
  <link rel="stylesheet" href="css/sign.css">
</head>

<body>
  <div class="sign-out">

    <div class="logo">
      <span class="letter">P</span>lus<span class="letter">F</span>ollowers
    </div>

    <p> . . . تتم معالجة الطلب</p>

  </div>
</body>

</html>