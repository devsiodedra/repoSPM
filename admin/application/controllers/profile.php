<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Profile extends CI_Controller {

	function __construct() {
        parent::__construct();
        $this->load->model('m_auth');
        $this->load->model('m_admin');
        $this->m_auth->check_session();
    }

	

	public function index()
	{
        $user_id = $this->session->userdata('admin_id');
		if(!$user_id) {
			redirect(base_url());
		}
		$data = [];
		$data['title'] = 'Profile';
		$data['profile'] = $this->m_admin->getById($user_id);
		// print_r($data); die;
        $this->load->view('header', $data);
        $this->load->view('nav');
        $this->load->view('profile');
        $this->load->view('footer');
	}

	public function profile($user_id = '')
	{
		if(!$user_id) {
			redirect('instructor');
		}
		$data = [];
		$data['title'] = 'Instructor';
		$data['instructor'] = $this->m_admin->getById($user_id);
		// print_r($data); die;
        $this->load->view('header', $data);
        $this->load->view('nav');
        $this->load->view('instructor_profile');
        $this->load->view('footer');
	}

	public function uploadFile()
    {
        //print_r($_FILES);
        if (isset($_FILES['profile_pic'])) {
                    $ext = '.' . pathinfo($_FILES['profile_pic']['name'], PATHINFO_EXTENSION);
                    $filename = date('dmyhis') . $ext;

                    $config = array(
                        'upload_path' => './../uploads/',
                        'allowed_types' => 'gif|jpg|png|bmp|jpeg',
                        'file_name' => $filename,
                        'max_size' => '20000'
                    );

                    $this->upload->initialize($config);
                    if($this->upload->do_upload('profile_pic')) {
                        $this->m_tools->thumbCreate('./../uploads/', './../uploads/thumb/', $filename);
                      echo $filename;  
                    } else {
                        echo $this->upload->display_errors();
                       // echo "error";
                    }
                    
                    
        } else {
            echo "error";
        }
    }

    public function save()
    {
    	$post = $_POST;

    	
    	$exist = $this->m_admin->getByEmail($post);
    	if($exist) {
    		echo "user_exist"; exit();
    	}

    	if($post) {
    		if(isset($post['admin_id']) && $post['admin_id']) {
    			$update = $this->m_admin->update($post);
    			if($update) {
    				echo 'success';
    			} else {
    				echo 'error';
    			}
    		}
    	}
    }

    public function change_password()
    {
        $user_id = $this->session->userdata("admin_id");
        if(!$user_id) {
           redirect(base_url());
        }
        $data = [];
        $data['title'] = 'Change password';
        $this->load->view('header', $data);
        $this->load->view('nav');
        $this->load->view('change_password');
        $this->load->view('footer');
    }
    public function updatePassword()
    {
        $post = $_POST;
        $post['admin_id'] = $this->session->userdata("admin_id");
        if (isset($post['current_password']) && $post['current_password']) {
                    $check_current_password = $this->m_admin->check_current_password($post);
                    if ($check_current_password) {
                        echo "currunt_password_wrong";
                        exit();
                    }
        }
        if($post['password']) {
                $update = $this->m_admin->updatePassword($post);
                if($update) {
                    echo 'success';
                } else {
                    echo 'error';
                }
        }
    }


}

/* End of file instructor.php */
/* Location: ./application/controllers/instructor.php */