<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_category extends CI_Model {

	public function categoryList()
	{
		$this->db->where('is_deleted', 0);
		$this->db->order_by('status', 'desc');
		$this->db->order_by('category_id', 'desc');
		$category = $this->db->get('category')->result_array();
		if($category) {
			foreach ($category as $key => $value) {
				$category[$key]['image'] = $this->m_tools->pic_url($category[$key]['image']);
			}
		}
		return $category;
	}

	public function getCategoryWithSubCategory($category_id='')
	{
		$this->db->where('category_id', $category_id);
		$category = $this->db->get('category')->row_array();
		if($category) {
			$category['image_name'] = $category['image'];
			$category['image'] = $this->m_tools->pic_url($category['image']);
			

		}
		return $category;
	}

	

}

/* End of file m_category.php */
/* Location: ./application/models/m_category.php */