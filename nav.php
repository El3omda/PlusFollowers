<link rel="stylesheet" href="css/font-awesome.min.css">
<link rel="stylesheet" href="css/fixed.css">
<nav>
  <div class="container">
    <div class="logo">
      <span class="letter">P</span>luse<span class="letter">F</span>ollowers
    </div>
    <ul>

      <?php

      @session_start();

      if (isset($_SESSION['UserEmail'])) {
        require_once 'config.php';
        $UserEmail = $_SESSION['UserEmail'];
        $sqlGetCoin = "SELECT Coins FROM users WHERE UserEmail = '$UserEmail'";
        $resultCoin = mysqli_query($conn, $sqlGetCoin);
        $row = $resultCoin->fetch_assoc();
        echo '
      <li><a href="sign-out.php">تسجيل الخروج</a></li>
      ';
        if ($_SERVER['PHP_SELF'] != "/GitHub/PlusFollowers/dashboard.php") {
          echo '
        <li><a href="dashboard.php">الصفحة الرئيسية</a></li>
          ';
        }
        if ($_SERVER['PHP_SELF'] != "/GitHub/PlusFollowers/Shop.php") {
          echo '
          <li><a href="Shop.php">زيادة المتابعين</a></li>
          ';
        }
        echo '
        <li class="coin"><i class="fa fa-money"></i> ' . $row['Coins'] . ' </li>
        ';
      } else {
        echo '
        <li><a href="sign-up.php">حساب جديد</a></li>
      <li><a href="sign-in.php">تسجيل الدخول</a></li>
        ';
      }

      ?>

    </ul>
  </div>
</nav>