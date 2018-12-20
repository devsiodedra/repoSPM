<?php

function created_at($postdata, $xcrud) {
    $postdata->set('created_at', date("Y-m-d H:i:s"));
}

function cb_active_inactive($value, $fieldname, $primary, $row, $xcrud){
    if($value){
        return "<font color='green'>Active</font>";
    }
    return "<font color='red'>Inactive</font>";
}
function cb_transactions_rchips($value, $fieldname, $primary, $row, $xcrud){
    // if($value > 0){
    //     return "<font color='green'>".$value."</font>";
    // }
    

    if($primary) {
        $db = Xcrud_db::get_instance();

        $query = 'SELECT * FROM transaction WHERE  transaction_id = ' . (int) $primary;
        $db->query($query);
        $result = $db->result();
        if($result && $result[0]) {

            if($result[0]['type'] == 'offline_purchase') {
                 return "<font color='green'>".$value." </font>";
            } else {
                 return "<font color='red'>".$value." </font>";
            }
        }
    } else {
        return "<font color='red'>".$value."</font>";
    }

}

function cb_download_qr_code($value, $fieldname, $primary, $row, $xcrud)
{
   return '<a href="../uploads/'.$value.'" download> Download </a>';
}
function cb_transactions_store($value, $fieldname, $primary, $row, $xcrud){
    
    if($primary) {
        $db = Xcrud_db::get_instance();

        $query = 'SELECT * FROM transaction WHERE  transaction_id = ' . (int) $primary;
        $db->query($query);
        $result = $db->result();
        if($result && $result[0]) {

            if($result[0]['type'] == 'offline_purchase') {
                $a = 1;
                 $url =  '<a href="store/edit/'. $result[0]['store_id'] .' "> '.$value.' </a>';
                 return $url;
            } else {
                 return "N/A";
            }
        }
    } else {
        return "";
    }

}
function cb_transactions_amount($value, $fieldname, $primary, $row, $xcrud){
    
    if($primary) {
        $db = Xcrud_db::get_instance();

        $query = 'SELECT * FROM transaction WHERE  transaction_id = ' . (int) $primary;
        $db->query($query);
        $result = $db->result();
        if($result && $result[0]) {

            if($result[0]['type'] == 'offline_purchase') {
               return $value;
            } else {
                 return "N/A";
            }
        }
    } else {
        return "";
    }

}
function cb_transactions_promo_percentage($value, $fieldname, $primary, $row, $xcrud){
    
    if($primary) {
        $db = Xcrud_db::get_instance();

        $query = 'SELECT * FROM transaction WHERE  transaction_id = ' . (int) $primary;
        $db->query($query);
        $result = $db->result();
        if($result && $result[0]) {

            if($result[0]['type'] == 'offline_purchase') {
               return $value;
            } else {
                 return "N/A";
            }
        }
    } else {
        return "";
    }

}
function cb_store_open_close($value, $fieldname, $primary, $row, $xcrud){

    if ($value) {
        $db = Xcrud_db::get_instance();

        $query = 'SELECT * FROM store_timings WHERE day_name = dayname(now()) AND store_id = ' . (int) $primary;
        $db->query($query);
        $result = $db->result();
        if($result && $result[0]) {
           // return 'currunt '. date('G:i'). ' start '. $result[0]['start_time']. ' end'. $result[0]['end_time']; exit;
            if($result[0]['is_closed']) {
                return '<span style="width:100px;"><span class="badge-text badge-text-small danger">Closed</span></span>';
            } else if(date('G:i') >= $result[0]['start_time']  && date('G:i') <= $result[0]['end_time'] ) {
                return '<span style="width:100px;"><span class="badge-text badge-text-small success">Open</span></span>';
            } else if( ($result[0]['start_time'] > date('G:i')) ||(date('G:i') > $result[0]['end_time'] )) {
                return '<span style="width:100px;"><span class="badge-text badge-text-small danger">Closed</span></span>';
            }

            // default status
            // $status = 'closed';

            // if (($result[0]['start_time'] < date('G:i')) && (date('G:i') < $result[0]['end_time'])) {
            //     $status = 'open';
            //    // break;
            // }
            // return $status;
        }

    }

   
}

