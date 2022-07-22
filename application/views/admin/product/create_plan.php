<div class="row">
    <?php $attributes = array('class' => 'plan_insert_submit_form', 'id' => 'plan_insert_submit_form');?>
    <?php echo form_open('admin/product/insert_plan', $attributes); ?>
    <div class="col-md-12">
        <div class="form-group">
            <span id="quick-save-btn" class="btn btn-primary">建立</span>
        </div>
    </div>
    <div class="col-md-12">
        <div class="content-box-large">
            <div class="tabbable">
                <!-- Nav tabs -->
                <ul class="nav nav-tabs" role="tablist">
                    <li role="presentation" class="active">
                        <a href="#general" aria-controls="general" role="tab" data-toggle="tab">基本資料</a>
                    </li>
                    <!-- <li role="presentation">
                        <a href="#plan" aria-controls="plan" role="tab" data-toggle="tab">方案</a>
                    </li> -->
                </ul>

                <!-- Tab panes -->
                <div class="tab-content">
                    <div role="tabpanel" class="tab-pane active" id="general">
                        <div class="row">
                            <div class="col-md-5">
                                <div class="form-group">
                                    <label for="product_combine_name">方案名稱</label>
                                    <input type="text" class="form-control" id="product_combine_name" name="product_combine_name" required>
                                    <input type="hidden" name="product_id" value="<?php echo $product['product_id'] ?>">
                                </div>
                            </div>
                            <div class="col-md-5">
                                <div class="form-group">
                                    <label for="product_combine_price">方案售價</label>
                                    <input type="text" class="form-control" id="product_combine_price" name="product_combine_price" required>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="product_combine_image" class="control-label">封面圖片</label>
                                    <div class="form-group">
                                        <a href="/assets/admin/filemanager/dialog.php?type=1&field_id=add_product_combine_image&relative_url=1" class="btn btn-primary fancybox" type="button" style="margin-top: 5px;">選擇圖片</a>
                                    </div>
                                    <img src="" id="add_product_combine_image_preview" class="img-responsive" style="display: none;">
                                    <input type="hidden" id="add_product_combine_image" name="product_combine_image" />
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="product_combine_description">方案描述</label>
                                    <textarea class="form-control" id="product_combine_description" name="product_combine_description" cols="30" rows="10"></textarea>
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

<script>
$('.fancybox').fancybox({
    'width': 1920,
    'height': 1080,
    'type': 'iframe',
    'autoScale': false
});
$('#quick-save-btn').click(function(e){
    e.preventDefault();
    var form = $('#plan_insert_submit_form');
    var url = form.attr('action');
    // console.log( $('#submit_form').serialize() );
    $.ajax({
        type: "POST",
        url: url,
        data: form.serialize(),
        // contentType: false,
        // cache: false,
        // processData: false,
        success : function(data)
        {
          // $('#use-Modal').modal('hide');
          location.reload(true);
          // console.log(data);
        },
        error: function(data)
        {
          console.log('無法送出');
        }
    })
});
</script>