<style type="text/css">
    .username {
        color: #e76c90;
    }
</style>
<a id="notifications" rel="nofollow" data-target="#" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="nav-link">
    <i class="la la-bell animated infinite swing"></i>
    <?php if($noti_count > 0) { ?>
    <span class="badge-pulse"></span>
    <?php } ?>
</a>
    <ul aria-labelledby="notifications" class="dropdown-menu notification">

        <li>
        <div class="notifications-header">
            <div class="title">Notifications (<?= $noti_count ?>)</div>
            <div class="notifications-overlay"></div>
            <img src="assets/img/notifications/01.jpg" alt="..." class="img-fluid">
        </div>
        </li>

        <?php
        if(isset($noti) && $noti) {
            foreach ($noti as $key => $value) {
               
        ?>

            <li>
            <a href="<?= $value['transaction_id'] ? 'customer/transaction/transaction_id/'.$value['transaction_id']  : '#' ?>" id="notification_list_li">
                <div class="message-icon">
                    <i class="la la-user"></i>
                </div>
                <div class="message-body">
                    <div class="message-body-heading">
                       </span> New  of <b> <?= $value['freebees']['name'] ?> </b> By <span class="username"><?= $value['name'] ?>
                    </div>
                    <span class="date"><?= $value['date'] ?></span>
                </div>
            </a>
            </li>

        <?php
            }
            echo '<li><a rel="nofollow" href="customer/transaction/transaction_id/'.$noti[0]["transaction_id"].'" class="dropdown-item all-notifications text-center">View All Transactions</a></li>';
        }
        ?>

<!-- <li>
<a rel="nofollow" href="javascript:void(0)" class="dropdown-item all-notifications text-center">View All Notifications</a>
</li> -->

</ul>