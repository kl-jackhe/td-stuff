<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Others extends Public_Controller {

    function __construct()
    {
        parent::__construct();
    }

    public function update()
    {
        // $query = $this->db->get('users');
        // if ($query->num_rows() > 0) {
        //     foreach($query->result_array() as $data){
        //         $update_data = array(
        //             'recommend_code' => get_random_string(10),
        //         );
        //         $this->db->where('id', $data['id']);
        //         $this->db->update('users', $update_data);
        //     }
        // }
    }

}