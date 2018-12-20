<style type="text/css">
    .error {
            margin: 0;
            font-size: .95rem;
            color: #fe195e;
    }
    .success {
            color: green;
    }
    .nav-link i {
        margin-right: 10px;
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
                            <div class="col-xl-3">
                                <!-- Begin Widget -->
                                <div class="widget has-shadow">
                                    <div class="widget-body">
                                        <div class="mt-5">
                                            <img src="<?= $user['profile_pic'] ?>" alt="..." style="width: 120px; height: 120px; background-position: center center;background-repeat: no-repeat; object-fit: cover;" class="avatar rounded-circle d-block mx-auto">
                                        </div>
                                        <h3 class="text-center mt-3 mb-1"><?= $user['first_name'] ?> <?= $user['last_name'] ?></h3>
                                        <p class="text-center"><?= $user['email'] ?></p>
                                        <div class="em-separator separator-dashed"></div>
                                      
                                            
                                      

                                    </div>
                                </div>
                                <!-- End Widget -->
                            </div>
                            <div class="col-xl-9">
                                <div class="widget has-shadow">
                                    <div class="widget-header bordered no-actions d-flex align-items-center">
                                        <h4>Profile</h4>
                                    </div>
                                    <div class="widget-body">
                                        <div class="col-9 ml-auto">
                                            <div class="section-title mt-3 mb-3">
                                                <h4>01. Personnal Informations</h4>
                                            </div>
                                        </div>
                                        <form class="form-horizontal" id="customer">
                                            <input type="hidden" name="user_id" value="<?= $user['user_id'] ?>">
                                            <div class="form-group row d-flex align-items-center mb-5">
                                                <label class="col-lg-3 form-control-label d-flex justify-content-lg-end">User ID</label>
                                                <div class="col-lg-6">
                                                    <input type="text" class="form-control" value="<?= $user['user_id'] ?>" disabled>
                                                </div>
                                            </div>
                                            <div class="form-group row d-flex align-items-center mb-5">
                                                <label class="col-lg-3 form-control-label d-flex justify-content-lg-end">First Name</label>
                                                <div class="col-lg-6">
                                                    <input type="text" name="first_name" class="form-control" value="<?= $user['first_name'] ?>" >
                                                </div>
                                            </div>
                                            <div class="form-group row d-flex align-items-center mb-5">
                                                <label class="col-lg-3 form-control-label d-flex justify-content-lg-end">Last Name</label>
                                                <div class="col-lg-6">
                                                    <input type="text" name="last_name" class="form-control" value="<?= $user['last_name'] ?>" >
                                                </div>
                                            </div>
                                            <!-- <div class="form-group row d-flex align-items-center mb-5">
                                                <label class="col-lg-3 form-control-label d-flex justify-content-lg-end">Gender</label>
                                                <div class="col-lg-6">
                                                    <select name="gender" class="form-control">
                                                        <option value="male" <?= ($user['gender'] == 'male') ? 'selected' : '' ?> >Male</option>
                                                        <option value="female" <?= ($user['gender'] == 'female') ? 'selected' : '' ?>>Female</option>
                                                       
                                                    </select>
                                                </div>
                                            </div> -->
                                            <div class="form-group row d-flex align-items-center mb-5">
                                                <label class="col-lg-3 form-control-label d-flex justify-content-lg-end">Email</label>
                                                <div class="col-lg-6">
                                                    <input type="text" name="email" class="form-control"  value="<?= $user['email'] ?>" >
                                                </div>
                                            </div>
                                            <div class="form-group row d-flex align-items-center mb-5">
                                                <label class="col-lg-3 form-control-label d-flex justify-content-lg-end">Mobile No.</label>
                                                <div class="col-lg-6">
                                                    <input type="text" name="phone" class="form-control"  value="<?= $user['phone'] ?>" >
                                                </div>
                                            </div>
                                         
                                           
                                        </form>


                                        
                                        <div class="em-separator separator-dashed"></div>
                                        <div class="text-right">
                                            <a href="javascript:void(0)" class="btn btn-gradient-01 btn_save" >Save Changes</button>
                                            <a href="customer/" class="btn btn-secondary mr-1">Back</a>
                                            <!-- <button class="btn btn-shadow for_back" type="button">Back</button> -->

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- End Row -->
                    </div>
<script type="text/javascript">
 

</script>
<script src='assets/autosize-master/dist/autosize.js'></script>
<script>
        autosize(document.querySelectorAll('textarea'));


$(document).on('change', '#country', function(event) {
    var country = $(this).val();

    $.ajax({
        url: 'customer/stateBycountryId',
        type: 'POST',
        data: {country: country},
        success: function (resp) {
            $('#state').html(resp);
            setTimeout(function() { 
                 $('#state').trigger('change'); 
            }, 100);
           

        }
    })
    
});

$(document).on('change', '#state', function(event) {
    var state = $(this).val();

    $.ajax({
        url: 'customer/cityBystateId',
        type: 'POST',
        data: {state: state},
        success: function (resp) {
            $('#city').html(resp);
        }
    })
    
});

jQuery(document).ready(function($) {
    $('#customer').validate({
                ignore: "",
                //errorElement: 'div',
                //errorClass: "invalid-feedback",
                rules: {
                    first_name: {
                        required: true,
                    },
                    last_name: {
                        required: true,
                    },
                    gender: {
                        // required: true,
                     },
                    email: {
                        required: true,
                        email: true,
                    },
                    phone: {
                       // required: true,
                        number: true
                     },
                    
                  
                   
                },
                messages: {
                  
                    name: "Please specify name",
                    gender: "Please select gender",
                    email: {
                      required: "Please enter email address",
                      email: "Your email address must be in the format of name@domain.com",
                    },
                    phone: {
                      required: "Please enter mobile no.",
                      number: "Enter valid mobile no.",
                    },
                   
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
            if($("#customer").valid()) {
                _this.prop('disabled', true).text('Processing...');
                $.ajax({
                        url: "customer/saveCustomer", 
                        type: "POST",             
                        data:  $('#customer').serialize(),      
                        success: function(data) {
                            _this.prop('disabled', false).text('Save');
                            if(data == 'success') {
                            //  location.replace('store');
                            _this.after('<label class="success success_save">Customer saved.</label>');
                            } else if(data == 'email_exist') {
                               $("input[name='email']").after('<label class="error">Email is already registered.</label>');
                            } else {
                                _this.after('<label class="error cannot_save">Cannot save customer.</label>');
                            }
                        }
                });
            }
    
});

</script>