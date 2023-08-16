<div class="row">
    <?if (!empty($SingleSalesDetail)) {?>
    <div class="col-md-2">
        <div class="input-group">
            <span class="input-group-addon">ID</span>
            <input type="text" class="form-control" id="sales_id" value="<?=$SingleSalesDetail['id']?>" readonly>
        </div>
    </div>
    <div class="col-md-4">
        <div class="input-group">
            <span class="input-group-addon">商品名稱</span>
            <input type="text" class="form-control" id="product_id" value="<?=get_product_name($SingleSalesDetail['product_id'])?>" readonly>
            <a href="/admin/product/edit/<?php echo $SingleSalesDetail['product_id'] ?>" target="_blank" class="input-group-addon">
                <i class="fa-solid fa-up-right-from-square"></i>
            </a>
        </div>
    </div>
    <div class="col-md-4">
        <div class="input-group">
            <span class="input-group-addon">預設代言人利潤百分比</span>
            <input type="number" max="100" min="0" id="default_profit_percentage" value="<?=format_number($SingleSalesDetail['default_profit_percentage'])?>" class="form-control">
            <span class="input-group-addon">%</span>
        </div>
    </div>
    <div class="col-md-2">
        <div class="input-group">
            <span class="input-group-addon">狀態</span>
            <input type="text" class="form-control" id="status" value="<?=$this->lang->line($SingleSalesDetail['status'])?>" readonly>
        </div>
    </div>
    <div class="col-md-12">
        <hr>
    </div>
    <div class="col-md-4">
        <div class="input-group">
            <span class="input-group-addon">展示日期</span>
            <input type="text" class="form-control datetimepicker" id="pre_date" value="<?=($SingleSalesDetail['pre_date'] != '0000-00-00 00:00:00' ? substr($SingleSalesDetail['pre_date'], 0, 10) : '')?>">
        </div>
    </div>
    <div class="col-md-4">
        <div class="input-group">
            <span class="input-group-addon">開始日期</span>
            <input type="text" class="form-control datetimepicker" id="start_date" value="<?=($SingleSalesDetail['start_date'] != '0000-00-00 00:00:00' ? substr($SingleSalesDetail['start_date'], 0, 10) : '')?>">
        </div>
    </div>
    <div class="col-md-4">
        <div class="input-group">
            <span class="input-group-addon">結束日期</span>
            <input type="text" class="form-control datetimepicker" id="end_date" value="<?=($SingleSalesDetail['end_date'] != '0000-00-00 00:00:00' ? substr($SingleSalesDetail['end_date'], 0, 10) : '')?>">
        </div>
    </div>
    <div class="col-md-12">
        <hr>
    </div>
    <?}?>
</div>