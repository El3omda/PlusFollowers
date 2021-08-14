<?php

// Start Connection To DataBase

require_once 'config.php';

// Get User Data

@$UserEmail = $_POST['UserEmail'];
@$UserPass = $_POST['UserPass'];

// Check User Data 

if (isset($_POST['submit'])) {
  $sqlCheck = "SELECT * FROM users WHERE UserEmail = '$UserEmail' AND UserPass = '$UserPass'";
  $result = mysqli_query($conn, $sqlCheck);
  if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    // Set User Status To Online
    $USEREMAIL = $row['UserEmail'];
    $sqlOnline = "UPDATE users SET Online = 'Yas' WHERE UserEmail = '$USEREMAIL'";
    mysqli_query($conn, $sqlOnline);
    session_start();
    $_SESSION['UserName'] = $row['UserName'];
    $_SESSION['UserEmail'] = $row['UserEmail'];
    $_SESSION['InstaUser'] = $row['InstaUser'];
    setcookie('UserEmail', $row['UserEmail'], time() + 3600 * 24 * 10);
    setcookie('UserPass', $row['UserPass'], time() + 3600 * 24 * 10);
    $msg = "مرحبا بعودتك من جديد سيتم تحويلك لصفحة الرئيسية بعد 3 ثواني";
    header("Refresh:3;url=dashboard.php?success");
  } else {
    $msg = 'خطاء في الايمال او الباسورد حاول مجددا او سجل <a href="sign-up.php">حساب جديد</a>';
  }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>تسجيل الدخول</title>
  <link rel="stylesheet" href="css/font-awesome.min.css">
  <link rel="stylesheet" href="css/sign.css">
</head>

<body>
  <!-- Include Nav -->

  <?php include 'nav.php'; ?>


  <!-- Start Form Sign Up -->

  <div class="container">
    <div style="top: 14%;" class="screen">
      <i class="fa fa-times"></i>
      <span><?php echo @$msg; ?></span>
    </div>
    <div style="margin-top: 100px;" class="form-box">

      <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">

        <div class="input-field">
          <label for="UserEmail">الايمال</label>
          <input type="email" name="UserEmail" id="UserEmail" value="<?php echo @$_COOKIE['UserEmail']; ?>" placeholder="اكتب ايمالك . . . " required autocomplete="off">
        </div>
        <div class="input-field">
          <label for="UserPass">كلمة المرور</label>
          <input type="password" name="UserPass" id="UserPass" value="<?php echo @$_COOKIE['UserPass']; ?>" placeholder="اكتب كلمة المرور . . ." required autocomplete="off">
        </div>
        <input type="submit" name="submit" value="تسجيل الدخول">
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

    if (screenSpan.innerHTML == "خطاء في الايمال او الباسورد حاول مجددا او سجل <a href=\"sign-up.php\">حساب جديد</a>") {
      screen.classList.add('faild');
      screen.style.display = 'block';
    } else if (screenSpan.innerHTML == "مرحبا بعودتك من جديد سيتم تحويلك لصفحة الرئيسية بعد 3 ثواني") {
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