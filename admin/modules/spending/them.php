<link rel="stylesheet" href="css/dialog.css">
<div class="row" style="margin-bottom: 10px;">
    <div class="col d-flex" style="justify-content: space-between; align-items: flex-end;">
        <h3>
            Thêm khoản chi
        </h3>
        <a href="index.php?action=spending&query=spending_list&groupId=all" class="btn btn-outline-dark btn-fw">
            <i class="mdi mdi-reply"></i>
            Quay lại
        </a>
    </div>
</div>
<form method="POST" action="modules/spending/xuly.php" enctype="multipart/form-data">
    <div class="row">
        <div class="col-lg-8 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <div class="card-content">
                        <div class="input-item form-group">
                            <label for="spendName" class="d-block">Tên khoản chi</label>
                            <input type="text" id="spendName" name="spendName" class="form-control" value="" placeholder="spend name" required>
                        </div>
                        <div class="input-item form-group">
                            <label for="spendTotal" class="d-block">Số tiền</label>
                            <input type="number" id="spendTotal" name="spendTotal" class="form-control" value="" placeholder="spend total" required>
                        </div>
                        <div class="input-item form-group">
                            <div class="header-group">
                                <label for="paymentGroup" class="d-block">Thành viên tham gia (<span id="totalCountSpan" class="totalCount">0 thành viên</span>) </label>
                                <button class="btn-select-all">Tất cả</button>
                            </div>
                            <div class="member-box">
                                <?php
                                $sql_member_list = "SELECT * FROM member ORDER BY memberId ASC";
                                $query_member_list = mysqli_query($mysqli, $sql_member_list);
                                while ($row_member = mysqli_fetch_array($query_member_list)) {
                                ?>
                                    <div class="member-item">
                                        <input onchange="updateTotalCount()" onclick="changeLabelColor(this)" class="d-none" type="checkbox" name="paymentGroup[]" id="<?php echo $row_member['memberId'] ?>" value="<?php echo $row_member['memberId'] ?>">
                                        <label class="member-label" for="<?php echo $row_member['memberId'] ?>">
                                            <div class="member-image"><img src="modules/member/uploads/<?php echo $row_member['memberImage'] ?>" alt="<?php echo $row['memberName'] ?>"></div>
                                            <span class="member-title"><?php echo $row_member['memberName'] ?></span>
                                        </label>
                                    </div>
                                <?php
                                }
                                ?>
                            </div>
                        </div>
                        <button type="submit" name="spend_add" class="btn btn-primary btn-icon-text">
                            <i class="ti-file btn-icon-prepend"></i>
                            Thêm
                        </button>

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
                                <label for="title" class="d-block">Ngày chi tiêu</label>
                                <input type="date" name="spendDate" id="spendDate" class="form-control" placeholder="spend date">
                            </div>
                            <div class="input-item form-group">
                                <label for="groupId" class="d-block">Loại chi tiêu</label>
                                <select name="groupId" id="groupId" class="form-control select_category">
                                    <?php
                                    $sql_groupspend_list = "SELECT * FROM groupspend ORDER BY groupId ASC";
                                    $query_groupspend_list = mysqli_query($mysqli, $sql_groupspend_list);
                                    while ($row_groupspend = mysqli_fetch_array($query_groupspend_list)) {
                                    ?>
                                        <option value="<?php echo $row_groupspend['groupId'] ?>"><?php echo $row_groupspend['groupName'] ?></option>
                                    <?php
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="input-item form-group">
                                <label for="spendMember" class="d-block">Ai là người chi tiêu</label>
                                <div class="member-box">
                                    <?php
                                    $sql_member_list = "SELECT * FROM member ORDER BY memberId ASC";
                                    $query_member_list = mysqli_query($mysqli, $sql_member_list);
                                    while ($row_member = mysqli_fetch_array($query_member_list)) {
                                    ?>
                                        <div class="member-item">
                                            <input onchange="changeLabelColorRadio(this)" class="d-none" type="radio" name="spendMember" id="user<?php echo $row_member['memberId'] ?>" value="<?php echo $row_member['memberId'] ?>">
                                            <label class="member-label spend-member" for="user<?php echo $row_member['memberId'] ?>">
                                                <div class="member-image"><img src="modules/member/uploads/<?php echo $row_member['memberImage'] ?>" alt="<?php echo $row['memberName'] ?>"></div>
                                                <span class="member-title"><?php echo $row_member['memberName'] ?></span>
                                            </label>
                                        </div>
                                    <?php
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>

<!-- Modal -->
<div id="myModal" class="modal">
    <!-- Modal content -->
    <div class="modal-content">
        <div><span>Ai là người chi tiêu?</span><span class="close">&times;</span></div>
        <div class="input-item form-group">
            <label for="spendMember" class="d-block">danh sách thành viên</label>
            <div class="member-box">
                <?php
                $sql_member_list = "SELECT * FROM member ORDER BY memberId ASC";
                $query_member_list = mysqli_query($mysqli, $sql_member_list);
                while ($row_member = mysqli_fetch_array($query_member_list)) {
                ?>
                    <div class="member-item">
                        <input onchange="changeLabelColorRadio(this)" class="d-none" type="radio" name="" id="user<?php echo $row_member['memberId'] ?>" value="<?php echo $row_member['memberId'] ?>">
                        <label class="member-label spend-member" for="user<?php echo $row_member['memberId'] ?>">
                            <div class="member-image"><img src="modules/member/uploads/<?php echo $row_member['memberImage'] ?>" alt="<?php echo $row['memberName'] ?>"></div>
                            <span class="member-title"><?php echo $row_member['memberName'] ?></span>
                        </label>
                    </div>
                <?php
                }
                ?>
            </div>
        </div>
    </div>
</div>

<script>
    let uploadButton = document.getElementById("spendImage");
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
    // Lấy thẻ input theo id
    var spendDateInput = document.getElementById('spendDate');

    // Kiểm tra nếu giá trị mặc định rỗng, gán giá trị mặc định là ngày hiện tại
    if (!spendDateInput.value) {
        var today = new Date().toISOString().split('T')[0];
        spendDateInput.value = today;
    }
</script>

<script>
    function changeLabelColor(checkbox) {
        var label = checkbox.nextElementSibling; // Lấy phần tử label liền sau checkbox
        if (checkbox.checked) {
            label.classList.add('selected'); // Thêm lớp 'selected' vào label nếu checkbox được chọn
        } else {
            label.classList.remove('selected'); // Loại bỏ lớp 'selected' nếu checkbox không được chọn
        }
    }

    function changeLabelColorRadio(radio) {
        var labels = document.querySelectorAll('.spend-member');
        for (var i = 0; i < labels.length; i++) {
            labels[i].classList.remove('selected'); // Bỏ class 'active' khỏi tất cả các label
        }
        if (radio.checked) {
            var label = radio.nextElementSibling; // Lấy label kế tiếp của radio
            label.classList.add('selected'); // Thêm class 'active' cho label khi radio được chọn
            var modal = document.getElementById("myModal");
            modal.style.display = "none";
        }
    }

    function updateTotalCount() {
        var checkboxes = document.querySelectorAll('input[name="paymentGroup[]"]:checked');
        var totalCountSpan = document.getElementById('totalCountSpan');
        if (checkboxes.length > 0) {
            totalCountSpan.textContent = checkboxes.length + " thành viên";
        } else {
            totalCountSpan.textContent = "0 thành viên"; // Số mặc định nếu không có checkbox nào được chọn
        }
    }

    // Lấy modal
    var modal = document.getElementById("myModal");

    // Lấy nút đóng
    var closeButton = document.getElementsByClassName("close")[0];

    // Khi trang web được tải, hiển thị modal
    window.onload = function() {
        modal.style.display = "flex";
    }

    // Khi người dùng click vào nút đóng, đóng modal
    closeButton.onclick = function() {
        modal.style.display = "none";
    }
</script>

<script>
    // Hàm để chọn tất cả các checkbox
    function selectAll(event) {
        // Ngăn chặn hành động mặc định của form
        event.preventDefault();

        // Chọn tất cả các checkbox
        var checkboxes = document.querySelectorAll('input[name="paymentGroup[]"]');
        for (var i = 0; i < checkboxes.length; i++) {
            checkboxes[i].checked = true;
            // Thêm class 'selected' cho label tương ứng
            changeLabelColor(checkboxes[i]);
        }

        // Cập nhật số lượng đã chọn
        updateTotalCount();
    }

    // Lắng nghe sự kiện click của nút "Tất cả"
    var selectAllButton = document.querySelector('.btn-select-all');
    selectAllButton.addEventListener('click', selectAll);
</script>