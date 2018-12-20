<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cms extends CI_Controller {

	function __construct() {
        parent::__construct();
       $this->load->model('m_auth');
       $this->m_auth->check_session();
    }
	public function index()
	{
		
	}
	public function page($page = "") {
        if (!$page) {
            show_404();
            die;
        }
        $content = $this->db
                        ->select("value")
                        ->where("key", $page)
                        ->get("setting")->row_array();
        if (!$content) {
            show_404();
            die;
        } else {
            $data['content'] = $content['value'];
        }
        if ($page == "terms_condition") {
            $data['page_title'] = "Terms and conditions";
        }else if ($page == "privacy_policy") {
            $data['page_title'] = "Privacy Policy";
        }else if ($page == "faq") {
            $data['page_title'] = "FAQ";
        }else if ($page == "about_us") {
            $data['page_title'] = "About us";
        }else if ($page == "customer_support") {
            $data['page_title'] = "Customer Support";
        }
        $data['page'] = $page;
        $data['active_nav'] = "cms/page/$page";
        $this->load->view('header', $data);
        $this->load->view('nav');
        $this->load->view('cms');
        $this->load->view('footer');
    }

    public function update_page() {
        $this->db
                ->set("value", $_POST['value'])
                ->where("key", $_POST['key'])
                ->update("setting");
    }

    public function customer_support()
    {
        $this->db->where('key', 'customer_support');
        $setting = $this->db->get('setting')->row_array();


        $data['cust'] = json_decode($setting['value']);
        $data['title'] = 'Customer Support';
       // print_r($data['cust']->os_phone); die;
        $this->load->view('header', $data);
        $this->load->view('nav');
        $this->load->view('save_customer_support');
        $this->load->view('footer');
    }

    public function save()
    {
        $val = $_POST;
        $val = json_encode($val);
         $save = $this->db
                ->set("value", $val)
                ->where("key", 'customer_support')
                ->update("setting");
        if($save) {
            echo "success";
        } else {
            echo 'fail';
        }
    }

}

/* End of file cms.php */
/* Location: ./application/controllers/cms.php */