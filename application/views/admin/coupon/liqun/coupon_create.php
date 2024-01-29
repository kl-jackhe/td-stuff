<style>
  label.required::before {
    content: '*';
    color: red;
    margin-right: 5px;
  }

  .previewTag {
    width: 24.5%;
    max-height: 480px;
    /* Adjust the maximum height as needed */
    overflow-y: auto;
    /* Enables vertical scrollbar when content overflows */
  }

  .selectedCheckboxTitle {
    height: 40px;
    line-height: 40px;
    border-bottom: 2px solid #ddd;
    padding: 0;
    margin: 0 0 20px 0;
    background-color: #f0f0f0;
  }

  .selectedCheckboxTitle span {
    font-size: 22px;
  }

  .checkedTagMemberName {
    display: inline-block;
    max-width: 100%;
    margin-bottom: 10px;
  }

  span.checkedTagMemberName {
    margin-left: 5px;
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
        <div class="col-md-6">
          <div class="form-horizontal">
            <div class="form-group">
              <label for="name" class="col-md-3 control-label required">優惠券名稱：</label>
              <div class="col-md-9">
                <input type="text" class="form-control" name="name" id="name" required>
              </div>
            </div>
            <div class="form-group">
              <label for="type" class="col-md-3 control-label required">優惠券類型：</label>
              <div class="col-md-9">
                <select class="form-control" id="type" name="type">
                  <option value="cash">現金折扣</option>
                  <option value="percent">百分比折扣</option>
                  <option value="free_shipping">免運費</option>
                </select>
              </div>
            </div>
            <div class="form-group">
              <label for="discount_amount" class="col-md-3 control-label required">優惠券折扣：</label>
              <div class="col-md-9">
                <input type="number" class="form-control" id="discount_amount" name="discount_amount" value="0" required>
                <p>備注：現金折扣直接輸入數字, 例如: 折扣11元則輸入「11」, 百分比折扣則輸入小數點, 例如: 打85折則輸入「0.85」</p>
              </div>
            </div>
            <div class="form-group">
              <label for="use_limit_enable" class="col-md-3 control-label">次數限定：</label>
              <div class="col-md-9">
                <div class="form-inline">
                  <select class="form-control" id="use_limit_enable" name="use_limit_enable" onchange="toggleLimitReadOnly()">
                    <option value="0">無限</option>
                    <option value="1">僅限</option>
                  </select>
                  <div style="display: inline-block;">
                    <input type="number" class="form-control" id="use_limit_number" name="use_limit_number" placeholder="請輸入限制之使用次數">
                  </div>
                </div>
              </div>
            </div>
            <div class="form-group">
              <label for="use_type_enable" class="col-md-3 control-label">限定類型：</label>
              <div class="col-md-9">
                <div class="form-inline">
                  <select name="use_type_enable" id="use_type_enable" class="form-control" onchange="toggleTypeReadOnly()">
                    <option value="0">停用</option>
                    <option value="1">啟用</option>
                  </select>
                  <select name="use_type_name" id="use_type_name" class="form-control">
                    <option value="qty">數量</option>
                    <option value="price">價格</option>
                  </select>
                  <input type="number" class="form-control" name="use_type_number" id="use_type_number" placeholder="請輸入指定數量或價格">
                </div>
                <p>備注：限制一定要達到某個價格或某個數量才可以使用</p>
              </div>
            </div>
            <div class="form-group">
              <label for="use_member_enable" class="col-md-3 control-label">自動發送：</label>
              <div class="col-md-9">
                <div class="form-inline">
                  <select class="form-control" id="use_member_enable" name="use_member_enable" onchange="toggleMemberReadOnly()">
                    <option value="0">停用</option>
                    <option value="1">啟用</option>
                  </select>
                  <select class="form-control" id="use_member_type" name="use_member_type">
                    <option value="old_member">目前有註冊的會員</option>
                    <option value="new_member">未來新註冊的會員</option>
                    <option value="all_member">目前有註冊的會員&未來新註冊的會員</option>
                  </select>
                </div>
              </div>
            </div>
            <div class="form-group">
              <label for="use_product_enable" class="col-md-3 control-label">商品限定：</label>
              <div class="col-md-9">
                <div class="form-inline">
                  <select name="use_product_enable" id="use_product_enable" class="form-control" onchange="toggleProductReadOnly()">
                    <option value="0">全體</option>
                    <option value="1">部分</option>
                  </select>
                  <div class="use_product_enable_button" style="display: inline-block;">
                    <input type="button" class="btn btn-primary" id="use_product_enable_button_view" value="顯示清單">
                    <input type="button" class="btn btn-primary" id="use_product_enable_button_hide" value="關閉清單">
                  </div>
                </div>
              </div>
            </div>
            <div class="form-group">
              <label class="col-md-3 control-label required">上架日期：</label>
              <div class="col-md-9">
                <input type="text" class="form-control datetimepicker" name="distribute_at" id="distribute_at" required>
              </div>
            </div>
            <div class="form-group">
              <label class="col-md-3 control-label required">下架日期：</label>
              <div class="col-md-9">
                <input type="text" class="form-control datetimepicker" name="discontinued_at" id="discontinued_at" required>
              </div>
            </div>
          </div>
        </div>
        <?php if (!empty($products)) : ?>
          <div class="col-md-3 previewTag">
            <p class="selectedCheckboxTitle text-center">
              <span>限定商品成員</span>
            </p>
            <label class="checkedTagMemberName">
              <input type="checkbox" id="selectAllCheckbox"> 全選
            </label>
            <hr>
            <?php foreach ($products as $self) : ?>
              <label class="checkedTagMemberName">
                <input type="checkbox" class="productCheckbox" name="checkboxList[]" value="<?= $self['product_id'] ?>">
                <?= $self['product_name'] ?>
              </label><br>
            <?php endforeach; ?>
          </div>
          <div class="col-md-3 previewTag">
            <p class="selectedCheckboxTitle text-center">
              <span>已選限定商品</span>
            </p>
            <div class="form-group" id="selectedCheckboxContainer">
              <!-- 已選列表 -->
            </div>
          </div>
        <?php endif; ?>
      </div>
    </div>
  </div>
  <?php echo form_close() ?>
</div>

<script src="/node_modules/jquery-validation/dist/jquery.validate.min.js"></script>
<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.17.0/jquery.validate.min.js"></script> -->
<script src="/node_modules/jquery-validation/dist/localization/messages_zh_TW.js"></script>
<script>
  window.onload = function() {
    toggleLimitReadOnly();
    toggleTypeReadOnly();
    toggleMemberReadOnly();
    toggleProductReadOnly();
  };

  // 選擇之商品checkbox
  $(document).ready(function() {
    // 監聽 use_product_enable_btn
    $('#use_product_enable_button_hide').click(function() {
      toggleProductCheckboxVisibility(0);
    });
    $('#use_product_enable_button_view').click(function() {
      toggleProductCheckboxVisibility(1);
    });

    // 監聽全選 checkbox 的變化
    $('#selectAllCheckbox').change(function() {
      // 設定所有子 checkbox 的選中狀態與全選 checkbox 一致
      $('.productCheckbox').prop('checked', $(this).prop('checked'));
      rearrangeCheckboxes();
    });

    // 監聽子 checkbox 的變化
    $('.productCheckbox').change(function() {
      // 如果有任何一個子 checkbox 未被選中，取消全選 checkbox 的選中狀態
      if (!$(this).prop('checked')) {
        $('#selectAllCheckbox').prop('checked', false);
        rearrangeCheckboxes();
      }
    });

    // 當 checkbox 狀態改變時，重新排序
    $('.productCheckbox').change(function() {
      rearrangeCheckboxes();
    });

    // Trigger change event for pre-selected checkboxes
    $('.productCheckbox:checked').each(function() {
      rearrangeCheckboxes();
    });
  });

  function rearrangeCheckboxes() {
    var selectedContainer = $('#selectedCheckboxContainer');

    // Remove any existing content in the selected container
    selectedContainer.empty();

    // Loop through all checkboxes to find selected ones
    $('.productCheckbox:checked').each(function() {
      var labelText = $(this).closest('label').text().trim();
      var productId = $(this).val();

      // Create a span element with a class for styling
      var spanElement = $('<span class="checkedTagMemberName">').text(labelText);

      // Create a link (X) element for unchecking the checkbox
      var uncheckLink = $('<a href="#" class="removeTag" data-product-id="' + productId + '"><i class="fa fa-times" aria-hidden="true"></i></a>').click(function() {
        // Retrieve the product ID from the data attribute
        var productIdToRemove = $(this).data('product-id');

        // Uncheck the corresponding checkbox
        $('.productCheckbox[value="' + productIdToRemove + '"]').prop('checked', false);

        rearrangeCheckboxes(); // Update the displayed checkboxes
      });

      // Append the X link before the span
      selectedContainer.append(uncheckLink).append(spanElement).append('<br>');
    });
  }

  function toggleLimitReadOnly() {
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

  function toggleMemberReadOnly() {
    var selectElement = document.getElementById("use_member_enable");
    var selectTypeElement = document.getElementById("use_member_type");

    if (selectElement.value == '1') {
      selectTypeElement.removeAttribute("readonly");
    } else {
      selectTypeElement.setAttribute("readonly", "readonly");
    }
  }

  function toggleProductReadOnly() {
    var selectElement = $("#use_product_enable").val();

    if (selectElement == '0') {
      $('.use_product_enable_button').hide();
      $('.previewTag').hide();
    } else {
      $('.use_product_enable_button').show();
    }
  }

  // 切換 checkbox 的可見性
  function toggleProductCheckboxVisibility(bol) {
    if (bol == 0) {
      // 隱藏 checkbox
      $('.previewTag').hide();
    } else {
      // 顯示 checkbox
      $('.previewTag').show();
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