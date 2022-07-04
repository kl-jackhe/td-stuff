<style>
[type="radio"]:checked+label:before,
[type="radio"]:not(:checked)+label:before {
    border-radius: 50px;
}

[type="radio"]:checked+label:after,
[type="radio"]:not(:checked)+label:after {
    background: orange;
}

.table>tbody>tr>td {
    vertical-align: middle;
}

td {
    border-top: none !important;
}

select.county {
    width: 48%;
    float: left;
}

select.district {
    width: 48%;
    float: left;
    margin-left: 4%;
}

input.zipcode {
    width: 33%;
    display: none;
}

@media (max-width: 480px) {

    #sub_menu a {
        width: 24%;
        padding: 6px;
    }

}
</style>
<div role="main" class="main pt-signinfo">
    <section>
        <div class="container">
            <div class="box">
                <div class="" id="sub_menu">
                    <h3 class="fs-18 color-595757">Hi
                        <?php echo $this->ion_auth->user()->row()->full_name ?>
                    </h3>
                    <a href="/auth/edit_user/<?php echo $this->ion_auth->user()->row()->id ?>" class="btn fs-13" style="border: 1px solid gray; color: gray; border-bottom: none;">個人資料</a>
                    <a href="/coupon" class="btn fs-13" style="border: 1px solid gray; color: gray; border-bottom: none;">優惠券管理</a>
                    <a href="/order" class="btn fs-13" style="border: 1px solid gray; color: gray; border-bottom: none;">訂單管理</a>
                    <a href="/my_address" class="btn fs-13" style="background: gray; color: white;">常用地址</a>
                </div>
                <div class="col-md-12">
                    <div class="row" id="my-address-table" style="border: 2px solid gray;">
                        <div class="col-md-6 col-md-offset-3">
                            <h3>常用地址</h3>
                            <table class="table">
                                <?php if(!empty($my_address)) { foreach($my_address as $data) { ?>
                                <tr>
                                    <td>
                                        <div class="form-check" onclick="set_default('<?php echo $data['id'] ?>')" style="border: 1px solid #ddd; padding: 15px; margin-bottom: 10px; border-radius: 10px;">
                                            <input type="radio" class="form-check-input" name="address" id="address_<?php echo $data['id'] ?>" value="<?php echo $data['county'].$data['district'].$data['address'] ?>" <?php echo ($data['used']?'checked':'') ?>>
                                            <label for="address_<?php echo $data['id'] ?>" class="form-check-label fs-13 color-59757 font-normal">
                                                <?php echo $data['county'].$data['district'].$data['address'] ?>
                                            </label>
                                        </div>
                                    </td>
                                    <td>
                                        <a href="/my_address/delete/<?php echo $data['id'] ?>" onClick="return confirm('您確定要刪除嗎?')">
                                            <i class="fa fa-trash-o align-middle" style="font-size: 24px; color: black;"></i>
                                        </a>
                                    </td>
                                </tr>
                                <?php }} ?>
                            </table>
                            <div class="row">
                                <div class="col-md-6 col-md-offset-3">
                                    <div class="form-group">
                                        <button class="btn btn-warning btn-block" style="background: #FFB718; border-color: #FFB718; border-radius: 10px;" onclick="add_address()">添加地址</button>
                                    </div>
                                </div>
                            </div>
                            <form action="/my_address/insert" method="post" id="address_form" style="display: none;">
                                <div class="form-group">
                                    <div class="form-group">
                                        <label class="col-sm-3 control-label">地址</label>
                                        <div class="col-md-9">
                                            <div id="twzipcode"></div>
                                        </div>
                                    </div>
                                    <label class="col-sm-3 control-label"></label>
                                    <div class="col-md-9">
                                        <div class="form-group">
                                            <input type="text" class="form-control" name="address" id="address" value="">
                                        </div>
                                        <button type="submit" class="btn btn-primary" style="background: #FFB718; border-color: #FFB718; border-radius: 10px;">添加</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
<script src="/node_modules/jquery-twzipcode/jquery.twzipcode.min.js"></script>
<script>
function add_address() {
    $('#address_form').show();
}

function set_default(id) {
    $.ajax({
        url: "<?php echo base_url(); ?>my_address/set_default",
        method: "POST",
        data: { id: id },
        success: function(data) {
            // if(data=='1'){
            //     alert('更新預設常用地址成功');
            // } else {
            //     alert('更新預設常用地址失敗');
            // }
        }
    });
}
$('#twzipcode').twzipcode({
    // 'detect': true, // 預設值為 false
    'css': ['form-control county', 'form-control district', 'form-control zipcode'],
    'countySel': '',
    'districtSel': ''
});
</script>