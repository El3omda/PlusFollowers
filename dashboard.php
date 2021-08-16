<?php

require_once 'config.php';

// Start Grabing Instegram By Insta User

session_start();

$InstaUser = $_SESSION['InstaUser'];

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
$_SESSION['followers'] = $followers = $endscrapePoFollowers[0];
// To Get User Follows

$StartscrapeFollows = explode('<span id="following">', $scrape);
$endscrapePoFollows = explode('</span><span>Following</span>', $StartscrapeFollows[1]);
$_SESSION['follows'] = $follows = $endscrapePoFollows[0];


// Gain Coins 

// Get User To Follow Account Details

# Get Data From Database

$sqlGetUserOrders = "SELECT * FROM orders WHERE OrderOwner != '$InstaUser'";
$resultGet = mysqli_query($conn, $sqlGetUserOrders);


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

  <div style="top: 14%;" class="screen">
    <i class="fa fa-times"></i>
    <span><?php echo @$_SESSION['msg'] ?></span>
  </div>
  <!-- Start Main Content -->

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

  <div class="seperator">

  </div>

  <!-- Start Gain Coins -->

  <div class="gain-coins">
    <p class="head">تابع الاخرون لتحصل علي النقاط</p>

    <?php


    if ($resultGet->num_rows > 0) {

      while ($rowGetCoin = $resultGet->fetch_assoc()) {


        // To Get Proile Image

        $scrape1 = file_get_contents("https://privatephotoviewer.com/usr/" . $rowGetCoin['OrderOwner']);
        $startscrap1 = explode('<img src=', $scrape1);
        $endscrapPhoto1 = explode(' style=>', $startscrap1[1]);

        // To Get Profile Name

        $StartscrapeName1 = explode('<h1 id="userfullname" style="margin-bottom: 0; font-size: 22px; font-weight: 600;">', $scrape1);
        $endscrapeName1 = explode('</h1>', $StartscrapeName1[1]);


        echo '
        <div class="follow-box">
        <div class="u-datails">
        <div class="image">
         
        </div>
        <div class="name">' . $endscrapeName1[0] . '</div>
      </div>
      <div class="action">
        <button class="follow" data-url="https://www.instagram.com/' . $rowGetCoin['OrderOwner'] . '">متابعة</button>
        <button class="skip" data-id="' . $rowGetCoin['ID'] . '">تخطي</button>
      </div>
        </div>
        ';
      }
    } else {
      echo '<p class="head">لا يوجد حسابات في الوقت الحالي</p>';
    }


    ?>
    <p style="margin-top: 300px;display:none;" class="head" id="show">
      عرض الحسابات المتخطاة
      <br>
      <button class="clear">اضغط هنا</button>
    </p>
  </div>

  <!-- End Gain Coins -->

  <!-- Include Footer -->

  <?php include 'footer.php'; ?>

  <script>
    var skip = document.querySelectorAll(".follow-box .skip");
    var follow = document.querySelectorAll(".follow-box .follow");
    var skiped = [];
    var followed = [];
    localStorage.setItem('test', '0');

    skip.forEach(function(el) {
      el.addEventListener("click", function() {
        el.parentElement.parentElement.style.display = "none";
        var id = el.dataset.id;
        skiped.push(id);
        localStorage.setItem("skiped", JSON.stringify(skiped));
      })
    })
    var skipedids = JSON.parse(localStorage.skiped);
    var clearLocal = document.querySelector("#show button");

    if (skipedids.length != 0) {
      var butnClear = document.querySelector("#show");
      butnClear.style.display = "block";

      for (var i = 0; i < skipedids.length; i++) {
        // console.log(skipedids[i])
        skip.forEach(function(skipel) {
          var idNum = skipel.dataset.id;
          if (idNum == skipedids[i]) {
            skipel.parentElement.parentElement.style.display = "none"
          }
        })
      }

      clearLocal.onclick = function() {
        localStorage.clear();
        localStorage.setItem('test', '0');
        window.location.reload();
      }
    }

    follow.forEach(function(el1) {
      el1.addEventListener("click", function() {
        var userlink = el1.dataset.url;
        var win = window.open(
          userlink,
          '_blank',
          'toolbar=0,scrollbars=0,resizable=0,top=100,left=300,width=400,height=400',
        )
        setTimeout(function() {
          window.location.replace("http://localhost/GitHub/PlusFollowers/procc.php")
        }, 5000);
      })
    })
    var screen = document.querySelector('.screen');
    var screenSpan = document.querySelector('.screen span');
    var screenClose = document.querySelector('.screen i');

    if (screenSpan.innerHTML == "لم تقم بالمطلوب") {
      screen.classList.add('faild');
      screen.style.display = 'block';
    } else if (screenSpan.innerHTML == "تم اضافة 5 نقاط") {
      screen.classList.add('success');
      screen.style.display = 'block';
    } else {
      screen.style.display = 'none';
    }

    screenClose.onclick = function() {
      screen.style.display = 'none';
    }
    // Start Skiped Control
  </script>
</body>

</html>