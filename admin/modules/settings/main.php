<div class="row" style="margin-bottom: 10px;">
    <div class="col d-flex" style="justify-content: space-between; align-items: flex-end;">
        <h3 class="card-title">
            Cài đặt chung
        </h3>
    </div>
</div>
<form method="POST" action="modules/product/xuly.php" id="form-product" enctype="multipart/form-data">
    <div class="row">
        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">
                
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