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
                            <?php $attributes = array('class' => 'cross_industry_alliance', 'id' => 'cross_industry_alliance'); ?>
                            <?php echo form_open('home/cross_industry_alliance' , $attributes); ?>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>公司名稱</label>
                                    <input type="text" class="form-control" name="cross_industry_alliance_name" placeholder="輸入內容">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>統一編號</label>
                                    <input type="text" class="form-control" name="cross_industry_alliance_number" placeholder="如需開立發票請輸入">
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>服務需求</label>
                                    <textarea name="cross_industry_alliance_content" cols="30" rows="5" class="form-control" placeholder="輸入內容"></textarea>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>聯絡人</label>
                                    <input type="text" class="form-control" name="cross_industry_alliance_contact_name" placeholder="輸入內容">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>聯絡電話</label>
                                    <input type="text" class="form-control" name="cross_industry_alliance_phone" placeholder="0900000000">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>電子信箱</label>
                                    <input type="text" class="form-control" name="cross_industry_alliance_email" placeholder="輸入內容">
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
                        <img src="/assets/images/about/cross_industry_alliance-alert.png" class="img-responsive">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    <?php if($this->input->get('send')=='yes'){ ?>
        $('#done-Modal').modal('show');
    <?php } ?>
</script>
<!-- <script src="/node_modules/jquery-twzipcode/jquery.twzipcode.min.js"></script>

<script>
    $('#twzipcode').twzipcode({
        // 'detect': true, // 預設值為 false
        'css': ['form-control county', 'form-control district', 'form-control zipcode'],
    });
</script> -->