<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Customer extends CI_Controller {

	function __construct() {
        parent::__construct();
       $this->load->model('m_auth');
       $this->load->model('m_customer');
       $this->m_auth->check_session();
    }
	public function index()
	{

        $data['title'] = 'User';
        $data['data'] = $this->filter();
        $data['customer'] = $this->m_customer->allCustomers();
        $this->load->view('header', $data);
        $this->load->view('nav');
        $this->load->view('customer');
        $this->load->view('footer');
    }
    public function filter()
    {
        include_once 'xcrud/xcrud.php';
        $xcrud = Xcrud::get_instance();
        $post = $_POST;
    
        if (isset($post['xcrud']['name']) && $post['xcrud']['name']) {
            $this->db->where('user_id', $post['xcrud']['name']);
        }
        if (isset($post['xcrud']['phone']) && $post['xcrud']['phone']) {
            $this->db->like('phone', $post['xcrud']['phone'], 'BOTH');
        }
        if (isset($post['xcrud']['email']) && $post['xcrud']['email']) {
            $this->db->like('email', $post['xcrud']['email'], 'BOTH');
        }
       
        $filter = $this->db->get('user')->result_array();

        $ids = [0];
        if($filter) {
            foreach ($filter as $key => $value) {
               $ids[] =  $value['user_id'];
            }
           
        }
      
        $xcrud->table('user');
       // $xcrud->fields('s_name, s_image, status');
        if(isset($post) && $post) {
             $xcrud->where('user_id',  $ids);
        }
        $xcrud->columns('user_id, first_name, last_name, gender, phone, email, member_since, status');
        $xcrud->unset_view();
        $xcrud->unset_add();
        $xcrud->unset_edit();
        $xcrud->unset_search();
        $xcrud->unset_remove();
        $xcrud->button("customer/details/{user_id}", "Detail", "la la-align-justify ", "btn btn-info btn-sm ");
       
        $xcrud->buttons_position('left');
        $xcrud->column_pattern('user_id','<a href="customer/details/{user_id}">{user_id} </a>');
        $xcrud->column_callback("status","cb_active_inactive");
        $xcrud->column_cut(1000,'description');
        $xcrud->create_action('active', 'active_user');
        $xcrud->create_action('inactive', 'inactive_user');
        $xcrud->button('javascript:void(0)', 'Active', 'la la-check-circle', 'xcrud-action btn btn-success btn-sm', [
            'data-task' => 'action',
            'data-action' => 'active',
            'data-primary' => '{user_id}'], ['status',
            '!=',
            '1']
        );
        $xcrud->button('#', 'Inactive', 'la la-ban', 'xcrud-action btn btn-warning btn-sm', [
            'data-task' => 'action',
            'data-action' => 'inactive',
            'data-primary' => '{user_id}'], ['status',
            '=',
            '1']
        );
       // $data['data'] = $xcrud->render();
         if ($this->input->is_ajax_request()) {
            echo $xcrud->render();
        } else {
            return $xcrud->render();
        }
        
    }

    public function details($user_id='')
    {
        if(!$user_id) {
            redirect('customer');
        }

        $user = $this->m_customer->getByID($user_id);
        $data = [];
        $data['title'] = 'Usr Details';
        $data['user'] = $user;
        //echo "<pre>"; print_r($data); die;
        $this->load->view('header', $data);
        $this->load->view('nav');
        $this->load->view('user_details');
        $this->load->view('footer');
    }

  

    public function saveCustomer()
    {
        $post = $_POST;

        $check_email_exist = $this->m_customer->checkEmailExist($post);
        if($check_email_exist) {
            echo "email_exist"; exit();
        } else {
            if($this->m_customer->saveCustomer($post)) {
                echo "success";
            } else {
                return false;
            }
        }
    }

    
   

}
