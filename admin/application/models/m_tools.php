<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class M_tools extends CI_Model {

    public function send_mail($to, $subject, $msg) {
        $ci = get_instance();
        $config = array();
        $config_data = $this->db->where_in('key', array('smtp_user', 'smtp_pass', 'smtp_host', 'smtp_port', 'smtp_from', 'smtp_reply_to'))->get('setting')->result_array();

        foreach ($config_data as $key => $value) {
            $config[$value['key']] = $value['value'];
        }

        $config['charset'] = "utf-8";
        $config['mailtype'] = "html";
        $config['newline'] = "\r\n";
        $ci->email->initialize($config);

        $ci->email->from($config['smtp_user'], APP_NAME);
        $ci->email->to($to);
        $this->email->reply_to($config['smtp_reply_to'], APP_NAME);
        $ci->email->subject($subject);

        //create message with header and footer
        //$data['msg'] = $msg;
        // $msg = $this->load->view('mail_template', $data, true);
        //echo $msg;
        $ci->email->message($msg);
        $ci->email->send();

        // echo $this->email->print_debugger();
    }

    public function s3_upload($input = "") {
        $ext = '.' . pathinfo($_FILES[$input]['name'], PATHINFO_EXTENSION);
        $filename = date("YmdHis") . rand(11111, 99999) . $ext;
        include_once('../../aws/aws-autoloader.php');
        $s3Client = new Aws\S3\S3Client([
            'version' => '2006-03-01',
            'region' => 'ap-south-1',
            'credentials' => [
                'key' => ACCESS_KEY_ID,
                'secret' => SECRET_ACCESS_KEY,
            ],
        ]);

        $result = $s3Client->putObject(array(
            'Bucket' => BUCKET_NAME,
            'Key' => $filename,
            'SourceFile' => $_FILES[$input]['tmp_name'],
            'StorageClass' => 'REDUCED_REDUNDANCY'
        ));
    }

    public function get_s3_url($file = "") {
        if (!$file) {
            return "";
        }
        include_once('../aws/aws-autoloader.php');
        $s3Client = new Aws\S3\S3Client([
            'version' => '2006-03-01',
            'region' => 'ap-south-1',
            'credentials' => [
                'key' => ACCESS_KEY_ID,
                'secret' => SECRET_ACCESS_KEY,
            ],
        ]);
        $cmd = $s3Client->getCommand('GetObject', [
            'Bucket' => BUCKET_NAME,
            'Key' => $file
        ]);

        $request = $s3Client->createPresignedRequest($cmd, '+' . (60 * 24 * 7) . ' minutes');
        return $presignedUrl = (string) $request->getUri();
    }

    public function get_category() {
        $category = $this->db
                        ->where('is_deleted', 0)
                        ->where('status', 1)
                        ->get("category")->result_array();
        return $category;
    }

    public function get_instructor() {
        $instructor = $this->db
                        ->where('is_deleted', 0)
                        ->where('status', 1)
                        ->where('user_type', 'instructor')
                        ->get("user")->result_array();
        return $instructor;
    }

    public function get_course() {
        $course = $this->db
                        ->get("course")->result_array();
        return $course;
    }

    public function pic_url($pic, $thumb = '') {
        if ($thumb) {
            if ($pic) {
                //return str_replace('ws/v1/', '', site_url('upload/thumb/' . $pic));
                return site_url('../upload/' . $pic);
            }
        } else {
            if ($pic) {
                //return str_replace('ws/v1/', '', site_url('upload/' . $pic));
                return site_url('../upload/' . $pic);
            }
        }
        return '';
    }
    public function pic_url_subcat($pic, $thumb = '') {
        if ($thumb) {
            if ($pic) {
                //return str_replace('ws/v1/', '', site_url('upload/thumb/' . $pic));
                return site_url('../uploads/subcat/' . $pic . '.png');
            }
        } else {
            if ($pic) {
                //return str_replace('ws/v1/', '', site_url('upload/' . $pic));
                return site_url('../uploads/subcat/' . $pic . '.png');
            }
        }
        return '';
    }

    public function notificationList()
    {
        $this->db->select('n.*, u.*');
        $this->db->where('n.is_read', 0);
        $this->db->where('n.notification_for', 'admin');
        $this->db->join('user u', 'u.user_id = n.from_user_id');
        $this->db->limit(5);
        $this->db->order_by('n.notification_id', 'desc');
        $noti = $this->db->get('notification n')->result_array();
        if($noti) {
            foreach ($noti as $key => $value) {
                    $noti[$key]['profile_pic'] = $this->pic_url($noti[$key]['profile_pic']);
                    $noti[$key]['date'] = $this->time_elapsed_string($noti[$key]['created_at']);

                    $this->db->where('transaction_id',  $noti[$key]['transaction_id']);
                    $noti[$key]['freebees'] = $this->db->get('transaction_detail')->row_array();

                
            }
        }
        return $noti;
    }

    public function notificationCount()
    {
        $this->db->select('count(*) as total');
        $this->db->where('n.is_read', 0);
        $this->db->where('n.notification_for', 'admin');
        $noti = $this->db->get('notification n')->row_array();
        return $noti['total'];
    }
    public function notificationGenerate()
    {
        $this->db->select('count(*) as total');
        $this->db->where('n.is_read', 0);
        $this->db->where('n.is_window_generated', 0);
        $this->db->where('n.notification_for', 'admin');
        $noti = $this->db->get('notification n')->row_array();

        $this->db->where('is_window_generated', 0);
        $this->db->set('is_window_generated', 1);
        $this->db->update('notification');
        return $noti['total'];
    }
    public function readAll()
    {
        $this->db->where('is_read', 0);
        $this->db->set('is_window_generated', 1);
        $this->db->set('is_read', 1);
        $this->db->update('notification');
    }
    

    function time_elapsed_string($datetime, $full = false) {
        $now = new DateTime;
        $ago = new DateTime($datetime);
        $diff = $now->diff($ago);
        $diff->w = floor($diff->d / 7);
        $diff->d -= $diff->w * 7;

        $string = array(
            'y' => 'year',
            'm' => 'month',
            'w' => 'week',
            'd' => 'day',
            'h' => 'hour',
            'i' => 'minute',
            's' => 'second',
        );
        foreach ($string as $k => &$v) {
            if ($diff->$k) {
                $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
            } else {
                unset($string[$k]);
            }
        }

        if (!$full) $string = array_slice($string, 0, 1);
        return $string ? implode(', ', $string) . ' ago' : 'just now';
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

}
