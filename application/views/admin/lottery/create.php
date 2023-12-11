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
    <?php echo form_open('admin/lottery/addLotteryEvent' , $attributes); ?>
    <div class="col-md-12">
        <div class="form-group">
            <a href="<?php echo base_url().'admin/'.$this->uri->segment(2) ?>" class="btn btn-info hidden-print">返回上一頁</a>
        </div>
        <div class="content-box-large">
            <button type="submit" class="btn btn-primary">建立</button>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <h3>基本資訊</h3>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="input-group">
                                    <span class="input-group-addon">抽選名稱</span>
                                    <input type="text" value="" class="form-control" name="name" placeholder="請輸抽選名稱" required>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="input-group">
                                    <span class="input-group-addon">抽選商品</span>
                                    <select class="chosen form-control" data-placeholder="請選擇抽選商品" style="width: 100%;" name="product" required>
                                        <option value=""></option>
                                        <?if (!empty($product)) {
                                            foreach ($product as $p_row) {?>
                                                <option value="<?=$p_row['product_id']?>"><?=$p_row['product_sku'] . " " . $p_row['product_name']?></option>
                                            <?}
                                        }?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="input-group">
                                    <span class="input-group-addon">正取名額</span>
                                    <input type="number" name="number_limit" min="1" value="1" class="form-control" required>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <h3>有效期限 ／ 開獎時間</h3>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="input-group">
                                    <span class="input-group-addon">開始日</span>
                                    <input type="text" name="star_time" value="" class="form-control datetimepicker" required>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="input-group">
                                    <span class="input-group-addon">結束日</span>
                                    <input type="text" name="end_time" value="" class="form-control datetimepicker" required>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="input-group">
                                    <span class="input-group-addon">開獎日</span>
                                    <input type="text" name="draw_date" value="" class="form-control datetimepicker" required>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <h3>電子郵件</h3>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="input-group">
                                    <span class="input-group-addon">電子郵件標題</span>
                                    <textarea class="form-control" rows="2" name="email_subject"></textarea>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="input-group">
                                    <span class="input-group-addon">電子郵件內容</span>
                                    <textarea class="form-control" rows="5" name="email_content"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <h3>簡訊</h3>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="input-group">
                                    <span class="input-group-addon">簡訊標題</span>
                                    <textarea class="form-control" rows="2" name="sms_subject"></textarea>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="input-group">
                                    <span class="input-group-addon">簡訊內容</span>
                                    <textarea class="form-control" rows="5" name="sms_content"></textarea>
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