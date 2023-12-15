<?php defined('BASEPATH') or exit('No direct script access allowed');

class Update extends Admin_Controller
{

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
                $this->update_202311211630();
                $this->update_202312051900();
                $this->update_202312062000();
                $this->update_202312112300();
                $this->update_202312121540();
                $this->update_202312121541();
                $this->update_202312122310();
                $this->update_202312122315();
                $this->update_202312122325();
                $this->update_202312131400();
                $this->update_202312132220();
                $this->update_202312142100();
                $this->update_202312151515();
                $this->update_202312151520();
                $this->update_202312151530();
                $this->update_202312151535();
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

    function update_202312151535()
    {
        $version = '202312151535';
        $description = '[product_unit]新增欄位[weight,volume_length,volume_width,volume_height]';
        $this->db->select('id');
        $this->db->where('version', $version);
        $row = $this->db->get('update_log')->row_array();
        if (empty($row)) {
            $query = $this->db->query("SHOW COLUMNS FROM product_unit LIKE 'weight'")->result_array();
            if (empty($query)) {
                $this->db->query("ALTER TABLE `product_unit` ADD `weight` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL AFTER `unit`;");
            }
            $query = $this->db->query("SHOW COLUMNS FROM product_unit LIKE 'volume_length'")->result_array();
            if (empty($query)) {
                $this->db->query("ALTER TABLE `product_unit` ADD `volume_length` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL AFTER `weight`;");
            }
            $query = $this->db->query("SHOW COLUMNS FROM product_unit LIKE 'volume_width'")->result_array();
            if (empty($query)) {
                $this->db->query("ALTER TABLE `product_unit` ADD `volume_width` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL AFTER `volume_length`;");
            }
            $query = $this->db->query("SHOW COLUMNS FROM product_unit LIKE 'volume_height'")->result_array();
            if (empty($query)) {
                $this->db->query("ALTER TABLE `product_unit` ADD `volume_height` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL AFTER `volume_width`;");
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

    function update_202312151530()
    {
        $version = '202312151530';
        $description = '新增資料表[menu][sub_menu][menu_list]';
        $this->db->select('id');
        $this->db->where('version', $version);
        $row = $this->db->get('update_log')->row_array();
        if (empty($row)) {
            $row = $this->db->query("SHOW TABLES LIKE 'menu'")->row_array();
            if (empty($row)) {
                $this->db->query("CREATE TABLE `menu` (
                    `id` int(11) NOT NULL,
                    `code` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
                    `name` varchar(100) NOT NULL,
                    `sort` decimal(13,4) NOT NULL,
                    `status` TINYINT(4) NOT NULL DEFAULT TRUE,
                    `updated_at` DATETIME NOT NULL,
                    `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;");
                $this->db->query("ALTER TABLE `menu` ADD PRIMARY KEY (`id`);");
                $this->db->query("ALTER TABLE `menu` MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;");
            }

            $row = $this->db->query("SHOW TABLES LIKE 'sub_menu'")->row_array();
            if (empty($row)) {
                $this->db->query("CREATE TABLE `sub_menu` (
                    `id` int(11) NOT NULL,
                    `code` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
                    `name` varchar(100) NOT NULL,
                    `sort` decimal(13,4) NOT NULL,
                    `status` TINYINT(4) NOT NULL DEFAULT TRUE,
                    `updated_at` DATETIME NOT NULL,
                    `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;");
                $this->db->query("ALTER TABLE `sub_menu` ADD PRIMARY KEY (`id`);");
                $this->db->query("ALTER TABLE `sub_menu` MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;");
            }

            $row = $this->db->query("SHOW TABLES LIKE 'menu_list'")->row_array();
            if (empty($row)) {
                $this->db->query("CREATE TABLE `menu_list` (
                    `id` int(11) NOT NULL,
                    `sub_menu_id` int(11) NOT NULL,
                    `upper_layer_id` int(11) NOT NULL,
                    `upper_layer_code` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;");
                $this->db->query("ALTER TABLE `menu_list` ADD PRIMARY KEY (`id`);");
                $this->db->query("ALTER TABLE `menu_list` MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;");
                $this->db->query("ALTER TABLE `menu_list` ADD INDEX(`sub_menu_id`);");
                $this->db->query("ALTER TABLE `menu_list` ADD INDEX(`upper_layer_id`);");
                $this->db->query("ALTER TABLE `menu_list` ADD INDEX(`upper_layer_code`);");
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

    function update_202312151520()
    {
        $version = '202312151520';
        $description = '[tab_store]新增欄位[code]&新增資料表[tab_category_list]';
        $this->db->select('id');
        $this->db->where('version', $version);
        $row = $this->db->get('update_log')->row_array();
        if (empty($row)) {
            $query = $this->db->query("SHOW COLUMNS FROM tab_store LIKE 'code'")->result_array();
            if (empty($query)) {
                $this->db->query("ALTER TABLE `tab_store` ADD `code` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL AFTER `id`;");
            }

            $row = $this->db->query("SHOW TABLES LIKE 'tab_category_list'")->row_array();
            if (empty($row)) {
                $this->db->query("CREATE TABLE `tab_category_list` (
                    `id` int(11) NOT NULL,
                    `product_category_id` int(11) NOT NULL,
                    `upper_layer_id` int(11) NOT NULL,
                    `upper_layer_code` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;");
                $this->db->query("ALTER TABLE `tab_category_list` ADD PRIMARY KEY (`id`);");
                $this->db->query("ALTER TABLE `tab_category_list` MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;");
                $this->db->query("ALTER TABLE `tab_category_list` ADD INDEX(`product_category_id`);");
                $this->db->query("ALTER TABLE `tab_category_list` ADD INDEX(`upper_layer_id`);");
                $this->db->query("ALTER TABLE `tab_category_list` ADD INDEX(`upper_layer_code`);");
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

    function update_202312151515()
    {
        $version = '202312151515';
        $description = '[product_category]新增欄位[product_category_sort][product_category_code]';
        $this->db->select('id');
        $this->db->where('version', $version);
        $row = $this->db->get('update_log')->row_array();
        if (empty($row)) {
            $query = $this->db->query("SHOW COLUMNS FROM product_category LIKE 'product_category_sort'")->result_array();
            if (empty($query)) {
                $this->db->query("ALTER TABLE `product_category` ADD `product_category_sort` int(8) NOT NULL AFTER `product_category_print`;");
            }
            $query = $this->db->query("SHOW COLUMNS FROM product_category LIKE 'product_category_code'")->result_array();
            if (empty($query)) {
                $this->db->query("ALTER TABLE `product_category` ADD `product_category_code` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL AFTER `product_category_parent`;");
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

    function update_202312142100()
    {
        $version = '202312142100';
        $description = '[orders]新增欄位[InvoiceNumber]&[AllPayLogisticsID]&[CVSPaymentNo]';
        $this->db->select('id');
        $this->db->where('version', $version);
        $row = $this->db->get('update_log')->row_array();
        if (empty($row)) {
            $query = $this->db->query("SHOW COLUMNS FROM orders LIKE 'CVSPaymentNo'");
            if ($query->num_rows() > 0) {
            } else {
                $this->db->query("ALTER TABLE `orders` ADD `CVSPaymentNo` varchar(20) NOT NULL  AFTER `order_payment`;");
            }
            $query = $this->db->query("SHOW COLUMNS FROM orders LIKE 'AllPayLogisticsID'");
            if ($query->num_rows() > 0) {
            } else {
                $this->db->query("ALTER TABLE `orders` ADD `AllPayLogisticsID` varchar(10) NOT NULL  AFTER `order_payment`;");
            }
            $query = $this->db->query("SHOW COLUMNS FROM orders LIKE 'InvoiceNumber'");
            if ($query->num_rows() > 0) {
            } else {
                $this->db->query("ALTER TABLE `orders` ADD `InvoiceNumber` varchar(10) NOT NULL  AFTER `order_payment`;");
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
    function update_202312132220()
    {
        $version = '202312132220';
        $description = '優化資料庫-新增索引';
        $this->db->select('id');
        $this->db->where('version', $version);
        $row = $this->db->get('update_log')->row_array();
        if (empty($row)) {
            $query = $this->db->query("SHOW COLUMNS FROM product LIKE 'product_category_id'")->result_array();
            if (!empty($query)) {
                $this->db->query("ALTER TABLE `product` ADD INDEX(`product_category_id`);");
            }
            $query = $this->db->query("SHOW COLUMNS FROM product_combine LIKE 'product_id'")->result_array();
            if (!empty($query)) {
                $this->db->query("ALTER TABLE `product_combine` ADD INDEX(`product_id`);");
            }
            $query = $this->db->query("SHOW COLUMNS FROM product_combine_item LIKE 'product_combine_id'")->result_array();
            if (!empty($query)) {
                $this->db->query("ALTER TABLE `product_combine_item` ADD INDEX(`product_combine_id`);");
            }
            $query = $this->db->query("SHOW COLUMNS FROM product_combine_item LIKE 'product_id'")->result_array();
            if (!empty($query)) {
                $this->db->query("ALTER TABLE `product_combine_item` ADD INDEX(`product_id`);");
            }
            $query = $this->db->query("SHOW COLUMNS FROM product_specification LIKE 'product_id'")->result_array();
            if (!empty($query)) {
                $this->db->query("ALTER TABLE `product_specification` ADD INDEX(`product_id`);");
            }
            $query = $this->db->query("SHOW COLUMNS FROM product_unit LIKE 'product_id'")->result_array();
            if (!empty($query)) {
                $this->db->query("ALTER TABLE `product_unit` ADD INDEX(`product_id`);");
            }
            $query = $this->db->query("SHOW COLUMNS FROM single_product_combine LIKE 'product_id'")->result_array();
            if (!empty($query)) {
                $this->db->query("ALTER TABLE `single_product_combine` ADD INDEX(`product_id`);");
            }
            $query = $this->db->query("SHOW COLUMNS FROM single_product_combine_item LIKE 'product_combine_id'")->result_array();
            if (!empty($query)) {
                $this->db->query("ALTER TABLE `single_product_combine_item` ADD INDEX(`product_combine_id`);");
            }
            $query = $this->db->query("SHOW COLUMNS FROM single_product_combine_item LIKE 'product_id'")->result_array();
            if (!empty($query)) {
                $this->db->query("ALTER TABLE `single_product_combine_item` ADD INDEX(`product_id`);");
            }
            $query = $this->db->query("SHOW COLUMNS FROM single_product_specification LIKE 'product_id'")->result_array();
            if (!empty($query)) {
                $this->db->query("ALTER TABLE `single_product_specification` ADD INDEX(`product_id`);");
            }
            $query = $this->db->query("SHOW COLUMNS FROM single_product_unit LIKE 'product_id'")->result_array();
            if (!empty($query)) {
                $this->db->query("ALTER TABLE `single_product_unit` ADD INDEX(`product_id`);");
            }
            $query = $this->db->query("SHOW COLUMNS FROM order_item LIKE 'product_id'")->result_array();
            if (!empty($query)) {
                $this->db->query("ALTER TABLE `order_item` ADD INDEX(`product_id`);");
            }
            $query = $this->db->query("SHOW COLUMNS FROM order_item LIKE 'product_combine_id'")->result_array();
            if (!empty($query)) {
                $this->db->query("ALTER TABLE `order_item` ADD INDEX(`product_combine_id`);");
            }
            $query = $this->db->query("SHOW COLUMNS FROM order_item LIKE 'specification_id'")->result_array();
            if (!empty($query)) {
                $this->db->query("ALTER TABLE `order_item` ADD INDEX(`specification_id`);");
            }
            $query = $this->db->query("SHOW COLUMNS FROM single_sales LIKE 'product_id'")->result_array();
            if (!empty($query)) {
                $this->db->query("ALTER TABLE `single_sales` ADD INDEX(`product_id`);");
            }
            $query = $this->db->query("SHOW COLUMNS FROM users LIKE 'fb_id'")->result_array();
            if (!empty($query)) {
                $this->db->query("ALTER TABLE `users` ADD INDEX(`fb_id`);");
            }
            $query = $this->db->query("SHOW COLUMNS FROM users_address LIKE 'user_id'")->result_array();
            if (!empty($query)) {
                $this->db->query("ALTER TABLE `users_address` ADD INDEX(`user_id`);");
            }
            $query = $this->db->query("SHOW COLUMNS FROM product_category_list LIKE 'product_id'")->result_array();
            if (!empty($query)) {
                $this->db->query("ALTER TABLE `product_category_list` ADD INDEX(`product_id`);");
            }
            $query = $this->db->query("SHOW COLUMNS FROM product_category_list LIKE 'product_category_id'")->result_array();
            if (!empty($query)) {
                $this->db->query("ALTER TABLE `product_category_list` ADD INDEX(`product_category_id`);");
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

    function update_202312131400()
    {
        $version = '202312131400';
        $description = '[users]新增欄位[store_code]&[groups]新增參數[franchisee]';
        $this->db->select('id');
        $this->db->where('version', $version);
        $row = $this->db->get('update_log')->row_array();
        if (empty($row)) {
            $query = $this->db->query("SHOW COLUMNS FROM users LIKE 'store_code'")->result_array();
            if (empty($query)) {
                $this->db->query("ALTER TABLE `users` ADD `store_code` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL AFTER `ip_address`;");
            }

            $this->db->select('id');
            $this->db->where('name', 'franchisee');
            $this->db->limit(1);
            $g_row = $this->db->get('groups')->row_array();
            if (empty($g_row)) {
                $this->db->insert('groups', array('id' => 99, 'name' => 'franchisee', 'description' => '加盟主'));
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

    function update_202312122325()
    {
        $version = '202312122325';
        $description = '[orders]新增欄位參數';
        $this->db->select('id');
        $this->db->where('version', $version);
        $row = $this->db->get('update_log')->row_array();
        if (empty($row)) {
            $query = $this->db->query("SHOW COLUMNS FROM orders LIKE 'order_pay_status'")->result_array();
            if (empty($query)) {
                $this->db->query("ALTER TABLE `orders` ADD `order_pay_status` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL AFTER `order_payment`;");
            }
            $query = $this->db->query("SHOW COLUMNS FROM orders LIKE 'merID'")->result_array();
            if (empty($query)) {
                $this->db->query("ALTER TABLE `orders` ADD `merID` varchar(10) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL AFTER `order_status`;");
            }
            $query = $this->db->query("SHOW COLUMNS FROM orders LIKE 'authCode'")->result_array();
            if (empty($query)) {
                $this->db->query("ALTER TABLE `orders` ADD `authCode` varchar(6) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL AFTER `merID`;");
            }
            $query = $this->db->query("SHOW COLUMNS FROM orders LIKE 'lidm'")->result_array();
            if (empty($query)) {
                $this->db->query("ALTER TABLE `orders` ADD `lidm` varchar(19) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL AFTER `authCode`;");
            }
            $query = $this->db->query("SHOW COLUMNS FROM orders LIKE 'authAmt'")->result_array();
            if (empty($query)) {
                $this->db->query("ALTER TABLE `orders` ADD `authAmt` decimal(13,2) NOT NULL AFTER `lidm`;");
            }
            $query = $this->db->query("SHOW COLUMNS FROM orders LIKE 'xid'")->result_array();
            if (empty($query)) {
                $this->db->query("ALTER TABLE `orders` ADD `xid` varchar(40) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL AFTER `authAmt`;");
            }
            $query = $this->db->query("SHOW COLUMNS FROM orders LIKE 'MerchantID'")->result_array();
            if (empty($query)) {
                $this->db->query("ALTER TABLE `orders` ADD `MerchantID` varchar(10) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL AFTER `xid`;");
            }
            $query = $this->db->query("SHOW COLUMNS FROM orders LIKE 'MerchantTradeNo'")->result_array();
            if (empty($query)) {
                $this->db->query("ALTER TABLE `orders` ADD `MerchantTradeNo` varchar(18) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL AFTER `MerchantID`;");
            }
            $query = $this->db->query("SHOW COLUMNS FROM orders LIKE 'PaymentDate'")->result_array();
            if (empty($query)) {
                $this->db->query("ALTER TABLE `orders` ADD `PaymentDate` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL AFTER `MerchantTradeNo`;");
            }
            $query = $this->db->query("SHOW COLUMNS FROM orders LIKE 'PaymentType'")->result_array();
            if (empty($query)) {
                $this->db->query("ALTER TABLE `orders` ADD `PaymentType` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL AFTER `PaymentDate`;");
            }
            $query = $this->db->query("SHOW COLUMNS FROM orders LIKE 'PaymentTypeChargeFee'")->result_array();
            if (empty($query)) {
                $this->db->query("ALTER TABLE `orders` ADD `PaymentTypeChargeFee` decimal(13,2) NOT NULL AFTER `PaymentType`;");
            }
            $query = $this->db->query("SHOW COLUMNS FROM orders LIKE 'RtnCode'")->result_array();
            if (empty($query)) {
                $this->db->query("ALTER TABLE `orders` ADD `RtnCode` int(11) NOT NULL AFTER `PaymentTypeChargeFee`;");
            }
            $query = $this->db->query("SHOW COLUMNS FROM orders LIKE 'RtnMsg'")->result_array();
            if (empty($query)) {
                $this->db->query("ALTER TABLE `orders` ADD `RtnMsg` varchar(200) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL AFTER `RtnCode`;");
            }
            $query = $this->db->query("SHOW COLUMNS FROM orders LIKE 'SimulatePaid'")->result_array();
            if (empty($query)) {
                $this->db->query("ALTER TABLE `orders` ADD `SimulatePaid` int(1) NOT NULL AFTER `RtnMsg`;");
            }
            $query = $this->db->query("SHOW COLUMNS FROM orders LIKE 'TradeAmt'")->result_array();
            if (empty($query)) {
                $this->db->query("ALTER TABLE `orders` ADD `TradeAmt` decimal(13,2) NOT NULL AFTER `SimulatePaid`;");
            }
            $query = $this->db->query("SHOW COLUMNS FROM orders LIKE 'PayAmt'")->result_array();
            if (empty($query)) {
                $this->db->query("ALTER TABLE `orders` ADD `PayAmt` decimal(13,2) NOT NULL AFTER `TradeAmt`;");
            }
            $query = $this->db->query("SHOW COLUMNS FROM orders LIKE 'TradeNo'")->result_array();
            if (empty($query)) {
                $this->db->query("ALTER TABLE `orders` ADD `TradeNo` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL AFTER `PayAmt`;");
            }
            $query = $this->db->query("SHOW COLUMNS FROM orders LIKE 'TradeDate'")->result_array();
            if (empty($query)) {
                $this->db->query("ALTER TABLE `orders` ADD `TradeDate` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL AFTER `TradeNo`;");
            }
            $query = $this->db->query("SHOW COLUMNS FROM orders LIKE 'PaymentNo'")->result_array();
            if (empty($query)) {
                $this->db->query("ALTER TABLE `orders` ADD `PaymentNo` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL AFTER `TradeDate`;");
            }
            $query = $this->db->query("SHOW COLUMNS FROM orders LIKE 'VirtualAccount'")->result_array();
            if (empty($query)) {
                $this->db->query("ALTER TABLE `orders` ADD `VirtualAccount` varchar(16) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL AFTER `PaymentNo`;");
            }
            $query = $this->db->query("SHOW COLUMNS FROM orders LIKE 'BankCode'")->result_array();
            if (empty($query)) {
                $this->db->query("ALTER TABLE `orders` ADD `BankCode` varchar(3) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL AFTER `VirtualAccount`;");
            }
            $query = $this->db->query("SHOW COLUMNS FROM orders LIKE 'ExpireDate'")->result_array();
            if (empty($query)) {
                $this->db->query("ALTER TABLE `orders` ADD `ExpireDate` varchar(10) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL AFTER `BankCode`;");
            }
            $query = $this->db->query("SHOW COLUMNS FROM orders LIKE 'invoid'")->result_array();
            if (empty($query)) {
                $this->db->query("ALTER TABLE `orders` ADD `invoid` varchar(10) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL AFTER `ExpireDate`;");
            }
            $query = $this->db->query("SHOW COLUMNS FROM orders LIKE 'send_date'")->result_array();
            if (empty($query)) {
                $this->db->query("ALTER TABLE `orders` ADD `send_date` date NOT NULL AFTER `invoid`;");
            }
            $query = $this->db->query("SHOW COLUMNS FROM orders LIKE 'send_type'")->result_array();
            if (empty($query)) {
                $this->db->query("ALTER TABLE `orders` ADD `send_type` varchar(30) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL AFTER `send_date`;");
            }
            $query = $this->db->query("SHOW COLUMNS FROM orders LIKE 'send_no'")->result_array();
            if (empty($query)) {
                $this->db->query("ALTER TABLE `orders` ADD `send_no` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL AFTER `send_type`;");
            }
            $query = $this->db->query("SHOW COLUMNS FROM orders LIKE 'upay_no'")->result_array();
            if (empty($query)) {
                $this->db->query("ALTER TABLE `orders` ADD `upay_no` varchar(5) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL AFTER `send_no`;");
            }
            $query = $this->db->query("SHOW COLUMNS FROM orders LIKE 'upay_price'")->result_array();
            if (empty($query)) {
                $this->db->query("ALTER TABLE `orders` ADD `upay_price` decimal(13,2) NOT NULL AFTER `upay_no`;");
            }
            $query = $this->db->query("SHOW COLUMNS FROM orders LIKE 'upay_name'")->result_array();
            if (empty($query)) {
                $this->db->query("ALTER TABLE `orders` ADD `upay_name` varchar(30) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL AFTER `upay_price`;");
            }
            $query = $this->db->query("SHOW COLUMNS FROM orders LIKE 'upay_date'")->result_array();
            if (empty($query)) {
                $this->db->query("ALTER TABLE `orders` ADD `upay_date` date NOT NULL AFTER `upay_name`;");
            }
            $query = $this->db->query("SHOW COLUMNS FROM orders LIKE 'upay_memo'")->result_array();
            if (empty($query)) {
                $this->db->query("ALTER TABLE `orders` ADD `upay_memo` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL AFTER `upay_date`;");
            }
            $query = $this->db->query("SHOW COLUMNS FROM orders LIKE 'stock_makeup'")->result_array();
            if (empty($query)) {
                $this->db->query("ALTER TABLE `orders` ADD `stock_makeup` int(8) NOT NULL AFTER `upay_memo`;");
            }
            $query = $this->db->query("SHOW COLUMNS FROM orders LIKE 'point_enabled'")->result_array();
            if (empty($query)) {
                $this->db->query("ALTER TABLE `orders` ADD `point_enabled` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL AFTER `stock_makeup`;");
            }
            $query = $this->db->query("SHOW COLUMNS FROM orders LIKE 'point_price'")->result_array();
            if (empty($query)) {
                $this->db->query("ALTER TABLE `orders` ADD `point_price` decimal(13,2) NOT NULL AFTER `point_enabled`;");
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

    function update_202312122315()
    {
        $version = '202312122315';
        $description = '[users&users_address]變更[address]長度->300';
        $this->db->select('id');
        $this->db->where('version', $version);
        $row = $this->db->get('update_log')->row_array();
        if (empty($row)) {
            $query = $this->db->query("SHOW COLUMNS FROM users LIKE 'address'")->result_array();
            if (!empty($query)) {
                $this->db->query("ALTER TABLE `users` CHANGE `address` `address` VARCHAR(300) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL;");
            }
            $query = $this->db->query("SHOW COLUMNS FROM users_address LIKE 'address'")->result_array();
            if (!empty($query)) {
                $this->db->query("ALTER TABLE `users_address` CHANGE `address` `address` VARCHAR(300) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL;");
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

    function update_202312122310()
    {
        $version = '202312122310';
        $description = '[users]新增欄位[register_source,black_tag,point,fb_id,is_send_email]';
        $this->db->select('id');
        $this->db->where('version', $version);
        $row = $this->db->get('update_log')->row_array();
        if (empty($row)) {
            $query = $this->db->query("SHOW COLUMNS FROM users LIKE 'black_tag'")->result_array();
            if (empty($query)) {
                $this->db->query("ALTER TABLE `users` ADD `black_tag` int(11) NOT NULL AFTER `status`;");
            }
            $query = $this->db->query("SHOW COLUMNS FROM users LIKE 'register_source'")->result_array();
            if (empty($query)) {
                $this->db->query("ALTER TABLE `users` ADD `register_source` int(11) NOT NULL AFTER `black_tag`;");
            }
            $query = $this->db->query("SHOW COLUMNS FROM users LIKE 'point'")->result_array();
            if (empty($query)) {
                $this->db->query("ALTER TABLE `users` ADD `point` int(11) NOT NULL AFTER `company`;");
            }
            $query = $this->db->query("SHOW COLUMNS FROM users LIKE 'fb_id'")->result_array();
            if (empty($query)) {
                $this->db->query("ALTER TABLE `users` ADD `fb_id` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL AFTER `id`;");
            }
            $query = $this->db->query("SHOW COLUMNS FROM users LIKE 'is_send_email'")->result_array();
            if (empty($query)) {
                $this->db->query("ALTER TABLE `users` ADD `is_send_email` tinyint(1) NOT NULL;");
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

    function update_202312121541()
    {
        $version = '202312121541';
        $description = '[delivery]新增欄位*limit*[weight,weight_unit,volume_length,volume_width,volume_height]';
        $this->db->select('id');
        $this->db->where('version', $version);
        $row = $this->db->get('update_log')->row_array();
        if (empty($row)) {
            $query = $this->db->query("SHOW COLUMNS FROM delivery LIKE 'limit_weight'")->result_array();
            if (empty($query)) {
                $this->db->query("ALTER TABLE `delivery` ADD `limit_weight` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL AFTER `shipping_cost`;");
            }
            $query = $this->db->query("SHOW COLUMNS FROM delivery LIKE 'limit_weight_unit'")->result_array();
            if (empty($query)) {
                $this->db->query("ALTER TABLE `delivery` ADD `limit_weight_unit` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL AFTER `limit_weight`;");
            }
            $query = $this->db->query("SHOW COLUMNS FROM delivery LIKE 'limit_volume_length'")->result_array();
            if (empty($query)) {
                $this->db->query("ALTER TABLE `delivery` ADD `limit_volume_length` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL AFTER `limit_weight_unit`;");
            }
            $query = $this->db->query("SHOW COLUMNS FROM delivery LIKE 'limit_volume_width'")->result_array();
            if (empty($query)) {
                $this->db->query("ALTER TABLE `delivery` ADD `limit_volume_width` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL AFTER `limit_volume_length`;");
            }
            $query = $this->db->query("SHOW COLUMNS FROM delivery LIKE 'limit_volume_height'")->result_array();
            if (empty($query)) {
                $this->db->query("ALTER TABLE `delivery` ADD `limit_volume_height` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL AFTER `limit_volume_width`;");
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

    function update_202312121540()
    {
        $version = '202312121540';
        $description = '[product]新增欄位[product_weight,volume_length,volume_width,volume_height]';
        $this->db->select('id');
        $this->db->where('version', $version);
        $row = $this->db->get('update_log')->row_array();
        if (empty($row)) {
            $query = $this->db->query("SHOW COLUMNS FROM product LIKE 'product_weight'")->result_array();
            if (empty($query)) {
                $this->db->query("ALTER TABLE `product` ADD `product_weight` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL AFTER `product_sku`;");
            }
            $query = $this->db->query("SHOW COLUMNS FROM product LIKE 'volume_length'")->result_array();
            if (empty($query)) {
                $this->db->query("ALTER TABLE `product` ADD `volume_length` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL AFTER `product_weight`;");
            }
            $query = $this->db->query("SHOW COLUMNS FROM product LIKE 'volume_width'")->result_array();
            if (empty($query)) {
                $this->db->query("ALTER TABLE `product` ADD `volume_width` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL AFTER `volume_length`;");
            }
            $query = $this->db->query("SHOW COLUMNS FROM product LIKE 'volume_height'")->result_array();
            if (empty($query)) {
                $this->db->query("ALTER TABLE `product` ADD `volume_height` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL AFTER `volume_width`;");
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

    function update_202312112300()
    {
        $version = '202312112200';
        $description = '新增資料表[features_pay]';
        $this->db->select('id');
        $this->db->where('version', $version);
        $row = $this->db->get('update_log')->row_array();
        if (empty($row)) {
            $row = $this->db->query("SHOW TABLES LIKE 'features_pay'")->row_array();
            if (empty($row)) {
                $this->db->query("CREATE TABLE `features_pay` (
                    `pay_id` int(2) NOT NULL,
                    `pay_name` varchar(30) NOT NULL,
                    `ECPAY_ACTIVE` char(1) NOT NULL,
                    `ECPAY_OPEN` char(1) NOT NULL,
                    `ECPAY_MerchantID` varchar(10) NOT NULL,
                    `ECPAY_HashKey` varchar(64) NOT NULL,
                    `ECPAY_HashIV` varchar(64) NOT NULL
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;");
                $this->db->query("ALTER TABLE `features_pay` ADD PRIMARY KEY (`pay_id`);");
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

    function update_202312062000()
    {
        $version = '202312062000';
        $description = '[product]新增欄位[discontinued_at]';
        $this->db->select('id');
        $this->db->where('version', $version);
        $row = $this->db->get('update_log')->row_array();
        if (empty($row)) {
            $query = $this->db->query("SHOW COLUMNS FROM product LIKE 'discontinued_at'");
            if ($query->num_rows() > 0) {
            } else {
                $this->db->query("ALTER TABLE `product` ADD `discontinued_at` datetime NOT NULL  AFTER `updater_id`;");
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

    function update_202312051900()
    {
        $version = '202312051900';
        $description = '[product]新增欄位[distribute_at]';
        $this->db->select('id');
        $this->db->where('version', $version);
        $row = $this->db->get('update_log')->row_array();
        if (empty($row)) {
            $query = $this->db->query("SHOW COLUMNS FROM product LIKE 'distribute_at'");
            if ($query->num_rows() > 0) {
            } else {
                $this->db->query("ALTER TABLE `product` ADD `distribute_at` datetime NOT NULL  AFTER `updater_id`;");
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

    function update_202311211630()
    {
        $version = '202311211630';
        $description = '新增資料表[lottery][lottery_pool]';
        $this->db->select('id');
        $this->db->where('version', $version);
        $row = $this->db->get('update_log')->row_array();
        if (empty($row)) {
            $row = $this->db->query("SHOW TABLES LIKE 'lottery'")->row_array();
            if (empty($row)) {
                $this->db->query("CREATE TABLE `lottery` (
                  `id` int(8) NOT NULL,
                  `name` varchar(255) NOT NULL,
                  `email_subject` varchar(100) NOT NULL,
                  `email_content` text NOT NULL,
                  `sms_subject` varchar(255) NOT NULL,
                  `sms_content` varchar(255) NOT NULL,
                  `product_id` int(8) NOT NULL,
                  `number_limit` int(8) NOT NULL,
                  `number_remain` int(8) NOT NULL,
                  `number_alternate` int(8) NOT NULL,
                  `star_time` datetime NOT NULL,
                  `end_time` datetime NOT NULL,
                  `draw_date` datetime NOT NULL,
                  `fill_up_date` datetime NOT NULL,
                  `draw_over` int(8) NOT NULL,
                  `fill_up_over` int(8) NOT NULL,
                  `filter_black` int(8) NOT NULL,
                  `state` varchar(255) NOT NULL,
                  `lottery_end` int(8) NOT NULL,
                  `create_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;");
                $this->db->query("ALTER TABLE `lottery` ADD PRIMARY KEY (`id`);");
                $this->db->query("ALTER TABLE `lottery` MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;");
                $this->db->query("ALTER TABLE `lottery` ADD INDEX(`product_id`);");
            }

            $row = $this->db->query("SHOW TABLES LIKE 'lottery_pool'")->row_array();
            if (empty($row)) {
                $this->db->query("CREATE TABLE `lottery_pool` (
                  `id` int(8) NOT NULL,
                  `lottery_id` int(8) NOT NULL,
                  `users_id` int(8) NOT NULL,
                  `send_mail` text NOT NULL,
                  `abstain` int(8) NOT NULL,
                  `winner` int(8) NOT NULL,
                  `alternate` int(8) NOT NULL,
                  `fill_up` int(8) NOT NULL,
                  `blacklist` int(8) NOT NULL,
                  `abandon` int(8) NOT NULL,
                  `order_state` varchar(255) NOT NULL,
                  `order_id` int(11) NOT NULL,
                  `order_number` varchar(15) NOT NULL,
                  `msg_mail` varchar(255) NOT NULL,
                  `msg` varchar(255) NOT NULL,
                  `create_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;");
                $this->db->query("ALTER TABLE `lottery_pool` ADD PRIMARY KEY (`id`);");
                $this->db->query("ALTER TABLE `lottery_pool` MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;");
                $this->db->query("ALTER TABLE `lottery_pool` ADD INDEX(`lottery_id`);");
                $this->db->query("ALTER TABLE `lottery_pool` ADD INDEX(`users_id`);");
                $this->db->query("ALTER TABLE `lottery_pool` ADD INDEX(`order_id`);");
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

    function update_202311081430()
    {
        $version = '202311081430';
        $description = '[users]資料表[email]移除唯一值';
        $this->db->select('id');
        $this->db->where('version', $version);
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

    function update_202310311530()
    {
        $version = '202310311530';
        $description = '新增資料表[delivery_range_list]';
        $this->db->select('id');
        $this->db->where('version', $version);
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

    function update_202310251800()
    {
        $version = '20231025180';
        $description = '新增資料表[tab_store]';
        $this->db->select('id');
        $this->db->where('version', $version);
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

    function update_202310251330()
    {
        $version = '202310251330';
        $description = 'delivery insertData[home_delivery]';
        $this->db->select('id');
        $this->db->where('version', $version);
        $row = $this->db->get('update_log')->row_array();
        if (empty($row)) {
            $query = $this->db->query("SHOW TABLES LIKE 'delivery';");
            if ($query->num_rows() > 0) {
                $this->db->select('id');
                $this->db->where('delivery_name_code', 'home_delivery');
                $this->db->limit(1);
                $d_row = $this->db->get('delivery')->row_array();
                if (empty($d_row)) {
                    $insertData = array(
                        'delivery_name_code' => 'home_delivery',
                        'delivery_name' => '一般宅配',
                    );
                    $this->db->insert('delivery', $insertData);
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

    function update_202309191500()
    {
        $version = '202309191500';
        $description = 'setting_general insertData[join_member_info]';
        $this->db->select('id');
        $this->db->where('version', $version);
        $row = $this->db->get('update_log')->row_array();
        if (empty($row)) {
            $query = $this->db->query("SHOW TABLES LIKE 'setting_general';");
            if ($query->num_rows() > 0) {
                $insertList = array('join_member_info');
                for ($i = 0; $i < count($insertList); $i++) {
                    $this->db->select('setting_general_id');
                    $this->db->where('setting_general_name', $insertList[$i]);
                    $this->db->limit(1);
                    $sg_row = $this->db->get('setting_general')->row_array();
                    if (empty($sg_row)) {
                        $this->db->insert('setting_general', array('setting_general_name' => $insertList[$i]));
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

    function update_202309121800()
    {
        $version = '202309121800';
        $description = '[order_item]新增欄位[specification_str]';
        $this->db->select('id');
        $this->db->where('version', $version);
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

    function update_202309071240()
    {
        $version = '202309071240';
        $description = '[product]新增欄位[product_sku]';
        $this->db->select('id');
        $this->db->where('version', $version);
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

    function update_202309061750()
    {
        $version = '202309061750';
        $description = '[product]新增欄位[stock_overbought]';
        $this->db->select('id');
        $this->db->where('version', $version);
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

    function update_202309061300()
    {
        $version = '202309061300';
        $description = '新增資料表[notify]';
        $this->db->select('id');
        $this->db->where('version', $version);
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

    function update_202309051755()
    {
        $version = '202309051755';
        $description = '[product]新增欄位[excluding_inventory]';
        $this->db->select('id');
        $this->db->where('version', $version);
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

    function update_202309051540()
    {
        $version = '202309051540';
        $description = '新增資料表[inventory_log]';
        $this->db->select('id');
        $this->db->where('version', $version);
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

    function update_202308301910()
    {
        $version = '202308301910';
        $description = '[product]新增欄位[inventory]&[single_sales_agent]新增欄位[signature_file]';
        $this->db->select('id');
        $this->db->where('version', $version);
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

    function update_202308231510()
    {
        $version = '202308231510';
        $description = 'setting_general insertData[mail_header_text,mail_boddy_text,mail_other_text,mail_footer_text]';
        $this->db->select('id');
        $this->db->where('version', $version);
        $row = $this->db->get('update_log')->row_array();
        if (empty($row)) {
            $query = $this->db->query("SHOW TABLES LIKE 'setting_general';");
            if ($query->num_rows() > 0) {
                $insertList = array('mail_header_text', 'mail_boddy_text', 'mail_other_text', 'mail_footer_text');
                for ($i = 0; $i < count($insertList); $i++) {
                    $this->db->select('setting_general_id');
                    $this->db->where('setting_general_name', $insertList[$i]);
                    $this->db->limit(1);
                    $sg_row = $this->db->get('setting_general')->row_array();
                    if (empty($sg_row)) {
                        $this->db->insert('setting_general', array('setting_general_name' => $insertList[$i]));
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

    function update_202308212210()
    {
        $version = '202308212210';
        $description = 'setting_general insertData[smtp_host,smtp_user,smtp_pass,smtp_port,smtp_crypto]';
        $this->db->select('id');
        $this->db->where('version', $version);
        $row = $this->db->get('update_log')->row_array();
        if (empty($row)) {
            $query = $this->db->query("SHOW TABLES LIKE 'setting_general';");
            if ($query->num_rows() > 0) {
                $insertList = array('smtp_host', 'smtp_user', 'smtp_pass', 'smtp_port', 'smtp_crypto');
                for ($i = 0; $i < count($insertList); $i++) {
                    $this->db->select('setting_general_id');
                    $this->db->where('setting_general_name', $insertList[$i]);
                    $this->db->limit(1);
                    $sg_row = $this->db->get('setting_general')->row_array();
                    if (empty($sg_row)) {
                        $this->db->insert('setting_general', array('setting_general_name' => $insertList[$i]));
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

    function update_202308212140()
    {
        $version = '202308212140';
        $description = 'setting_general insertData[facebook,line,instagram,tiktok,xiaohongshu,single_sales_error_info]';
        $this->db->select('id');
        $this->db->where('version', $version);
        $row = $this->db->get('update_log')->row_array();
        if (empty($row)) {
            $query = $this->db->query("SHOW TABLES LIKE 'setting_general';");
            if ($query->num_rows() > 0) {
                $insertList = array('official_facebook_1_qrcode', 'official_facebook_2_qrcode', 'official_line_1_qrcode', 'official_line_2_qrcode', 'official_instagram_1_qrcode', 'official_instagram_2_qrcode', 'official_tiktok_1_qrcode', 'official_tiktok_2_qrcode', 'official_xiaohongshu_1_qrcode', 'official_xiaohongshu_2_qrcode', 'single_sales_error_info');
                for ($i = 0; $i < count($insertList); $i++) {
                    $this->db->select('setting_general_id');
                    $this->db->where('setting_general_name', $insertList[$i]);
                    $this->db->limit(1);
                    $sg_row = $this->db->get('setting_general')->row_array();
                    if (empty($sg_row)) {
                        $this->db->insert('setting_general', array('setting_general_name' => $insertList[$i]));
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

    function update_202308201555()
    {
        $version = '202308201555';
        $description = '[users]新增欄位[join_status]';
        $this->db->select('id');
        $this->db->where('version', $version);
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

    function update_202308191205()
    {
        $version = '202308191205';
        $description = 'setting_general insertData[facebook,line,instagram,tiktok,xiaohongshu,logo_max_width,shopping_notes]';
        $this->db->select('id');
        $this->db->where('version', $version);
        $row = $this->db->get('update_log')->row_array();
        if (empty($row)) {
            $query = $this->db->query("SHOW TABLES LIKE 'setting_general';");
            if ($query->num_rows() > 0) {
                $insertList = array('logo_max_width', 'official_facebook_1', 'official_facebook_2', 'official_line_1', 'official_line_2', 'official_instagram_1', 'official_instagram_2', 'official_tiktok_1', 'official_tiktok_2', 'official_xiaohongshu_1', 'official_xiaohongshu_2', 'shopping_notes');
                for ($i = 0; $i < count($insertList); $i++) {
                    $this->db->select('setting_general_id');
                    $this->db->where('setting_general_name', $insertList[$i]);
                    $this->db->limit(1);
                    $sg_row = $this->db->get('setting_general')->row_array();
                    if (empty($sg_row)) {
                        $this->db->insert('setting_general', array('setting_general_name' => $insertList[$i]));
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

    function update_202308161240()
    {
        $version = '202308161240';
        $description = 'single_sales_agent->income,order_qty,finish_qty,cancel_qty,other_qty,turnover_amount,turnover_rate';
        $this->db->select('id');
        $this->db->where('version', $version);
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

    function update_202308161230()
    {
        $version = '202308161230';
        $description = 'single_sales->qty,unit,default_profit_percentage';
        $this->db->select('id');
        $this->db->where('version', $version);
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

    function update_202308161130()
    {
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
