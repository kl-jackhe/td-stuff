<style>
    select.county {
        width: 48%!important;
        float: left;
    }
    select.district {
        width: 48%!important;
        float: left;
        margin-left: 4%;
    }
    input.zipcode{
        width:33%;
        display: none;
    }
    .owl-theme .owl-nav [class*='owl-']:hover {
        background: transparent;
    }
    .owl-prev {
        color: #DCDEDD!important;
    }
    .owl-prev:hover {
        color: #585755!important;
    }
    .owl-prev:focus {
        border: none!important;
        outline: none!important;
    }
    .owl-next {
        color: #DCDEDD!important;
    }
    .owl-next:hover {
        color: #585755!important;
    }
    .owl-next:focus {
        border: none!important;
        outline: none!important;
    }
    .owl-dots{
        /*left: 50%!important;*/
        /*margin-left: -35px;*/
        width: 100%;
    }
</style>
<div role="main" class="main">
	<section class="page-header no-padding sm-slide-fix" style="padding-left: 4%; padding-right: 4%;">
        <div class="row">
            <div class="col-md-12 owl-carousel owl-theme item-slide" data-plugin-options='{"items":1, "loop": true, "nav":true, "dots":true,"autoplay": true,"autoplayTimeout": 6000}'>
                <?php if (!empty($banner)) {foreach ($banner as $data) {?>
                    <a href="<?php echo $data['banner_link'] ?>" target="<?php echo ($data['banner_link'] == '#') ? ('_self') : ('_new') ?>" class="banner slidebanner">
                        <img src="/assets/uploads/<?php echo $data['banner_image'] ?>">
                    </a>
                <?php }}?>
            </div>
        </div>
    </section>
    <section class="form-section">
        <div class="container">

            <div class="row" id="home_main_area">
                <div class="searchbox collapse in " id="essearch">
                    <?php $attributes = array('class' => 'store_form', 'id' => 'store_form', 'method' => 'get');?>
                    <?php echo form_open('store#main_area', $attributes); ?>
                    <div class="row">
                        <div class="col-md-4 border-box">
                            <div class="row">
                                <div class="col-md-12">
                                    <h4 class="fs-13 color-595757">送達地點</h4>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div id="twzipcode" class="form-group"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 border-box">
                            <div class="row">
                                <div class="col-md-12">
                                    <h4 class="fs-13 color-595757">您的所在地</h4>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-control-custom dropdown-toggle">
                                                <input type="text" id="address" name="address" class="form-control" placeholder="請輸入地址" value="<?php if (!empty($users_address)) {echo $users_address['address'];} else {echo $this->input->get('address');}?>" required>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="middle text-center">
                                <label for=""></label>
                                <button class="btn btn-info" style="padding:6px 20px;">搜尋</button>
                            </div>
                        </div>
                        <hr class="xs-visible">
                    </div>
                    <?php echo form_close() ?>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12 visible-md visible-lg" style="margin-top: 100px; margin-bottom: 70px;">
                    <img src="/assets/images/home/home_1.png" class="img-responsive">
                </div>
                <div class="col-md-12 visible-xs visible-sm">
                    <!-- <div class="row">
                        <div class="col-xs-5 col-xs-offset-1 text-right" style="align-items: center; display: flex; min-height: 150px;">
                            <img src="/assets/images/home/home_1_1.png" class="img-responsive">
                        </div>
                        <div class="col-xs-5 text-left" style="align-items: center; display: flex; min-height: 150px;">
                            <img src="/assets/images/home/home_1_2.png" class="img-responsive">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-5 col-xs-offset-1 text-right" style="align-items: center; display: flex; min-height: 150px;">
                            <img src="/assets/images/home/home_1_4.png" class="img-responsive">
                        </div>
                        <div class="col-xs-5 text-left" style="align-items: center; display: flex; min-height: 150px;">
                            <img src="/assets/images/home/home_1_3.png" class="img-responsive">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-5 col-xs-offset-1 text-right" style="align-items: center; display: flex; min-height: 150px;">
                            <img src="/assets/images/home/home_1_5.png" class="img-responsive">
                        </div>
                        <div class="col-xs-5 text-left" style="align-items: center; display: flex; min-height: 150px;">
                            <img src="/assets/images/home/home_1_6.png" class="img-responsive">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-6 col-xs-offset-1 text-right" style="align-items: center; display: flex; min-height: 150px;">
                            <img src="/assets/images/home/home_1_8.png" class="img-responsive">
                        </div>
                        <div class="col-xs-5 text-left" style="align-items: center;display: flex;min-height: 150px;margin-top: 50px;margin-left: -30px;">
                            <img src="/assets/images/home/home_1_7.png" class="img-responsive">
                        </div>
                    </div> -->
                    <div class="row">
                        <div class="col-xs-10 col-xs-offset-1 col-sm-10 col-sm-offset-1" style="padding-top: 20px; padding-bottom: 20px;">
                            <img src="/assets/images/home/step1.png" class="img-responsive">
                        </div>
                        <div class="col-xs-10 col-xs-offset-1 col-sm-10 col-sm-offset-1" style="padding-top: 20px; padding-bottom: 20px;">
                            <img src="/assets/images/home/step2.png" class="img-responsive">
                        </div>
                        <div class="col-xs-10 col-xs-offset-1 col-sm-10 col-sm-offset-1" style="padding-top: 20px; padding-bottom: 20px;">
                            <img src="/assets/images/home/step3.png" class="img-responsive">
                        </div>
                        <div class="col-xs-10 col-xs-offset-1 col-sm-10 col-sm-offset-1">
                            <img src="/assets/images/home/step4.png" class="img-responsive">
                        </div>
                    </div>
                </div>
                <div class="col-md-10 col-md-offset-1 visible-md visible-lg" style="background: #E9ECF3; margin-top: 30px; padding-top: 30px;">
                    <div class="row">
                        <div class="col-md-6 col-md-offset-3 text-center" style="margin-bottom: 30px;">
                            <h1 class="fs-24 color-595757 sm-margin bold">給公司、企業的客製化服務</h1>
                            <h3 class="fs-16 color-595757 sm-margin">年會、慶生會、各種PARTY</h3>
                            <h3 class="fs-16 color-595757 sm-margin">都有專業客服為您提供訂購餐點服務</h3>
                            <div class="row">
                                <div class="col-md-8 col-md-offset-2">
                                    <a href="/about/cross_industry_alliance">
                                        <img src="/assets/images/home/home_server_btn.png" class="img-responsive">
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <img src="/assets/images/home/bubble.png" class="img-responsive hidden-sm hidden-xs">
                        </div>
                    </div>
                </div>

                <div class="col-xs-10 col-xs-offset-1 visible-xs visible-sm" style="background: #E9ECF3; margin-top: 30px; padding-top: 30px; padding-bottom: 30px;">
                    <div class="row">
                        <div class="col-xs-12 text-center">
                            <h1 class="fs-24 color-595757 sm-margin bold">給公司、企業的客製化服務</h1>
                            <h3 class="fs-16 color-595757 sm-margin">年會、慶生會、各種PARTY</h3>
                            <h3 class="fs-16 color-595757 sm-margin">都有專業客服為您提供訂購餐點服務</h3>
                            <div class="row">
                                <div class="col-xs-12">
                                    <a href="/about/cross_industry_alliance">
                                        <img src="/assets/images/home/home_server_btn.png" class="img-responsive">
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-10 col-md-offset-1 visible-md visible-lg">
                    <img src="/assets/images/home/home_2.png" class="img-responsive" style="padding-top: 30px; padding-bottom: 30px;">
                </div>
            </div>

        </div>
    </section>
