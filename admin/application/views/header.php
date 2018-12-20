<!DOCTYPE html>

<html lang="en">
    
<head>
        <base href="<?= site_url() ?>">
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title><?= APP_NAME ?></title>
        <meta name="description" content="<?= APP_NAME ?>">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <!-- Google Fonts -->
        <script src="assets/webfont/1.6.26/webfont.js"></script>
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
        <link rel="stylesheet" href="assets/css/owl-carousel/owl.carousel.min.css">
        <link rel="stylesheet" href="assets/css/owl-carousel/owl.theme.min.css">

        <link rel="stylesheet" href="assets/icons/icomoon/style.css">
        <!-- <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" /> -->
        <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.12.6/css/selectize.css">
        
        <script src="assets/vendors/js/base/jquery.min.js"></script>
        <script src="assets/js/custom-validation.js"></script>
        <!-- <script type="text/javascript" src="assets/js/html5lightbox.js"></script> -->
        <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script> -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.12.6/js/standalone/selectize.js" type="text/javascript"></script>
        <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.17.0/jquery.validate.min.js"></script> -->
        <!-- Elisyam Slash Screen -->
        <style type="text/css">

        /* Start Change Theme Color */
            .default-sidebar {
                background: #3278BD;
            }
            .default-sidebar>.side-navbar a[aria-expanded="true"] {
                background: #1c65ad;
            }
            .default-sidebar>.side-navbar ul ul {
                background: #1c65ad;
            }
            .btn-primary {
                color: #fff;
                background-color: #007bff;
                border-color: #007bff;
            }
            .btn-primary:hover {
                color: #fff;
                background-color: #0069d9;
                border-color: #0062cc;
            }
            nav.navbar .user-size.dropdown-menu a.logout {
                background: #007bff;
            }
            .spinner {
                border-top: solid 5px #007bff;
            }
            /* End Change Theme Color */

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

            .hideMe {
                display: none;
            }

            #xcrud-modal-window img {
                width: 100% !important;
            }
            .xcrud-list td {
                vertical-align: top !important;
            }

            select {
                  -webkit-appearance: none;
                  -moz-appearance: none;
                  appearance: none;
            }
            .xcrud-nav .pagination>li>a, .pagination>li>span {
                position: relative;
                float: left;
                padding: 6px 12px;
                margin-left: -1px;
                line-height: 1.428571429;
                text-decoration: none;
                background-color: #fff;
                border: 1px solid #ddd;
            }

            .xcrud-nav .pagination {
                /*display: inline-block;*/
                padding-left: 0;
                margin: 20px 0;
                border-radius: 4px;
            }
            .xcrud-list a {
                   /* text-decoration: underline;*/
            }
            
        </style>
        <!-- Elisyam Slash Screen -->
        <!-- Tweaks for older IEs--><!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script><![endif]-->

        <script type="text/javascript">
            jQuery.validator.addMethod("email", function (value, element) {
                var email_rex = /^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$/i;
                return this.optional(element) || email_rex.test(value);
            }, "Enter valid email");

            function getExt(filename) {
                var ext = filename.split(".");
                var cnt = ext.length;
                ext = ext[cnt - 1];
                ext = "." + ext.toLowerCase();
                return ext;
            }
            function getFileType(filename) {
                var ext = getExt(filename);
                if (ext == ".mp3") {
                    return "Audio";
                } else if (ext == ".mp4") {
                    return "Video";
                } else if (ext == ".jpg" || ext == ".jpeg" || ext == ".bmp" || ext == ".png" || ext == ".gif") {
                    return "Image";
                } else if(ext == '.pdf') {
                    return 'Pdf';
                }
            }

        

        </script>
    </head>
    <body id="page-top">

      

        <!-- Begin Preloader -->
        <div id="preloader">
            <div class="canvas">
                <img src="assets/img/s_logo.png" alt="logo" class="loader-logo">
                <div class="spinner"></div>   
            </div>
        </div>
        <!-- End Preloader -->
        <div class="page">
            <!-- Begin Header -->
            <header class="header">
                <nav class="navbar fixed-top">         
                    <!-- Begin Search Box-->
                    <div class="search-box">
                        <button class="dismiss"><i class="ion-close-round"></i></button>
                        <form id="searchForm" action="#" role="search">
                            <input type="search" placeholder="Search something ..." class="form-control">
                        </form>
                    </div>
                    <!-- End Search Box-->
                    <!-- Begin Topbar -->
                    <div class="navbar-holder d-flex align-items-center align-middle justify-content-between">
                        <!-- Begin Logo -->
                        <div class="navbar-header">
                            <a href="<?= base_url(); ?>" class="navbar-brand">
                                <div class="brand-image brand-big">
                                    <img src="assets/img/b_logo.png" alt="logo" class="logo-big">
                                </div>
                                <div class="brand-image brand-small">
                                    <img src="assets/img/b_logo.png" alt="logo" class="logo-small">
                                </div>
                            </a>
                            <!-- Toggle Button -->
                            <a id="toggle-btn" href="#" class="menu-btn active">
                                <span></span>
                                <span></span>
                                <span></span>
                            </a>
                            <!-- End Toggle -->
                        </div>
                        <!-- End Logo -->
                        <!-- Begin Navbar Menu -->
                        <ul class="nav-menu list-unstyled d-flex flex-md-row align-items-md-center pull-right">
                            <!-- Search -->
                           <!--  <li class="nav-item d-flex align-items-center hide"><a id="search" href="#"><i class="la la-search"></i></a></li> -->
                            <!-- End Search -->
                            <!-- Begin Notifications -->
                            <li class="nav-item dropdown" id="notification_list">

                                    
                            </li>
                            
                            <!-- End Notifications -->
                            <!-- User -->
                            <li class="nav-item dropdown"><a id="user" rel="nofollow" data-target="#" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="nav-link"><img src="assets/img/avatar-01.jpg" alt="..." class="avatar rounded-circle"></a>
                                <ul aria-labelledby="user" class="user-size dropdown-menu">
                                    <li class="welcome">
                                        <a href="javascript:void(0)" class="edit-profil"><i class="la la-gear"></i></a>
                                        <img src="assets/img/avatar-01.jpg" alt="..." class="rounded-circle">
                                    </li>
                                    <li>
                                        <a href="profile" class="dropdown-item"> 
                                            Profile
                                        </a>
                                    </li>
                                   <!--  <li>
                                        <a href="app-mail.html" class="dropdown-item"> 
                                            Messages
                                        </a>
                                    </li> -->
                                    <li>
                                        <a href="profile/change_password" class="dropdown-item no-padding-bottom"> 
                                            Change Password
                                        </a>
                                    </li>
                                    <li class="separator"></li>
                                    <!-- <li>
                                        <a href="pages-faq.html" class="dropdown-item no-padding-top"> 
                                            Faq
                                        </a>
                                    </li> -->
                                    <li><a rel="nofollow" href="auth/logout" class="dropdown-item logout text-center"><i class="ti-power-off"></i></a></li>
                                </ul>
                            </li>
                            <!-- End User -->
                            <!-- Begin Quick Actions -->
                            <li class="nav-item"><a href="#off-canvas" class="open-sidebar"><!-- <i class="la la-ellipsis-h"> --></i></a></li>
                            <!-- End Quick Actions -->
                        </ul>
                        <!-- End Navbar Menu -->
                    </div>
                    <!-- End Topbar -->
                </nav>
            </header>
            <!-- End Header -->
            <!-- Begin Page Content -->



            <!-- Offline Purchase Modal Start -->
<div id="modal-detail" class="modal fade">
            <div class="modal-dialog modal-lg">
                <div class="modal-content detail_content">
                    
                </div>
            </div>
</div>

<!-- Offline Purchase Modal End -->



<script type="text/javascript">

    // if(typeof(EventSource) !== "undefined") {
    //     var source = new EventSource("auth/notification_update");
    //     console.log(source);
    //     source.onmessage = function(event) {
    //         document.getElementById("result").innerHTML += event.data + "<br>";
    //     };
    // } else {
    //     document.getElementById("result").innerHTML = "Sorry, your browser does not support server-sent events...";
    // }

    
   


   

   

</script>