<div class="row">
  	<div class="col-md-6">
    	<a href="/admin/auth/create_user" class="btn btn-primary">新增管理員</a>
    	<!-- <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exportModal">匯出資料</button> -->
  	</div>
  	<div class="col-md-6">
    	<div class="form-inline text-right">
	      	<input type="text" id="keywords" class="form-control" placeholder="搜尋..." onkeyup="searchFilter()"/>
	      	<!-- <select id="sortBy" class="form-control" onchange="searchFilter()">
		        <option value="0">排序</option>
	        	<option value="asc">升冪</option>
	        	<option value="desc">降冪</option>
	      	</select> -->
    	</div>
  	</div>
</div>
<div class="table-responsive" id="datatable">
  <?php require('ajax-data.php'); ?>
</div>