<?php

// Start Session

session_start();

$InstaUser = $_SESSION['InstaUser'];

// Include Config File 

require_once 'config.php';

// Sql For Get User Last Orders

$sqlLO = "SELECT * FROM orders WHERE OrderOwner = '$InstaUser'";
$resultLO = mysqli_query($conn, $sqlLO);

// Create New Order

if ($_SERVER["REQUEST_METHOD"] == "POST") {

  # Get User Current Coins

  $sqlGetCoins = "SELECT Coins FROM users WHERE InstaUser = '$InstaUser'";
  $resultCoins = mysqli_query($conn, $sqlGetCoins);
  $rowGCoins = $resultCoins->fetch_assoc();

  $userCoins = $rowGCoins['Coins'];

  # Get Order Details

  if (isset($_POST['r5'])) {
    $order = 5;
    $mustHave = 50;
  } elseif (isset($_POST['r10'])) {
    $order = 10;
    $mustHave = 100;
  } elseif (isset($_POST['r20'])) {
    $order = 20;
    $mustHave = 200;
  } elseif (isset($_POST['r50'])) {
    $order = 50;
    $mustHave = 500;
  } elseif (isset($_POST['r100'])) {
    $order = 100;
    $mustHave = 1000;
  }

  if ($userCoins >= $mustHave) {

    // Insert ORDER Into DataBase

    #Chech If There Are Pending Orders

    $sqlCPO = "SELECT * FROM orders WHERE OrderOwner = '$InstaUser' AND OrderStatus = 'Pending'";
    $resultCPO = mysqli_query($conn, $sqlCPO);

    if ($resultCPO->num_rows > 0) {
      $msg = "لا يمكنك انشاء طلب يلزم اكمال الطلب السابق";
    } else {
      $sqlInsertOrder = "INSERT INTO orders (OrderOwner,RFollowers,CFollowers,OrderStatus,CoinSpend) VALUES ('$InstaUser','$order','0','Pending','$mustHave')";
      if (mysqli_query($conn, $sqlInsertOrder)) {
        $msg = "تم حفظ الطلب بنجاح";

        // Update User Coins
        $newCoins = $userCoins - $mustHave;
        $sqlUpdateUserCoins = "UPDATE users SET Coins = '$newCoins' WHERE InstaUser = '$InstaUser'";
        mysqli_query($conn, $sqlUpdateUserCoins);
      } else {
        $msg = "لم يتم الحفظ راجع عدد نقاطك";
      }
    }
  } else {
    $msg = "ليس لديك نقاط كافية";
  }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>زيادة المتابعين</title>
  <link rel="stylesheet" href="css/shop.css">
</head>

<body>

  <!-- Include Nav -->

  <?php include 'nav.php'; ?>


  <!-- Start Last Order -->

  <div class="last-order">
    <div style="top: 14%;" class="screen">
      <i class="fa fa-times"></i>
      <span><?php echo @$msg; ?></span>
    </div>
    <p class="head">طلباتك السابقة</p>
    <?php

    if ($resultLO->num_rows > 0) {

      echo '
  <table>
    <tr>
      <th>رقم العملية</th>
      <th>المتابعين</th>
      <th>حصلت علي</th>
      <th>النقاط</th>
      <th>حالة الطلب</th>
    </tr>
  ';
      while ($rowLO = $resultLO->fetch_assoc()) {

        echo '
    <tr>
      <td>' . $rowLO['ID'] . '</td>
      <td>' . $rowLO['RFollowers'] . '</td>
      <td>' . $rowLO['CFollowers'] . '</td>
      <td>' . $rowLO['CoinSpend'] . '</td>
      <td>' . $rowLO['OrderStatus'] . '</td>
    </tr>
    ';
      }

      echo '</table>';
    } else {
      echo '<p style="text-align:center;font-family:cairo,arial;font-size:18px;">لا يوجد طلبات لعرضها</p>';
    }

    ?>

  </div>

  <!-- End Last Order -->

  <div class="seperator">

  </div>

  <!-- Start New Order -->

  <div class="new-order">

    <div class="head">انشاء طلب جديد</div>

    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">

      <span class="get">تحصل علي </span><input type="text" value="5" readonly> <span class="get2">متابعين مقابل</span> <span class="coast">50</span> نقطة
      <input type="submit" name="r5" value="طلب">

    </form>

    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">

      <span class="get">تحصل علي </span><input type="text" value="10" readonly> <span class="get2">متابعين مقابل</span> <span class="coast">100</span> نقطة
      <input type="submit" name="r10" value="طلب">

    </form>

    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">

      <span class="get">تحصل علي </span><input type="text" value="20" readonly> <span class="get2">متابعين مقابل</span> <span class="coast">200</span> نقطة
      <input type="submit" name="r20" value="طلب">

    </form>

    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">

      <span class="get">تحصل علي </span><input type="text" value="50" readonly> <span class="get2">متابعين مقابل</span> <span class="coast">500</span> نقطة
      <input type="submit" name="r50" value="طلب">

    </form>

    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">

      <span class="get">تحصل علي </span><input type="text" value="100" readonly> <span class="get2">متابعين مقابل</span> <span class="coast">1000</span> نقطة
      <input type="submit" name="r100" value="طلب">

    </form>

  </div>

  <!-- End New Order -->

  <!-- Include Footer -->

  <?php include 'footer.php'; ?>
  <script>
    var screen = document.querySelector('.screen');
    var screenSpan = document.querySelector('.screen span');
    var screenClose = document.querySelector('.screen i');

    if (screenSpan.innerHTML == "ليس لديك نقاط كافية" || screenSpan.innerHTML == "لم يتم الحفظ راجع عدد نقاطك" || screenSpan.innerHTML == "لا يمكنك انشاء طلب يلزم اكمال الطلب السابق") {
      screen.classList.add('faild');
      screen.style.display = 'block';
    } else if (screenSpan.innerHTML == "تم حفظ الطلب بنجاح") {
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