function second_to_time($value, $fieldname, $primary_key, $row, $xcrud) {
    if ($value >= 60) {
        $min = floor($value / 60);
        $sec = $value % 60;
        if ($min && $sec) {
            return "$min Min $sec Sec";
        } else if ($min) {
            return "$min Min";
        } else if ($sec) {
            return "$sec Sec";
        }
    } else {
        return "$value Sec";
    }
}


function _parse_smily($value, $fieldname, $primary, $row, $xcrud) {
    //return emoji_unified_to_html($value);
    return json_decode('"'.$value.'"');
}
function active_category($xcrud) {

    if ($xcrud->get('primary')) {
        $db = Xcrud_db::get_instance();
        $query = 'UPDATE category SET status = 1 WHERE category_id = ' . (int) $xcrud->get('primary');
        $db->query($query);
    }
}

function inactive_category($xcrud) {

    if ($xcrud->get('primary')) {
        $db = Xcrud_db::get_instance();
        $query = 'UPDATE category SET status = 0 WHERE category_id = ' . (int) $xcrud->get('primary');
        $db->query($query);
    }
}

function active_store($xcrud) {

    if ($xcrud->get('primary')) {
        $db = Xcrud_db::get_instance();
        $query = 'UPDATE store SET status = 1 WHERE store_id = ' . (int) $xcrud->get('primary');
        $db->query($query);
    }
}

function inactive_store($xcrud) {

    if ($xcrud->get('primary')) {
        $db = Xcrud_db::get_instance();
        $query = 'UPDATE store SET status = 0 WHERE store_id = ' . (int) $xcrud->get('primary');
        $db->query($query);
    }
}
function remove_store($xcrud) {

    if ($xcrud->get('primary')) {
        $db = Xcrud_db::get_instance();
        $query = 'UPDATE store SET is_deleted = 1 WHERE store_id = ' . (int) $xcrud->get('primary');
       // echo $query ; die;
        $db->query($query);
    }
}

function active_freebie($xcrud) {

    if ($xcrud->get('primary')) {
        $db = Xcrud_db::get_instance();
        $query = 'UPDATE freebie SET status = 1 WHERE freebie_id = ' . (int) $xcrud->get('primary');
        $db->query($query);
    }
}

function inactive_freebie($xcrud) {

    if ($xcrud->get('primary')) {
        $db = Xcrud_db::get_instance();
        $query = 'UPDATE freebie SET status = 0 WHERE freebie_id = ' . (int) $xcrud->get('primary');
        $db->query($query);
    }
}

function active_pincode($xcrud) {

    if ($xcrud->get('primary')) {
        $db = Xcrud_db::get_instance();
        $query = 'UPDATE delivery_pincode SET status = 1 WHERE id = ' . (int) $xcrud->get('primary');
        $db->query($query);
    }
}

function inactive_pincode($xcrud) {

    if ($xcrud->get('primary')) {
        $db = Xcrud_db::get_instance();
        $query = 'UPDATE delivery_pincode SET status = 0 WHERE id = ' . (int) $xcrud->get('primary');
        $db->query($query);
    }
}

function active_user($xcrud) {

    if ($xcrud->get('primary')) {
        $db = Xcrud_db::get_instance();
        $query = 'UPDATE user SET status = 1 WHERE user_id = ' . (int) $xcrud->get('primary');
        $db->query($query);
    }
}

function inactive_user($xcrud) {

    if ($xcrud->get('primary')) {
        $db = Xcrud_db::get_instance();
        $query = 'UPDATE user SET status = 0 WHERE user_id = ' . (int) $xcrud->get('primary');
        $db->query($query);
    }
}