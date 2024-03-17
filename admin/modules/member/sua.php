<link rel="stylesheet" href="css/dialog.css">
<?php
$sql_member_edit = "SELECT * FROM member WHERE memberId = '$_GET[memberId]' LIMIT 1";
$query_member_edit = mysqli_query($mysqli, $sql_member_edit);
?>
<div class="row" style="margin-bottom: 10px;">
    <div class="col d-flex" style="justify-content: space-between; align-items: flex-end;">
        <h3>
            Sửa thông tin thành viên
        </h3>
        <a href="index.php?action=member&query=member_list" class="btn btn-outline-dark btn-fw">
            <i class="mdi mdi-reply"></i>
            Quay lại
        </a>
    </div>
</div>
<?php
while ($item = mysqli_fetch_array($query_member_edit)) {
?>
    <form method="POST" action="modules/member/xuly.php?memberId=<?php echo $_GET['memberId'] ?>" enctype="multipart/form-data">

        <div class="row">
            <div class="col-lg-8 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <div class="card-content">

                            <div class="input-item form-group">
                                <label for="title" class="d-block">Tên thành viên</label>
                                <input type="text" name="memberName" class="form-control" value="<?php echo $item['memberName'] ?>" placeholder="member name" required>
                            </div>
                            <div class="input-item form-group">
                                <label for="title" class="d-block">Tổng chi</label>
                                <input type="number" name="totalExpend" class="form-control" value="<?php echo $item['totalExpend'] ?>" placeholder="total expend" <?php
                                                                                                                                                                    if (isset($_SESSION['accountRole']) && $_SESSION['accountRole'] != 1) {
                                                                                                                                                                    ?> disabled <?php
                                                                                                                                                                            }
                                                                                                                                                                                ?> required>
                            </div>
                            <div class="input-item form-group">
                                <label for="title" class="d-block">Tổng nợ</label>
                                <input type="number" name="totalLoss" class="form-control" value="<?php echo $item['totalLoss'] ?>" placeholder="total loss" <?php
                                                                                                                                                                if (isset($_SESSION['accountRole']) && $_SESSION['accountRole'] != 1) {
                                                                                                                                                                ?> disabled <?php
                                                                                                                                                                        }
                                                                                                                                                                            ?> required>
                            </div>
                            <div class="input-item form-group">
                                <label for="title" class="d-block">Số dư</label>
                                <input type="number" name="totalSurplus" class="form-control" value="<?php echo $item['totalExpend'] - $item['totalLoss'] ?>" placeholder="Số dư" disabled>
                            </div>
                            <div class="input-item form-group">
                                <label for="title" class="d-block">Ghi chú</label>
                                <textarea class="form-control" name="memberNote" type="text" value="" placeholder="member note" style="height: auto;"><?php echo $item['memberNote'] ?></textarea>
                            </div>
                            <button type="submit" name="member_edit" class="btn btn-primary btn-icon-text">
                                <i class="ti-file btn-icon-prepend"></i>
                                Sửa
                            </button>
                            <a type="button" href="index.php?action=payment&query=payment_list" class="btn btn-secondary btn-icon-text" style="line-height: 16px;">
                                Thanh toán
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <div class="card-content">
                            <div class="main-pane-top">
                                <div class="input-item form-group">
                                    <label class="d-block" for="memberImage">Image</label>
                                    <div class="image-box w-100">
                                        <figure class="image-container p-relative">
                                            <img src="modules/member/uploads/<?php echo $item['memberImage'] ?>" id="chosen-image">
                                            <figcaption id="file-name"></figcaption>
                                        </figure>
                                        <input type="file" class="d-none" id="memberImage" name="memberImage" accept="image/*">
                                        <small id="textHelp" class="form-text text-muted text-success"><span class="fa fa-info mt-1"></span>  Không được tải lên ảnh có dung lượng quá lớn.</small>
                                        <label class="label-for-image" for="memberImage">
                                            <i class="fas fa-upload"></i> &nbsp; Tải lên hình ảnh
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
<?php
}
?>

<script>
    let uploadButton = document.getElementById("memberImage");
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

<script>
    function showSuccessToast() {
        toast({
            title: "Success",
            message: "Cập nhật thành công",
            type: "success",
            duration: 0,
        });
    }

    function showWarningToast() {
        toast({
            title: "Error",
            message: "Không tồn tại khoản thanh toán",
            type: "error",
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
    echo 'window.history.pushState(null, "", "index.php?action=member&query=member_edit");';
    echo '</script>';
} elseif (isset($_GET['message']) && $_GET['message'] == 'error') {
    echo '<script>';
    echo 'showErrorToast();';
    echo 'window.history.pushState(null, "", "index.php?action=member&query=member_edit");';
    echo '</script>';
} elseif (isset($_GET['message']) && $_GET['message'] == 'warning') {
    echo '<script>';
    echo 'showWarningToast();';
    echo 'window.history.pushState(null, "", "index.php?action=member&query=member_edit");';
    echo '</script>';
}
?>