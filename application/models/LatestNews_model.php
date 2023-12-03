<?php defined('BASEPATH') or exit('No direct script access allowed');

class LatestNews_model extends CI_Model
{
	function __construct()
	{
		parent::__construct();
	}
	function get_news_data()
	{
		$this->db->select('*');
		$this->db->from('news');
		$query = $this->db->get();

		if ($query->num_rows() > 0) {
			return $query->result_array();
		} else {
			return false;
		}
	}

	function get_news_kind_data()
	{
		$this->db->select('*');
		$query = $this->db->get('news_kind')->result_array();
		return (!empty($query)) ? $query : false;
	}
}
