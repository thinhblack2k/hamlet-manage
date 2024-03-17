<?php
$sql_account_edit = "SELECT * FROM account WHERE accountId = '$_GET[accountId]' LIMIT 1";
$query_account_edit = mysqli_query($mysqli, $sql_account_edit);
?>
<div class="row" style="margin-bottom: 10px;">
    <div class="col d-flex" style="justify-content: space-between; align-items: flex-end;">
        <h3 class="card-title">
            Sửa đổi thông tin tài khoản
        </h3>
        <a href="index.php?action=account&query=account_list" class="btn btn-outline-dark btn-fw">
            <i class="mdi mdi-reply"></i>
            Quay lại
        </a>
    </div>
</div>
<form method="POST" action="modules/account/xuly.php?accountId=<?php echo $_GET['accountId'] ?>" id="form-product" enctype="multipart/form-data">
    <div class="row">
        <?php
        while ($item = mysqli_fetch_array($query_account_edit)) {
        ?>
            <div class="col-lg-8 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <div class="card-content">

                            <div class="input-item form-group">
                                <label for="title" class="d-block" for="userName">Tên đăng nhập</label>
                                <input type="text" name="userName" class="form-control" id="userName" value="<?php echo $item['userName'] ?>">
                            </div>
                            <div class="input-item form-group">
                                <label for="firstName" class="d-block">Họ đệm</label>
                                <input type="text" name="firstName" id="firstName" class="form-control" value="<?php echo $item['firstName'] ?>">
                            </div>
                            <div class="input-item form-group">
                                <label for="lastName" class="d-block">Tên</label>
                                <input type="text" name="lastName" id="lastName" class="form-control" value="<?php echo $item['lastName'] ?>">
                            </div>
                            <div class="input-item form-group">
                                <label for="role" class="d-block">Quyền hạn</label>
                                <select name="role" id="role" class="form-control">
                                    <option value="0" <?php if ($item['accountRole'] == 0) {
                                                            echo "selected";
                                                        } ?>>Thành viên</option>
                                    <option value="1" <?php if ($item['accountRole'] == 1) {
                                                            echo "selected";
                                                        } ?>>Quản trị viên</option>
                                    <option value="2" <?php if ($item['accountRole'] == 2) {
                                                            echo "selected";
                                                        } ?>>Quản trị viên</option>
                                </select>
                            </div>
                            <div class="input-item form-group">
                                <label for="title" class="d-block">Tình trạng</label>
                                <select name="status" id="status" class="form-control">
                                    <option value="0" <?php if ($item['accountStatus'] == 0) {
                                                            echo "selected";
                                                        } ?>>Đang hoạt động</option>
                                    <option value="-1" <?php if ($item['accountStatus'] == -1) {
                                                            echo "selected";
                                                        } ?>>Tạm khóa</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <div class="card-content">
                            <div class="main-pane-top">
                                <h4 class="card-title"></h4>
                            </div>
                            <div class="input-item form-group">
                                <label class="d-block" for="accountImage">Image</label>
                                <div class="image-box w-100">
                                    <figure class="image-container p-relative">
                                        <img src="modules/account/uploads/<?php echo $item['accountImage'] ?>" id="chosen-image">
                                        <figcaption id="file-name"></figcaption>
                                    </figure>
                                    <input type="file" class="d-none" id="accountImage" name="accountImage" accept="image/*">
                                    <small id="textHelp" class="form-text text-muted text-success"><span class="fa fa-info mt-1"></span>  Không được tải lên ảnh có dung lượng quá lớn.</small>
                                    <label class="label-for-image" for="accountImage">
                                        <i class="fas fa-upload"></i> &nbsp; Tải lên hình ảnh
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php
        }
        ?>
    </div>
    <div class="w-100" style="text-align: left;">
        <button type="submit" name="account_edit" class="btn btn-primary btn-icon-text">
            <i class="ti-file btn-icon-prepend"></i>
            Sửa
        </button>
    </div>
</form>

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


<script>
    let uploadButton = document.getElementById("accountImage");
    let chosenImage = document.getElementById("chosen-image");
    let fileName = document.getElementById("file-name");

    uploadButton.onchange = () => {
        let reader = new FileReader();
        reader.readAsDataURL(uploadButton.files[0]);
        reader.onload = () => {
            chosenImage.setAttribute("src", reader.result);
        }
        fileName.textContent = uploadButton.files[0].name;
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

<script>
    function showSuccessToast() {
        toast({
            title: "Success",
            message: "Cập nhật thành công",
            type: "success",
            duration: 0,
        });
    }

    function showErrorToast() {
        toast({
            title: "Error",
            message: "Kích thức ảnh quá lớn",
            type: "error",
            duration: 0,
        });
    }
</script>

<?php
if (isset($_GET['message']) && $_GET['message'] == 'success') {
    echo '<script>';
    echo 'showSuccessToast();';
    echo 'window.history.pushState(null, "", "index.php?action=account&query=account_add");';
    echo '</script>';
} elseif (isset($_GET['message']) && $_GET['message'] == 'error') {
    echo '<script>';
    echo 'showErrorToast();';
    echo 'window.history.pushState(null, "", "index.php?action=account&query=account_add");';
    echo '</script>';
}
?>