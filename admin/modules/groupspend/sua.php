<?php
$sql_groupspend_edit = "SELECT * FROM groupspend WHERE groupId = '$_GET[groupspend_id]' LIMIT 1";
$query_groupspend_edit = mysqli_query($mysqli, $sql_groupspend_edit);
?>
<div class="row" style="margin-bottom: 10px;">
    <div class="col d-flex" style="justify-content: space-between; align-items: flex-end;">
        <h3>
            Sửa nhóm chi tiêu
        </h3>
        <a href="index.php?action=groupspend&query=groupspend_list" class="btn btn-outline-dark btn-fw">
            <i class="mdi mdi-reply"></i>
            Quay lại
        </a>
    </div>
</div>
<div class="row">
    <div class="col-lg-8 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <div class="card-content">
                    <form method="POST" action="modules/groupspend/xuly.php?groupspend_id=<?php echo $_GET['groupspend_id'] ?>" enctype="multipart/form-data">
                        <?php
                        while ($item = mysqli_fetch_array($query_groupspend_edit)) {
                        ?>
                            <div class="input-item form-group">
                                <label for="title" class="d-block">Tên nhóm chi tiêu</label>
                                <input type="text" name="groupspendName" class="form-control" value="<?php echo $item['groupName'] ?>" placeholder="group name" required>
                            </div>
                            <button type="submit" name="groupspend_edit" class="btn btn-primary btn-icon-text">
                                <i class="ti-file btn-icon-prepend"></i>
                                Sửa
                            </button>
                        <?php
                        }
                        ?>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>