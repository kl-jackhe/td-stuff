<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Update extends Admin_Controller {

    function __construct()
    {
        parent::__construct();
    }

    function index($version = '202308161240')
    {
        if ($version != '') {
            $this->version = $version;
            echo '
            <html><head><link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/css/bootstrap.min.css"></head>';
            echo '<body>
            <div class="container">
                <div class="row">
                    <div class="col-md-6 col-md-offset-3">
                        <h4>自動更新程序</h4>
                    </div>
                    <div class="col-md-6 col-md-offset-3" style="border: 1px solid gray; padding: 15px;">';
                        $query = $this->db->query("SHOW TABLES LIKE 'update_log'");
                        if ($query->num_rows() > 0) {
                            // 已經存在
                            $this->update_202308161230();
                            $this->update_202308161240();
                        } else {
                            // 不存在
                            $this->update_202308161130();
                        }
                    '</div>
                </div>
            </div>';
            echo '<hr>';
            echo '<a href="/admin" class="btn btn-primary">回到控制台</a>';
            echo '</body></html>';
        }
    }

    function update_202308161240() {
        $version = '202308161240';
        $description = 'single_sales_agent->income,order_qty,finish_qty,cancel_qty,other_qty,turnover_amount,turnover_rate';
        $this->db->select('id');
        $this->db->where('version',$version);
        $row = $this->db->get('update_log')->row_array();
        if (empty($row)) {
            $query = $this->db->query("SHOW COLUMNS FROM single_sales_agent LIKE 'order_qty'");
            if ($query->num_rows() > 0) {
            } else {
                $this->db->query("ALTER TABLE `single_sales_agent` ADD `order_qty` int(11) NOT NULL AFTER `start_hits`;");
            }

            $query = $this->db->query("SHOW COLUMNS FROM single_sales_agent LIKE 'finish_qty'");
            if ($query->num_rows() > 0) {
            } else {
                $this->db->query("ALTER TABLE `single_sales_agent` ADD `finish_qty` int(11) NOT NULL AFTER `order_qty`;");
            }

            $query = $this->db->query("SHOW COLUMNS FROM single_sales_agent LIKE 'cancel_qty'");
            if ($query->num_rows() > 0) {
            } else {
                $this->db->query("ALTER TABLE `single_sales_agent` ADD `cancel_qty` int(11) NOT NULL AFTER `finish_qty`;");
            }

            $query = $this->db->query("SHOW COLUMNS FROM single_sales_agent LIKE 'other_qty'");
            if ($query->num_rows() > 0) {
            } else {
                $this->db->query("ALTER TABLE `single_sales_agent` ADD `other_qty` int(11) NOT NULL AFTER `cancel_qty`;");
            }

            $query = $this->db->query("SHOW COLUMNS FROM single_sales_agent LIKE 'turnover_rate'");
            if ($query->num_rows() > 0) {
            } else {
                $this->db->query("ALTER TABLE `single_sales_agent` ADD `turnover_rate` float(6,2) NOT NULL AFTER `other_qty`;");
            }

            $query = $this->db->query("SHOW COLUMNS FROM single_sales_agent LIKE 'turnover_amount'");
            if ($query->num_rows() > 0) {
            } else {
                $this->db->query("ALTER TABLE `single_sales_agent` ADD `turnover_amount` decimal(13,4) NOT NULL AFTER `turnover_rate`;");
            }

            $query = $this->db->query("SHOW COLUMNS FROM single_sales_agent LIKE 'income'");
            if ($query->num_rows() > 0) {
            } else {
                $this->db->query("ALTER TABLE `single_sales_agent` ADD `income` decimal(13,4) NOT NULL AFTER `turnover_amount`;");
            }

            $insertData = array(
                'version' => $version,
                'description' => $description,
            );
            if ($this->db->insert('update_log', $insertData)) {
                echo '<p>' . $version . ' - ' . $description . '</p>';
            }
        }
    }

    function update_202308161230() {
        $version = '202308161230';
        $description = 'single_sales->qty,unit,default_profit_percentage';
        $this->db->select('id');
        $this->db->where('version',$version);
        $row = $this->db->get('update_log')->row_array();
        if (empty($row)) {
            $query = $this->db->query("SHOW COLUMNS FROM single_sales LIKE 'qty'");
            if ($query->num_rows() > 0) {
                // 已經存在
            } else {
                // 不存在
                $this->db->query("ALTER TABLE `single_sales` ADD `qty` decimal(13,4) NOT NULL AFTER `cost`;");
            }
            $query = $this->db->query("SHOW COLUMNS FROM single_sales LIKE 'unit'");
            if ($query->num_rows() > 0) {
                // 已經存在
            } else {
                // 不存在
                $this->db->query("ALTER TABLE `single_sales` ADD `unit` varchar(10) NOT NULL AFTER `qty`;");
            }
            $query = $this->db->query("SHOW COLUMNS FROM single_sales LIKE 'default_profit_percentage'");
            if ($query->num_rows() > 0) {
                // 已經存在
            } else {
                // 不存在
                $this->db->query("ALTER TABLE `single_sales` ADD `default_profit_percentage` float(6,2) NOT NULL AFTER `unit`;");
            }

            $insertData = array(
                'version' => $version,
                'description' => $description,
            );
            if ($this->db->insert('update_log', $insertData)) {
                echo '<p>' . $version . ' - ' . $description . '</p>';
            }
        }
    }

    function update_202308161130() {
        $version = '202308161130';
        $description = '新增資料表[update_log]';
        $query = $this->db->query("SHOW TABLES LIKE 'update_log'");
        if ($query->num_rows() > 0) {
            // 已經存在
        } else {
            // 不存在
            $this->db->query("CREATE TABLE `update_log` (
                `id` int(11) NOT NULL,
                `version` varchar(20) NOT NULL,
                `description` varchar(100) NOT NULL,
                `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;");
            $this->db->query("ALTER TABLE `update_log` ADD PRIMARY KEY (`id`);");
            $this->db->query("ALTER TABLE `update_log` MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;");
        }

        $query = $this->db->query("SHOW TABLES LIKE 'update_log'");
        if ($query->num_rows() > 0) {
            // 已經存在
            $insertData = array(
                'version' => $version,
                'description' => $description,
            );
            if ($this->db->insert('update_log', $insertData)) {
                echo '<p>' . $version . ' - ' . $description . '</p>';
            }
        } else {
            // 不存在
        }
    }

}