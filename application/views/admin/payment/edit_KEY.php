<div class="row">
    <div class="col-md-12">
        <a href="<?php echo base_url() . 'admin/' . $this->uri->segment(2) ?>" class="btn btn-info hidden-print">返回上一頁</a>
        <hr>
    </div>
    <div class="col-md-6">
        <div class="content-box-large">
            <?php $attributes = array('class' => 'key', 'id' => 'key'); ?>
            <?php echo form_open('admin/payment/update_KEY/' . $features_pay['pay_id'], $attributes); ?>
            <div class="form-group">
                <label for="pay_name">支付名稱</label>
                <input type="text" class="form-control" name="pay_name" value="<?php echo $features_pay['pay_name']; ?>" readonly>
            </div>
            <div class="form-group">
                <label for="MerchantID">MerchantID</label>
                <input type="text" class="form-control" name="MerchantID" value="<?php echo $features_pay['MerchantID']; ?>">
            </div>
            <div class="form-group">
                <label for="HashKey">HashKey</label>
                <input type="text" class="form-control" name="HashKey" value="<?php echo $features_pay['HashKey']; ?>">
            </div>
            <div class="form-group">
                <label for="HashIV">HashIV</label>
                <input type="text" class="form-control" name="HashIV" value="<?php echo $features_pay['HashIV']; ?>">
            </div>
            <div class="form-group">
                <label for="payment_status">狀態</label>
                <select class="form-control" name="payment_status" id="payment_status">
                    <? if ($features_pay['payment_status'] == 1) { ?>
                        <option value="1" selected>啟用</option>
                        <option value="0">停用</option>
                    <? } else { ?>
                        <option value="0" selected>停用</option>
                        <option value="1">啟用</option>
                    <? } ?>
                </select>
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-primary">修改</button>
            </div>
            <?php echo form_close(); ?>
        </div>
    </div>
</div>