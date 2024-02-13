<style>
.chosen-container {
    border: none;
}
.input-group {
    margin-bottom: 15px;
}
</style>
<div class="row">
    <?php $attributes = array('class' => 'lottery', 'id' => 'lottery'); ?>
    <?php echo form_open('admin/lottery/editLotteryEvent/' . $lottery['id'] , $attributes); ?>
    <div class="col-md-12">
        <div class="form-group">
            <a href="<?php echo base_url().'admin/'.$this->uri->segment(2) ?>" class="btn btn-info hidden-print">返回上一頁</a>
        </div>
        <div class="content-box-large">
            <button type="submit" class="btn btn-primary">儲存</button>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <h3>基本資訊</h3>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="input-group">
                                    <span class="input-group-addon">抽選名稱</span>
                                    <input type="text" name="name" value="<?=$lottery['name']?>" class="form-control" id="name" placeholder="請輸抽選名稱" required>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="input-group">
                                    <span class="input-group-addon">抽選商品</span>
                                    <select class="chosen form-control" data-placeholder="請選擇抽選商品" style="width: 100%;" name="product" required>
                                        <option value=""></option>
                                        <?if (!empty($product)) {
                                            foreach ($product as $p_row) {?>
                                                <option value="<?=$p_row['product_id']?>" <?=($p_row['product_id'] == $lottery['product_id']? 'selected' : '')?>><?=$p_row['product_sku'] . " " . $p_row['product_name']?></option>
                                            <?}
                                        }?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="input-group">
                                    <span class="input-group-addon">正取名額</span>
                                    <input type="number" name="number_limit" min="1" value="<?=$lottery['number_limit']?>" class="form-control" required>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="input-group">
                                    <span class="input-group-addon">商品網址</span>
                                    <span class="input-group-addon" style="cursor: pointer;color: green;" onclick="copy_product_front_link()"><i class="fa-solid fa-copy"></i></span>
                                    <input type="text" class="form-control" id="product_front_link" value="<?='https://' . $_SERVER['HTTP_HOST'] . '/product/product_detail/' . $lottery['product_id']?>" disabled>
                                    <span class="input-group-addon"><a href="<?='https://' . $_SERVER['HTTP_HOST'] . '/product/product_detail/' . $lottery['product_id']?>">瀏覽頁面</a></span>
                                </div>
                               <!--  <span class="btn btn-success" onclick="copy_product_front_link()">複製網址 <i class="fa-solid fa-copy"></i></span>
                                <a href="<?='https://' . $_SERVER['HTTP_HOST'] . '/product/view/' . $lottery['product_id']?>"><?='https://' . $_SERVER['HTTP_HOST'] . '/product/view/' . $lottery['product_id']?></a> -->
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <h3>有效期限 ／ 開獎時間</h3>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="input-group">
                                    <span class="input-group-addon">開始日</span>
                                    <input type="text" name="star_time" value="<?=$lottery['star_time']?>" class="form-control datetimepicker" required>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="input-group">
                                    <span class="input-group-addon">結束日</span>
                                    <input type="text" name="end_time" value="<?=$lottery['end_time']?>" class="form-control datetimepicker" required>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="input-group">
                                    <span class="input-group-addon">開獎日</span>
                                    <input type="text" name="draw_date" value="<?=$lottery['draw_date']?>" class="form-control datetimepicker" required>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <p>正取匯款截止時間</p>
                                <p><?=$draw_date_3d_end?></p>
                            </div>
                        </div>
                    </div>
                </div>
                <?if (!empty($lottery_pool)) {?>
                    <div class="col-md-3">
                        <h3>遞補資訊</h3>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-12">
                                    <p>“逾期下單/逾期付款”名額釋出</p>
                                    <p><?=$lottery['number_remain']?> 人</p>
                                </div>
                                <div class="col-md-12">
                                    <p>遞補開獎時間</p>
                                    <p><?=$fill_up_date?></p>
                                </div>
                                <div class="col-md-12">
                                    <p>遞補匯款截止時間</p>
                                    <p>
                                        <?=(($fill_up_date != '0000-00-00 00:00:00')?$fill_up_date_3d_end:'尚無資訊')?> 
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                <?}?>
                <div class="col-md-12">
                    <h3>電子郵件 / 簡訊</h3>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="input-group">
                                    <span class="input-group-addon">電子郵件標題</span>
                                    <textarea class="form-control" rows="1" name="email_subject"><?=$lottery['email_subject']?></textarea>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="input-group">
                                    <span class="input-group-addon">電子郵件內容</span>
                                    <textarea class="form-control" rows="5" name="email_content"><?=$lottery['email_content']?></textarea>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="input-group">
                                    <span class="input-group-addon">簡訊標題</span>
                                    <textarea class="form-control" rows="1" name="sms_subject"><?=$lottery['sms_subject']?></textarea>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="input-group">
                                    <span class="input-group-addon">簡訊內容</span>
                                    <textarea class="form-control" rows="5" name="sms_content"><?=$lottery['sms_content']?></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php echo form_close() ?>
