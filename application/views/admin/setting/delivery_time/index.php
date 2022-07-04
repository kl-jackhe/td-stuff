<div class="row">
  <div class="col-md-4">
    <div class="content-box-large">
    <?php $attributes = array('class' => 'delivery_time', 'id' => 'delivery_time'); ?>
    <?php echo form_open('admin/setting/insert_delivery_time' , $attributes); ?>
      <div class="form-group">
        <label for="delivery_time_name">名稱</label>
        <input type="text" class="form-control" name="delivery_time_name">
      </div>
      <div class="form-group">
        <button type="submit" id="save-btn" class="btn btn-primary"><i class="fa fa-edit"></i> 儲存 (F2)</button>
      </div>
    <?php echo form_close() ?>
    </div>
  </div>
  <div class="col-md-8">
  	<div class="content-box-large">
  	  <table class="table table-bordered">
        <thead>
          <tr class="info">
            <th>名稱</th>
            <th>操作</th>
          </tr>
        </thead>
        <?php if(!empty($delivery_time)): foreach ($delivery_time as $data): ?>
          <tr>
            <td><?php echo $data['delivery_time_name'] ?></td>
            <td>
              <a href="/admin/setting/edit_delivery_time/<?php echo $data['delivery_time_id'] ?>" class="btn btn-info btn-sm" target="_blank"><i class="fa fa-edit"></i></a>
              <a href="/admin/setting/delete_delivery_time/<?php echo $data['delivery_time_id'] ?>" class="btn btn-danger btn-sm" onClick="return confirm('確定要刪除嗎?')"><i class="fa fa-trash-o"></i></a>
            </td>
          </tr>
         <?php endforeach ?>
         <?php else: ?>
            <tr>
              <td colspan="4"><center>對不起, 沒有資料 !</center></td>
            </tr>
          <?php endif; ?>
      </table>
  	</div>
  </div>
</div>