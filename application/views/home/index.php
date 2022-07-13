<style>
select.county {
    width: 48% !important;
    float: left;
}

select.district {
    width: 48% !important;
    float: left;
    margin-left: 4%;
}

input.zipcode {
    width: 33%;
    display: none;
}

.owl-theme .owl-nav [class*='owl-']:hover {
    background: transparent;
}

.owl-prev {
    color: #DCDEDD !important;
}

.owl-prev:hover {
    color: #585755 !important;
}

.owl-prev:focus {
    border: none !important;
    outline: none !important;
}

.owl-next {
    color: #DCDEDD !important;
}

.owl-next:hover {
    color: #585755 !important;
}

.owl-next:focus {
    border: none !important;
    outline: none !important;
}

.owl-dots {
    /*left: 50%!important;*/
    /*margin-left: -35px;*/
    width: 100%;
}
</style>
<div role="main" class="main">
    <section class="page-header no-padding sm-slide-fix" style="padding-left: 30px;padding-right: 30px;">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12 owl-carousel owl-theme item-slide" data-plugin-options='{"items":1, "loop": true, "nav":true, "dots":true,"autoplay": true,"autoplayTimeout": 6000}'>
                    <?php if (!empty($banner)) {foreach ($banner as $data) {?>
                    <a href="<?php echo $data['banner_link'] ?>" target="<?php echo ($data['banner_link'] == '#') ? ('_self') : ('_new') ?>" class="banner slidebanner">
                        <img class="img-fluid" style="width: 100%;" src="/assets/uploads/<?php echo $data['banner_image'] ?>">
                    </a>
                    <?php }}?>
                </div>
            </div>
        </div>
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12 text-center py-5">
                    <h1>熱銷商品</h1>
                </div>
                <div class="col-md-12 text-center">
                    <div class="row">
                        <?
                        if (!empty($products)) {
                            foreach ($products as $product){
                        ?>
                        <div class="col-md-4">
                            <a href="/product/view/<?=$product['product_id']?>">
                                <img style="border-radius: 15px;" class="img-fluid" src="/assets/uploads/<?=$product['product_image'];?>">
                                <p>
                                    <?=$product['product_name'];?>
                                </p>
                                <p>$
                                    <?=$product['product_price'];?>
                                </p>
                            </a>
                        </div>
                        <?}
                    }?>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
<!-- <script src="/node_modules/jquery-twzipcode/jquery.twzipcode.min.js"></script> -->
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
    'countySel': '<?php if (!empty($users_address)) {echo $users_address['
    county '];} else {echo $this->input->get('
    county ');}?>',
    'districtSel': '<?php if (!empty($users_address)) {echo $users_address['
    district '];} else {echo $this->input->get('
    district ');}?>',
    'hideCounty': [<?php if (!empty($hide_county)) {foreach ($hide_county as $hc) {echo '"' . $hc . '",';}}?>],
    'hideDistrict': [<?php if (!empty($hide_district)) {foreach ($hide_district as $hd) {echo '"' . $hd . '",';}}?>]
});
</script>