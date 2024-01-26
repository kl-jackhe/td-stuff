<style>
  label.required::before {
    content: '*';
    color: red;
    margin-right: 5px;
  }
</style>
<div class="row">
  <?php $attributes = array('class' => 'coupon', 'id' => 'coupon'); ?>
  <?php echo form_open('admin/coupon/insert', $attributes); ?>
  <div class="col-md-12">
    <div class="form-group">
      <button type="submit" class="btn btn-primary">建立</button>
      <button type="button" onClick="returnTo()" class="btn btn-info hidden-print">返回上一頁</button>
    </div>
    <div class="content-box-large">

      <div class="row">
        <div class="col-md-12">
          <div class="form-horizontal">
            <div class="form-group">
              <label for="name" class="col-md-2 control-label required">優惠券名稱：</label>
              <div class="col-md-4">
                <input type="text" class="form-control" name="name" id="name" required>
              </div>
            </div>
            <div class="form-group">
              <label for="type" class="col-md-2 control-label required">優惠券類型：</label>
              <div class="col-md-4">
                <select class="form-control" id="type" name="type">
                  <option value="cash">現金折扣</option>
                  <option value="percent">百分比折扣</option>
                  <option value="free_shipping">免運費</option>
                </select>
              </div>
            </div>
            <div class="form-group">
              <label for="discount_amount" class="col-md-2 control-label required">優惠券折扣：</label>
              <div class="col-md-4">
                <input type="number" class="form-control" id="discount_amount" name="discount_amount" value="0" required>
                <p>備注：現金折扣直接輸入數字, 例如: 折扣11元則輸入「11」, 百分比折扣則輸入小數點, 例如: 打85折則輸入「0.85」</p>
              </div>
            </div>
            <div class="form-group">
              <label for="use_limit_enable" class="col-md-2 control-label">次數限定：</label>
              <div class="col-md-9">
                <div class="form-inline">
                  <select class="form-control" id="use_limit_enable" name="use_limit_enable" onchange="toggleInputReadOnly()">
                    <option value="0">停用</option>
                    <option value="1">啟用</option>
                  </select>
                  <div style="display: inline-block;">
                    <input type="number" class="form-control" id="use_limit_number" name="use_limit_number" placeholder="請輸入限制之使用次數" readonly>
                  </div>
                </div>
              </div>
            </div>
            <div class="form-group">
              <label for="use_type_enable" class="col-md-2 control-label">限定類型：</label>
              <div class="col-md-9">
                <div class="form-inline">
                  <select name="use_type_enable" id="use_type_enable" class="form-control" onchange="toggleTypeReadOnly()">
                    <option value="0">停用</option>
                    <option value="1">啟用</option>
                  </select>
                  <select name="use_type_name" id="use_type_name" class="form-control" readonly>
                    <option value="">類型</option>
                    <option value="qty">數量</option>
                    <option value="price">價格</option>
                  </select>
                  <input type="number" class="form-control" name="use_type_number" id="use_type_number" placeholder="請輸入指定數量或價格" readonly>
                </div>
                <p>備注：限制一定要達到某個價格或某個數量才可以使用</p>
              </div>
            </div>
            <div class="form-group">
              <label class="col-md-2 control-label required">上架日期：</label>
              <div class="col-md-2">
                <input type="text" class="form-control datetimepicker" name="distribute_at" id="distribute_at" required>
              </div>
            </div>
            <div class="form-group">
              <label class="col-md-2 control-label required">下架日期：</label>
              <div class="col-md-2">
                <input type="text" class="form-control datetimepicker" name="discontinued_at" id="discontinued_at" required>
              </div>
            </div>
          </div>
        </div>
      </div>

    </div>
  </div>
  <?php echo form_close() ?>
</div>

<script src="/node_modules/jquery-validation/dist/jquery.validate.min.js"></script>
<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.17.0/jquery.validate.min.js"></script> -->
<script src="/node_modules/jquery-validation/dist/localization/messages_zh_TW.js"></script>
<script>
  function toggleInputReadOnly() {
    var selectElement = document.getElementById("use_limit_enable");
    var inputElement = document.getElementById("use_limit_number");

    // 如果選擇了"specific"，取消readonly
    if (selectElement.value == "1") {
      inputElement.removeAttribute("readonly");
    } else {
      // 否則，加上readonly
      inputElement.setAttribute("readonly", "readonly");
    }
  }

  function toggleTypeReadOnly() {
    var selectElement = document.getElementById("use_type_enable");
    var selectTypeElement = document.getElementById("use_type_name");
    var inputNumberElement = document.getElementById("use_type_number");

    // 如果選擇了"specific"，取消readonly
    if (selectElement.value == "1") {
      selectTypeElement.removeAttribute("readonly");
      inputNumberElement.removeAttribute("readonly");
    } else {
      // 否則，加上readonly
      selectTypeElement.setAttribute("readonly", "readonly");
      inputNumberElement.setAttribute("readonly", "readonly");
    }
  }

  function returnTo() {
    window.history.back();
  }

  $.validator.setDefaults({
    submitHandler: function() {
      document.getElementById("coupon").submit();
      //alert("submitted!");
    }
  });
  $(document).ready(function() {
    $("#coupon").validate({});
  });
</script>