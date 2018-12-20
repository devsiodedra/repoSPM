<style type="text/css">
    .error {
            margin: 0;
            font-size: .95rem;
            color: #fe195e;
    }
</style>
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
                            <div class="col-xl-6 col-6">
                                <div class="widget has-shadow">
                                    <div class="widget-body">
                                           <form class="form-horizontal" id="change_pass" autocomplete="off">
                                           
                                           
                                           <div class="form-group row mb-3">
                                                <div class="col-xl-12 mb-3">
                                                    <label class="form-control-label">Currunt Password</label>
                                                    <input type="password" name="current_password" class="form-control">
                                                </div>
                                            </div>
                                            <div class="form-group row mb-3">
                                                <div class="col-xl-12 mb-3">
                                                    <label class="form-control-label">New Password</label>
                                                    <input type="password" name="password" class="form-control">
                                                </div>
                                            </div>
                                            <div class="form-group row mb-3">
                                                <div class="col-xl-12">
                                                    <label class="form-control-label">Confirm New Password</label>
                                                    <input type="password" name="c_password" class="form-control">
                                                </div>
                                            </div>
                                            
                                            <div class="text-right">
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

    $('#change_pass').validate({
                ignore: "",
                //errorElement: 'div',
                //errorClass: "invalid-feedback",
                rules: {
                    current_password: {
                        required: true,
                        minlength: 6
                    },
                    password: {
                        required: true,
                        minlength: 6
                    },
                    c_password: {
                        minlength: 6,
                        equalTo: "[name='password']"
                    },
                },
                messages: {
                   
                    current_password: {
                        required: "Please enter currunt password",
                        minlength: "Enter minimum 6 characters"
                    },
                    password: {
                        required: "Please enter password",
                        minlength: "Enter minimum 6 characters"
                    },
                    c_password: {
                        required: "Please enter confirm password",
                        minlength: "Enter minimum 6 characters",
                        equalTo: "Mismatch password and confirm password"
                    },
                },
                submitHandler: function (form) {
                   // return true;
                }
                
            });


        $(document).on('click', '.btn_save', function() {
            $('label .error').remove();
            $('.alert-outline-success').remove();
            var _this = $(this);
            if($("#change_pass").valid()) {
                _this.prop('disabled', true).text('Processing...');
                $.ajax({
                        url: "profile/updatePassword", 
                        type: "POST",             
                        data:  $('#change_pass').serialize(),
                        cache: false,             
                        processData: false,      
                        success: function(data) {
                            _this.prop('disabled', false).text('Save');
                            if(data == 'success') {
                               _this.before('<label class="alert-outline-success">Password succesfully changed.</label>');
                               $('#change_pass')[0].reset();
                            } else if(data == 'currunt_password_wrong') {
                                $("input[name='current_password']").after('<label class="error">Currunt password doe not match.</label>');
                            }  else {
                                _this.after('<label class="error">Cannot change Password.</label>');
                            }
                        }
                });
            }
        });
});
</script>