<?php defined('BASEPATH') or exit('No direct script access allowed');

class Posts_model extends CI_Model
{

    function __construct()
    {
        parent::__construct();
    }

    function getRows($params = array())
    {
        $this->db->select('*');
        $this->db->from('posts');
        $this->db->order_by("updated_at DESC", "created_at DESC", "post_id ASC");
        //filter data by searched keywords
        if (!empty($params['search']['keywords'])) {
            $this->db->like('post_title', $params['search']['keywords']);
        }
        if (!empty($params['search']['category'])) {
            $this->db->where('post_category', $params['search']['category']);
        }
        // if(!empty($params['search']['status'])){
        //     $this->db->where('post_status',$params['search']['status']);
        // } else {
        //     $this->db->where('post_status', '1');
        // }
        if (!empty($params['search']['sortBy'])) {
            $this->db->order_by('post_id', $params['search']['sortBy']);
        } else {
            $this->db->order_by('post_id', 'desc');
        }
        //set start and limit
        if (array_key_exists("start", $params) && array_key_exists("limit", $params)) {
            $this->db->limit($params['limit'], $params['start']);
        } elseif (!array_key_exists("start", $params) && array_key_exists("limit", $params)) {
            $this->db->limit($params['limit']);
        }
        if (array_key_exists("returnType", $params) && $params['returnType'] == 'count') {
            $result = $this->db->count_all_results();
        } else {
            //get records
            $query = $this->db->get();
            //return fetched data
            $result = ($query->num_rows() > 0) ? $query->result_array() : false;
        }
        return $result;
    }

    function getPosts($params = array())
    {
        $this->db->select('*');
        $this->db->from('posts');
        $this->db->order_by("updated_at DESC", "created_at DESC", "post_id ASC");

        if (!empty($params['search']['post_category_id'])) {
            $this->db->where('post_category_id', $params['search']['post_category_id']);
        }
        $this->db->where('post_status', '1');
        if (array_key_exists("returnType", $params) && $params['returnType'] == 'count') {
            // search
            $result = $this->db->count_all_results();
        } else {
            //get records
            $query = $this->db->get();
            //return fetched data
            $result = ($query->num_rows() > 0) ? $query->result_array() : false;
        }
        return $result;
    }

    function getDescPosts()
    {
        $this->db->select('*');
        $this->db->order_by('post_id', 'desc');
        $query = $this->db->get('posts');
        if (!empty($query)) {
            return $query->result_array();
        } else {
            return false;
        }
    }

    function getDescCreatedAtPosts()
    {
        $this->db->select('*');
        $this->db->where('post_status', 1);
        $this->db->order_by('created_at', 'desc');
        $query = $this->db->get('posts');
        if (!empty($query)) {
            return $query->result_array();
        } else {
            return false;
        }
    }

    function getLastestPosts($limit)
    {
        $this->db->select('*');
        $this->db->order_by('post_id', 'desc');
        $this->db->limit($limit);
        $query = $this->db->get('posts');
        //return fetched data
        return ($query->num_rows() > 0) ? $query->result_array() : FALSE;
    }

    function getPostCategoryId()
    {
        $this->db->select('*');
        $query = $this->db->get('post_category');
        return ($query->num_rows() > 0) ? $query->result_array() : FALSE;
    }

    function getHomePosts()
    {
        $this->db->select('*');
        $this->db->order_by('created_at', 'desc');
        $this->db->limit(3);
        $query = $this->db->get('posts')->result_array();
        return !empty($query) ? $query : false;
    }
}
