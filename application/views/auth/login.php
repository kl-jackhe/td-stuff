<div role="main" class="main pt-xlg-main">
    <section>
        <div class="container">
            <div class="box mt-md">
                <div class="row">
                    <div class="col-md-6 col-md-offset-3" style="box-shadow: 6px 6px 20px grey; padding: 30px 60px; margin-bottom: 60px;">
                        <?php $attributes = array('id' => 'login'); ?>
                        <?php echo form_open('login' , $attributes); ?>
                            <?php if ($this->session->flashdata('message')) { ?>
                                <div class="alert alert-info">
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                    <?php echo $this->session->flashdata('message'); ?>
                                </div>
                            <?php } ?>
                            <div class="form-group">
                                <h4>行動電話</h4>
                                <input type="number" class="form-control" id="identity" name="identity" placeholder="請輸入行動電話..." required>
                            </div>
                            <div class="form-group">
                                <h4>密碼</h4>
                                <input type="password" class="form-control" id="password" name="password" placeholder="6-15個字元" required>
                            </div>
                            <div class="form-group">
                                <a href="/forgot_password" class="pull-right">忘記手機號碼或密碼?</a>
                            </div>
                            <div class="form-group">
                                <input type="submit" value="登入" class="btn btn-info btn-lg btn-block mt-xl mr-lg">
                            </div>
                            <div class="form-group">
                                <a href="/register" class="btn btn-info btn-lg btn-block mt-xl mr-lg">免費註冊</a>
                            </div>
                        <?php echo form_close(); ?>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<script>
    $(document).ready(function() {
        document.getElementById('identity').focus();
    });
</script>