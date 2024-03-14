<?php
$sql_account_edit = "SELECT * FROM account WHERE accountId = '" . $_SESSION['account_id_admin'] . "' LIMIT 1";
$query_account_edit = mysqli_query($mysqli, $sql_account_edit);
?>

<div class="row" style="margin-bottom: 10px;">
    <div class="col d-flex" style="justify-content: space-between; align-items: flex-end;">
        <h3>
            Thông tin tài khoản
        </h3>
        <a href="index.php?action=account&query=account_list" class="btn btn-outline-dark btn-fw">
            <i class="mdi mdi-reply"></i>
            Quay lại
        </a>
    </div>
</div>
<div class="row">
    <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <div class="card-content">
                    <?php
                    while ($row = mysqli_fetch_array($query_account_edit)) {
                    ?>
                        <form method="POST" action="modules/account/xuly.php?account_id=<?php echo $_SESSION['account_id_admin'] ?>">
                            <div class="input-item form-group">
                                <label for="userName" class="d-block">Tên người dùng</label>
                                <input type="text" name="userName" class="form-control" value="<?php echo $row['userName'] ?>">
                            </div>
                            <div class="input-item form-group">
                                <label for="firstName" class="d-block">Họ, đêm</label>
                                <input type="text" name="firstName" id="firstName" class="form-control" value="<?php echo $row['firstName'] ?>">
                            </div>
                            <div class="input-item form-group">
                                <label for="lastName" class="d-block">Tên</label>
                                <input type="text" name="lastName" id="lastName" class="form-control" value="<?php echo $row['lastName'] ?>">
                            </div>

                            <button type="submit" name="account_edit" class="btn btn-primary btn-icon-text" style="margin-right: 10px" <?php
                                                                                                                                        if (isset($_SESSION['accountRole']) && $_SESSION['accountRole'] != 1) {
                                                                                                                                        ?> disabled <?php
                                                                                                                                        }
                            ?>>
                                <i class="ti-file btn-icon-prepend"></i>
                                Lưu
                            </button>
                            <a href="index.php?action=account&query=password_change" class="btn btn-primary btn-icon-text">
                                <i class="ti-file btn-icon-prepend"></i>
                                Đổi mật khẩu
                            </a>

                        </form>
                    <?php
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    function showErrorToast() {
        toast({
            title: "Success",
            message: "Cập nhật thành công",
            type: "success",
            duration: 0,
        });
    }
</script>

<?php
if (isset($_GET['message']) && $_GET['message'] == 'success') {
    $message = $_GET['message'];
    echo '<script>';
    echo '   showErrorToast();';
    echo 'window.history.pushState(null, "", "index.php?action=account&query=my_account");';
    echo '</script>';
}
?>