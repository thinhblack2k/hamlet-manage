<?php
$sql_spending_list = "SELECT * FROM spending WHERE spendingStatus = 2 ORDER BY spendDate DESC, spendId DESC LIMIT 25";
$query_spending_list = mysqli_query($mysqli, $sql_spending_list);
?>
<div class="row">
    <div class="col">
        <div class="header__list d-flex space-between align-center">
            <h3 class="card-title" style="margin: 0;">Lịch sử thanh toán</h3>
            <div class="action_group">
                <?php
                if (isset($_SESSION['accountRole']) && $_SESSION['accountRole'] == 1 or $_SESSION['accountRole'] == 0) {
                ?>
                    <a href="?action=payment&query=payment_add" class="button button-dark">Thanh toán</a>
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
                <div class="">
                    <div class="main-pane-top d-flex justify-center align-center">
                        <div class="input__search p-relative">
                            <form method="POST" class="search-form" action="?action=payment&query=payment_search">
                                <i class="icon-search p-absolute"></i>
                                <input type="search" class="form-control" name="payment_search" placeholder="Search Here" title="Search here">
                            </form>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-hover table-action">
                            <thead>
                                <tr>
                                    <th></th>
                                    <th>
                                        <?php
                                        if (isset($_SESSION['accountRole']) && $_SESSION['accountRole'] == 1 or $_SESSION['accountRole'] == 0) {
                                        ?>
                                            <input type="checkbox" id="checkAll">
                                        <?php
                                        }
                                        ?>
                                    </th>
                                    <th>Ngày</th>
                                    <th>Nội dung</th>
                                    <th>Người thanh toán</th>
                                    <th class="text-center">Số tiền</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $i = 0;
                                while ($row = mysqli_fetch_array($query_spending_list)) {
                                    $i++;
                                ?>
                                    <tr>
                                        <td>
                                            <?php
                                            if (isset($_SESSION['accountRole']) && $_SESSION['accountRole'] == 1) {
                                            ?>
                                                <a href="?action=payment&query=payment_edit&spendId=<?php echo $row['spendId'] ?>">
                                                    <div class="icon-edit">
                                                        <img class="w-100 h-100" src="images/icon-edit.png" alt="edit">
                                                    </div>
                                                </a>
                                            <?php
                                            }
                                            ?>
                                        </td>
                                        <td>
                                            <?php
                                            if (isset($_SESSION['accountRole']) && $_SESSION['accountRole'] == 1 or $_SESSION['accountRole'] == 0) {
                                            ?>
                                                <input type="checkbox" class="checkbox" onclick="testChecked(); getCheckedCheckboxes();" id="<?php echo $row['spendId'] ?>">
                                            <?php
                                            }
                                            ?>
                                        </td>
                                        <td><?php echo $row['spendDate'] ?></td>
                                        <td><?php echo $row['spendName'] ?></td>
                                        <td>
                                            <?php
                                            $sql_get_member_spending = "SELECT * FROM member WHERE memberId = '" . $row['spendMember'] . "' LIMIT 1";
                                            $query_get_member_spending = mysqli_query($mysqli, $sql_get_member_spending);
                                            $member = mysqli_fetch_array($query_get_member_spending);
                                            echo $member['memberName'];
                                            ?>
                                        </td>
                                        <td class="text-center"><?php echo number_format($row['spendTotal']) ?>đ</td>
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
</div>
<?php
if (isset($_SESSION['accountRole']) && $_SESSION['accountRole'] == 1 or $_SESSION['accountRole'] == 0) {
?>
    <div class="dialog__control">
        <div class="control__box">
            <a href="#" class="button__control" id="btnDelete">Xóa</a>
        </div>
    </div>
<?php
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
    echo 'window.history.pushState(null, "", "index.php?action=spending&query=spending_list");';
    echo '</script>';
} elseif (isset($_GET['message']) && $_GET['message'] == 'error') {
    echo '<script>';
    echo 'showErrorToast();';
    echo 'window.history.pushState(null, "", "index.php?action=spending&query=spending_list");';
    echo '</script>';
}
?>

<script>
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
        btnDelete.href = "modules/spending/xuly.php?data=" + JSON.stringify(checkedIds);
    }
</script>