</div>
<div class="row">
    <div class="col-md-12" style="overflow-x: auto;">
        <table id="data-table" class="table table-bordered table-striped table-hover table-responsive">
            <thead>
                <tr class="info">
                    <th>序號</th>
                    <th>姓名</th>
                    <th>聯絡電話 / 手機</th>
                    <th>信箱</th>
                    <th>地址</th>
                    <th>正取 / 遞補 / 放棄</th>
                    <th>寄信狀態</th>
                    <th>付款方式 / 付款狀態</th>
                    <th>訂單編號</th>
                    <th>黑名單</th>
                    <th>預定中選</th>
                </tr>
            </thead>
            <tbody>
                <?if (!empty($lottery_pool)) {
                    $count = 0;
                    foreach ($lottery_pool as $lp_row) {
                        $count++;
                        $memid = $lp_row['id'];
                        $abstain = $lp_row['abstain']; //1遞補名額
                        $alternate = $lp_row['alternate']; //改為預定中選
                        $winner = $lp_row['winner']; //1為正取
                        $fill_up = $lp_row['fill_up']; //1為遞補
                        $blacklist = $lp_row['blacklist']; //1黑名單
                        $abandon = $lp_row['abandon']; //1棄權
                        $member_id = $lp_row['member_id'];
                        $send_mail = $lp_row['send_mail'];
                        $order_state = $lp_row['order_state'];
                        $this->db->select('*');
                        $this->db->where('id', $member_id);
                        $this->db->limit(1);
                        $u_row = $this->db->get('users')->result_array();
                        if (!empty($u_row)) {?>
                            <tr>
                                <td nowrap="nowrap"><?=$count?></td>
                                <td nowrap="nowrap"><?=$u_row['full_name']?></td>
                                <td nowrap="nowrap"><?=$u_row['phone']?></td>
                                <td nowrap="nowrap"><?=$u_row['email']?></td>
                                <td nowrap="nowrap"><?=$u_row['address']?></td>
                                <td nowrap="nowrap">
                                    <?if ($winner == '1' && $abandon == '0') {
                                        echo '正取';
                                    }if ($fill_up == '1' && $abandon == '0') {
                                        echo '遞補';
                                    }if ($winner == '0' && $fill_up == '0' && $abandon == '0') {
                                        echo '/';
                                    }if ($abandon == '1') {
                                        echo "放棄";
                                    }?>
                                </td>
                                <td nowrap="nowrap">
                                    <?if ($winner == '1' || $fill_up == '1') {
                                        if ($send_mail == 'OK') {
                                            echo '寄信完成';
                                        }
                                        else {
                                            echo '/';
                                        }
                                    }if ($winner != '1' && $fill_up != '1') {
                                            echo '/';
                                    }?>
                                </td>
                                <td nowrap="nowrap">
                                    <?if ($winner == '1' || $fill_up == '1') {
                                        if ($order_state == 'pay_ok') {
                                            echo '已收款';
                                        }
                                        if ($order_state == 'delay_pay') {
                                            echo '逾期付款';
                                        }
                                        if ($order_state == 'un_order' || $order_state=='') {
                                            echo '未下單';
                                        }
                                    }else{
                                        echo '/';
                                    }?>
                                </td>
                                <td>
                                    <?if($order_state == 'pay_ok') {
                                    $order_list = "select * from order_list where memid='$member_id'";
                                    $order_result = mysqli_query($dblink, $order_list);
                                    if (mysqli_num_rows($order_result) > 0):
                                        while ($order_row = mysqli_fetch_array($order_result)) {
                                            $odid = $order_row['odid'];
                                            if ($order_row['RtnCode'] == '1' || $order_row['pay_state'] == '2') {
                                                $order_dtl = "select * from order_dtl where odid='$odid' && prdid='$product_id'";
                                                $order_dtl_result = mysqli_query($dblink, $order_dtl);
                                                if (mysqli_num_rows($order_dtl_result) > 0):
                                                    while ($order_dtl_row = mysqli_fetch_array($order_dtl_result)) {
                                                        if ($order_row['state'] == 7) {?>
                                                            <span style="color: red;">
                                                            <?echo ' 商品退貨';
                                                        }
                                                        if ($order_row['state'] == 8) {?>
                                                            <span style="color: red;">
                                                            <?echo ' ※訂單取消';
                                                        }
                                                        if ($order_row['state'] == 9) {?>
                                                            <span style="color: red;">
                                                                <?echo ' ※訂單作廢';
                                                        }
                                                        if ($order_row['state'] == 10) {?>
                                                            <span style="color: red;">
                                                                <?echo ' ※後台退訂';
                                                        }
                                                        if ($order_row['state'] != 9 && $order_row['state'] != 8) {?>
                                                            <span>
                                                        <?}?>
                                                        <?=$order_row['odno'];?>
                                                        </span>
                                                    <?}
                                                    endif;
                                                }
                                            }
                                        endif;
                                    } else {
                                        echo "/";
                                    }?>
                                </td>
                                <td nowrap="nowrap">
                                    <?if ($blacklist != '1') {
                                        echo "/";
                                    }else{
                                        echo "Ｏ&emsp;";?>
                                    <a class="btn btn-primary" href="lottery_submit.php?act=unblock&id=<?=$id?>&member_id=<?=$member_id?>">解除</a>
                                    <?}?>
                                </td>
                                <td nowrap="nowrap">
                                    <?if ($winner == '0' && $abandon == '0' && $fill_up == '0' && $blacklist == '0' && $lottery_end == '0') {?>
                                    <a class="btn btn-primary" href="lottery_submit.php?act=reservation&id=<?=$id?>&memid=<?=$memid?>">預定中選</a>
                                    <?}else{
                                        echo "/";?>
                                    <?}?>
                                </td>
                            </tr>
                        <?}
                    }
                } else {?>
                    <tr>
                        <td colspan="15">
                            <center>對不起, 沒有資料 !</center>
                        </td>
                    </tr>
                <?}?>
            </tbody>
        </table>
    </div>
