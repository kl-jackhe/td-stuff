<link rel="stylesheet" href="/node_modules/bootstrap-timepicker/css/bootstrap-timepicker.min.css">
<!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-timepicker/0.5.2/css/bootstrap-timepicker.min.css"> -->
<div class="row">
  <div class="col-md-4">
    <?php $attributes = array('class' => 'form', 'id' => 'search-form', 'method' => 'get'); ?>
    <?php echo form_open('report/search' , $attributes); ?>
      <div class="form-group">
        <label>報表類型</label>
        <select name="type" id="type" class="form-control chosen" data-rule-required="true" onchange="check_select(this)">
          <?php if($authority['pos'] && $access['pos']==1){ ?>
          <option value="pos">POS收入</option>
          <?php } ?>
          <?php if($authority['purchase_sales'] && $access['purchase_sales']==1){ ?>
          <option value="sales">銷售收入</option>
          <?php } ?>
          <?php if($authority['purchase_sales'] && $access['purchase_sales']==1){ ?>
          <option value="purchase">進貨費用</option>
          <?php } ?>
          <?php if($authority['produce'] && $access['produce']==1){ ?>
          <option value="produce">生產費用</option>
          <?php } ?>
        </select>
      </div>
      <div class="form-group" id="sel_customer" style="display: none;">
        <?php if(!empty($sales_manufacturer)): ?>
        <label>客戶</label> <small style="color: red;">不選擇則查詢全部</small>
        <?php $att = 'id="customer" class="form-control chosen" data-rule-required="true"';
        $data = array('選擇客戶');
        foreach ($sales_manufacturer as $u)
        {
          $data[$u['manufacturer_id']] = get_manufacturer_name($u['manufacturer_id']);
        }
        echo form_dropdown('sales_manufacturer', $data, '0', $att);
        else: echo '<label>沒有客戶</label><input type="text" class="form-control" id="sales_manufacturer" name="sales_manufacturer" value="0" readonly>';
            endif; ?>
      </div>
      <div class="form-group" id="sel_manufacturer" style="display: none;">
        <?php if(!empty($purchase_manufacturer)): ?>
        <label>廠商</label> <small style="color: red;">不選擇則查詢全部</small>
        <?php $att = 'id="manufacturer" class="form-control chosen" data-rule-required="true"';
        $data = array('選擇廠商');
        foreach ($purchase_manufacturer as $u)
        {
          $data[$u['manufacturer_id']] = get_manufacturer_name($u['manufacturer_id']);
        }
        echo form_dropdown('purchase_manufacturer', $data, '0', $att);
        else: echo '<label>沒有廠商</label><input type="text" class="form-control" id="purchase_manufacturer" name="purchase_manufacturer" value="0" readonly>';
        endif; ?>
      </div>
      <div class="form-group">
        <label>使用者</label> <small style="color: red;">不選擇則查詢全部</small>
        <?php $att = 'id="user" class="form-control chosen" data-rule-required="true"';
        $data = array('選擇使用者');
        foreach ($user as $u)
        {
          $data[$u['id']] = $u['username'];
        }
        echo form_dropdown('user', $data, '0', $att); ?>
      </div>
      <label>選擇日期</label> <small style="color: red;">不輸入則查詢全部</small>
      <div class="form-group form-inline">
        <input type="text" class="form-control text-center datepicker" name="start_date" id="start_date" placeholder="起始日期" size="9" autocomplete="off">
        <input type="text" class="form-control text-center datepicker" name="end_date" id="end_date" placeholder="終止日期" size="9" autocomplete="off">
      </div>
      <div class="form-group form-inline" style="margin-top: 5px;">
        <span class="btn btn-info" onclick="set_today()">今天</span>
        <span class="btn btn-info" onclick="set_this_month()">今月</span>
        <span class="btn btn-info" onclick="set_this_year()">今年</span>
      </div>
      <label>選擇時間</label> <small style="color: red;">不輸入則查詢全部</small>
      <div class="form-group form-inline">
        <input type="text" class="form-control text-center timepicker" name="start_time" id="start_time" placeholder="起始時間" size="9" autocomplete="off">
        <input type="text" class="form-control text-center timepicker" name="end_time" id="end_time" placeholder="終止時間" size="9" autocomplete="off">
      </div>
      <div class="form-group">
        <button type="submit" class="btn btn-primary btn-block">搜尋</button>
      </div>
    <?php echo form_close() ?>
  </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-timepicker/0.5.2/js/bootstrap-timepicker.min.js"></script>
<script>
  function set_today()
  {
    // var d = new Date();
    // var month = d.getMonth()+1;
    // var day = d.getDate();
    // var output = d.getFullYear() + '-' + ((''+month).length<2 ? '0' : '') + month + '-' + ((''+day).length<2 ? '0' : '') + day;
    // $('#start_date').attr('value', output);
    // $('#end_date').attr('value', output);

    var today = moment().format('YYYY-MM-DD');
    $('#start_date').attr('value', today);
    $('#end_date').attr('value', today);
  }
  function set_this_month()
  {
    var date = new Date(), y = date.getFullYear(), m = date.getMonth();
    var firstDay = new Date(y, m, 1);
    var lastDay = new Date(y, m + 1, 0);

    firstDay = moment(firstDay).format('YYYY-MM-DD');
    lastDay = moment(lastDay).format('YYYY-MM-DD');

    $('#start_date').attr('value', firstDay);
    $('#end_date').attr('value', lastDay);
  }
  function set_this_year()
  {
    var date = new Date();
    var nowYear = date.getFullYear();
    firstDay = nowYear+'-01-'+'01';
    lastDay = nowYear+'-12-'+'31';

    $('#start_date').attr('value', firstDay);
    $('#end_date').attr('value', lastDay);
  }
  function check_select(select)
  {
    //alert(select.value);
    $('#sel_customer').hide();
    $('#sel_manufacturer').hide();
    if (select.value=='sales') {
      $('#sel_customer').show();
    } else if(select.value=='purchase') {
      $('#sel_manufacturer').show();
    }
  }
  $(document).ready(function() {
    $('.timepicker').timepicker({
      //showSeconds: true,
      showMeridian: false,
      defaultTime: false
    });
  });
</script>