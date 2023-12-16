<div class="row">
	<div class="col-md-12" style="margin-bottom: 15px;">
		<span class="btn btn-primary">儲存</span>
	</div>
	<div class="col-md-12" style="margin-bottom: 15px;">
		<h4>標題</h4>
		<input type="text" class="form-control" value="<?=(!empty($pageData) ? $pageData['page_title'] : '')?>">
    </div>
    <div class="col-md-12">
    	<h4>內容</h4>
        <textarea class="form-control"><?=(!empty($pageData) ? $pageData['page_info'] : '')?></textarea>
    </div>
</div>