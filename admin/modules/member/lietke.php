    <?php
    $sql_member_list = "SELECT * FROM member ORDER BY memberId ASC";
    $query_member_list = mysqli_query($mysqli, $sql_member_list);
    ?>
    <div class="row">
        <div class="col">
            <div class="header__list d-flex space-between align-center">
                <h3 class="card-title" style="margin: 0;">Danh sách thành viên</h3>
                <div class="action_group">
                    <?php
                    if (isset($_SESSION['accountRole']) && $_SESSION['accountRole'] == 1) {
                    ?>
                        <a href="?action=member&query=member_add" class="button button-dark">Thêm thành viên</a>
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
                    <div class="card-content">
                        <div class="main-pane-top d-flex justify-center align-center">
                            <div class="input__search p-relative">
                                <form method="POST" class="search-form" action="?action=member&query=member_search">
                                    <i class="icon-search p-absolute"></i>
                                    <input type="search" class="form-control" name="member_search" placeholder="Search Here" title="Search here">
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
                                        <th></th>
                                        <th>Tên</th>
                                        <th>Tổng chi</th>
                                        <th>Tổng nợ</th>
                                        <th>Số dư</th>
                                        <th>Ghi chú</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $i = 0;
                                    while ($row = mysqli_fetch_array($query_member_list)) {
                                        $i++;
                                    ?>
                                        <tr>
                                            <td>
                                                <?php
                                                if (isset($_SESSION['accountRole']) && $_SESSION['accountRole'] == 1 OR $_SESSION['accountRole'] == 0) {
                                                ?>
                                                    <a href="?action=member&query=member_edit&memberId=<?php echo $row['memberId'] ?>">
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
                                                    <input type="checkbox" class="checkbox" onclick="testChecked(); getCheckedCheckboxes();" id="<?php echo $row['memberId'] ?>">
                                                <?php
                                                }
                                                ?>
                                            </td>
                                            <td>
                                                <div class="image-cover">
                                                    <img src="modules/member/uploads/<?php echo $row['memberImage'] ?>" alt="<?php echo $row['memberName'] ?>">
                                                </div>
                                            </td>
                                            <td><?php echo $row['memberName'] ?></td>
                                            <td><?php echo number_format($row['totalExpend']) ?>đ</td>
                                            <td><?php echo number_format($row['totalLoss']) ?>đ</td>
                                            <td><?php echo number_format($row['totalExpend'] - $row['totalLoss']) ?>đ</td>
                                            <td><?php echo $row['memberNote'] ?></td>
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
    if (isset($_SESSION['accountRole']) && $_SESSION['accountRole'] == 1) {
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
            btnDelete.href = "modules/member/xuly.php?data=" + JSON.stringify(checkedIds);
        }
    </script>