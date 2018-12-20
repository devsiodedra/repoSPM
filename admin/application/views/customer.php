<!-- End Left Sidebar -->
<style type="text/css">
</style>
                <div class="content-inner">
                    <div class="container-fluid">
                        <!-- Begin Page Header-->
                        <div class="row">
                            <div class="page-header">
                                <div class="d-flex align-items-center">
                                    <h2 class="page-header-title"><?= $title; ?>
                                        <!-- <a href="freebie/add" class="btn btn-success"><i class="la la-plus-circle"></i>Add</a> -->
                                    </h2>
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
                                        
                                       
                                        <div class="row col-xl-12">
                                            <div class="col-xl-3 mb-3">
                                                <label class="form-control-label"> Name</label>
                                                <!-- <input type="text" name="name" class="form-control " placeholder=" Name" id="name"> -->
                                                <select class="form-control" name="name" id="name">
                                                        <option value="">Select User</option>
                                                        <?php
                                                        if($customer) {
                                                            foreach ($customer as $key => $value) {
                                                                $selected = "";

                                                                if(isset($uri) && $uri && $uri['user_id']) {
                                                                    if($uri['user_id'] == $value['user_id']) {
                                                                        //$selected = "selected";
                                                                    }
                                                                }
                                                                
                                                                ?>
                                                                <option value="<?= $value['user_id'] ?>" <?= $selected ?> ><?= $value['first_name'] ?> <?= $value['last_name'] ?></option>
                                                                <?php
                                                            }
                                                        }
                                                        ?>
                                                </select>
                                            </div>
                                            <div class="col-xl-3 mb-3">
                                               <label class="form-control-label"> Mobile No.</label>
                                                <input type="text" name="phone" class="form-control " placeholder=" Mobile No." id="phone">
                                            </div>
                                            <div class="col-xl-3 mb-3">
                                                <label class="form-control-label"> Email</label>
                                                <input type="text" name="email" class="form-control " placeholder=" Email" id="email">
                                            </div>
                                            <div class="col-xl-1 mb-3">
                                               
                                            </div>
                                            <div class="col-xl-2 mb-3">
                                                <label class="form-control-label">&nbsp;</label>
                                                <button type="button" class="btn btn-primary mr-1 mb-2 mt-4 btn-filter"><i class="la la-search"></i>Search</button>
                                                
                                            </div>
                                            
                                        </div>
                                        
                                          <?= $data ?>
                                        <!-- <p class="text-primary mt-2 mb-2">Play with Elisyam :)</p> -->
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- End Row -->
                    </div>
                    <!-- End Container -->


<script type="text/javascript">


    $('#name').selectize();

    $(document).on("click", ".btn-filter", function () {

            var container = $('.xcrud-ajax');
            var data = Xcrud.list_data(container);
            data.name = $("#name").val();
            data.phone = $("[name='phone']").val();
            data.email = $("[name='email']").val();
           // var from_date = $('#from_date').val();
           // var to_date = $('#to_date').val();

           

            jQuery.ajax({
                type: "post",
                url: "customer/filter",
                beforeSend: function () {
                    Xcrud.current_task = data.task;
                    Xcrud.show_progress(container);
                },
                data: {
                    "xcrud": data
                },
                success: function (response) {
                    jQuery(container).html(response);
                    //jQuery(container).trigger("xcrudafterrequest");
                    jQuery(document).trigger("xcrudafterrequest", [container, data]);
                },
                complete: function () {
                    Xcrud.hide_progress(container);
                },
                dataType: "html",
                cache: false
            });
        });
</script>