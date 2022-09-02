<div class="row">
  <div class="col-md-12">
    <a href="<?php echo base_url() . 'admin/' . $this->uri->segment(2) ?>" class="btn btn-info hidden-print">返回上一頁</a>
    <hr>
  </div>
  <div class="col-md-4">
    <div class="content-box-large">
    <?php $attributes = array('class' => 'product_add_on_group', 'id' => 'product_add_on_group');?>
    <?php echo form_open('admin/product/insert_add_on_group', $attributes); ?>
      <div class="form-group">
        <label for="product_group_name">項目名稱</label>
        <input type="text" class="form-control" name="product_group_name" required>
      </div>
      <!-- <input type="hidden" name="product_group_id" value="A"> -->
      <div class="form-group">
        <button type="submit" class="btn btn-primary">新增項目</button>
      </div>
    <?php echo form_close(); ?>
    </div>
  </div>
  <div class="col-md-8">
  	<div class="content-box-large">
  	  <table class="table">
        <thead>
          <tr>
            <th>加購項目</th>
            <th>選用商品</th>
            <th>操作</th>
          </tr>
        </thead>
        <?php if (!empty($add_on_group)) {
          foreach ($add_on_group as $data){ ?>
	        <tr>
	          <td><?php echo $data['product_group_name'] ?></td>
            <td></td>
	          <td>
	            <a href="/admin/product/edit_add_on_group/<?php echo $data['id'] ?>" class="btn btn-info btn-sm"><i class="fa fa-edit"></i></a>
	            <a href="/admin/product/delete_add_on_group/<?php echo $data['id'] ?>" class="btn btn-danger btn-sm" onClick="return confirm('確定要刪除嗎?')"><i class="fa fa-trash-o"></i></a>
	          </td>
	        </tr>
	        <?php }} else {?>
          <tr>
            <td colspan="4"><center>對不起, 沒有資料 !</center></td>
          </tr>
        <?}?>
      </table>
  	</div>
  </div>
</div>