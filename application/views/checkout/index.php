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
    <section class="form-section">
        <div class="container-fluid" style="padding-bottom: 30px;padding-top: 30px;">
            <div class="row">
                <div class="col-md-12 text-center">
                    <h1>產品描述</h1>
                </div>
                <div class="col-md-12 text-center">
                    <img class="img-fluid">
                </div>
                <div class="col-md-12 text-center">
                    <h1>商品選購</h1>
                </div>
                <div class="col-md-12 text-center">
                    <div class="col-md-4">
                        <img class="img-fluid">
                        <div class="text-right">
                            <span style="border: 1px solid red;background-color: red;border-radius: 15px;padding: 5px 10px 5px 10px;"><i class="fa-solid fa-cart-shopping"></i> 選購</span>
                        </div>
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
        'countySel'   : '<?php if (!empty($users_address)) {echo $users_address['county'];} else {echo $this->input->get('county');}?>',
        'districtSel' : '<?php if (!empty($users_address)) {echo $users_address['district'];} else {echo $this->input->get('district');}?>',
        'hideCounty' : [<?php if (!empty($hide_county)) {foreach ($hide_county as $hc) {echo '"' . $hc . '",';}}?>],
        'hideDistrict': [<?php if (!empty($hide_district)) {foreach ($hide_district as $hd) {echo '"' . $hd . '",';}}?>]
    });
</script>

