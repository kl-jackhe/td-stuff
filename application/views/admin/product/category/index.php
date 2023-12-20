<div class="row">
  <div class="col-md-4">
    <div class="content-box-large">
    <?php $attributes = array('class' => 'product_category', 'id' => 'product_category');?>
    <?php echo form_open('admin/product/insert_category', $attributes); ?>
      <div class="form-group">
        <label for="product_category_name">分類名稱</label>
        <input type="text" class="form-control" name="product_category_name">
      </div>
      <div class="form-group">
        <label>上層分類</label>
        <select name="product_category_parent" class="form-control">
          <option value="0">選擇分類</option>
          <?php echo get_product_category_option() ?>
        </select>
      </div>
      <div class="form-group">
        <label for="product_category_sort">分類排序</label>
        <input type="text" class="form-control" name="product_category_sort" value="50">
      </div>
      <div class="form-group">
        <button type="submit" class="btn btn-primary">新增分類</button>
      </div>
    <?php echo form_close(); ?>
    </div>
  </div>
  <div class="col-md-8">
  	<div class="content-box-large">
  	  <table class="table">
        <thead>
          <tr>
            <th>分類名稱</th>
            <th>排序</th>
            <th>配送方式</th>
            <th>操作</th>
          </tr>
        </thead>
        <tbody>
          <?php get_product_category_td() ?>
        </tbody>
      </table>
  	</div>
  </div>
</div>