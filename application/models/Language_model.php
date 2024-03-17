<?
class Language_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }
    function getLanguageData($lang, $title)
    {
        $this->db->where('page_lang', $lang);
        $this->db->like('page_name', $title, 'both');
        $query = $this->db->get('standard_page_list');
        return (!empty($query) ? $query->row_array() : false);
    }
}
