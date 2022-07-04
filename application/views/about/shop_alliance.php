<style>
.form-horizontal .control-label{
    text-align: left;
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
input.zipcode{
  width:33%;
  display: none;
}
</style>
<div role="main" class="main pt-signinfo">
    <section>
        <div class="container">
            <?php include('left_menu.php'); ?>
            <div class="col-md-9 col-xs-12">
                <img src="/assets/uploads/<?php echo $about['about_image']; ?>" class="img-responsive">
                <div class="row mt-lg mb-xlg">

                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-md-12">
                                <?php echo $about['about_content']; ?>
                            </div>
                            <?php $attributes = array('class' => 'shop_alliance', 'id' => 'shop_alliance'); ?>
                            <?php echo form_open('home/shop_alliance' , $attributes); ?>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>店家名稱</label>
                                    <input type="text" class="form-control" name="shop_alliance_name" placeholder="輸入內容">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>城市</label>
                                    <div id="twzipcode"></div>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>店家地址</label>
                                    <input type="text" class="form-control" name="shop_alliance_address" placeholder="輸入內容">
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>聯絡人</label>
                                    <input type="text" class="form-control" name="shop_alliance_contact_name" placeholder="輸入內容">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>聯絡電話</label>
                                    <input type="text" class="form-control" name="shop_alliance_phone" placeholder="0900000000">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>電子信箱</label>
                                    <input type="text" class="form-control" name="shop_alliance_email" placeholder="輸入內容">
                                </div>
                            </div>
                            <div class="col-md-12 mt-lg">
                                <div class="form-group">
                                    <button type="submit" class="btn btn-round btn-info pull-right">送出</button>
                                </div>
                            </div>
                            <?php echo form_close() ?>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<div id="done-Modal" class="modal fade">
    <div class="modal-dialog modal-md">
        <!-- Modal content-->
        <div class="modal-content" style="background: #717171; color: white;">
            <div class="modal-body" style="padding: 15px;">
                <div class="row">
                    <div class="col-md-12" style="padding-top: 50px; padding-bottom: 50px;">
                        <img src="/assets/images/about/shop_alliance-alert.png" class="img-responsive">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="/node_modules/jquery-twzipcode/jquery.twzipcode.min.js"></script>

<script>
    <?php if($this->input->get('send')=='yes'){ ?>
        $('#done-Modal').modal('show');
    <?php } ?>
    $('#twzipcode').twzipcode({
        // 'detect': true, // 預設值為 false
        'css': ['form-control county', 'form-control district', 'form-control zipcode'],
    });
</script>