</div>

<script src="/node_modules/jquery-twzipcode/jquery.twzipcode.min.js"></script>
<script>
    // $(document).ready(function() {
    //     if (LIFF_userID != "") {
    //         setTimeout("store_form_submit()", 50);
    //     } else {
    //         setTimeout("store_form_submit()", 50);
    //     }
    // });

    // function store_form_submit(){
    //     if (LIFF_userID != "") {
    //         $('#store_form').submit();
    //     } else {
    //         // alert('xxx');
    //         store_form_submit();
    //     }
    // }

    // $('#store_form').submit();

    function getLiffUserID() {
        if (LIFF_userID != "") {
            alert(LIFF_userID);
        } else {
            console.log("等候LIFF加載...");
            setTimeout("getLiffUserID()", 300);
        }
    };

    $('#twzipcode').twzipcode({
        // 'detect': true, // 預設值為 false
        'css': ['form-control county', 'form-control district', 'form-control zipcode'],
        'countySel'   : '<?php if (!empty($users_address)) {echo $users_address['county'];} else {echo $this->input->get('county');}?>',
        'districtSel' : '<?php if (!empty($users_address)) {echo $users_address['district'];} else {echo $this->input->get('district');}?>',
        'hideCounty' : [<?php if (!empty($hide_county)) {foreach ($hide_county as $hc) {echo '"' . $hc . '",';}}?>],
        'hideDistrict': [<?php if (!empty($hide_district)) {foreach ($hide_district as $hd) {echo '"' . $hd . '",';}}?>]
    });
</script>

