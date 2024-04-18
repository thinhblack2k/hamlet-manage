<div class="row" style="margin-bottom: 10px;">
    <div class="col d-flex" style="justify-content: space-between; align-items: flex-end;">
        <h3 class="card-title">
            Cài đặt chung
        </h3>
    </div>
</div>
<form method="POST" action="modules/settings/xuly.php" id="form-product" enctype="multipart/form-data">
    <div class="row">
        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <div class="card-content">
                        <div>
                            <p class="color-t-red">
                                Cảnh báo những hành động khi thực hiện ở trong đây có thể ảnh hưởng tới dữ liệu của hệ thống!!!
                            </p>
                            <?php
                            if (
                                isset($_SESSION["accountRole"]) &&
                                $_SESSION["accountRole"] != 1
                            ) {
                            ?>
                                <p class="color-t-green">
                                    Vui lòng đăng nhập bằng tài khoản có quyền quản trị cao nhất để thực hiện các thao tác này!!!
                                </p>
                            <?php
                            }
                            ?>
                        </div>
                        <label for="codeText">Nhập vào cụm từ xác thực: </label>
                        <input type="text" name="codebaomat" class="form-control p-input" id="codeText" aria-describedby="textHelp" placeholder="Nhập vào đoạn mã">
                        <small id="textHelp" class="form-text text-muted text-success"><span class="fa fa-info mt-1"></span>  Cụm từ gồm 9 ký tự được tạo ra bởi founder của website này dùng để xác thực khi thực hiện các thao tác liên quan đến hệ thống.</small>
                        <div class="template-demo">
                            <button type="submit" name="chotchitieu" class="btn btn-inverse-info btn-fw" <?php
                                                                                                            if (
                                                                                                                isset($_SESSION["accountRole"]) &&
                                                                                                                $_SESSION["accountRole"] != 1
                                                                                                            ) { ?> disabled <?php }
                ?>>Chốt chi tiêu</button>
                            <button type="submit" name="thanhkhoan" class="btn btn-inverse-success btn-fw" <?php
                                                                                                            if (
                                                                                                                isset($_SESSION["accountRole"]) &&
                                                                                                                $_SESSION["accountRole"] != 1
                                                                                                            ) { ?> disabled <?php }
                ?>>Thanh khoản</button>
                            <button type="submit" name="lammoichitieu" class="btn btn-inverse-warning btn-fw" <?php
                                                                                                                if (
                                                                                                                    isset($_SESSION["accountRole"]) &&
                                                                                                                    $_SESSION["accountRole"] != 1
                                                                                                                ) { ?> disabled <?php }
                ?>>Xóa chi tiêu...</button>
                            <button type="submit" name="resettoanbohethong" class="btn btn-inverse-danger btn-fw" <?php
                                                                                                                    if (
                                                                                                                        isset($_SESSION["accountRole"]) &&
                                                                                                                        $_SESSION["accountRole"] != 1
                                                                                                                    ) { ?> disabled <?php }
                ?>>Xóa toàn bộ .</button>
                        </div>
                        <div style="margin-top: 50px; text-align: center;">
                            <small class="form-text text-muted text-success text-center">
                                create by edricdang
                            </small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>

<script>
    $('.select_brand').chosen();
    $('.select_capacity').chosen();
    $('.select_category').chosen();
    CKEDITOR.replace('product_description');
</script>

<script>
    Validator({
        form: '#form-product',
        errorSelector: '.form-message',
        rules: [
            Validator.isRequired('#product_name', 'vui lòng nhập tên sản phẩm'),
            Validator.isRequired('#product_price', 'vui lòng nhập vào giá bán')
        ],
        onSubmit: function(data) {
            console.log(data);
        }
    })
</script>

<script>
    let uploadButton = document.getElementById("product_image");
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
    let uploadButton1 = document.getElementById("imagebanner1");
    let chosenImage1 = document.getElementById("chosen-image1");
    let fileName1 = document.getElementById("file-name1");

    uploadButton1.onchange = () => {
        let reader = new FileReader();
        reader.readAsDataURL(uploadButton.files[0]);
        reader.onload = () => {
            chosenImage1.setAttribute("src", reader.result);
        }
        fileName1.textContent = uploadButton.files[0].name;
    }

    let uploadButton2 = document.getElementById("imagebanner2");
    let chosenImage2 = document.getElementById("chosen-image2");
    let fileName2 = document.getElementById("file-name2");

    uploadButton2.onchange = () => {
        let reader = new FileReader();
        reader.readAsDataURL(uploadButton.files[0]);
        reader.onload = () => {
            chosenImage2.setAttribute("src", reader.result);
        }
        fileName2.textContent = uploadButton2.files[0].name;
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

    function showErrorToast() {
        toast({
            title: "Error",
            message: "Mã xác thực không hợp lệ",
            type: "error",
            duration: 0,
        });
    }
</script>

<?php
if (isset($_GET['message']) && $_GET['message'] == 'success') {
    echo '<script>';
    echo 'showSuccessToast();';
    echo 'window.history.pushState(null, "", "index.php?action=settings&query=settings");';
    echo '</script>';
} elseif (isset($_GET['message']) && $_GET['message'] == 'error') {
    echo '<script>';
    echo 'showErrorToast();';
    echo 'window.history.pushState(null, "", "index.php?action=settings&query=settings");';
    echo '</script>';
}
?>