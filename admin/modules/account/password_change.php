<link rel="stylesheet" href="css/login.css">
<div class="row" style="margin-bottom: 10px;">
    <div class="col d-flex" style="justify-content: space-between; align-items: flex-end;">
        <h3 class="card-title">
        </h3>
        <a href="trang-chu" class="btn btn-outline-dark btn-fw">
            <i class="mdi mdi-reply"></i>
            Quay lại
        </a>
    </div>
</div>
<div class="row" style="justify-content: center;">
    <div class="col-lg-5 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <div class="card-content">
                    <div class="auth-form-light text-left py-5 px-4 px-sm-5">
                        <h4>Đổi mật khẩu cho tài khoản</h4>
                        <h6 class="fw-light">User Name: <?php echo $_SESSION['login'] ?></h6>
                        <?php
                        if (isset($_POST['password_change'])) {
                            $userName = $_SESSION['login'];
                            $password_old = md5($_POST['password_old']);
                            $password_new = md5($_POST['password_new']);
                            $sql = "SELECT * FROM account WHERE userName='" . $userName . "' AND accountPassword='" . $password_old . "' ";
                            $query = mysqli_query($mysqli, $sql);
                            $row = mysqli_fetch_array($query);
                            $count = mysqli_num_rows($query);
                            if ($count > 0) {
                                $sql_update = "UPDATE account SET accountPassword = '" . $password_new . "'";
                                mysqli_query($mysqli, $sql_update);
                                echo '<p style="color:green; text-align: center;">Mật khẩu đã được thay đổi</p>';
                            } else {
                                echo '<p style="color:red; text-align: center;">Mật khẩu cũ không đúng vui lòng nhập lại</p>';
                            }
                        }
                        ?>
                        <form action="" autocomplete="off" method="POST" class="pt-3">
                            <div class="form-group">
                                <label for="exampleInputPassword1">Mật khẩu cũ</label>
                                <input type="password" name="password_old" class="form-control form-control-lg" id="exampleInputPassword1" placeholder="Password old">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword2">Mật khẩu mới</label>
                                <input type="password" name="password_new" class="form-control form-control-lg" id="exampleInputPassword2" placeholder="Password new">
                            </div>
                            <div class="mt-3">
                                <button type="submit" name="password_change" class="btn btn-block btn-primary btn-lg font-weight-medium auth-form-btn">Lưu lại</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>