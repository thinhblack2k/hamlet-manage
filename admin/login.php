<?php
session_start();
include('config/config.php');
if (isset($_POST['login'])) {
  $account_username = $_POST['username'];
  $account_password = md5($_POST['password']);
  $account_username = mysqli_real_escape_string($mysqli, $account_username);
  $account_password = mysqli_real_escape_string($mysqli, $account_password);
  $sql_account = "SELECT * FROM account WHERE userName='" . $account_username . "' AND accountPassword='" . $account_password . "' AND (accountRole=0 OR accountRole=1 OR accountRole=2) AND accountStatus = 0 ";
  $query_account = mysqli_query($mysqli, $sql_account);
  $row = mysqli_fetch_array($query_account);
  $count = mysqli_num_rows($query_account);
  if ($count > 0) {
    $_SESSION['login'] = $row['userName'];
    $_SESSION['account_id_admin'] = $row['accountId'];
    $_SESSION['account_name'] = $row['lastName'];
    $_SESSION['accountRole'] = $row['accountRole'];
    header('Location:index.php');
  } else {
    echo '<script>alert("Tài khoản hoặc mật khẩu không chính xác, vui lòng nhập lại");</script>';
  }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="author" content="EdricDang">
  <meta name="description" content="Quản lý chi tiêu nội bộ xóm trọ">
  <meta property="og:image" content="./images/bg.jpg">
  <title>Xóm trọ</title>
  <!-- plugins:css -->
  <link rel="stylesheet" href="./vendors/feather/feather.css">
  <link rel="stylesheet" href="./vendors/mdi/css/materialdesignicons.min.css">
  <link rel="stylesheet" href="./vendors/ti-icons/css/themify-icons.css">
  <link rel="stylesheet" href="./vendors/typicons/typicons.css">
  <link rel="stylesheet" href="./vendors/simple-line-icons/css/simple-line-icons.css">
  <link rel="stylesheet" href="./vendors/css/vendor.bundle.base.css">
  <!-- endinject -->
  <!-- Plugin css for this page -->
  <!-- End plugin css for this page -->
  <!-- inject:css -->
  <link rel="stylesheet" href="./css/vertical-layout-light/style.css">
  <!-- endinject -->
  <link rel="shortcut icon" href="./images/logoadmin.ico" />
</head>

<body>
  <div class="container-scroller">
    <div class="container-fluid page-body-wrapper full-page-wrapper">
      <div class="content-wrapper d-flex align-items-center auth px-0">
        <div class="row w-100 mx-0">
          <div class="col-lg-4 mx-auto">
            <div class="auth-form-light text-left py-5 px-4 px-sm-5">
              <div class="brand-logo" style="text-align: center;">
                <img src="./images/logo225-white.png" alt="logo">
              </div>
              <h4>Hello! let's get started</h4>
              <h6 class="fw-light">Đặng nhập để vào với trang quản lý xóm trọ.</h6>
              <form action="" autocomplete="on" method="POST" class="pt-3">
                <div class="form-group">
                  <input type="text" name="username" class="form-control form-control-lg" id="exampleInputEmail1" placeholder="Username">
                </div>
                <div class="form-group">
                  <input type="password" name="password" class="form-control form-control-lg" id="exampleInputPassword1" placeholder="Password">
                </div>
                <div class="mt-3">
                  <button type="submit" name="login" class="btn btn-block btn-primary btn-lg font-weight-medium auth-form-btn" href="./index.html">SIGN IN</button>
                </div>
                <div class="my-2 d-flex justify-content-between align-items-center">
                  <div class="form-check">
                    <label class="form-check-label text-muted">
                      <input type="checkbox" class="form-check-input">
                      Keep me signed in
                    </label>
                  </div>
                  <a href="https://www.facebook.com/edricdang310" class="auth-link text-black">Forgot password?</a>
                </div>
                <div class="text-center mt-4 fw-light">
                  Don't have an account? <a href="https://www.facebook.com/edricdang310" class="text-primary">Create</a>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
      <!-- content-wrapper ends -->
    </div>
    <!-- page-body-wrapper ends -->
  </div>
  <!-- container-scroller -->
  <!-- plugins:js -->
  <script src="./vendors/js/vendor.bundle.base.js"></script>
  <!-- endinject -->
  <!-- Plugin js for this page -->
  <script src="./vendors/bootstrap-datepicker/bootstrap-datepicker.min.js"></script>
  <!-- End plugin js for this page -->
  <!-- inject:js -->
  <script src="./js/off-canvas.js"></script>
  <script src="./js/hoverable-collapse.js"></script>
  <script src="./js/template.js"></script>
  <script src="./js/settings.js"></script>
  <script src="./js/todolist.js"></script>
  <!-- endinject -->
</body>

</html>