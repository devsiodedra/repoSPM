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
<div class="content-inner profile">
                    <div class="container-fluid">
                        <!-- Begin Page Header-->
                        <div class="row">
                            <div class="page-header">
                                <div class="d-flex align-items-center">
                                    <h2 class="page-header-title"><?= $title ?></h2>
                                    <div>
                                        <ul class="breadcrumb">
                                            <li class="breadcrumb-item"><a href="<?= base_url(); ?>"><i class="ti ti-home"></i></a></li>
                                            <!-- <li class="breadcrumb-item"><a href="#">Pages</a></li> -->
                                            <li class="breadcrumb-item active"><?= $title ?></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- End Page Header -->
                        <div class="row">
                            <div class="col-xl-12">
                                <div class="widget has-shadow">
                                    <div class="widget-header bordered no-actions d-flex align-items-center">
                                        <h4>Settings</h4>
                                    </div>
                                    <div class="widget-body">
                                        <div class="col-9 ml-auto">
                                            <div class="section-title mt-3 mb-3">
                                                <h4>SMTP Email Configuration</h4>
                                            </div>
                                        </div>
                                        <form class="form-horizontal" id="smtp_email">
                                            <input type="hidden" name="" value="">
                                            <div class="form-group row d-flex align-items-center mb-5">
                                                <label class="col-lg-3 form-control-label d-flex justify-content-lg-end">Email</label>
                                                <div class="col-lg-6">
                                                    <input type="text" class="form-control" value="<?= $admin_data[0]['value']; ?>" name="smtp_user">
                                                </div>
                                            </div>
                                            <div class="form-group row d-flex align-items-center mb-5">
                                                <label class="col-lg-3 form-control-label d-flex justify-content-lg-end">Password</label>
                                                <div class="col-lg-6">
                                                    <input type="password" name="smtp_pass" class="form-control" value="<?= $admin_data[1]['value']; ?>" >
                                                </div>
                                            </div>
                                            <div class="form-group row d-flex align-items-center mb-5">
                                                <label class="col-lg-3 form-control-label d-flex justify-content-lg-end">Host</label>
                                                <div class="col-lg-6">
                                                    <input type="text" name="smtp_host" class="form-control"  value="<?= $admin_data[2]['value']; ?>" >
                                                </div>
                                            </div>
                                            <div class="form-group row d-flex align-items-center mb-5">
                                                <label class="col-lg-3 form-control-label d-flex justify-content-lg-end">Port</label>
                                                <div class="col-lg-6">
                                                    <input type="text" name="smtp_port" class="form-control"  value="<?= $admin_data[3]['value']; ?>" >
                                                </div>
                                            </div>
                                             <div class="form-group row d-flex align-items-center mb-5">
                                                <label class="col-lg-3 form-control-label d-flex justify-content-lg-end">From Email</label>
                                                <div class="col-lg-6">
                                                    <input type="text" name="smtp_from" class="form-control"  value="<?= $admin_data[8]['value']; ?>" >
                                                </div>
                                            </div>
                                             <div class="form-group row d-flex align-items-center mb-5">
                                                <label class="col-lg-3 form-control-label d-flex justify-content-lg-end">Replay To Email</label>
                                                <div class="col-lg-6">
                                                    <input type="text" name="smtp_reply_to" class="form-control"  value="<?= $admin_data[9]['value']; ?>" >
                                                </div>
                                            </div>
                                        
                                         
                                           
                                        </form>


                                        
                                        <div class="em-separator separator-dashed"></div>
                                        <div class="section-title mt-5 mb-5">
                                        <h4>Note : </h4>
                                        <span style="color: red;"> In case you are using Gmail SMTP. Turn ON <a href="https://myaccount.google.com/lesssecureapps" target="_blank" style="color: green;"> Less Secure App </a> Settings. </span>
                                    </div>

                                        <div class="text-right">
                                            <a href="javascript:void(0)" class="btn btn-gradient-01 btn_save" >Save Changes</a>
                                            <!-- <a href="/" class="btn btn-secondary mr-1">Back</a> -->
                                            <!-- <button class="btn btn-shadow for_back" type="button">Back</button> -->

                                        </div>

                                    </div>

                                </div>
                            </div>
                        </div>
                        <!-- End Row -->
                    </div>

<script>


jQuery(document).ready(function($) {
    $('#smtp_email').validate({
                ignore: "",
                //errorElement: 'div',
                //errorClass: "invalid-feedback",
                rules: {
                    smtp_user: {
                        required: true,
                        email: true,
                    },
                    smtp_pass: {
                         required: true,
                     },
                    smtp_host: {
                        required: true,
                    },
                    smtp_port: {
                        required: true,
                        number: true
                     },
                    smtp_from: {
                        required: true,
                        email: true,
                    },
                    smtp_reply_to: {
                        required: true,
                        email: true,
                    },
                  
                   
                },
                messages: {
                  
                   
                },
                submitHandler: function (form) {
                   // return true;
                }
                
            });

});
$(document).on('click', '.btn_save', function(event) {
    $('label .error').remove();
    $('.cannot_save').remove();  $('.success_save').remove();
    var _this = $(this);
            if($("#smtp_email").valid()) {
                _this.prop('disabled', true).text('Processing...');
                $.ajax({
                        url: "settings/save_settings", 
                        type: "POST",             
                        data:  $('#smtp_email').serialize(),      
                        success: function(data) {
                            _this.prop('disabled', false).text('Save Changes');
                            if(data == 'success') {
                            //  location.replace('store');
                            _this.after('<label class="success success_save">SMTP Email saved.</label>');
                            } else {
                                _this.after('<label class="error cannot_save">Cannot save SMTP Email.</label>');
                            }
                        }
                });
            }
    
});

</script>