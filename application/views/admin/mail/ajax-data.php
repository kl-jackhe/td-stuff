<?php echo $this->ajax_pagination_admin->create_links(); ?>
<?php $attributes = array('class' => 'mails', 'id' => 'mails'); ?>
<?php echo form_open('admin/mail/multiple_action', $attributes); ?>
<table class="table table-striped table-bordered table-hover">
  <thead>
    <tr class="info">
      <!-- <th></th> -->
      <th>公司名稱</th>
      <th>客戶名稱</th>
      <th>聯絡電話</th>
      <th>電子郵件</th>
      <th>方便聯絡時間</th>
      <th>狀態</th>
      <th>發布日期</th>
      <th>回覆日期</th>
      <th>操作</th>
    </tr>
  </thead>
  <?php if (!empty($mails)) : ?>
    <?php foreach ($mails as $data) : ?>
      <tr <?php echo ($data['state'] == 0) ? 'style="color: red;"' : '' ?>>
        <td><?php echo $data['cpname'] ?></td>
        <td><?php echo $data['custname'] ?></td>
        <td><?php echo $data['tel'] ?></td>
        <td><?php echo $data['email'] ?></td>
        <td><?php echo ($data['gtime'] == 1) ? '上午' : (($data['gtime'] == 2) ? '中午' : (($data['gtime'] == 3) ? '下午' : (($data['gtime'] == 4) ? '晚上' : '皆可'))); ?></td>
        <td><?php echo ($data['state'] == 1) ? '已回覆' : '未回覆' ?></td>
        <td><?php echo $data['datetime'] ?></td>
        <td><?php echo $data['datetime2'] ?></td>
        <td>
          <a href="/admin/mail/edit/<?php echo $data['contid'] ?>" class="btn btn-info btn-sm"><i class="fa fa-edit"></i></a>
          <a href="/admin/mail/delete/<?php echo $data['contid'] ?>" class="btn btn-danger btn-sm" onClick="return confirm('您確定要刪除嗎?')"><i class="fa fa-trash" aria-hidden="true"></i></a>
        </td>
      </tr>
    <?php endforeach ?>
  <?php else : ?>
    <tr>
      <td colspan="15">
        <center>對不起, 沒有資料 !</center>
      </td>
    </tr>
  <?php endif; ?>
</table>
<?php echo form_close() ?>

<script>
  $(document).ready(function() {
    $("#checkAll").click(function() {
      $('#data-table input:checkbox').not(this).prop('checked', this.checked);
    });
  });
</script>