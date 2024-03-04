<div class="row" style="margin-bottom: 10px;">
    <div class="col d-flex" style="justify-content: space-between; align-items: flex-end;">
        <h3>
            Thêm nhóm chi tiêu
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
                    <form method="POST" action="modules/groupspend/xuly.php" enctype="multipart/form-data">
                        <div class="input-item form-group">
                            <label for="title" class="d-block">Tên nhóm chi tiêu</label>
                            <input type="text" name="groupspendName" class="d-block form-control" value="" placeholder="Nhập vào tên danh mục" required>
                        </div>
                        <button type="submit" name="groupspend_add" class="btn btn-primary btn-icon-text mg-t-16">
                            <i class="ti-file btn-icon-prepend"></i>
                            Thêm
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>