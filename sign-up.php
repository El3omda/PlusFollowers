<?php

// Call Config

require_once 'config.php';

// Insert Into DataBase

#Get User Data

@$UserName = $_POST['UserName'];
@$UserEmail = $_POST['UserEmail'];
@$UserPass = $_POST['UserPass'];
@$InstaUser = $_POST['InstaUser'];
@$ref = $_REQUEST['Ref'];
# Chech If User Data Is Duplicated

$sqlCheck = "SELECT * FROM users WHERE UserEmail = '$UserEmail' OR InstaUser = '$InstaUser'";
$resultCheck = mysqli_query($conn, $sqlCheck);

if (isset($_POST['submit'])) {
  if (!$resultCheck->num_rows > 0) {
    $sqlInsert = "INSERT INTO users (UserName,UserEmail,UserPass,InstaUser) Value ('$UserName','$UserEmail','$UserPass','$InstaUser')";
    if (mysqli_query($conn, $sqlInsert)) {
      $msg = 'تم تسجيل الحساب بنجاح <a href="sign-in.php">تسجيل الدخول</a>';
    }
    // Add Coins For User Invite Refferal
    if (isset($ref)) {
      $sqlCheckRef = "SELECT InstaUser FROM users WHERE InstaUser = '$ref'";
      $resultCheckRef = mysqli_query($conn, $sqlCheckRef);
      if ($resultCheckRef->num_rows > 0) {
        // Get User Old Coins
        $sqlOLdCoin = "SELECT Coins FROM users WHERE InstaUser = '$ref'";
        $resultOC = mysqli_query($conn, $sqlOLdCoin);
        $rowOC = $resultOC->fetch_assoc();
        $oldCoin = $rowOC['Coins'];
        $newCoins = (int)$oldCoin + 50;

        // Update New Coin

        $sqlUUC = "UPDATE users SET Coins = '$newCoins' WHERE InstaUser = '$ref'";
        mysqli_query($conn, $sqlUUC);
      }
    }
  } else {
    $msg = 'بيانات الحساب مسجلة بالفعل <a href="sign-in.php">تسجيل الدخول</a>';
  }
}



?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>تسجيل حساب جديد</title>
  <link rel="stylesheet" href="css/font-awesome.min.css">
  <link rel="stylesheet" href="css/sign.css">
</head>

<body style="padding-bottom: 100px;">

  <!-- Include Nav -->

  <?php include 'nav.php'; ?>


  <!-- Start Form Sign Up -->

  <div class="container">
    <div class="screen">
      <i class="fa fa-times"></i>
      <span><?php echo @$msg; ?></span>
    </div>
    <div class="form-box">

      <form action="<?php echo $_SERVER['PHP_SELF'] . "?Ref=" . $ref; ?>" method="POST">

        <div class="input-field">
          <label for="UserName">اسم المستخدم</label>
          <input type="text" name="UserName" value="<?php echo $UserName; ?>" id="UserName" placeholder="اكتب اسمك . . . " required autocomplete="off">
        </div>
        <div class="input-field">
          <label for="UserEmail">الايمال</label>
          <input type="email" name="UserEmail" value="<?php echo $UserEmail; ?>" id="UserEmail" placeholder="اكتب ايمالك . . . " required autocomplete="off">
        </div>
        <div class="input-field">
          <label for="UserPass">كلمة المرور</label>
          <input type="password" name="UserPass" value="<?php echo $UserPass; ?>" id="UserPass" placeholder="اكتب كلمة المرور . . ." required autocomplete="off">
        </div>
        <div class="input-field">
          <label for="InstaUser">اسم مستخدم الانستا</label>
          <input type="text" name="InstaUser" value="<?php echo $InstaUser; ?>" id="InstaUser" placeholder="اكتب اليوزر بتاع انستا . . . " required autocomplete="off">
        </div>
        <input type="submit" name="submit" value="تسجيل حساب">
      </form>

    </div>

  </div>

  <!-- End Form Sign Up -->


  <!-- Include Footer -->

  <?php include 'footer.php'; ?>

  <script>
    var screen = document.querySelector('.screen');
    var screenSpan = document.querySelector('.screen span');
    var screenClose = document.querySelector('.screen i');

    if (screenSpan.innerHTML == "بيانات الحساب مسجلة بالفعل <a href=\"sign-in.php\">تسجيل الدخول</a>") {
      screen.classList.add('faild');
      screen.style.display = 'block';
    } else if (screenSpan.innerHTML == "تم تسجيل الحساب بنجاح <a href=\"sign-in.php\">تسجيل الدخول</a>") {
      screen.classList.add('success');
      screen.style.display = 'block';
    } else {
      screen.style.display = 'none';
    }

    screenClose.onclick = function() {
      screen.style.display = 'none';
    }
  </script>
</body>

</html>