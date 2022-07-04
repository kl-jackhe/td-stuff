<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends Admin_Controller {

    function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $this->data['page_title'] = '控制台';
        $this->render('dashboard/index');
    }

    public function get_today_order_income()
    {
        $this->db->select('SUM(order_discount_total) as sum');
        $this->db->where('order_status', '1');
        $this->db->like('created_at',date('Y-m-d'));
        $query = $this->db->get('pos_order');
        if ($query->num_rows() > 0) {
            $row = $query->row_array();
            $result = ($row['sum'] == 0)?0:$row['sum'];
            // $result=0;
            // foreach ($query->result_array() as $data ) {
            //     $result += $data['order_discount_total'];
            // }
            echo $result;
        } else {
            echo 0;
        }
    }

    public function get_today_sales()
    {
        $this->db->select('SUM(sales_price) as sum');
        $this->db->where('sales_status', '1');
        $this->db->like('created_at',date('Y-m-d'));
        $query = $this->db->get('sales_order');
        if ($query->num_rows() > 0) {
            $row = $query->row_array();
            $result = ($row['sum'] == 0)?0:$row['sum'];
            // $result=0;
            // foreach ($query->result_array() as $data ) {
            //     $result += $data['sales_price'];
            // }
            echo $result;
        } else {
            echo 0;
        }
    }

    public function get_today_purchase()
    {
        $this->db->select('SUM(purchase_price) as sum');
        $this->db->where('purchase_status', '1');
        $this->db->like('created_at',date('Y-m-d'));
        $query = $this->db->get('purchase_order');
        if ($query->num_rows() > 0) {
            $row = $query->row_array();
            $result = ($row['sum'] == 0)?0:$row['sum'];
            // $result=0;
            // foreach ($query->result_array() as $data ) {
            //     $result += $data['purchase_price'];
            // }
            echo $result;
        } else {
            echo 0;
        }
    }

    public function get_today_produce()
    {
        $this->db->select('SUM(produce_price) as sum');
        $this->db->where('produce_status', '1');
        $this->db->join('bom', 'bom.bom_id = produce.bom_id');
        $this->db->join('bom_item', 'bom_item.bom_id = bom.bom_id');
        $this->db->like('produce.created_at',date('Y-m-d'));
        $query = $this->db->get('produce');
        if ($query->num_rows() > 0) {
            $row = $query->row_array();
            $result = ($row['sum'] == 0)?0:$row['sum'];
            // $result=0;
            // foreach ($query->result_array() as $data ) {
            //     $result += $data['produce_price'];
            // }
            echo $result;
        } else {
            echo 0;
        }
    }

    public function get_month_order_income()
    {
        $last_day=new DateTime('last day of this month');
        $last_day = $last_day->format('Y-m-d');
        $start_date=date('Y-m-01').' 00:00:00';
        $end_date=$last_day.' 23:59:59';
        $this->db->select('SUM(order_discount_total) as sum');
        $this->db->where('order_status', '1');
        $this->db->where('created_at >=', $start_date);
        $this->db->where('created_at <=', $end_date);
        $query = $this->db->get('pos_order');
        if ($query->num_rows() > 0) {
            $row = $query->row_array();
            $result = ($row['sum'] == 0)?0:$row['sum'];
            // $result=0;
            // foreach ($query->result_array() as $data ) {
            //     $result += $data['order_discount_total'];
            // }
            echo $result;
        } else {
            echo 0;
        }
    }

    public function get_month_sales()
    {
        $last_day=new DateTime('last day of this month');
        $last_day = $last_day->format('Y-m-d');
        $start_date=date('Y-m-01').' 00:00:00';
        $end_date=$last_day.' 23:59:59';
        $this->db->select('SUM(sales_price) as sum');
        $this->db->where('sales_status', '1');
        $this->db->where('created_at >=', $start_date);
        $this->db->where('created_at <=', $end_date);
        $query = $this->db->get('sales_order');
        if ($query->num_rows() > 0) {
            $row = $query->row_array();
            $result = ($row['sum'] == 0)?0:$row['sum'];
            // $result=0;
            // foreach ($query->result_array() as $data ) {
            //     $result += $data['sales_price'];
            // }
            echo $result;
        } else {
            echo 0;
        }
    }

    public function get_month_purchase()
    {
        $last_day=new DateTime('last day of this month');
        $last_day = $last_day->format('Y-m-d');
        $start_date=date('Y-m-01').' 00:00:00';
        $end_date=$last_day.' 23:59:59';
        $this->db->select('SUM(purchase_price) as sum');
        $this->db->where('purchase_status', '1');
        $this->db->where('created_at >=', $start_date);
        $this->db->where('created_at <=', $end_date);
        $query = $this->db->get('purchase_order');
        if ($query->num_rows() > 0) {
            $row = $query->row_array();
            $result = ($row['sum'] == 0)?0:$row['sum'];
            // $result=0;
            // foreach ($query->result_array() as $data ) {
            //     $result += $data['purchase_price'];
            // }
            echo $result;
        } else {
            echo 0;
        }
    }

    public function get_month_produce()
    {
        $last_day=new DateTime('last day of this month');
        $last_day = $last_day->format('Y-m-d');
        $start_date=date('Y-m-01').' 00:00:00';
        $end_date=$last_day.' 23:59:59';
        $this->db->select('SUM(produce_price) as sum');
        $this->db->join('bom', 'bom.bom_id = produce.bom_id');
        $this->db->join('bom_item', 'bom_item.bom_id = bom.bom_id');
        $this->db->where('produce_status', '1');
        $this->db->where('produce.created_at >=', $start_date);
        $this->db->where('produce.created_at <=', $end_date);
        $query = $this->db->get('produce');
        if ($query->num_rows() > 0) {
            $row = $query->row_array();
            $result = ($row['sum'] == 0)?0:$row['sum'];
            // $result=0;
            // foreach ($query->result_array() as $data ) {
            //     $result += $data['produce_price'];
            // }
            echo $result;
        } else {
            echo 0;
        }
    }

    public function checkSession()
    {
        echo 1;
    }

    public function step1()
    {
        echo '
        <form action="'.base_url().'dashboard/step1" method="post" name="upload_excel" enctype="multipart/form-data">
          <div class="form-group">
            <input type="file" name="file">
          </div>
          <button type="submit" name="import" class="btn btn-primary">上傳</button>
        </form>
        ';

        if(isset($_POST["import"]))
        {
            ini_set('max_execution_time', 0);
            $filename=$_FILES["file"]["tmp_name"];
            if($_FILES["file"]["size"] > 0)
            {
                $file = fopen($filename, "r");
                while (($importdata = fgetcsv($file, 90000, ",")) !== FALSE)
                {
                    $data = array(
                        'content' => $importdata[0],
                    );
                    $this->db->insert('test', $data);
                }
                fclose($file);
                $this->session->set_flashdata('message', '上傳成功！');
                redirect('dashboard/step1');
            }else{
                $this->session->set_flashdata('message', '上傳失敗...');
                redirect('dashboard/step1');
            }
        }
    }

    public function step2()
    {
        ini_set('max_execution_time', 0);
        $query = $this->db->get('test');
        if(!empty($query->result_array())) {
            foreach ($query->result_array() as $data ) {
                $string = $data['content'];
                if(strlen(mb_substr($string, 2, 15))>15){
                    $len = strlen(mb_substr($string, 2, 15));
                    $data = ($len-15)/2;
                    $space = ' ';
                    for ($i=1; $i < $data ; $i++) { 
                        $space .= ' ';
                    }
                    $string = substr_replace($string, $space, 2, 0);
                    $string = mb_substr($string, 0, 500, 'UTF-8');
                }
                if(strlen(mb_substr($string, 113, 12))>12){
                    $len = strlen(mb_substr($string, 113, 12));
                    $data = ($len-12)/2;
                    $space = ' ';
                    for ($i=1; $i < $data ; $i++) { 
                        $space .= ' ';
                    }
                    $string = substr_replace($string, $space, 113, 0);
                }
                $data = array(
                    'a' => trim(mb_substr($string, 0, 2)),
                    'b' => trim(mb_substr($string, 2, 15)),
                    'c' => trim(mb_substr($string, 17, 6)),
                    'd' => trim(mb_substr($string, 23, 3)),
                    'e' => trim(mb_substr($string, 26, 3)),
                    'f' => trim(mb_substr($string, 29, 3)),
                    'g' => trim(mb_substr($string, 32, 20)),
                    'h' => trim(mb_substr($string, 52, 6)),
                    'i' => trim(mb_substr($string, 58, 5)),
                    'j' => trim(mb_substr($string, 63, 1)),
                    'k' => trim(mb_substr($string, 64, 2)),
                    'l' => trim(mb_substr($string, 66, 4)),
                    'm' => trim(mb_substr($string, 70, 3)),
                    'n' => trim(mb_substr($string, 73, 20)),
                    'o' => trim(mb_substr($string, 93, 20)),
                    'p' => trim(mb_substr($string, 113, 12)),
                    'q' => trim(mb_substr($string, 125, 1)),
                    'r' => trim(mb_substr($string, 126, 4)),
                    's' => trim(mb_substr($string, 130, 5)),
                    't' => trim(mb_substr($string, 135, 5)),
                    'u' => trim(mb_substr($string, 140, 14)),
                    'v' => trim(mb_substr($string, 154, 3)),
                    'w' => trim(mb_substr($string, 157, 2)),
                    'x' => trim(mb_substr($string, 159, 6)),
                );

                $this->db->insert('test_content',$data);

            }
        }
    }

}