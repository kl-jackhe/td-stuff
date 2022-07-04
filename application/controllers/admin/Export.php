<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Export extends Admin_Controller {

    public function __construct()
    {
        parent::__construct();
    }

    public function index( $table )
    {
        $AlllineData = array();
        $start_date = $this->input->post('start_date');
        $end_date = $this->input->post('end_date');
        $type = $this->input->post('type');

        if (!empty($start_date)) {
            if($start_date==$end_date){
                $this->db->like('order_date',$start_date);
            } else {
                // $start_date=$start_date.' 00:00:00';
                // $end_date=$end_date.' 23:59:59';
                $this->db->where('order_date >=', $start_date);
                $this->db->where('order_date <=', $end_date);
            }
        }

        $query = $this->db->get($table);

        if($query->num_rows() > 0){

            switch ($table)
            {
                case 'orders':
                    $fields = array('訂單編號', '訂單日期', '取餐日期', '取餐時段', '訂購人', '取餐地址', '訂單金額', '訂單金額(折扣後)', '折扣金額', '商品', '單價', '數量', '小計', '付款方式', '付款狀態', '訂單狀態');
                    break;
            }

            array_push($AlllineData, $fields);

            foreach($query->result_array() as $row){

                switch ($table)
                {
                    case 'orders':
                        $lineData = array
                        (
                            $row['order_number'],
                            substr($row['created_at'], 0, 10),
                            $row['order_date'],
                            $row['order_delivery_time'],
                            get_user_full_name($row['customer_id']),
                            $row['order_delivery_address'],
                            $row['order_total'],
                            $row['order_discount_total'],
                            $row['order_discount_price'],
                            '',
                            '',
                            '',
                            '',
                            get_payment($row['order_payment']),
                            get_pay_status($row['order_pay_status']),
                            get_order_step($row['order_step']),
                        );
                        break;
                }

                array_push($AlllineData, $lineData);

                if($table=='orders'){
                    $this->db->join('product', 'product.product_id = order_item.product_id');
                    $this->db->where('order_id', $row['order_id']);
                    $query2 = $this->db->get('order_item');
                    if ($query2->num_rows() > 0) {
                        foreach($query2->result_array() as $item){
                            $itemData = array
                            (
                                '',
                                '',
                                '',
                                '',
                                '',
                                '',
                                '',
                                '',
                                '',
                                $item['product_name'],
                                floatval($item['order_item_price']),
                                floatval($item['order_item_qty']),
                                floatval($item['order_item_qty'])*floatval($item['order_item_price']),
                            );
                            array_push($AlllineData, $itemData);
                        }
                    }
                }

            }

        if($type=='csv'){
            $delimiter = ",";
            $filename = get_file_name($table)."_" . date('Y-m-d H-i-s') . ".csv";
            //create a file pointer
            $f = fopen('php://memory', 'w');
            fputs($f, $bom =( chr(0xEF) . chr(0xBB) . chr(0xBF) ));
            fputcsv($f, $fields, $delimiter);
            fputcsv($f, $lineData, $delimiter);
            //move back to beginning of file
            fseek($f, 0);
            //set headers to download file rather than displayed
            header('Content-Type: text/csv');
            header('Content-Disposition: attachment; filename="' . $filename . '";');
            //output all remaining data on a file pointer
            fpassthru($f);
        } elseif ($type=='xls') {
            function filterData(&$str)
            {
                $str = preg_replace("/\t/", "\\t", $str);
                $str = preg_replace("/\r?\n/", "\\n", $str);
                if(strstr($str, '"')) $str = '"' . str_replace('"', '""', $str) . '"';
            }

            // file name for download
            $fileName = "訂單_".date('Y-m-d H-i-s') . ".xls";

            // headers for download
            header("Content-Type: application/vnd.ms-excel");
            header("Content-Disposition: attachment; filename=\"$fileName\"");

            $flag = false;
            // utf8_to_big5_array() 把陣列utf8_to_big5
            foreach(utf8_to_big5_array($AlllineData) as $row) {
                if(!$flag) {
                    // display column names as first row
                    // echo implode("\t", array_keys($row)) . "\n";
                    $flag = true;
                }
                // filter data
                array_walk($row, 'filterData');
                echo implode("\t", array_values($row)) . "\n";
            }
        } elseif ($type=='pdf') {
            //
        }

        exit;
    }}

}