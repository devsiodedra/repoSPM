<style type="text/css">
    .error {
            margin: 0;
            font-size: .95rem;
            color: #fe195e;
    }
    .success {
        color: green;
    }
</style>
<?php
if (!isset($profile['profile_pic']) || !$profile['profile_pic']) {
    $profile['profile_pic'] = NO_IMAGE;
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
                                           <form class="form-horizontal" id="add_instructors" autocomplete="off">
                                            <input type="hidden" name="admin_id" value="<?= (isset($profile['admin_id'])) ? $profile['admin_id'] : "" ?>" id="admin_id">
                                          <!--  <div class="form-group row mb-3">
                                                <div class="col-xl-6 offset-md-5 mb-3">
                                                    <img style="width: 150px; height: 150px; border-radius: 50%; cursor: pointer" src="<?= $profile['profile_pic'] ?>" class="select_image" data-s3='1'>
                                                    <input type="file" name="user_image" id="image" class="hideMe">
                                                    <input type="hidden" name="profile_pic" id="profile_pic" value="<?= (isset($profile['profile_pic_name'])) ? $profile['profile_pic_name'] : "" ?>"">
                                                    <div class="progress hide" style="width: 150px; margin-top: 5px;">
                                                        <div class="progress-bar" id="progress" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"><span class="trackerball">0%</span></div>
                                                    </div>
                                                </div>
                                            </div> -->
                                            <div class="form-group row mb-3">
                                                <div class="col-xl-6 mb-3">
                                                    <label class="form-control-label">Name<span class="text-danger ml-2">*</span></label>
                                                    <input type="text" name="full_name" class="form-control" value="<?= (isset($profile['full_name'])) ? $profile['full_name'] : "" ?>" placeholder="Full name">
                                                </div>
                                                <div class="col-xl-6">
                                                    <label class="form-control-label">Email<span class="text-danger ml-2">*</span></label>
                                                    <input type="email" name="email" class="form-control" value="<?= (isset($profile['email'])) ? $profile['email'] : "" ?>" placeholder="Email address">
                                                </div>
                                            </div>
                                            <div class="form-group row mb-3">
                                                <div class="col-xl-6 mb-3">
                                                    <label class="form-control-label">Address<span class="text-danger ml-2">*</span></label>
                                                     <textarea class="form-control" name="address" placeholder="Type Address bio here ..." required><?= (isset($profile['address'])) ? $profile['address'] : "" ?></textarea>
                                                </div>
                                                <div class="col-xl-6">
                                                    <label class="form-control-label">Mobile No<span class="text-danger ml-2">*</span></label>
                                                    <input type="text" name="phone" class="form-control" value="<?= (isset($profile['phone'])) ? $profile['phone'] : "" ?>" placeholder="Mobile No">
                                                </div>
                                            </div>
                                            
                                         
                                            <div class="text-right">
                                                <!-- <a href="/" class="btn btn-secondary mr-1">Back</a> -->
                                                <button class="btn btn-gradient-01 btn_save" type="button">Save</button>
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
jQuery(document).ready(function($) {

    $('#add_instructors').validate({
                ignore: "",
                //errorElement: 'div',
                //errorClass: "invalid-feedback",
                rules: {
                    full_name: {
                        minlength: 3,
                        required: true,
                    },
                    email: {
                        required: true,
                        email: true,
                    },
                    phone: {
                        required: true,
                        number: true,
                    },
                    address: {
                        required: true,
                    },
                  
                },
                messages: {
                    full_name: "Please specify name",
                    email: {
                      required: "Please enter email address",
                      email: "Your email address must be in the format of name@domain.com",
                    },
                    phone: "Please enter phone number",
                    address: "Please enter address",
                   
                },
                submitHandler: function (form) {
                   // return true;
                }
                
            });


        $(document).on('click', '.btn_save', function() {
            $('label .error').remove(); 
            $('.success').remove();
            var _this = $(this);
            if($("#add_instructors").valid()) {
                _this.prop('disabled', true).text('Processing...');
                $.ajax({
                        url: "profile/save", 
                        type: "POST",             
                        data:  $('#add_instructors').serialize(),
                        cache: false,             
                        processData: false,      
                        success: function(data) {
                            _this.prop('disabled', false).text('Save');
                            if(data == 'success') {
                               //location.replace('profile/');
                              // var htm = '<div class="alert alert-success alert-dissmissible fade show" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"></button><strong>Hey!</strong>Successfully saved.</div>';
                               var htm = '<label class="success">Successfully saved.</label>';

                                _this.after(htm);
                            } else if(data == 'user_exist') {
                               $("input[name='email']").after('<label class="error">Email is already registered.</label>');
                            } else {
                                _this.after('<label class="error">Cannot save instructor.</label>');
                            }
                        }
                });
            }
        });
});



$(document).ready(function() {
        

    $(document).on('click', '.select_image', function(event) {
        event.preventDefault();
        $('#image').trigger('click');
    });
    var _URL = window.URL || window.webkitURL;
    var file, img;
    $("#image").change(function (e) {
        
        $('#profile_pic').siblings('.error').remove();

        if ((file = this.files[0])) {
           var ext = file.name.split('.').pop();
           if(ext == 'jpg' || ext == 'png' || ext == 'jpeg' || ext == 'gif' || ext == 'bmp') {
                $('.select_image').attr({src: _URL.createObjectURL(file)});
                uploadFile(file);
           } else {
                $('#profile_pic').after('<label class="error">Please select file in image formate (.jpg  .png  .jpeg  .gif  .bmp).</label>');
           }
           
        }
    });

    function uploadFile(file) {
            var fd = new FormData();
            fd.append('profile_pic', file);
            $.ajax({
                url: 'instructor/uploadFile',
                type: 'POST',
                processData: false,
                contentType: false,
                data: fd,
                success: function (data, status, jqxhr) {
                    //console.log(jqxhr);
                    if(status == 'success') {
                        $('#profile_pic').val(data);
                    } else {
                        alert('Cannot upload file.');
                    }
                },
                error: function (jqxhr, status, msg) {
                    //error code
                }
            });
    }

       /* $(document).on("click", "[data-s3='1']", function () {
            $("#frm_s3upload #s3file").trigger("click");
        });*/
           
});
</script>

<script src='assets/autosize-master/dist/autosize.js'></script>
<script>
        autosize(document.querySelectorAll('textarea'));
</script>