</div>
<script>
function copy_product_front_link() {
    var inputField = document.getElementById('product_front_link');
    inputField.select();
    document.execCommand("Copy");
    try {
        var success = document.execCommand('copy');
        if (success) {
            alert("已複製連結！");
        } else {
            alert('複製失敗！請重新複製。');
        }
    } catch (err) {
        console.error('資料錯誤：', err);
    }
}
$(document).ready(function() {
  $('#data-table').DataTable( {
    "order": [[ 0, "desc" ]],
    stateSave: true,
    "dom": '<"top"iflp<"clear">>rt<"bottom"iflp<"clear">>',
    "language": {
      "processing":   "處理中...",
      "loadingRecords": "載入中...",
      "lengthMenu":   "顯示 _MENU_ 項結果",
      "zeroRecords":  "沒有符合的結果",
      "emptyTable":   "沒有資料",
      "info":         "顯示第 _START_ 至 _END_ 項結果，共 _TOTAL_ 項",
      "infoEmpty":    "顯示第 0 至 0 項結果，共 0 項",
      "infoFiltered": "(從 _MAX_ 項結果中過濾)",
      "infoPostFix":  "",
      "search":       "搜尋:",
      "paginate": {
          "first":    "第一頁",
          "previous": "上一頁",
          "next":     "下一頁",
          "last":     "最後一頁"
      },
      "aria": {
          "sortAscending":  ": 升冪排列",
          "sortDescending": ": 降冪排列"
      }
    }
  });
});
</script>