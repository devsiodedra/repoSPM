<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class M_api extends CI_Model {

    public function send_mail($to, $subject, $msg) {
        $ci = get_instance();
        $config = array();
        $config_data = $this->db->where_in('key', array('smtp_user', 'smtp_pass', 'smtp_host', 'smtp_port', 'smtp_from', 'smtp_reply_to'))->get('setting')->result_array();
        foreach($config_data as $key=>$val){
            $config[$val['key']] = $val['value'];
        }
        $config['smtp_crypto'] = 'tls';
        $config['charset'] = "utf-8";
        $config['mailtype'] = "html";
        $config['newline'] = "\r\n";
        //print_r($config); die;
        $ci->email->initialize($config);

        $ci->email->from($config['smtp_user'], APP_NAME);
        $ci->email->to($to);
        $this->email->reply_to($config['smtp_user'], APP_NAME);
        $ci->email->subject($subject);
        $ci->email->message($msg);
        $ci->email->send();
        //echo $this->email->print_debugger(); die;
    }

    

    public function pic_url($pic, $thumb = '') {
        if ($thumb) {
            if ($pic) {
                return str_replace('/ws/v1', '', site_url('upload/thumb/' . $pic));
            }
        } else {
            if ($pic) {
                return str_replace('/ws/v1', '', site_url('upload/' . $pic));
            }
        }
        return '';
    }

    public function notnull($ary = []) {
        return $this->filter_me($ary);
    }

    function filter_me(&$array) {
        foreach ($array as $key => $item) {
            if (!is_array($item) && $array [$key] == null) {
                $array [$key] = "";
            } else {
                is_array($item) && $array [$key] = $this->filter_me($item);
            }
        }
        return $array;
    }

    public function thumbCreate($img_uploadpath, $thumb_uploadpath, $source) {
        $fullPath = $img_uploadpath . $source;
        $thumbSize = 200;
        $thumbPath = $thumb_uploadpath;
        $thumbQuality = 99;

        $extension = pathinfo($img_uploadpath . $source, PATHINFO_EXTENSION);

        if ($extension == 'jpg' || $extension == 'jpeg')
            $full = imagecreatefromjpeg($fullPath);
        if ($extension == 'gif')
            $full = imagecreatefromgif($fullPath);
        if ($extension == 'png')
            $full = imagecreatefrompng($fullPath);


//$full = imagecreatefromjpeg($fullPath);
        $name = $source;

        $width = imagesx($full);
        $height = imagesy($full);

        /* work out the smaller version, setting the shortest
          side to the size of the thumb, constraining height/wight
         */

        if ($height > $width) {
            $divisor = $width / $thumbSize;
        } else {
            $divisor = $height / $thumbSize;
        }

        $resizedWidth = ceil($width / $divisor);
        $resizedHeight = ceil($height / $divisor);

        /* work out center point */
        $thumbx = floor(($resizedWidth - $thumbSize) / 2);
        $thumby = floor(($resizedHeight - $thumbSize) / 2);

        /* create the small smaller version, then crop it centrally
          to create the thumbnail */
        $resized = imagecreatetruecolor($resizedWidth, $resizedHeight);
        $thumb = imagecreatetruecolor($thumbSize, $thumbSize);
        imagecopyresized($resized, $full, 0, 0, 0, 0, $resizedWidth, $resizedHeight, $width, $height);
        imagecopyresized($thumb, $resized, 0, 0, $thumbx, $thumby, $thumbSize, $thumbSize, $thumbSize, $thumbSize);

        if ($extension == 'jpg' || $extension == 'jpeg')
            $status = imagejpeg($thumb, $thumbPath . $name, $thumbQuality);
        if ($extension == 'gif')
            $status = imagegif($thumb, $thumbPath . $name, $thumbQuality);
        if ($extension == 'png')
            $status = imagepng($thumb, $thumbPath . $name, 9);
    }

    /* @device
     * ios - check device token and update/insert
     * android - check device id and update/insert
     */

//$user_id, $device_type, $device_token, $device_id = '', $device_name = ''
    public function check_update_device_token($post = []) {
        $post['device_type'] = (isset($post['device_type']) && $post['device_type'] != null) ? $post['device_type'] : '';
        $post['device_token'] = (isset($post['device_token']) && $post['device_token'] != null) ? $post['device_token'] : '';
        $post['device_id'] = (isset($post['device_id']) && $post['device_id'] != null) ? $post['device_id'] : '';
        $post['device_name'] = (isset($post['device_name']) && $post['device_name'] != null) ? $post['device_name'] : '';
        if ($post['device_type'] == '' || $post['device_token'] == '') {
            return false;
        } else if ($post['device_type'] == 'android' && $post['device_id'] == '') {
            //return false;
        }


        if ($post['device_type'] == 'ios') {
//check device token exist or not
            $this->db->where(array(
                'user_id' => $post['user_id'],
                'status' => 1
            ));
            $row = $this->db->from('device_token')->get()->row_array();
            if ($row) {
//device token already exist update new user id and device
                $this->db->where(array(
                    'user_id' => $post['user_id'],
                    'status' => 1
                ));
                $this->db->set(array(
                    'device_token' => $post['device_token'],
                    'device_type' => $post['device_type'],
                    'date' => date('Y-m-d h:i:s'),
                ));
                $this->db->update('device_token');
            } else {
//device token not exist insert new token
                $this->db->insert('device_token', array(
                    'user_id' => $post['user_id'],
                    'device_token' => $post['device_token'],
                    'device_type' => $post['device_type'],
                    'date' => date('Y-m-d h:i:s'),
                    'status' => 1,
                ));
            }
        } else if ($post['device_type'] == 'android') {
//check device id exist or not
            $this->db->where(array(
                'user_id' => $post['user_id'],
                'status' => 1
            ));
            $row = $this->db->from('device_token')->get()->row_array();
            if ($row) {
//device token already exist update new user id and device
                $this->db->where(array(
                    'user_id' => $post['user_id'],
                    'status' => 1
                ));
                $this->db->set(array(
                    'device_id' => $post['device_id'],
                    'device_token' => $post['device_token'],
                    'device_type' => $post['device_type'],
                    'device_name' => $post['device_name'],
                    'date' => date('Y-m-d h:i:s'),
                ));
                $this->db->update('device_token');
            } else {
//device token not exist insert new token
                $this->db->insert('device_token', array(
                    'user_id' => $post['user_id'],
                    'device_token' => $post['device_token'],
                    'device_type' => $post['device_type'],
                    'device_id' => $post['device_id'],
                    'device_name' => $post['device_name'],
                    'date' => date('Y-m-d h:i:s'),
                    'status' => 1,
                ));
            }
        } else {
            return false;
        }
    }

    public function get_user_by_user_id_token($user_id, $token) {
        $this->db->where(array(
            'user_id' => $user_id,
            'status' => 1,
            'token' => $token,
        ));
        $userdata = $this->db->from('user')->get()->row_array();
//echo $this->db->last_query();
        if ($userdata) {
            return $userdata;
        } else {
            return false;
        }
    }

    public function get_user_by_email($email) {
        $user = $this->db
                        ->where('email', $email)
                        //->where('is_deleted', 0)
                        ->get('user')->row_array();
        return $user;
    }

    public function get_user_by_id($user_id) {
        $user = $this->db
                        ->where('user_id', $user_id)
                        ->get('user')->row_array();
        return $user;
    }

    public function signin($post = []) {
        $userdata = $this->db
                        ->where('email', $post['email'])
                        ->where('password', sha1($post['password']))
                        ->from('user')->get()->row_array();
        return $userdata;
    }

    public function check_token($user_id = '') {
        $token = $this->db->where('user_id', $user_id)
                        ->get('user')->row_array();
        return $token;
    }

    public function update_login_token($user_id, $token) {
        $this->db->set('token', $token);
        $this->db->where('user_id', $user_id);
        if ($this->db->update('user')) {
            return true;
        } else {
            return false;
        }
    }

    public function check_profile_complition_and_get_screen_code($user_id) {
        $this->db->where('user_id', $user_id);
        $row = $this->db->from('user')->get()->row_array();
        if ($row) {
            return '000';
        } else {
            return '333';
        }
    }

    public function verify($sha1_user_id) {
        $this->db->select('is_email_verified');
        $this->db->where('sha1(user_id)', $sha1_user_id);
        $row = $this->db->get('user')->row();
       // echo $this->db->last_query(); die;
        if ($row) {
//user found
            if (!$row->is_email_verified) {
//not verified - do verification
                $this->db->where('sha1(user_id)', $sha1_user_id);
                $this->db->set('is_email_verified', 1);
                $this->db->set('status', 1);
                $this->db->update('user');
                return '1';
            } else {
//verified -
                return '2';
            }
        } else {
//user not found
            return false;
        }
    }

    public function generate_random_password($user_id, $password) {
        $this->db->where(array(
            'user_id' => $user_id,
            'status' => 1
        ));
        $this->db->set('password', sha1($password));
        $this->db->set('password_updated', 0);
        if ($this->db->update('user')) {
            return true;
        } else {
            return false;
        }
    }
    public function check_current_password($post = []) {
        $check = $this->db
                        ->where('user_id', $post['user_id'])
                        ->where('password', sha1($post['current_password']))
                        ->get('user')->row_array();
        if (!$check) {
            return true;
        } else {
            return false;
        }
    }

    public function signup($post = []) {
        if(isset($post['password']) && $post['password']) {
            $post['password'] = sha1($post['password']);
        }
        
        $post['member_since'] = date('Y-m-d H:i:s');
        //$post['status'] = '0';

        $this->db->insert('user', $post);
        //echo $this->db->last_query(); die;
        $post['user_id'] = $this->db->insert_id();

        $this->db->where('status', 1);
        $category = $this->db->get('category')->result_array();
        if($category) {
            foreach ($category as $key => $value) {
                
                $uc_data = [
                    'user_id' => $post['user_id'],
                    'category' => $value['category'],
                    'image' => $value['image'],
                    'type' => $value['type'],
                    'created_at' => date('Y-m-d H:i:s')
                ];
                $this->db->insert('user_category', $uc_data);
            }
        }
        $userdata = $this->get_user_by_id($post['user_id']);
        return $userdata;
    }

    public function confirm_otp($post =[])
    {
        $this->db->where('user_id', $post['user_id']);
        $this->db->where('otp', $post['otp']);
        $this->db->where('otp !=', 0);
        return $this->db->get('user')->row_array();
    }

    public function check_social_id($post = []) {

        $userdata = $this->db
                        ->where($post['media_type'] . '_id', $post['media_id'])
                        ->get('user')->row_array();
        if ($userdata) {
            if (isset($post['profile_pic']) && $post['profile_pic']) {
                $this->db->set('profile_pic', $post['profile_pic'])
                        ->where('user_id', $userdata['user_id'])
                        ->update('user');
            }
            return $userdata;
        } else {
            return [];
        }
    }
    

    public function update_user($post = []) {
        if (isset($post['password']) && $post['password']) {
            $post['password'] = sha1($post['password']);
        }
        $user_id = $post['user_id'];
        unset($post['user_id']);
        // $post['city'] = $this->branch_name($post['branch_id']);
        $this->db
                ->where('user_id', $user_id)
                ->update('user', $post);
//echo $this->db->last_query();
        $post['user_id'] = $user_id;
        $userdata = $this->get_user_by_id($user_id);
        return $userdata;
    }

    public function update_password($post = []) {
        return $this->db->where('user_id', $post['user_id'])
                        ->set('password', sha1($post['password']))
                        ->set('password_updated', 1)
                        ->update('user');
    }

    public function delete_device_token($post = []) {
        return $this->db
                        ->where('user_id', $post['user_id'])
                        ->where('device_token', $post['device_token'])
                        ->delete('device_token');
    }

    

 

    public function bannerList()
    {
      //  $this->db->where('is_deleted', 0);
        $banner = $this->db->get('banner')->result_array();
        if($banner) {
            foreach ($banner as $key => $value) {
                $banner[$key]['image'] = $this->pic_url($banner[$key]['image']);
            }
         
        }
        return $banner;
    }

   


    public function user_profile($post = [])
    {
        if(isset($post['to_user_id']) && $post['to_user_id']) {
            $post['user_id'] = $post['to_user_id'];
        }
        $this->db->select('user_id, first_name, last_name, email, phone, is_marketing, company_name, profile_pic, notification, member_since, date, is_email_verified');
        $this->db->where('user_id', $post['user_id']);
        $data = $this->db->get('user')->row_array();
        if($data['profile_pic']) {
            $data['profile_pic_thumb'] = $this->pic_url($data['profile_pic'], 'thumb');
            $data['profile_pic'] = $this->pic_url($data['profile_pic']);
        }
        return $data;
    }

    public function update_profile($post = [])
    {
        $user_id = $post['user_id'];
        unset($post['user_id']);

        $this->db->where('user_id', $user_id);
        $this->db->update('user', $post);
        return $this->user_profile(['user_id' => $user_id]);
    }

    public function privacy_policy()
    {
        $this->db->where('key', 'privacy_policy');
        $data = $this->db->get('setting')->row_array();
        return $data['value'];
    }
    public function terms_conditions()
    {
        $this->db->where('key', 'terms_condition');
        $data = $this->db->get('setting')->row_array();
        return $data['value'];
    }
    public function contact_us($post = [])
    {
        $subject = 'New enquiry from '.APP_NAME;
        $msg = $this->load->view('mail_tmp/header', $post, true);
        $msg .= $this->load->view('mail_tmp/contact_us', $post, true);
        $msg .= $this->load->view('mail_tmp/footer', $post, true);
        return $this->m_api->send_mail(ADMIN_EMAIL, $subject, $msg);
    }
    public function notification_setting($post = [])
    {
        $this->db->set('notification', $post['notification']);
        $this->db->where('user_id', $post['user_id']);
        return $this->db->update('user');

    }

    public function user_category($post = [],$userdata = [])
    {
        if($userdata['is_marketing'] != 1) {
            $this->db->where('type', 1);
        }
        $this->db->where('status', 1);
        $this->db->where('user_id', $post['user_id']);
        $cat = $this->db->get('user_category')->result_array();

        $static_cat[0] = [

            'category_id' => '',
            'category' => 'All Contacts',
            'image' => ''
        ];

        $cat = array_merge($static_cat , $cat);

        if($cat) {
            foreach ($cat as $key => $value) {
                $cat[$key]['image'] = $this->pic_url($cat[$key]['image']);
            }
        }

        return $cat;
    }

    public function add_user_category($post = [],$userdata = [])
    {
        $cat_data = [
            'user_id' => $post['user_id'],
            'category' => $post['category'],
            'image' => $post['image'],
            'user_id' => $post['user_id'],
        ];
        return $this->db->insert('user_category', $cat_data);
        
    }
    public function add_contacts($post = [],$userdata = [])
    {
        if($post['phone'] && $post['first_name'] && $post['last_name']) {
            $phone = $post['phone'];
            $first_name = $post['first_name'];
            $last_name = $post['last_name'];
            $category_id = (isset($post['category_id']) && $post['category_id']) ? $post['category_id'] : [];
            $type = (isset($post['type']) && $post['type']) ? $post['type'] : [];
            $company = (isset($post['company']) && $post['company']) ? $post['company'] : [];
            $address = (isset($post['address']) && $post['address']) ? $post['address'] : [];
            $city = (isset($post['city']) && $post['city']) ? $post['city'] : [];
            $state = (isset($post['state']) && $post['state']) ? $post['state'] : [];
            $time_zone = (isset($post['time_zone']) && $post['time_zone']) ? $post['time_zone'] : [];
            $note = (isset($post['note']) && $post['note']) ? $post['note'] : [];
            $contact_ids = (isset($post['contact_id']) && $post['contact_id']) ? $post['contact_id'] : '';
            
            $resp = false;
            foreach ($phone as $key => $value) {
                
                $single_contact = [
                    'user_id' => $post['user_id'],
                    'phone' => $value,
                    'first_name' => (isset($first_name[$key]) && $first_name[$key] ) ? $first_name[$key] : '',
                    'last_name' => (isset($last_name[$key]) && $last_name[$key] ) ? $last_name[$key] : '',
                    'type' => (isset($type[$key]) && $type[$key] ) ? $type[$key] : 'simple',
                    'company' => (isset($company[$key]) && $company[$key] ) ? $company[$key] : '',
                    'address' => (isset($address[$key]) && $address[$key] ) ? $address[$key] : '',
                    'city' => (isset($city[$key]) && $city[$key] ) ? $city[$key] : '',
                    'state' => (isset($state[$key]) && $state[$key] ) ? $state[$key] : '',
                    'time_zone' => (isset($time_zone[$key]) && $time_zone[$key] ) ? $time_zone[$key] : '',
                    'note' => (isset($note[$key]) && $note[$key] ) ? $note[$key] : '',
                ];

                $contact_id = (isset($contact_ids[$key]) && $contact_ids[$key] ) ? $contact_ids[$key] : '';

                if($single_contact && $contact_id) {
                    
                    
                    $this->db->where('contact_id', $contact_id);
                    if($this->db->update('contact_list', $single_contact)) {

                        $resp = true;
                        
                    }
                    
                } else if($single_contact){

                    if($this->db->insert('contact_list', $single_contact)) {
                        $resp = true;

                        $contact_id = $this->db->insert_id();

                        if(isset($category_id[$key]) && $category_id[$key]) {
                            $contact_category = [
                                'contact_id' => $contact_id,
                                'category_id' => (isset($category_id[$key]) && $category_id[$key] ) ? $category_id[$key] : '',
                            ];
    
                            $this->db->insert('contact_category', $contact_category);
                        }
                        
                        
                        
                    }
                }
            }
            return $resp;
        }
        
    }

    public function contact_list($post = [],$userdata = [])
    {
        
        $this->db->where('user_id', $post['user_id']);
        $this->db->where('status', 1);
        $this->db->limit($post['limit']);
        $this->db->offset($post['offset']);
        $contact = $this->db->get('contact_list')->result_array();
        return $contact;

        
        
    }

    public function add_contact_to_category($post = [],$userdata = [])
    {
        
        //$this->db->where('user_id', $post['user_id']);
        $this->db->where('contact_id', $post['contact_id']);
        $this->db->where('category_id', $post['category_id']);
        $exist = $this->db->get('contact_category')->row_array();
        if(!$exist) {
            $contact_category = [
                'contact_id' => $post['contact_id'],
                'category_id' => $post['category_id'],
            ];
            $this->db->insert('contact_category', $contact_category);
            
        }

        return true;
        
    }


    
}
