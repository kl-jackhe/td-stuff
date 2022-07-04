<script src="https://www.stream-lab.net/public/SDK/utility/streamLiff.js"></script>
<script src="https://intra.sstrm.net/public/SDK/tracking/StreamInitLiffWithGtm.2.0.min.js"></script>

<div role="main" class="main pt-xlg-main">
    <section>
        <div class="container">
            <div class="box mt-md">
                <div class="row">
                    <div class="col-md-6 col-md-offset-3" style="box-shadow: 6px 6px 20px grey; padding: 30px 60px;">
                        <?php $attributes = array('id' => 'binding'); ?>
                        <?php echo form_open('login/binding_line' , $attributes); ?>
                        <div class="form-content">
                            <div class="form-group">
                                <a href="/login">←返回登入</a>
                            </div>
                            <div class="form-group">
                                <h4>行動電話</h4>
                                <input type="number" class="form-control" id="identity" name="identity" placeholder="請輸入行動電話..." required>
                            </div>
                            <div class="form-group">
                                <h4>密碼</h4>
                                <input type="password" class="form-control" id="password" name="password" placeholder="6-15個字元" required>
                            </div>
                            <div class="form-group">
                                <h4>LINE ID</h4>
                                <input type="text" class="form-control" id="line_id" name="line_id" placeholder="讀取中..." required readonly>
                            </div>
                            <div class="form-group">
                                <input type="submit" value="綁定" class="btn btn-info btn-lg btn-block mt-xl mr-lg">
                            </div>
                        </div>
                        <?php echo form_close() ?>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<script>
$(document).ready(function() {
    if (LIFF_userID != "") {
        setTimeout("get_register_line_id()", 300);
    } else {
        setTimeout("get_register_line_id()", 300);
    }
});

function get_register_line_id() {
    if (LIFF_userID != "") {
        // alert(LIFF_userID);
        $('#line_id').val(LIFF_userID);
    } else {
        LIFF_init();
        console.log("等候LIFF加載...");
        if($('#line_id').val()==''){
          setTimeout("get_register_line_id()", 300);
        }
    }
};
</script>