<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Category extends CI_Controller {
    function __construct() {
        parent::__construct();
       $this->load->model('m_auth');
       $this->load->model('m_category');
       $this->m_auth->check_session();
    }
    public function index() {
        ///echo $this->session->userdata('sess_expiration'); die;
        

        $data['data'] = $this->filter();;
        $data['title'] = 'Category';
        $this->load->view('header', $data);
        $this->load->view('nav');
        $this->load->view('category');
        $this->load->view('footer');
    }

    public function filter()
    {
        $post = $_POST;
        
        if (isset($post['xcrud']['category']) && $post['xcrud']['category']) {
            $this->db->like('category', $post['xcrud']['category'], 'BOTH');
        }
       
        $filter = $this->db->get('category')->result_array();

        $ids = [0];
        if($filter) {
            foreach ($filter as $key => $value) {
               $ids[] =  $value['category_id'];
            }
           
        }

        include_once 'xcrud/xcrud.php';
        $xcrud = Xcrud::get_instance();
        $xcrud->table('category');

        if(isset($post) && $post) {
             $xcrud->where('category_id',  $ids);
        }
        
        $xcrud->fields('category, image, status');
        $xcrud->columns('image, category, status');
      //  $xcrud->change_type("image","image",'',array('width'=>300, 'height'=>300, 'crop'=>true));
        $xcrud->change_type("image","image");
        $xcrud->column_callback("status","cb_active_inactive");
        $xcrud->unset_view();
        $xcrud->unset_add();
        $xcrud->unset_search();
        $xcrud->unset_edit();
        $xcrud->unset_remove();
        $xcrud->modal('image');
        $xcrud->button("category/updateCategory/{category_id}", "Edit", "la la-edit ", "btn btn-info btn-sm ");
        $xcrud->before_insert("created_at");
        $xcrud->buttons_position('left');
        $xcrud->create_action('active', 'active_category');
        $xcrud->create_action('inactive', 'inactive_category');
        $xcrud->button('javascript:void(0)', 'Active', 'la la-check-circle', 'xcrud-action btn btn-success btn-sm', [
            'data-task' => 'action',
            'data-action' => 'active',
            'data-primary' => '{category_id}'], ['status',
            '!=',
            '1']
        );
        $xcrud->button('#', 'Inactive', 'la la-ban', 'xcrud-action btn btn-warning btn-sm', [
            'data-task' => 'action',
            'data-action' => 'inactive',
            'data-primary' => '{category_id}'], ['status',
            '=',
            '1']
        );

        if ($this->input->is_ajax_request()) {
            echo $xcrud->render();
        } else {
            return $xcrud->render();
        }
    }

   
    public function newCategory()
    {
        $data['title'] = 'Category';
        $this->load->view('header', $data);
        $this->load->view('nav');
        $this->load->view('add_category');
        $this->load->view('footer');
    }
    public function updateCategory($category_id = '')
    {
        if(!$category_id) {
            redirect('category/');
        }
        $data['category'] = $this->m_category->getCategoryWithSubCategory($category_id);
        // echo "<pre>"; print_r($data); die;
        $data['title'] = 'Category';
        $this->load->view('header', $data);
        $this->load->view('nav');
        $this->load->view('add_category');
        $this->load->view('footer');
    }

    public function addCategory()
    {
        $post = $_POST;
        //print_r($post); die;
        if (isset($post['category_id']) && $post['category_id']) {
            $cat_data = [
                'category' => $post['category'],
                'image' => $post['image'],
                'type' => $post['type']
            ];
            $this->db->where('category_id', $post['category_id']);
            $this->db->update('category', $cat_data);
            echo 'success';

        } else if (isset($post['category']) && $post['category'] && isset($post['image']) && $post['image']) {
            $cat_data = [
                'category' => $post['category'],
                'image' => $post['image'],
                'type' => $post['type'],
                'created_at' => date('Y-m-d H:i:s')
            ];
            if ($this->db->insert('category', $cat_data)) {
                $category_id = $this->db->insert_id();
                echo 'success';
            }
        } else {
            echo 'missing_field_error';
        }
    }

    public function uploadCategoryImage()
    {
        //print_r($_FILES);
        if (isset($_FILES['category_file'])) {
                    $ext = '.' . pathinfo($_FILES['category_file']['name'], PATHINFO_EXTENSION);
                    $filename = date('dmyhis') . $ext;

                    $config = array(
                        'upload_path' => './../upload/',
                        'allowed_types' => 'gif|jpg|png|bmp|jpeg',
                        'file_name' => $filename,
                        'max_size' => '20000'
                    );

                    $this->upload->initialize($config);
                    if($this->upload->do_upload('category_file')) {
                      echo $filename;  
                    } else {
                        echo $this->upload->display_errors();
                       // echo "error";
                    }
                    //$this->m_api->thumbCreate('../../upload/', '../../upload/thumb/', $filename);
                    
        } else {
            echo "error";
        }
    }
  
    public function removeCategory()
    {
        $this->db->where('category_id', $_POST['category_id']);
        $this->db->set('is_deleted', 1);
        if($this->db->update('category')) {
            echo "success";
        }
    }
    public function removeSubCategory() {
        $this->db->where('sub_category_id', $_POST['sub_category_id']);
        $this->db->set('is_deleted', 1);
        if($this->db->update('sub_category')) {
            echo "success";
        }
    }
    public function inactiveActiveCategory()
    {
        $this->db->where('category_id', $_POST['category_id']);
        $this->db->set('status', $_POST['status']);
        if($this->db->update('category')) {
            echo "success";
        }
    }

   

    
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */