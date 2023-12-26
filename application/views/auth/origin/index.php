<div class="row">
  	<div class="col-md-6">
    	<!-- <a href="/admin/auth/create_user" class="btn btn-primary">建立新帳號</a> -->
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
	      	<select id="category" class="form-control" onchange="searchFilter()">
	      		<option value="0">請選擇月份</option>
		        <option value="01">一月</option>
	        	<option value="02">二月</option>
	        	<option value="03">三月</option>
	        	<option value="04">四月</option>
	        	<option value="05">五月</option>
	        	<option value="06">六月</option>
	        	<option value="07">七月</option>
	        	<option value="08">八月</option>
	        	<option value="09">九月</option>
	        	<option value="10">十月</option>
	        	<option value="11">十一月</option>
	        	<option value="12">十二月</option>
	      	</select>
	      	<select id="status" class="form-control" onchange="searchFilter()">
		        <option value="1">已認證</option>
	        	<option value="2">未認證</option>
	      	</select>
    	</div>
  	</div>
</div>
<div class="table-responsive" id="datatable">
  <?php require('ajax-data.php'); ?>
</div>



<!-- <div class="row">
	<div class="col-md-12">
		<a href="/auth/create_user" class="btn btn-primary">建立新帳號</a>
		<a href="/auth/create_group" class="btn btn-primary">建立新群組</a>
		<table class="table table-bordered" style="margin-top: 5px;">
			<tr>
				<th>帳號</th>
				<th><?php echo lang('index_email_th');?></th>
				<th><?php echo lang('index_groups_th');?></th>
				<th><?php echo lang('index_status_th');?></th>
				<th><?php echo lang('index_action_th');?></th>
			</tr>
			<?php foreach ($users as $user):?>
			<tr>
				<td><?php echo htmlspecialchars($user->username,ENT_QUOTES,'UTF-8');?></td>
				<td><?php echo htmlspecialchars($user->email,ENT_QUOTES,'UTF-8');?></td>
				<td>
					<?php foreach ($user->groups as $group):?>
					<?php echo anchor("/auth/edit_group/".$group->id, htmlspecialchars($group->name,ENT_QUOTES,'UTF-8')) ;?><br />
					<?php endforeach?>
				</td>
				<td><?php echo ($user->active) ? anchor("/auth/deactivate/".$user->id, lang('index_active_link')) : anchor("/auth/activate/". $user->id, lang('index_inactive_link'));?></td>
				<td>
					<a href="/auth/edit_user/<?php echo $user->id ?>" class="btn btn-info btn-sm"><i class="fa fa-edit"></i> 編輯</a>
					<a href="/access/single/<?php echo $user->id ?>" class="btn btn-warning btn-sm"><i class="fa fa-lock"></i> 權限</a>
				</td>
			</tr>
			<?php endforeach ?>
		</table>
	</div>
</div> -->