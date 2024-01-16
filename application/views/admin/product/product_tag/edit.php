<div class="row">
	<div class="col-md-12">
		<a onClick="goBack()" class="btn btn-info hidden-print">返回上一頁</a>
		<hr>
	</div>
	<div class="col-md-6">
		<div class="content-box-large">
			<?php $attributes = array('class' => 'product_tag', 'id' => 'product_tag'); ?>
			<?php echo form_open('admin/product/update_tag/' . $product_tag['id'], $attributes); ?>
			<div class="form-group">
				<label for="product_tag_name">標籤名稱</label>
				<input type="text" class="form-control" id="product_tag_name" name="product_tag_name" value="<?php echo $product_tag['name']; ?>">
			</div>
			<!-- <div class="form-group">
				<label for="product_tag_code">標籤內碼</label>
				<input type="text" class="form-control" id="product_tag_code" name="product_tag_code" value="<?php echo $product_tag['code']; ?>" readonly>
			</div> -->
			<div class="form-group">
				<label for="product_tag">標籤成員</label>
				<select class="form-control chosen" id="product_tag[]" name="product_tag[]" multiple>
					<? foreach ($products as $self) { ?>
						<option value="<?= $self['product_id'] ?>" <?= (!empty($selected_products) && in_array($self['product_id'], $selected_products) ? 'selected' : '') ?>><?= $self['product_name'] ?></option>
					<? } ?>
				</select>
			</div>
			<div class="form-group">
				<label for="product_tag">標籤狀態</label>
				<select class="form-control" id="product_tag_status" name="product_tag_status">
					<option value="1" <?= ($product_tag['status'] == '1') ? 'selected' : ''; ?>>✔️開啟</option>
					<option value="0" <?= ($product_tag['status'] == '0') ? 'selected' : ''; ?>>❌關閉</option>
				</select>
			</div>
			<div class="form-group">
				<label for="product_tag_sort">標籤排序</label>
				<input type="number" class="form-control" id="product_tag_sort" name="product_tag_sort" value="<?php echo $product_tag['sort']; ?>">
			</div>
			<div class="form-group">
				<button type="button" class="btn btn-primary" onClick="form_check()">修改</button>
			</div>
			<?php echo form_close(); ?>
		</div>
	</div>
</div>

<script>
	function form_check() {
		var product_tag_name = $('#product_tag_name').val();
		var product_tag_sort = $('#product_tag_sort').val();
		<?php if (!empty($total_product_tag)) : ?> <?php foreach ($total_product_tag as $self) : ?>
				var name = <?= json_encode($self['name']) ?>;
				var sort = <?= json_encode($self['sort']) ?>;
				if (product_tag_name == <?= json_encode($product_tag['name']) ?> || parseInt(product_tag_sort) == parseInt(<?= json_encode((int)$product_tag['sort']) ?>)) {
					if (product_tag_name == <?= json_encode($product_tag['name']) ?> && parseInt(product_tag_sort) == parseInt(<?= json_encode((int)$product_tag['sort']) ?>)) {} else {
						if (product_tag_name == name && parseInt(product_tag_sort) == parseInt(<?= json_encode((int)$product_tag['sort']) ?>)) {
							alert('該項目已存在');
							return;
						}
						if (parseInt(product_tag_sort) == parseInt(sort) && product_tag_name == <?= json_encode($product_tag['name']) ?>) {
							alert('該排序已存在');
							return;
						}
					}
				} else {
					if (product_tag_name == name) {
						alert('該項目已存在');
						return;
					}
					if (parseInt(product_tag_sort) == parseInt(sort)) {
						alert('該排序已存在');
						return;
					}
				}
			<?php endforeach; ?> <?php endif; ?> document.getElementById("product_tag").submit();
	}

	function goBack() {
		window.history.back();
	}
</script>