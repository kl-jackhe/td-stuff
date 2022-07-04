<style>
@media (max-width: 480px) {

    #sub_menu a {
        width: 24%;
        padding: 6px;
    }

}

table {
    margin: auto;
    /*padding: 20px;*/
    border-collapse: separate;
    border-spacing: 0;
}

tr {
    /*border: 1px solid #E0607E;*/
}

td {
    /*border: 1px solid #607ee0;*/
    /*padding: 10px 30px;*/
    /*background-color: #E0607E;*/
    /*color: #FFF;*/
}

/*第一欄第一列：左上*/
tr:first-child td:first-child {
    border-top-left-radius: 8px;
}

/*第一欄最後列：左下*/
tr:last-child td:first-child {
    border-bottom-left-radius: 8px;
}

/*最後欄第一列：右上*/
tr:first-child td:last-child {
    border-top-right-radius: 8px;
}

/*最後欄第一列：右下*/
tr:last-child td:last-child {
    border-bottom-right-radius: 8px;
}
</style>
<div role="main" class="main pt-signinfo">
    <section>
        <div class="container">
            <div class="box">
                <div class="" id="sub_menu">
                    <h3 class="fs-18 color-595757">Hi
                        <?php echo $this->ion_auth->user()->row()->full_name ?>
                    </h3>
                    <a href="/auth/edit_user/<?php echo $this->ion_auth->user()->row()->id ?>" class="btn fs-13" style="border: 1px solid gray; color: gray; border-bottom: none;">個人資料</a>
                    <a href="/coupon" class="btn fs-13" style="background: gray; color: white;">優惠券管理</a>
                    <a href="/order" class="btn fs-13" style="border: 1px solid gray; color: gray; border-bottom: none;">訂單管理</a>
                    <a href="/my_address" class="btn fs-13" style="border: 1px solid gray; color: gray; border-bottom: none;">常用地址</a>
                </div>
                <div class="col-md-12">
                    <div class="row" style="border: 2px solid gray;">
                        <div class="col-md-10 col-md-offset-1">
                            <div class="row">
                                <div class="col-md-8" style="margin-top: 20px;">
                                    <?php $att = "class='form-horizontal'"; ?>
                                    <?php echo form_open('coupon/insert', $att);?>
                                    <div class="form-inline">
                                        <span class="fs-13 color-595757">請輸入優惠代碼</span>
                                        <input type="text" class="form-control" name="coupon_code" id="coupon_code" required>
                                        <button tyue="submit" class="btn btn-info" onclick="insert_coupon()">取得優惠</button>
                                    </div>
                                    <?php echo form_close() ?>
                                </div>
                                <div class="col-md-4" style="margin-top: 20px;">
                                    <div class="form-inline text-right">
                                        <span class="fs-13 color-595757">優惠券狀態</span>
                                        <select id="coupon_method" class="form-control fs-12 color-595757" onchange="get_coupon()">
                                            <option value="all">全部</option>
                                            <option value="n">可使用</option>
                                            <option value="over">已過期</option>
                                            <option value="y">已使用</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-12" style="margin-top: 40px;">
                                    <?php if(wp_is_mobile()){ ?>

                                        <?php if(!empty($user_coupon)) { foreach($user_coupon as $data) { ?>
                                        <?php $status=''; ?>
                                        <?php $over=''; ?>
                                        <?php $uesd=''; ?>
                                        <?php if($data['coupon_off_date']=='0000-00-00 00:00:00'){$status='n';} ?>
                                        <?php if($data['coupon_is_uesd']=='n'){$uesd='n';} ?>
                                        <?php if(date('Y-m-d H:i:s')>$data['coupon_off_date']){$over='over';} ?>
                                        <?php if($data['coupon_is_uesd']=='y'){$uesd='y';} ?>
                                        <?php if($uesd=='y' || $over=='over'){$style='background: #A0A0A0; color: #333;';}else{$style='background: #FFB718; color: #fefefe;';} ?>
                                        <table class="table table-bordered <?php echo $status.' '.$over.' '.$uesd; ?>" style="border: none;">
                                            <tr>
                                                <td style="<?php echo $style; ?>">優惠券項目</td>
                                                <td><?php echo $data['coupon_name'] ?></td>
                                            </tr>
                                            <tr>
                                                <td style="<?php echo $style; ?>">優惠券代碼</td>
                                                <td><?php echo $data['coupon_code'] ?></td>
                                            </tr>
                                            <tr>
                                                <td style="<?php echo $style; ?>">使用期限</td>
                                                <td>
                                                    <?php echo ($data['coupon_off_date']!='0000-00-00 00:00:00')?($data['coupon_off_date']):('無期限') ?>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="<?php echo $style; ?>">使用狀況</td>
                                                <td><?php echo get_coupon_is_uesd($data['coupon_is_uesd']) ?></td>
                                            </tr>
                                        </table>
                                        <?php }} ?>

                                    <?php } else { ?>

                                        <table class="table table-bordered" style="border: none;">
                                            <tr id="coupon_header" style="background: #FFB718; color: #fefefe;">
                                                <td class="text-center fs-12" style="width: 24%;">優惠券代碼</td>
                                                <td class="text-center fs-12" style="width: 28%;">優惠券項目</td>
                                                <!-- <td class="text-center fs-12" style="width: 24%;">使用次數限制</td> -->
                                                <td class="text-center fs-12" style="width: 20%;">使用狀況</td>
                                                <td class="text-center fs-12" style="width: 24%;">使用期限</td>
                                            </tr>
                                            <?php if(!empty($user_coupon)) { foreach($user_coupon as $data) { ?>
                                            <?php $status=''; ?>
                                            <?php $over=''; ?>
                                            <?php $uesd=''; ?>
                                            <?php if($data['coupon_off_date']=='0000-00-00 00:00:00'){$status='n';} ?>
                                            <?php if($data['coupon_is_uesd']=='n'){$uesd='n';} ?>
                                            <?php if(date('Y-m-d H:i:s')>$data['coupon_off_date']){$over='over';} ?>
                                            <?php if($data['coupon_is_uesd']=='y'){$uesd='y';} ?>
                                            <tr class="<?php echo $status.' '.$over.' '.$uesd; ?>">
                                                <td class="fs-12 color-595757">
                                                    <?php echo $data['coupon_code'] ?>
                                                </td>
                                                <td class="fs-12 color-595757">
                                                    <?php echo $data['coupon_name'] ?>
                                                </td>
                                                <!-- <td class="fs-12 color-595757">
                                                        <?php // echo get_coupon_use_limit($data['coupon_use_limit']) ?>
                                                    </td> -->
                                                <td class="fs-12 color-595757">
                                                    <?php echo get_coupon_is_uesd($data['coupon_is_uesd']) ?>
                                                </td>
                                                <td class="fs-12 color-595757">
                                                    <?php echo ($data['coupon_off_date']!='0000-00-00 00:00:00')?($data['coupon_off_date']):('無期限') ?>
                                                </td>
                                            </tr>
                                            <?php }} ?>
                                        </table>

                                    <?php } ?>
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
<script>
// function insert_coupon() {
//     var coupon_code = $('#coupon_code').val();
//     $.ajax({
//         type: "POST",
//         url: "<?php // echo base_url() ?>coupon/insert_coupon",
//         data: { manufacturer_VAT_number: $("#manufacturer_VAT_number").val() },
//         dataType: "json",
//         beforeSend: function () {
//             $("#manufacturer_VAT_number_message").html("<img src='/assets/images/loading.gif' width='20px'/>檢查中...");
//         },
//         success: function(data) {
//             if (data == 0) {
//                 $("#manufacturer_VAT_number_message").html("<i class='fa fa-close' style='color:red;'></i><small>已經存在</small>");
//             } else {
//                 $("#manufacturer_VAT_number_message").html("<i class='fa fa-check' style='color:green;'></i><small>可以使用</small>");
//             }
//         }
//     });
// }

