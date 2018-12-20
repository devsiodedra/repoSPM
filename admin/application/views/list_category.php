 <style type="text/css">
    /* .card-image {
        display: block;
        overflow: hidden;
        position: relative;
        border-radius: 4px;
        margin: 0 1.07rem; 
    }
    .card-image>img {
        display: block;
        margin-bottom: 0;
        transition: all .25s ease-in-out;
    }
    .card-overlay-01 {
        background: linear-gradient(to bottom,rgba(46,52,81,0.5) 0,rgba(106,203,224,0.95) 100%);
        z-index: 2; 
    }
    .card-overlay {
        content: "";
        bottom: 0;
        display: block;
        height: 100%;
        left: 0;
        position: absolute;
        right: 0;
        top: 0;
        width: 100%;
        z-index: 1;
    }
    .card-overlay-content {
        position: absolute;
        bottom: 0;
        padding: 1.07rem;
        z-index: 3;
    } */
    .stats .counter {
        display: block;
        color: #2c304d;
        font-size: 1.4rem;
        font-weight: 600;
        text-align: center;
    }
    .stats .text {
        display: block;
        font-weight: 600;
        text-align: center;
    }
    .stats {
            margin-top: 6px;
            margin-left: 0px;
    }
    .for_owl_width {
        width: 100%;
    }
    .for_edit {
        color: #ff9123;
        padding: 0px;
        cursor: pointer;
    }
    .for_edit:hover{

    }
    .for_delete {
        color: #ff3d3d;
        padding: 0px;
        cursor: pointer;
    }
    .for_active {
        color: #00ff40;
        padding: 0px;
        cursor: pointer;
    }
    .for_inactive {
        color: #322e33;
       padding-right: 2px;
       cursor: pointer;
    }
  
    .second_stat {
        text-align: center;
    }
    .card-image {
        max-height: 180px;
    }
    .widget-20 .card-overlay-02 {
        background: linear-gradient(to bottom,rgba(46,52,81,0.5) 0,rgba(14, 13, 13, 0.95) 100%);
        z-index: 2;
    }
    hr {
      margin-top: 1rem;
      margin-bottom: 1rem;
      border: 0;
      border-top: 1px solid rgba(0, 0, 0, 0.1);
    }
 </style>
 <!-- End Left Sidebar -->
                <div class="content-inner">
                    <div class="container-fluid">
                        <!-- Begin Page Header-->
                        <div class="row">
                            <div class="page-header">
	                            <div class="d-flex align-items-center">
	                                <h2 class="page-header-title"><?= $title; ?> 
                                    <a href="category/newCategory" class="btn btn-success"><i class="la la-plus-circle"></i>Add</a>
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
                                <div class="widget" style="background: #F2F3F8;">
                                    <div class="widget-body">
                                        <div class="row">
                                         <?php
                                        if($category) {
                                            foreach ($category as $key => $value) {
                                                ?>
                                            <div class="col-xl-4 col-lg-4 col-md-4 col-sm-6 col-remove">
                                               <div class="widget widget-20">
                                    
                                                    <div class="widget-body">
                                                        <div class="row">
                                                            <div class="col-lg-12">
                                                                <div class="widget20 owl-carousel owl-loaded owl-drag">
                                                                    
                                                                <div class="owl-stage-outer">
                                                                    <div class="owl-stage" style="">
                                                                        <div class="owl-item cloned for_owl_width">
                                                                            <div class="item"  id="category_id" data-id="<?= $value['category_id'] ?>">
                                                                                <div class="card-image">
                                                                                    <img src="<?= $value['image'] ?>" alt="...">
                                                                                    <div class="card-overlay  <?= $value['status'] == 1 ?  'card-overlay-01': 'card-overlay-02' ?>">
                                                                                        <div class="card-overlay-content">
                                                                                            <a href="javascript:void(0)" class="card-title"><?= $value['category'] ?></a>
                                                                                            <!-- <div class="category">
                                                                                                <a href="#">Category</a>
                                                                                            </div> -->
                                                                                        </div>
                                                                                    </div>
                                                                                </div>

                                                                                <div class="stats">
                                                                                    <div class="row d-flex justify-content-between">
                                                                                        <div class="col">
                                                                                            <span class="counter"><?= $value['category_count'] ?></span> 
                                                                                            <span class="text">Sub Category</span>
                                                                                        </div>
                                                                                        <div class="col">
                                                                                            <span class="counter"><?= $value['course_count'] ?></span> 
                                                                                            <span class="text">Courses</span>
                                                                                        </div>
                                                                                        
                                                                                    </div>
                                                                                </div>
                                                                                <hr/>
                                                                                <div class="stats second_stat">
                                                                                    <div class="row d-flex justify-content-between action_buttons">
                                                                                        <div class="col for_edit">
                                                                                            <a href="category/updateCategory/<?= $value['category_id'] ?>" class="for_edit">
                                                                                            <i class="la la-pencil-square"></i> Edit
                                                                                            </a>
                                                                                        </div>
                                                                                        <div class="col for_delete">
                                                                                            <i class="la la-trash-o"></i> Delete
                                                                                        </div>
                                                                                    <?php
                                                                                     if(!$value['status']) {
                                                                                    ?>
                                                                                            <div class="col for_active">
                                                                                            <i class="la la-check-circle-o"></i> Active
                                                                                    </div>
                                                                                    <?php
                                                                                     } else {
                                                                                    ?>
                                                                                            <div class="col for_inactive">
                                                                                            <i class="la la-ban"></i> Inactive
                                                                                        </div>
                                                                                    <?php
                                                                                     }
                                                                                    ?>
                                                                                         
                                                                                        
                                                                                    </div>
                                                                                </div>

                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                    
                                                            </div>
                                                            </div>
                                                        </div>
                                                      
                                                    </div>
                                                </div>
                                            </div>
                                             <?php
                                            }
                                        }
                                        ?>
                                       

                                           
                                        </div>


                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- End Row -->
                    </div>
                    <!-- End Container -->
