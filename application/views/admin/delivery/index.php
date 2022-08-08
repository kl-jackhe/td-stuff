<div class="row">
  <!-- <div class="col-md-12">
    <a href="<?php echo base_url() . 'admin/' . $this->uri->segment(2) ?>" class="btn btn-info hidden-print">返回上一頁</a>
    <hr>
  </div> -->
  <div class="col-md-4">
    <div class="content-box-large">
    <?php $attributes = array('class' => 'delivery', 'id' => 'delivery');?>
    <?php echo form_open('admin/delivery/insert_delivery', $attributes); ?>
      <div class="form-group">
        <label for="delivery_name">配送名稱</label>
        <input type="text" class="form-control" name="delivery_name">
      </div>
      <div class="form-group">
        <button type="submit" class="btn btn-primary">新增配送方式</button>
      </div>
    <?php echo form_close(); ?>
    </div>
  </div>
  <div class="col-md-8">
  	<div class="content-box-large">
  	  <table class="table">
        <thead>
          <tr>
            <th>配送名稱</th>
            <th>操作</th>
          </tr>
        </thead>
        <?if (!empty($delivery)): foreach ($delivery as $data): ?>
	        <tr>
	          <td><?php echo $data['delivery_name'] ?></td>
	          <td>
	            <a href="/admin/delivery/edit_delivery/<?php echo $data['id'] ?>" class="btn btn-info btn-sm"><i class="fa fa-edit"></i></a>
	            <a href="/admin/delivery/delete_delivery/<?php echo $data['id'] ?>" class="btn btn-danger btn-sm" onClick="return confirm('確定要刪除嗎?')"><i class="fa fa-trash-o"></i></a>
	          </td>
	        </tr>
	        <?endforeach?>
        <?php else: ?>
          <tr>
            <td colspan="4"><center>對不起, 沒有資料 !</center></td>
          </tr>
        <?php endif;?>
      </table>
  	</div>
  </div>
</div>