$(document).ready(function() {
  $(document).on('click', '.remove_item', function() {
    $('#loading').show();
    var rowid = $(this).attr("rowid");
    //if (confirm("Are you sure you want to remove this?")) {
      $.ajax({
        url: "/cart/remove",
        method: "POST",
        data: { rowid: rowid },
        success: function(data) {
          //$('#cart_details').html(data);
          $('#cart_details').load("/cart/view_cart");
          $('#loading').fadeOut("fast");
        }
      });
    // } else {
    //     return false;
    // }
  });
  $(document).on('click', '.remove_item_cost', function() {
    $('#loading').show();
    var rowid = $(this).attr("rowid");
    //if (confirm("Are you sure you want to remove this?")) {
      $.ajax({
        url: "/cart/remove",
        method: "POST",
        data: { rowid: rowid },
        success: function(data) {
          //$('#cart_details').html(data);
          $('#cart_details_of_cost').load("/cart/view_cart_cost");
          $('#loading').fadeOut("fast");
        }
      });
    // } else {
    //     return false;
    // }
  });
  $(document).on('change', '.update_price', function() {
    $('#loading').show();
    var id = $(this).attr("id");
    var rowid = $(this).attr("rowid");
    var price = $(this).val();
    $.ajax({
      url: "/cart/update_price",
      method: "POST",
      data: { id: id, rowid: rowid, price: price },
      success: function(data) {
        //$('#cart_details').html(data);
        $('#cart_details').load("/cart/view_cart");
        $('#loading').fadeOut("fast");
      }
    });
  });
  $(document).on('change', '.update_cost', function() {
    $('#loading').show();
    var id = $(this).attr("id");
    var rowid = $(this).attr("rowid");
    var cost = $(this).val();
    $.ajax({
      url: "/cart/update_cost",
      method: "POST",
      data: { id: id, rowid: rowid, cost: cost },
      success: function(data) {
        //$('#cart_details').html(data);
        $('#cart_details_of_cost').load("/cart/view_cart_cost");
        $('#loading').fadeOut("fast");
      }
    });
  });
  $(document).on('change', '.update_qty', function() {
    $('#loading').show();
    var rowid = $(this).attr("rowid");
    var qty = $(this).val();
    $.ajax({
        url: "/cart/update_qty",
        method: "POST",
        data: { rowid: rowid, qty: qty },
        success: function(data) {
            //$('#cart_details').html(data);
            $('#cart_details').load("/cart/view_cart");
            $('#loading').fadeOut("fast");
        }
    });
  });
  $(document).on('change', '.update_qty_cost', function() {
    $('#loading').show();
    var rowid = $(this).attr("rowid");
    var qty = $(this).val();
    $.ajax({
        url: "/cart/update_qty",
        method: "POST",
        data: { rowid: rowid, qty: qty },
        success: function(data) {
            //$('#cart_details').html(data);
            $('#cart_details_of_cost').load("/cart/view_cart_cost");
            $('#loading').fadeOut("fast");
        }
    });
  });
  $(document).on('change', '.update_remark', function() {
    $('#loading').show();
    var rowid = $(this).attr("rowid");
    var remark = $(this).val();
    $.ajax({
        url: "/cart/update_remark",
        method: "POST",
        data: { rowid: rowid, remark: remark },
        success: function(data) {
            //$('#cart_details').html(data);
            $('#cart_details').load("/cart/view_cart");
            $('#loading').fadeOut("fast");
        }
    });
  });
  $(document).on('change', '.update_remark_cost', function() {
    $('#loading').show();
    var rowid = $(this).attr("rowid");
    var remark = $(this).val();
    $.ajax({
        url: "/cart/update_remark",
        method: "POST",
        data: { rowid: rowid, remark: remark },
        success: function(data) {
            //$('#cart_details').html(data);
            $('#cart_details').load("/cart/view_cart_cost");
            $('#loading').fadeOut("fast");
        }
    });
  });
  $(document).on('change', '.update_warehouse_cost', function() {
    $('#loading').show();
    var id = $(this).attr("id");
    var rowid = $(this).attr("rowid");
    var warehouse = $(this).val();
    $.ajax({
      url: "/cart/update_warehouse",
      method: "POST",
      data: { id: id, rowid: rowid, warehouse: warehouse },
      success: function(data) {
        //$('#cart_details').html(data);
        $('#cart_details').load("/cart/view_cart_cost");
        $('#loading').fadeOut("fast");
      }
    });
  });

});

function clear_cart() {
  if (confirm("確定要清空購物車嗎?")) {
    $.ajax({
      url: "/cart/remove_all",
      success: function(data) {
        //alert("Your cart has been clear...");
        $('#cart_details').html(data);
      }
    });
  } else {
    return false;
  }
}