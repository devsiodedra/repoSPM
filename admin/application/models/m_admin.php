<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_admin extends CI_Model {

	

	public function update($post = [])
	{
		$user_id = $post['admin_id'];
		unset($post['admin_id']);
		
		$this->db->where('admin_id', $user_id);
		return $this->db->update('admin', $post);
	}
	public function updatePassword($post = [])
	{
		$user_id = $post['admin_id'];
		unset($post['admin_id']);
		
		$upd['password'] = sha1($post['password']);
		$this->db->where('admin_id', $user_id);
		return $this->db->update('admin', $upd);
	}

	
	public function getById($id = '')
	{
		$this->db->where('admin_id', $id);
		$user = $this->db->get('admin')->row_array();
		if($user) {
			//$user['profile_pic_name'] = $user['profile_pic'];
			//$user['profile_pic'] = $this->m_tools->pic_url($user['profile_pic']);
		}
		return $user;
	}
	public function getByEmail($post = [])
	{
		if(isset($post['admin_id']) && $post['admin_id']) {
			$this->db->where('admin_id !=', $post['admin_id']);
		}
		$this->db->where('email', $post['email']);
		return $this->db->get('admin')->row_array();
	}
	public function check_current_password($post = []) {
        $check = $this->db
                        ->where('admin_id', $post['admin_id'])
                        ->where('password', sha1($post['current_password']))
                        ->get('admin')->row_array();
        if (!$check) {
            return true;
        } else {
            return false;
        }
    }

	

}

/* End of file m_instructor.php */
/* Location: ./application/models/m_instructor.php */