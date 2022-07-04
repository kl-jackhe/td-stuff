<div role="main" class="main pt-signinfo">
    <section>
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12" style="padding: 0px;">
                    <?php if(!empty($banner['page_banner'])){ ?>
                        <img src="/assets/uploads/<?php echo $banner['page_banner'] ?>" class="img-fluid">
                    <?php } ?>
                    <!-- <img src="/assets/uploads/home/banner.png" class="img-fluid" alt=""> -->
                </div>
            </div>
            <div class="row" style="padding-top: 30px; padding-bottom: 20px; background: #F2F2F2;">
                <div class="col-md-12 text-center">
                    <h4>最新消息 | News</h4>
                    <h4><i class="fa fa-angle-down"></i></h4>
                </div>
            </div>
        </div>

        <div class="container" style="padding-top: 25px; padding-bottom: 25px;">
            <?php require('ajax-data.php') ?>
        </div>
    </section>
</div>