function get_coupon() {
    var coupon_method = $('#coupon_method').val();
    if (coupon_method == 'all') {
        $('#coupon_header').css('background-color', '#FFB718');
        $("table.n").fadeIn('fast');
        $("table.over").fadeIn('fast');
        $("table.y").fadeIn('fast');

        $("table .n").fadeIn('fast');
        $("table .over").fadeIn('fast');
        $("table .y").fadeIn('fast');
    } else if (coupon_method == 'y') {
        $('#coupon_header').css('background-color', '#A0A0A0');
        $("table.n").fadeOut('fast');
        $("table.over").fadeOut('fast');
        $("table.y").fadeIn('fast');

        $("table .n").fadeOut('fast');
        $("table .over").fadeOut('fast');
        $("table .y").fadeIn('fast');
    } else if (coupon_method == 'n') {
        $('#coupon_header').css('background-color', '#FFB718');
        $("table.y").fadeOut('fast');
        $("table.over").fadeOut('fast');
        $("table.n").fadeIn('fast');

        $("table .y").fadeOut('fast');
        $("table .over").fadeOut('fast');
        $("table .n").fadeIn('fast');
    } else if (coupon_method == 'over') {
        $('#coupon_header').css('background-color', '#A0A0A0');
        $("table.y").fadeOut('fast');
        $("table.n").fadeOut('fast');
        $("table.over").fadeIn('fast');

        $("table .y").fadeOut('fast');
        $("table .n").fadeOut('fast');
        $("table .over").fadeIn('fast');
    }
}
</script>