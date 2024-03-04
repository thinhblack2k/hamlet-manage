<?php
if (isset($_POST['account_keyword'])) {
    $sql_account_list = "SELECT * FROM account WHERE username LIKE '%" . $_POST['account_keyword'] . "%' ORDER BY accountRole DESC";
    $query_account_list = mysqli_query($mysqli, $sql_account_list);
} else {
    $sql_account_list = "SELECT * FROM account ORDER BY accountRole DESC";
    $query_account_list = mysqli_query($mysqli, $sql_account_list);
}

?>
<div class="row">
    <div class="col">
        <div class="header__list d-flex space-between align-center">
            <h3 class="card-title" style="margin: 0;">Danh sách tài khoản</h3>
            <div class="action_group">
                <?php
                if (isset($_SESSION['accountRole']) && $_SESSION['accountRole'] == 1) {
                ?>
                    <a href="?action=account&query=account_add" class="button button-dark">Thêm tài khoản</a>
                <?php
                }
                ?>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <div class="main-pane-top d-flex justify-center align-center">
                    <div class="input__search p-relative">
                        <form class="search-form" action="" method="POST">
                            <i class="icon-search p-absolute"></i>
                            <input type="search" class="form-control" name="account_keyword" placeholder="Search Here" title="Search here">
                        </form>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover table-action">
                        <thead>
                            <tr>
                                <th></th>
                                <th>Ảnh</th>
                                <th>Tên đăng nhập</th>
                                <th>Họ tên</th>
                                <th>Loại tài khoản</th>
                                <th>Tình trạng</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $i = 0;
                            while ($row = mysqli_fetch_array($query_account_list)) {
                                $i++;
                            ?>
                                <tr>
                                    <td>
                                        <?php
                                        if (isset($_SESSION['accountRole']) && $_SESSION['accountRole'] == 1) {
                                        ?>
                                            <a href="?action=account&query=account_edit&accountId=<?php echo $row['accountId'] ?>">
                                                <div class="icon-edit">
                                                    <img class="w-100 h-100" src="images/icon-edit.png" alt="">
                                                </div>
                                            </a>
                                        <?php
                                        }
                                        ?>
                                    </td>
                                    <td>
                                        <div class="image-cover">
                                            <img class="w-100 h-100" src="modules/account/uploads/<?php echo $row['accountImage'] ?>" alt="<?php echo $row['lastName'] ?>">
                                        </div>
                                    </td>
                                    <td><?php echo $row['userName'] ?></td>
                                    <td><?php echo ($row['firstName'] . ' ' . $row['lastName'])  ?></td>
                                    <td><?php echo format_account_type($row['accountRole']) ?></td>
                                    <td><?php echo format_account_status($row['accountStatus']) ?></td>
                                </tr>
                            <?php
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    var url;
    var btnDelete = document.getElementById("btnDelete");
    var checkAll = document.getElementById("checkAll");
    var checkboxes = document.getElementsByClassName("checkbox");
    var dialogControl = document.querySelector('.dialog__control');
    // Thêm sự kiện click cho checkbox checkAll
    checkAll.addEventListener("click", function() {
        // Nếu checkbox checkAll được chọn
        if (checkAll.checked) {
            // Đặt thuộc tính "checked" cho tất cả các checkbox còn lại
            for (var i = 0; i < checkboxes.length; i++) {
                checkboxes[i].checked = true;
            }
        } else {
            // Bỏ thuộc tính "checked" cho tất cả các checkbox còn lại
            for (var i = 0; i < checkboxes.length; i++) {
                checkboxes[i].checked = false;
            }
        }
        testChecked();
        getCheckedCheckboxes();
    });

    function testChecked() {
        var count = 0;
        for (let i = 0; i < checkboxes.length; i++) {
            if (checkboxes[i].checked) {
                count++;
                console.log(count);
            }
        }
        if (count > 0) {
            dialogControl.classList.add('active');
        } else {
            dialogControl.classList.remove('active');
            checkAll.checked = false;
        }
    }

    function getCheckedCheckboxes() {
        var checkeds = document.querySelectorAll('.checkbox:checked');
        var checkedIds = [];
        for (var i = 0; i < checkeds.length; i++) {
            checkedIds.push(checkeds[i].id);
        }
        btnDelete.href = "modules/product/xuly.php?data=" + JSON.stringify(checkedIds);
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
            message: "Không thể cập nhật tài khoản",
            type: "error",
            duration: 0,
        });
    }
</script>

<?php
if (isset($_GET['message']) && $_GET['message'] == 'success') {
    echo '<script>';
    echo 'showSuccessToast();';
    echo 'window.history.pushState(null, "", "index.php?action=account&query=account_list");';
    echo '</script>';
} elseif (isset($_GET['message']) && $_GET['message'] == 'error') {
    echo '<script>';
    echo 'showErrorToast();';
    echo 'window.history.pushState(null, "", "index.php?action=account&query=account_list");';
    echo '</script>';
}
?>