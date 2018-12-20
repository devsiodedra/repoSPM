<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class M_auth extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    function login($post) {
        return $this->db
                        ->where("(username='" . $post['username'] . "' or "
                                . "email='" . $post['username'] . "')", null, false)
                        ->where("password", sha1($post['password']))
                        ->get("admin")->row_array();
    }

    function check_session($is_index = '') {
        if (!$this->session->userdata("loged_in") && !$is_index) {
            redirect(base_url());
        } else if ($this->session->userdata("loged_in") && $is_index) {
            redirect(base_url(REDIRECT_AFTER_LOGIN));
        }
    }

    function get_team_members() {
        return $this->db
                        ->where("status", 1)
                        ->get("team_members")->result_array();
    }
    function get_cities() {
        return $this->db
                        ->where("status", 1)
                        ->get("city")->result_array();
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

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */