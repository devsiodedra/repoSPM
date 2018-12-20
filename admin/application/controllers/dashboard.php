<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Dashboard extends CI_Controller {
    function __construct() {
        parent::__construct();
        $this->load->model('m_auth');
        $this->m_auth->check_session();
    }
    public function index() {
        $data = [];
		$data['title'] = 'Dashboard';
        $this->load->view('header', $data);
        $this->load->view('nav');
        $this->load->view('dashboard');
        $this->load->view('footer');
    }

    public function notificationList()
    {
        $data = [];
        $noti = $this->m_tools->notificationList();
        $noti_count = $this->m_tools->notificationCount();
        if($noti) {
           $data['noti'] = $noti;
        }
        $data['noti_count'] = $noti_count;
        echo $this->load->view('tmp_notification', $data, FALSE);
    }
    public function notificationGenerate()
    {
       $noti = $this->m_tools->notificationGenerate();

       echo $noti;
    }

    public function readAll()
    {
        $this->m_tools->readAll();
    }
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */