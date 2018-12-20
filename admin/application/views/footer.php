
                    <!-- Begin Page Footer-->
                    <footer class="main-footer fixed-footer">
                        <div class="row">
                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 mt-2 mb-2 d-flex align-items-center justify-content-xl-start justify-content-lg-start justify-content-md-start justify-content-center">
                                <p>Copyright © <?= date('Y') ?> <?= APP_NAME ?> <a href="javascript:void(0)" class="external"></a></p>
                            </div>
                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 mt-2 mb-2 d-flex align-items-center justify-content-xl-end justify-content-lg-end justify-content-md-end justify-content-center">
                                <!-- <ul class="nav">
                                    <li class="nav-item">
                                        <a class="nav-link" href="#">Documentation</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="#">Purchase Now</a>
                                    </li>
                                </ul> -->
                            </div>
                        </div>
                    </footer>
                    <!-- End Page Footer -->
                    <a href="#" class="go-top"><i class="la la-arrow-up"></i></a>
                    <!-- Offcanvas Sidebar -->
                    
                    <!-- End Offcanvas Sidebar -->
                </div>
                <!-- End Content -->
            </div>
            <!-- End Page Content -->
        </div>
        
        <!-- Begin Vendor Js -->
        
        <script src="assets/vendors/js/base/core.min.js"></script>
        <!-- <script src="assets/vendors/js/bootstrap-wizard/bootstrap.wizard.min.js"></script> -->
        <!-- End Vendor Js -->
        <!-- Begin Page Vendor Js -->
        <script src="assets/vendors/js/nicescroll/nicescroll.min.js"></script>
        <script src="assets/vendors/js/owl-carousel/owl.carousel.min.js"></script>
        
        <script src="assets/vendors/js/app/app.min.js"></script>
        
        <script src="assets/vendors/js/progress/circle-progress.min.js"></script>

        <script src="assets/js/app/contact/contact.min.js"></script>
       <!--  <script src="assets/js/components/wizard/form-wizard.min.js"></script> -->
        
        <?php 
        
        $controller = $this->router->fetch_class();
        if ($controller == 'dashboard'){ ?>
            <script src="assets/vendors/js/chart/chart.min.js"></script>
            <script src="assets/js/dashboard/custom.js"></script>
        <?php } ?>

        <!-- <script src="assets/js/components/widgets/widgets.min.js"></script> -->
        <!-- End Page Vendor Js -->

        <script type="text/javascript">
            function notificationList() {
                $.ajax({
                    url: 'dashboard/notificationList',
                    type: 'POST',
                    data: {},
                    success: function(notif) {
                        $('#notification_list').html(notif);
                    }
                })
            }

            //notificationList();
            // Refresh notification after every 2 minutes
            window.setInterval(function(){
             // notificationList();
            }, 120000);
        </script>

         <script type="text/javascript">
            function notificationGenerate() {
                $.ajax({
                    url: 'dashboard/notificationGenerate',
                    type: 'POST',
                    data: {},
                    success: function(notif) {
                        if(notif && notif > 0){
                            notifyMe(notif);
                        }
                       
                    }
                })
            }

           // notificationGenerate();
            // Refresh notification after every 2 minutes
            window.setInterval(function(){
              //notificationGenerate();
            }, 60000);
        </script>


        <script type="text/javascript">
              // request permission on page load
            document.addEventListener('DOMContentLoaded', function () {
              if (!Notification) {
                alert('Desktop notifications not available in your browser. Try another.'); 
                return;
              }

              if (Notification.permission !== "granted")
                Notification.requestPermission();
            });

            function notifyMe(count) {
              if (Notification.permission !== "granted")
                Notification.requestPermission();
              else {
                var notification = new Notification(count+' New Purchase', {
                  icon: 'assets/img/s_logo.png',
                  body: "New order received. Click here to view transaction.",
                });

                notification.onclick = function () {
                  window.open("<?= base_url() ?>customer/transaction");      
                };

              }

            }


            </script>


    </body>
</html>