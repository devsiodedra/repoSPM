<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_customer extends CI_Model {

	public function getByID($user_id='')
	{
		$this->db->select('*');
		$this->db->where('user_id', $user_id);
		$user = $this->db->get('user')->row_array();
		if($user) {
			$user['profile_pic'] = $this->m_tools->pic_url($user['profile_pic']);

			if(!$user['profile_pic']) {
				$user['profile_pic'] = DEFAULT_IMG_USER;
			}
		}
		return $user;
	}


	public function allCustomers()
	{
		//$this->db->where('status', 1);
		return $this->db->get('user')->result_array();
	}
	public function allStores()
	{
		$this->db->where('is_deleted', 0);
		return $this->db->get('store')->result_array();
	}
	
	public function checkEmailExist($post = [])
	{
		$this->db->where('user_id !=', $post['user_id']);
		$this->db->where('email', $post['email']);
		return $this->db->get('user')->row_array();
	}

	public function saveCustomer($post=[])
	{
		$user_id = $post['user_id'];

		unset($post['user_id']);

		$this->db->where('user_id', $user_id);
		return $this->db->update('user', $post);
	}
}

/* End of file M_customer.php */
/* Location: ./application/models/M_customer.php */