<script type="text/javascript">
    jQuery(document).ready(function($) {

        // Delete Category
        $(document).on('click', '.for_delete', function(event) {
            var _this = $(this);
            var category_id = _this.closest('#category_id').data('id');
            
                $.ajax({
                    url: 'category/removeCategory',
                    type: 'POST',
                    data: {category_id : category_id},
                    success: function (data, status, jqxhr) {
                        if(status == 'success') {
                            _this.closest('.col-remove').hide('slow');
                        } else {
                            alert('Cannot delete category.');
                        }
                    }
                });
        });

        // Inactive Category

        $(document).on('click', '.for_inactive', function(event) {
            var _this = $(this);
            var category_id = _this.closest('#category_id').data('id');
            $.ajax({
                    url: 'category/inactiveActiveCategory',
                    type: 'POST',
                    data: {category_id : category_id, status : 0},
                    success: function (data, status, jqxhr) {
                        if(status == 'success') {
                            _this.addClass('for_active').removeClass('for_inactive').html('<i class="la la-check-circle-o"></i> Active');
                            _this.closest('#category_id').find('.card-overlay').addClass('card-overlay-02').removeClass('card-overlay-01');
                        } else {
                            alert('Cannot de-active category.');
                        }
                    }
                });
        });

        // Active Category

        $(document).on('click', '.for_active', function(event) {
            var _this = $(this);
            var category_id = _this.closest('#category_id').data('id');
            $.ajax({
                    url: 'category/inactiveActiveCategory',
                    type: 'POST',
                    data: {category_id : category_id, status : 1},
                    success: function (data, status, jqxhr) {
                        if(status == 'success') {
                            _this.addClass('for_inactive').removeClass('for_active').html('<i class="la la-ban"></i> Inactive');
                            _this.closest('#category_id').find('.card-overlay').addClass('card-overlay-01').removeClass('card-overlay-02');
                        } else {
                            alert('Cannot active category.');
                        }
                    }
                });
        });


    });
</script>