<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Settings extends CI_Controller {

	function __construct() {
        parent::__construct();
       $this->load->model('m_auth');
       $this->m_auth->check_session();
    }
	public function index()
	{
		$data = [];
		$data['title'] = 'Email Configuration';
		$data['admin_data'] = $this->db->get('setting')->result_array();
		 //echo "<pre>"; print_r($data); die;
		$this->load->view('header', $data);
        $this->load->view('nav');
        $this->load->view('email_config');
        $this->load->view('footer');
	}
	public function save_settings()
	{
		$post = $_POST;
		$upd_data = [];

		if(isset($post['smtp_user']) && $post['smtp_user']) {
			$upd_data['smtp_user'] =  $post['smtp_user'];
		}
		if(isset($post['smtp_pass']) && $post['smtp_pass']) {
			$upd_data['smtp_pass'] =  $post['smtp_pass'];
		}
		if(isset($post['smtp_host']) && $post['smtp_host']) {
			$upd_data['smtp_host'] =  $post['smtp_host'];
		}
		if(isset($post['smtp_port']) && $post['smtp_port']) {
			$upd_data['smtp_port'] =  $post['smtp_port'];
		}
		if(isset($post['smtp_from']) && $post['smtp_from']) {
			$upd_data['smtp_from'] =  $post['smtp_from'];
		}
		if(isset($post['smtp_reply_to']) && $post['smtp_reply_to']) {
			$upd_data['smtp_reply_to'] =  $post['smtp_reply_to'];
		}
		if(isset($post['STORE_RADIUS_LIMIT']) && $post['STORE_RADIUS_LIMIT']) {
			$upd_data['STORE_RADIUS_LIMIT'] =  $post['STORE_RADIUS_LIMIT'];
		}

		if($upd_data) {
			foreach ($upd_data as $key => $value) {
				$this->db->where('key', $key);
				$this->db->set('value', $value);
				$this->db->update('setting');
			}
		}
		
		echo "success";
	}

	public function manage_store_radius_km()
	{
		$data = [];
		$data['title'] = 'Store Radius KM';
		$data['admin_data'] = $this->db->get('setting')->result_array();
		 //echo "<pre>"; print_r($data); die;
		$this->load->view('header', $data);
        $this->load->view('nav');
        $this->load->view('store_radius_km');
        $this->load->view('footer');
	}

}

/* End of file settings.php */
/* Location: ./application/controllers/settings.php */