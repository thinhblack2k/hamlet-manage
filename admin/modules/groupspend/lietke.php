<?php
$sql_groupspend_list = "SELECT * FROM groupspend ORDER BY groupId ASC";
$query_groupspend_list = mysqli_query($mysqli, $sql_groupspend_list);
?>
<div class="row">
    <div class="col">
        <div class="header__list d-flex space-between align-center">
            <h3 class="card-title" style="margin: 0;">Danh sách nhóm chi tiêu</h3>
            <div class="action_group">
                <?php
                if (isset($_SESSION['accountRole']) && $_SESSION['accountRole'] == 1) {
                ?>
                    <a href="?action=groupspend&query=groupspend_add" class="button button-dark">Thêm nhóm</a>
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
                        <form class="search-form" action="#">
                            <i class="icon-search p-absolute"></i>
                            <input type="search" class="form-control" placeholder="Search Here" title="Search here">
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
                                    if (isset($_SESSION['accountRole']) && $_SESSION['accountRole'] == 1) {
                                    ?>
                                        <input type="checkbox" id="checkAll">
                                    <?php
                                    }
                                    ?>
                                </th>
                                <th>#</th>
                                <th>Tên Nhóm Chi Tiêu</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $i = 0;
                            while ($row = mysqli_fetch_array($query_groupspend_list)) {
                                $i++;
                            ?>
                                <tr>
                                    <td>
                                        <?php
                                        if (isset($_SESSION['accountRole']) && $_SESSION['accountRole'] == 1) {
                                        ?>
                                            <a href="?action=groupspend&query=groupspend_edit&groupspend_id=<?php echo $row['groupId'] ?>">
                                                <div class="icon-edit">
                                                    <img class="w-100 h-100" src="images/icon-edit.png" alt="">
                                                </div>
                                            </a>
                                        <?php
                                        }
                                        ?>
                                    </td>
                                    <td>
                                        <?php
                                        if (isset($_SESSION['accountRole']) && $_SESSION['accountRole'] == 1) {
                                        ?>
                                            <input type="checkbox" class="checkbox" onclick="testChecked(); getCheckedCheckboxes();" id="<?php echo $row['groupId'] ?>">
                                        <?php
                                        }
                                        ?>
                                    </td>
                                    <td><?php echo $row['groupId'] ?></td>
                                    <td><?php echo $row['groupName'] ?></td>
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
<div class="dialog__control">
    <div class="control__box">
        <a href="#" class="button__control" id="btnDelete">Xóa</a>
    </div>
</div>
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
        btnDelete.href = "modules/groupspend/xuly.php?data=" + JSON.stringify(checkedIds);
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
    // echo 'window.history.pushState(null, "", "index.php?action=groupspend&query=groupspend_list");';
    echo '</script>';
} elseif (isset($_GET['message']) && $_GET['message'] == 'error') {
    echo '<script>';
    echo 'showErrorToast();';
    // echo 'window.history.pushState(null, "", "index.php?action=groupspend&query=groupspend_list");';
    echo '</script>';
}
?>