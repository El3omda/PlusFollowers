<?php

// Start Grabing Instegram By Insta User

session_start();

$InstaUser = $_SESSION['InstaUser'];


// You Can USe https://www.instagram.com/E.A.A.A.O/?__a=1



// To Get Proile Image

$scrape = file_get_contents("https://privatephotoviewer.com/usr/" . $InstaUser);
$startscrap = explode('<img src=', $scrape);
$endscrapPhoto = explode(' style=>', $startscrap[1]);

// To Get Profile Name

$StartscrapeName = explode('<h1 id="userfullname" style="margin-bottom: 0; font-size: 22px; font-weight: 600;">', $scrape);
$endscrapeName = explode('</h1>', $StartscrapeName[1]);

// To Get Profile USer

$StartscrapeUser = explode('<span id="username">', $scrape);
$endscrapeUser = explode(' </span>', $StartscrapeUser[1]);

// To Get User Posts

$StartscrapePosts = explode('<span id="posttoal">', $scrape);
$endscrapePosts = explode(' </span></div>', $StartscrapePosts[1]);

// To Get User Bio

$StartscrapeBio = explode('<p id="biofull" style="margin-top: 0; margin-bottom: 0; color: #212121;">', $scrape);
$endscrapePoBio = explode('</p>', $StartscrapeBio[1]);

// To Get User Followers

$StartscrapeFollowers = explode('<span class="followerCount">', $scrape);
$endscrapePoFollowers = explode('</span><span>Followers</span>', $StartscrapeFollowers[1]);

// To Get User Follows

$StartscrapeFollows = explode('<span id="following">', $scrape);
$endscrapePoFollows = explode('</span><span>Following</span>', $StartscrapeFollows[1]);


?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>الصفحة الرئيسية</title>
  <link rel="stylesheet" href="css/dashboard.css">
</head>

<body>

  <!-- Include Nav -->

  <?php include 'nav.php'; ?>


  <!-- Start Main Content -->

  <!-- <div class="login-to-insta">
    <button onclick="login();">تسجيل الدخول لحساب الانستا</button>
  </div> -->

  <div class="insta-details">
    <div class="profile-image">
      <img src="<?php echo $endscrapPhoto[0]; ?>" alt="">
    </div>
    <div class="user-details">
      <p class="user"><?php echo $endscrapeUser[0]; ?><span> : المستخدم</span></p>
      <p class="psots"><?php echo $endscrapePosts[0] ?><span> : المنشورات</span></p>
      <p class="name"><?php echo $endscrapeName[0]; ?><span> : الاسم</span></p>
      <p class="bio"><span style="display: block;text-align:right;">البايو : </span><?php echo $endscrapePoBio[0]; ?></p>
      <p class="followers"><?php echo $endscrapePoFollowers[0]; ?><span> : يتابعك</span></p>
      <p class="following"><?php echo $endscrapePoFollows[0]; ?><span> : تتابع</span></p>
    </div>
    <div style="clear: both;"></div>
    <div class="user-control">
      <p class="refferal">
        دعوة الاشخاص للتسجيل للحصول علي 50 نقطة لكل فرد
        <br>
      <p><?php echo $_SERVER['SERVER_NAME'] . "/GitHub/PlusFollowers/sign-up.php?Ref=" . $InstaUser; ?></p>
      </p>
    </div>
  </div>

  <!-- End Main Content -->


  <!-- Include Footer -->

  <?php include 'footer.php'; ?>

  <script src="js/dashboard-main.js"></script>
</body>

</html>