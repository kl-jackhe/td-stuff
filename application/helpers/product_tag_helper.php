<?php defined('BASEPATH') OR exit('No direct script access allowed.');

function getProductTagName($id,$lang)
{
	$CI =& get_instance();
	$CI->db->select('name');
	$CI->db->where('product_tag_id', $id);
	$CI->db->where('lang',$lang);
	$CI->db->limit(1);
	$row = $CI->db->get('product_tag_lang')->row_array();
	return (!empty($row)?$row['name']:'');
}