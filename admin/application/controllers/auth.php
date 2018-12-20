<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Auth extends CI_Controller {
    function __construct() {
        parent::__construct();
        $this->load->model('m_auth');
        
    }
    public function index() {

        $this->m_auth->check_session(1);
        $this->load->view('login');
    }
    public function notification_update() {
        $this->m_auth->check_session(1);
        
        header('Content-Type: text/event-stream');
        header('Cache-Control: no-cache');
        
        $time = date('r');
        echo "data: The server time is: {$time}\n\n";
        flush();
       
    }
    public function instructor() {
        $this->m_auth->check_session(1);
        $this->load->view('login_instructor');
    }
    public function login() {
        $post = $_POST;
        $userdata = $this->m_auth->login($_POST);
        if ($userdata) {
            //session
         
            
            $userdata['loged_in'] = true;
            $this->session->set_userdata($userdata);
            echo 'success';
            // redirect(base_url('dashboard/'));
        } else {
            echo 'Invalid_login';
        }
    }
    function logout() {
        $this->session->sess_destroy();
        redirect(site_url());
    }

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */