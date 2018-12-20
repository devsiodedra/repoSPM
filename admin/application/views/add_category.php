<style type="text/css">
    .error {
            margin: 0;
            font-size: .95rem;
            color: #fe195e;
    }
    .btn_remove_input {
           /*  background: red;
            position: absolute;
            border-radius: 50%;
            color: #fff;
            top: 7px;
            right: 23px;
            cursor: pointer; */
            margin-top: 28px;
            font-size: 30px;
            color: red;
            cursor: pointer;
    }
    .select_icon {
        cursor: pointer;
    }
</style>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<?php
if (!isset($category['image']) || !$category['image']) {
    $category['image'] = NO_IMAGE_CATEGORY;
}


?>
<!-- End Left Sidebar -->
                <div class="content-inner">
                    <div class="container-fluid">
                        <!-- Begin Page Header-->
                        <div class="row">
                            <div class="page-header">
                                <div class="d-flex align-items-center">
                                    <h2 class="page-header-title"><?= $title; ?></h2>
                                    <div>
                                        <ul class="breadcrumb">
                                            <li class="breadcrumb-item"><a href="<?= base_url(); ?>"><i class="ti ti-home"></i></a></li>
                                            <li class="breadcrumb-item active"><?= $title; ?></li>
                                        </ul>
                                    </div>                              
                                </div>
                            </div>
                        </div>
                        <!-- End Page Header -->
                        <!-- Begin Row -->
                        <div class="row flex-row">
                            <div class="col-xl-12 col-12">
                                <div class="widget has-shadow">
                                    <div class="widget-body">
                                           <form class="form-horizontal" id="add_instructor">
                                            <input type="hidden" name="category_id" value="<?= (isset($category['category_id'])) ? $category['category_id'] : "" ?>">
                                            <div class="form-group row mb-3">
                                               
                                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6">
                                                    <label class="form-control-label">Category Name<span class="text-danger ml-2">*</span></label>
                                                    <input type="text" name="category" class="form-control" value="<?= (isset($category['category'])) ? $category['category'] : "" ?>">
                                                </div>
                                            </div>
                                            <div class="form-group row mb-3">
                                               
                                                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6">
                                                    <label class="form-control-label">Category For<span class="text-danger ml-2">*</span></label>
                                                    <select name="type" id="type" class="form-control">
                                                        <option value="1" <?= (isset($category['type']) && $category['type'] == '1') ? "selected" : "" ?> > Simple</option>
                                                        <option value="2" <?= (isset($category['type']) && $category['type'] == '2') ? "selected" : "" ?> >Company</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group row mb-3">
                                                <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 mb-3">
                                                    <label class="form-control-label">Select Icon <span class="text-danger ml-2">*</span></label>
                                                    
                                                    <img src="<?= $category['image'] ?>" class="add_img form-control" id="img_disp" style="cursor: pointer;  height: 100%; width: 100%;">
                                                    <input type="file" name="cat_image" id="image" class="hideMe">
                                                    <input type="hidden" name="image" id="for_cat_image" value="<?= (isset($category['image_name'])) ? $category['image_name'] : "" ?>" >
                                                   <!--  <div class="widget has-shadow" style="height: 280px; width: 340px;">
                                                        <div class="new-badge text-center">
                                                            <div class="badge-img">
                                                                <img src="assets/img/Add-icon.png" class="add_img" id="img_disp" style="cursor: pointer; max-height: 280px;">
                                                                <i class="ion-plus-round mt-3 add_img" style="font-size: 5rem; cursor: pointer;"></i>
                                                            </div>
                                                           
                                                        </div>
                                                    </div> -->
                                                </div>
                                            </div>
                                            
                                           
                                           
                                           
                                            <div class="text-right">
                                                <a href="category/"  class="btn btn-secondary mr-1">Back</a>
                                                <button class="btn btn-success mr-1 btn_save" type="button">Save</button>
                                            </div>

                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- End Row -->
                    </div>
                    <!-- End Container -->


<script type="text/javascript">

    // For Category Image
    $(document).on('click', '.add_img', function(event) {
        event.preventDefault();
        $('#image').trigger('click');
    });

    var _URL = window.URL || window.webkitURL;
    var file, img;
    $("#image").change(function (e) {
        
        $('#for_cat_image').siblings('.error').remove();

        if ((file = this.files[0])) {
            //console.log('file', file);
            img = new Image();
            img.onload = function () {
                //alert(this.width + " " + this.height);
                checkImageDImension(this.width, this.height, file);
            };
            img.src = _URL.createObjectURL(file);
           
        }
    });

    function checkImageDImension(i_width, i_height) {
        // uploadFile(file);
        //$('#img_disp').attr({src: _URL.createObjectURL(file)});

        if(i_width && i_height && i_width == "<?= CATEGORY_IMG_WIDTH ?>" && i_height == "<?= CATEGORY_IMG_HEGHT ?>") {
            
            uploadFile(file);
           $('#img_disp').attr({src: _URL.createObjectURL(file)});  
        } else {
            $('#for_cat_image').after('<label class="error">Please select image in Ratio : (<?= CATEGORY_IMG_WIDTH ?> * <?= CATEGORY_IMG_HEGHT ?>)</label>');
        }
    }
    function uploadFile(file) {
            var fd = new FormData();
            fd.append('category_file', file);
            $.ajax({
                url: 'category/uploadCategoryImage',
                type: 'POST',
                processData: false,
                contentType: false,
                data: fd,
                success: function (data, status, jqxhr) {
                    //console.log(jqxhr);
                    if(status == 'success') {
                        $('#for_cat_image').val(data);
                    } else {
                        alert('Cannot upload file.');
                    }
                },
                error: function (jqxhr, status, msg) {
                    //error code
                }
            });
    }

    var _t_sub;
    $(document).on('click', '.sub_icon', function(event) {
        _t_sub = $(this);

        $('#modal-large').modal('toggle');
    });
    $(document).on('click', '.select_icon', function(event) {
        var _this = $(this);
        var sel_icon = _this.data('id');
        _t_sub.prop('src', 'assets/img/'+sel_icon+'.png');
        _t_sub.siblings('.sub_cat_icon_name').val(sel_icon);
         $('#modal-large').modal('toggle');
    });


</script>


<script type="text/javascript">
    $(document).ready(function() {
        $(document).on('click', '.btn_save', function(event) {
           var _this = $(this);
            if($("#add_instructor").valid()) {
                _this.prop('disabled', true).text('Processing...');
                $.ajax({
                        url: "category/addCategory", 
                        type: "POST",             
                        data:  $('#add_instructor').serialize(),
                        cache: false,             
                        processData: false,      
                        success: function(data) {
                            _this.prop('disabled', false).text('Save');
                            if(data == 'success') {
                                location.replace('category/');
                            }
                        }
                });
            }

                
        });

        $('#add_instructor').validate({
                ignore: "",
                //errorElement: 'div',
                //errorClass: "invalid-feedback",
                rules: {
                    category: {
                        minlength: 3,
                        required: true
                    },
                    image: {
                        required: true
                    },
                   
                },
                messages: {
                    category: "Please specify category",
                    image: "Please select category image",
                  
                },
                submitHandler: function (form) {
                   // return true;
                }
            });


        
           
});
</script>