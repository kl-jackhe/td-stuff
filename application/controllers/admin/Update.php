<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Update extends Admin_Controller {

    function __construct()
    {
        parent::__construct();
    }

    function index($version = '202308231510')
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
                            $this->update_202308161240();
                            $this->update_202308161230();
                            $this->update_202308191205();
                            $this->update_202308201555();
                            $this->update_202308212140();
                            $this->update_202308212210();
                            $this->update_202308231510();
                            $this->update_202308301910();
                            $this->update_202309051540();
                            $this->update_202309051755();
                            $this->update_202309061300();
                            $this->update_202309061750();
                            $this->update_202309071240();
                            $this->update_202309121800();
                            $this->update_202309191500();
                            $this->update_202310251330();
                            $this->update_202310251800();
                            $this->update_202310311530();
                            $this->update_202311081430();
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

    

    function update_202311081430() {
        $version = '202311081430';
        $description = '[users]資料表[email]移除唯一值';
        $this->db->select('id');
        $this->db->where('version',$version);
        $row = $this->db->get('update_log')->row_array();
        if (empty($row)) {
            $query = $this->db->query("SHOW COLUMNS FROM users LIKE 'email'")->result_array();
            if (!empty($query)) {
                $this->db->query("ALTER TABLE `users` DROP INDEX `uc_email`;");
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

    function update_202310311530() {
        $version = '202310311530';
        $description = '新增資料表[delivery_range_list]';
        $this->db->select('id');
        $this->db->where('version',$version);
        $row = $this->db->get('update_log')->row_array();
        if (empty($row)) {
            $row = $this->db->query("SHOW TABLES LIKE 'delivery_range_list'")->row_array();
            if (empty($row)) {
                $this->db->query("CREATE TABLE `delivery_range_list` (
                    `id` int(11) NOT NULL,
                    `delivery_id` int(11) NOT NULL,
                    `source` varchar(100) NOT NULL,
                    `source_id` int(11) NOT NULL,
                    `status` TINYINT(4) NOT NULL DEFAULT TRUE,
                    `updated_at` DATETIME NOT NULL,
                    `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;");
                $this->db->query("ALTER TABLE `delivery_range_list` ADD PRIMARY KEY (`id`);");
                $this->db->query("ALTER TABLE `delivery_range_list` MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;");
                $this->db->query("ALTER TABLE `delivery_range_list` ADD INDEX(`delivery_id`);");
                $this->db->query("ALTER TABLE `delivery_range_list` ADD INDEX(`source_id`);");
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

    function update_202310251800() {
        $version = '20231025180';
        $description = '新增資料表[tab_store]';
        $this->db->select('id');
        $this->db->where('version',$version);
        $row = $this->db->get('update_log')->row_array();
        if (empty($row)) {
            $row = $this->db->query("SHOW TABLES LIKE 'tab_store'")->row_array();
            if (empty($row)) {
                $this->db->query("CREATE TABLE `tab_store` (
                    `id` int(11) NOT NULL,
                    `name` varchar(100) NOT NULL,
                    `sort` decimal(13,4) NOT NULL,
                    `status` TINYINT(4) NOT NULL DEFAULT TRUE,
                    `updated_at` DATETIME NOT NULL,
                    `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;");
                $this->db->query("ALTER TABLE `tab_store` ADD PRIMARY KEY (`id`);");
                $this->db->query("ALTER TABLE `tab_store` MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;");
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

    function update_202310251330() {
        $version = '202310251330';
        $description = 'delivery insertData[home_delivery]';
        $this->db->select('id');
        $this->db->where('version',$version);
        $row = $this->db->get('update_log')->row_array();
        if (empty($row)) {
            $query = $this->db->query("SHOW TABLES LIKE 'delivery';");
            if ($query->num_rows() > 0) {
                $this->db->select('id');
                $this->db->where('delivery_name_code','home_delivery');
                $this->db->limit(1);
                $d_row = $this->db->get('delivery')->row_array();
                if (empty($d_row)) {
                    $insertData = array(
                        'delivery_name_code' => 'home_delivery',
                        'delivery_name' => '一般宅配',
                    );
                    $this->db->insert('delivery',$insertData);
                }
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

    function update_202309191500() {
        $version = '202309191500';
        $description = 'setting_general insertData[join_member_info]';
        $this->db->select('id');
        $this->db->where('version',$version);
        $row = $this->db->get('update_log')->row_array();
        if (empty($row)) {
            $query = $this->db->query("SHOW TABLES LIKE 'setting_general';");
            if ($query->num_rows() > 0) {
                $insertList = array('join_member_info');
                for ($i=0;$i<count($insertList);$i++) {
                    $this->db->select('setting_general_id');
                    $this->db->where('setting_general_name',$insertList[$i]);
                    $this->db->limit(1);
                    $sg_row = $this->db->get('setting_general')->row_array();
                    if (empty($sg_row)) {
                        $this->db->insert('setting_general',array('setting_general_name' => $insertList[$i]));
                    }
                }
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

    function update_202309121800() {
        $version = '202309121800';
        $description = '[order_item]新增欄位[specification_str]';
        $this->db->select('id');
        $this->db->where('version',$version);
        $row = $this->db->get('update_log')->row_array();
        if (empty($row)) {
            $query = $this->db->query("SHOW COLUMNS FROM order_item LIKE 'specification_str'");
            if ($query->num_rows() > 0) {
            } else {
                $this->db->query("ALTER TABLE `order_item` ADD `specification_str` varchar(300) NOT NULL  AFTER `specification_id`;");
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

    function update_202309071240() {
        $version = '202309071240';
        $description = '[product]新增欄位[product_sku]';
        $this->db->select('id');
        $this->db->where('version',$version);
        $row = $this->db->get('update_log')->row_array();
        if (empty($row)) {
            $query = $this->db->query("SHOW COLUMNS FROM product LIKE 'product_sku'");
            if ($query->num_rows() > 0) {
            } else {
                $this->db->query("ALTER TABLE `product` ADD `product_sku` varchar(50) NOT NULL  AFTER `product_name`;");
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

    function update_202309061750() {
        $version = '202309061750';
        $description = '[product]新增欄位[stock_overbought]';
        $this->db->select('id');
        $this->db->where('version',$version);
        $row = $this->db->get('update_log')->row_array();
        if (empty($row)) {
            $query = $this->db->query("SHOW COLUMNS FROM product LIKE 'stock_overbought'");
            if ($query->num_rows() > 0) {
            } else {
                $this->db->query("ALTER TABLE `product` ADD `stock_overbought` TINYINT(2) NOT NULL DEFAULT '1' AFTER `excluding_inventory`;");
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

    function update_202309061300() {
        $version = '202309061300';
        $description = '新增資料表[notify]';
        $this->db->select('id');
        $this->db->where('version',$version);
        $row = $this->db->get('update_log')->row_array();
        if (empty($row)) {
            $query = $this->db->query("SHOW TABLES LIKE 'notify'");
            if ($query->num_rows() > 0) {
                // 已經存在
            } else {
                // 不存在
                $this->db->query("CREATE TABLE `notify` (
                    `id` int(11) NOT NULL,
                    `title` varchar(50) NOT NULL,
                    `content` varchar(500) NOT NULL,
                    `source` varchar(20) NOT NULL,
                    `read` TINYINT(2) NOT NULL DEFAULT '1',
                    `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;");
                $this->db->query("ALTER TABLE `notify` ADD PRIMARY KEY (`id`);");
                $this->db->query("ALTER TABLE `notify` MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;");
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

    function update_202309051755() {
        $version = '202309051755';
        $description = '[product]新增欄位[excluding_inventory]';
        $this->db->select('id');
        $this->db->where('version',$version);
        $row = $this->db->get('update_log')->row_array();
        if (empty($row)) {
            $query = $this->db->query("SHOW COLUMNS FROM product LIKE 'excluding_inventory'");
            if ($query->num_rows() > 0) {
            } else {
                $this->db->query("ALTER TABLE `product` ADD `excluding_inventory` TINYINT(2) NOT NULL DEFAULT '1' AFTER `inventory`;");
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

    function update_202309051540() {
        $version = '202309051540';
        $description = '新增資料表[inventory_log]';
        $this->db->select('id');
        $this->db->where('version',$version);
        $row = $this->db->get('update_log')->row_array();
        if (empty($row)) {
            $query = $this->db->query("SHOW TABLES LIKE 'inventory_log'");
            if ($query->num_rows() > 0) {
                // 已經存在
            } else {
                // 不存在
                $this->db->query("CREATE TABLE `inventory_log` (
                    `id` int(11) NOT NULL,
                    `product_id` int(11) NOT NULL,
                    `source` varchar(20) NOT NULL,
                    `change_history` decimal(13,4) NOT NULL,
                    `change_notes` varchar(50) NOT NULL,
                    `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;");
                $this->db->query("ALTER TABLE `inventory_log` ADD PRIMARY KEY (`id`);");
                $this->db->query("ALTER TABLE `inventory_log` MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;");
                $this->db->query("ALTER TABLE `inventory_log` ADD INDEX(`product_id`);");
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

    function update_202308301910() {
        $version = '202308301910';
        $description = '[product]新增欄位[inventory]&[single_sales_agent]新增欄位[signature_file]';
        $this->db->select('id');
        $this->db->where('version',$version);
        $row = $this->db->get('update_log')->row_array();
        if (empty($row)) {
            $query = $this->db->query("SHOW COLUMNS FROM product LIKE 'inventory'");
            if ($query->num_rows() > 0) {
            } else {
                $this->db->query("ALTER TABLE `product` ADD `inventory` decimal(13,4) NOT NULL AFTER `sort`;");
            }

            $query = $this->db->query("SHOW COLUMNS FROM single_sales_agent LIKE 'signature_file'");
            if ($query->num_rows() > 0) {
            } else {
                $this->db->query("ALTER TABLE `single_sales_agent` ADD `signature_file` varchar(100) NOT NULL AFTER `income`;");
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

    function update_202308231510() {
        $version = '202308231510';
        $description = 'setting_general insertData[mail_header_text,mail_boddy_text,mail_other_text,mail_footer_text]';
        $this->db->select('id');
        $this->db->where('version',$version);
        $row = $this->db->get('update_log')->row_array();
        if (empty($row)) {
            $query = $this->db->query("SHOW TABLES LIKE 'setting_general';");
            if ($query->num_rows() > 0) {
                $insertList = array('mail_header_text','mail_boddy_text','mail_other_text','mail_footer_text');
                for ($i=0;$i<count($insertList);$i++) {
                    $this->db->select('setting_general_id');
                    $this->db->where('setting_general_name',$insertList[$i]);
                    $this->db->limit(1);
                    $sg_row = $this->db->get('setting_general')->row_array();
                    if (empty($sg_row)) {
                        $this->db->insert('setting_general',array('setting_general_name' => $insertList[$i]));
                    }
                }
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

    function update_202308212210() {
        $version = '202308212210';
        $description = 'setting_general insertData[smtp_host,smtp_user,smtp_pass,smtp_port,smtp_crypto]';
        $this->db->select('id');
        $this->db->where('version',$version);
        $row = $this->db->get('update_log')->row_array();
        if (empty($row)) {
            $query = $this->db->query("SHOW TABLES LIKE 'setting_general';");
            if ($query->num_rows() > 0) {
                $insertList = array('smtp_host','smtp_user','smtp_pass','smtp_port','smtp_crypto');
                for ($i=0;$i<count($insertList);$i++) {
                    $this->db->select('setting_general_id');
                    $this->db->where('setting_general_name',$insertList[$i]);
                    $this->db->limit(1);
                    $sg_row = $this->db->get('setting_general')->row_array();
                    if (empty($sg_row)) {
                        $this->db->insert('setting_general',array('setting_general_name' => $insertList[$i]));
                    }
                }
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

    function update_202308212140() {
        $version = '202308212140';
        $description = 'setting_general insertData[facebook,line,instagram,tiktok,xiaohongshu,single_sales_error_info]';
        $this->db->select('id');
        $this->db->where('version',$version);
        $row = $this->db->get('update_log')->row_array();
        if (empty($row)) {
            $query = $this->db->query("SHOW TABLES LIKE 'setting_general';");
            if ($query->num_rows() > 0) {
                $insertList = array('official_facebook_1_qrcode','official_facebook_2_qrcode','official_line_1_qrcode','official_line_2_qrcode','official_instagram_1_qrcode','official_instagram_2_qrcode','official_tiktok_1_qrcode','official_tiktok_2_qrcode','official_xiaohongshu_1_qrcode','official_xiaohongshu_2_qrcode','single_sales_error_info');
                for ($i=0;$i<count($insertList);$i++) {
                    $this->db->select('setting_general_id');
                    $this->db->where('setting_general_name',$insertList[$i]);
                    $this->db->limit(1);
                    $sg_row = $this->db->get('setting_general')->row_array();
                    if (empty($sg_row)) {
                        $this->db->insert('setting_general',array('setting_general_name' => $insertList[$i]));
                    }
                }
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

    function update_202308201555() {
        $version = '202308201555';
        $description = '[users]新增欄位[join_status]';
        $this->db->select('id');
        $this->db->where('version',$version);
        $row = $this->db->get('update_log')->row_array();
        if (empty($row)) {
            $query = $this->db->query("SHOW COLUMNS FROM users LIKE 'join_status'");
            if ($query->num_rows() > 0) {
            } else {
                $this->db->query("ALTER TABLE `users` ADD `join_status` varchar(30) NOT NULL AFTER `id`;");
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

    function update_202308191205() {
        $version = '202308191205';
        $description = 'setting_general insertData[facebook,line,instagram,tiktok,xiaohongshu,logo_max_width,shopping_notes]';
        $this->db->select('id');
        $this->db->where('version',$version);
        $row = $this->db->get('update_log')->row_array();
        if (empty($row)) {
            $query = $this->db->query("SHOW TABLES LIKE 'setting_general';");
            if ($query->num_rows() > 0) {
                $insertList = array('logo_max_width','official_facebook_1','official_facebook_2','official_line_1','official_line_2','official_instagram_1','official_instagram_2','official_tiktok_1','official_tiktok_2','official_xiaohongshu_1','official_xiaohongshu_2','shopping_notes');
                for ($i=0;$i<count($insertList);$i++) {
                    $this->db->select('setting_general_id');
                    $this->db->where('setting_general_name',$insertList[$i]);
                    $this->db->limit(1);
                    $sg_row = $this->db->get('setting_general')->row_array();
                    if (empty($sg_row)) {
                        $this->db->insert('setting_general',array('setting_general_name' => $insertList[$i]));
                    }
                }
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