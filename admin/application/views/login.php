<!DOCTYPE html>
<html lang="en">
<head>
        <base href="<?= site_url() ?>" />
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title><?= APP_NAME ?> - Admin Login</title>
        <meta name="description" content="<?= APP_NAME ?>">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <!-- Google Fonts -->
        <script src="<?= base_url()?>assets/webfont/1.6.26/webfont.js"></script>
        <script>
          WebFont.load({
            google: {"families":["Montserrat:400,500,600,700","Noto+Sans:400,700"]},
            active: function() {
                sessionStorage.fonts = true;
            }
          });
        </script>
        <!-- Favicon -->
        <link rel="apple-touch-icon" sizes="180x180" href="assets/img/s_logo.png">
        <link rel="icon" type="image/png" sizes="32x32" href="assets/img/s_logo.png">
        <link rel="icon" type="image/png" sizes="16x16" href="assets/img/s_logo.png">
        <!-- Stylesheet -->
        <link rel="stylesheet" href="assets/vendors/css/base/bootstrap.min.css">
        <link rel="stylesheet" href="assets/vendors/css/base/elisyam-1.0.2.min.css">
        <!-- Elisyam Slash Screen -->
        <style type="text/css">
            .error-view {
                color: red;
            }
            .fixed-btn {
                background: #5d5386;
                position: fixed;
                top: 30%;
                right: 0;
                padding: 0.7rem 1.07rem;
                text-align: center;
                border-radius: 6px 0 0 6px;
                cursor: pointer;
                z-index: 9999;
                transition: all 0.4s ease;
                transform: translateX(145px);
            }

            .fixed-btn:hover {
                background-position: right center;
                transform: translateX(0px);
            }

            .fixed-btn i {
                font-size: 2rem;
                color: #fff;
                vertical-align: middle;
            }

            .fixed-btn p {
                color: #fff;
                font-weight: 600;
                margin: 0;
            }
        </style>
        <!-- Elisyam Slash Screen -->
        <!-- Tweaks for older IEs--><!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script><![endif]-->
    </head>
    <body class="bg-fixed-05">
        <!-- Begin Preloader -->
        <div id="preloader">
            <div class="canvas">
                <img src="assets/img/s_logo.png" alt="logo" class="loader-logo">
                <div class="spinner"></div>   
            </div>
        </div>
        <!-- End Preloader -->
        <!-- Begin Container -->
        <div class="container-fluid h-100 overflow-y">
            <div class="row flex-row h-100">
                <div class="col-12 my-auto">
                    <div class="password-form mx-auto">
                        <div class="logo-centered">
                            <a href="<?= base_url(); ?>">
                                <img src="assets/img/b_logo.png" alt="logo">
                            </a>
                        </div>
                        <!-- <h3>Admin login</h3> -->
                        <form id="forms-login">
                            <div class="group material-input">
							    <input type="text" name="username" placeholder="Username / Email"  required>
							    <span class="highlight"></span>
							    <span class="bar"></span>
							    <!-- <label>Email</label> -->
                            </div>
                            <div class="group material-input">
                                <input type="password" name="password" placeholder="Password" required>
                                <span class="highlight"></span>
                                <span class="bar"></span>
                                <!-- <label>Password</label> -->
                            </div>
                        </form>
                        <div class="row">
                            <div class="col text-left">
                                <div class="styled-checkbox">
                                    <input type="checkbox" name="checkbox" id="agree">
                                    <label for="agree">Keep me signed in</label>
                                </div>
                            </div>
                        </div>

                        <div class="button text-center">
                            <a href="javascript:void(0)" class="btn btn-lg btn-gradient-01 btn_login">
                                Login
                            </a>
                        </div>
                        <!-- <div class="back">
                            <a href="pages-login.html">Sign In</a>
                        </div> -->
                    </div>        
                </div>
                <!-- End Col -->
            </div>
            <!-- End Row -->
        </div>  
        <!-- End Container --> 
        
        <!-- Begin Vendor Js -->
        <script src="assets/vendors/js/base/jquery.min.js"></script>
        <script src="assets/vendors/js/base/core.min.js"></script>
        <!-- End Vendor Js -->
        <!-- Begin Page Vendor Js -->
        <script src="assets/vendors/js/app/app.min.js"></script>
        <!-- End Page Vendor Js -->
         <script>
            $(document).ready(function () {
                $(document).keypress(function (event) {
                    if (event.keyCode == 13 || event.which == 13) {
                        $(".btn_login").trigger("click");
                    }
                });
                $(document).on("click", ".btn_login", function () {
                    $(".error-view").remove();
                    if ($(this).attr("disabled")) {
                        return false;
                    }
                    var frm = $("#forms-login");
                    var username = frm.find("[name='username']").val();
                    var password = frm.find("[name='password']").val();
                    var agree = $('#agree').is(':checked');
                    if(agree) {
                        agree = 1;
                    } else {
                        agree = 0;
                    }
                    var valid = true;
                    if (!username) {
                        var error = '<span class="error-view danger">Please enter username or email</span>';
                        frm.find("[name='username']").parents(".material-input").append(error);
                        valid = false;
                    }
                    if (!password) {
                        var error = '<span class="error-view danger">Please enter password</span>';
                        frm.find("[name='password']").parents(".material-input").append(error);
                        valid = false;
                    }

                    if (valid) {
                        _this = $(this);
                        $(this).attr("disabled", true);
                        var data = frm.serialize() + '&agree='+agree;
                        $.ajax({
                            url: "auth/login",
                            type: "post",
                            data: data,
                            success: function (resp) {
                                if (resp == "success") {
                                    

                                    location = "<?= REDIRECT_AFTER_LOGIN ?>";
                                } else if (resp == "Invalid_login") {
                                    var error = '<span class="error-view">Invalid username or password</span>';
                                    frm.find("[name='password']").parents(".material-input").append(error);
                                    _this.removeAttr("disabled");
                                } else {
                                    var error = '<span class="error-view">Oops! Something went wrong</span>';
                                    frm.find("[name='password']").parents(".material-input").append(error);
                                    _this.removeAttr("disabled");
                                }
                            }
                        });
                    }
                })
            })
        </script>
    </body>
</html>