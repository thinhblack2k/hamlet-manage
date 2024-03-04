<div class="row" style="margin-bottom: 10px;">
    <div class="col d-flex" style="justify-content: space-between; align-items: flex-end;">
        <h3>
            Thêm thành viên
        </h3>
        <a href="index.php?action=member&query=member_list" class="btn btn-outline-dark btn-fw">
            <i class="mdi mdi-reply"></i>
            Quay lại
        </a>
    </div>
</div>
<form method="POST" action="modules/member/xuly.php" enctype="multipart/form-data">
    <div class="row">
        <div class="col-lg-8 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <div class="card-content">

                        <div class="input-item form-group">
                            <label for="title" class="d-block">Tên thành viên</label>
                            <input type="text" name="memberName" class="form-control" value="" placeholder="member name" required>
                        </div>
                        <div class="input-item form-group">
                            <label for="title" class="d-block">Tổng chi</label>
                            <input type="text" name="totalExpend" class="form-control" value="" placeholder="total expend" required>
                        </div>
                        <div class="input-item form-group">
                            <label for="title" class="d-block">Tổng nợ</label>
                            <input type="text" name="totalLoss" class="form-control" value="" placeholder="total loss" required>
                        </div>
                        <div class="input-item form-group">
                            <label for="title" class="d-block">Ghi chú</label>
                            <textarea class="form-control" name="memberNote" type="text" value="" placeholder="member note" style="height: auto;"></textarea>
                        </div>
                        <button type="submit" name="member_add" class="btn btn-primary btn-icon-text">
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
                                <label class="d-block" for="memberImage">Image</label>
                                <div class="image-box w-100">
                                    <figure class="image-container p-relative">
                                        <img id="chosen-image">
                                        <figcaption id="file-name"></figcaption>
                                    </figure>
                                    <input type="file" class="d-none" id="memberImage" name="memberImage" accept="image/*">
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