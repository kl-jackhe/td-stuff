<?php
$count = 0;
foreach ($this->cart->contents() as $items) {
	$count++;
}?>
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
    p {
        margin: 0px;
    }
    .fixed-bottom {
        display: none;
    }
    .wizard > .content {
        overflow-y: auto;
    }
    .wizard > .actions {
        text-align: center;
    }
    .wizard > .content > .body {
        width: 100%;
        height: 100%;
    }
    .wizard > .steps .number {
        font-size: 32px;
    }
    .wizard ul, .tabcontrol ul {
        text-align: center;
    }
    .wizard > .steps a, .wizard > .steps a:hover, .wizard > .steps a:active {
        padding: 10px 10px;
        font-size: 20px;
    }

    .wizard > .steps .current a, .wizard > .steps .current a:hover, .wizard > .steps .current a:active {
        background: none;
        color: #fff;
        cursor: auto;
    }
    .wizard > .steps .disabled a, .wizard > .steps .disabled a:hover, .wizard > .steps .disabled a:active {
        background: none;
        color: #fff;
        cursor: auto;
    }
    .wizard > .steps .done a, .wizard > .steps .done a:hover, .wizard > .steps .done a:active {
        background: none;
        color: #fff;
    }

    .wizard > .actions a, .wizard > .actions a:hover, .wizard > .actions a:active {
        background: #420452;
    }

    .wizard ul li a div p{
        background: #420452;
        border-radius: 50%;
        padding: 3px 15px 3px 15px;
    }

    .wizard .steps .row {
        justify-content: center;
        margin: 0px;
        margin-top: 20px;
        margin-bottom: 20px;
    }

    .wizard_section_title {
        color: #524431;
    }
    #wizard {
        margin-bottom: 20px;
    }
    @media (max-width: 767.98px) {
        .wizard ul li a div p{
            width: 100%;
        }
    }
</style>
<div role="main" class="main">
    <section class="form-section">
        <?php $attributes = array('id' => 'checkout_form');?>
        <?php echo form_open('checkout/save_order', $attributes); ?>
        <div class="container">
            <div class="row justify-content-center" style="padding-left: 25px; padding-right: 25px;">
                <div id="wizard" class="wizard">
                    <h3>????????????</h3>
                    <section>
                        <h3 style="margin-top: 0px;">???????????? (<?=$count?> ?????????)</h3>
                        <table class="table table-hover m_table_none">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col" class="text-nowrap" style="width: 100px;">??????</th>
                                    <th scope="col" class="text-nowrap">??????</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i = 1;?>
                                <?php foreach ($this->cart->contents() as $items): ?>
                                <tr style="border-top:1px solid dimgray;">
                                    <td><?=$i?></td>
                                    <td>
                                        <a href="#">
                                            <?php if ($items['image'] != '') {?>
                                                <img style="width: 100%;" src="/assets/uploads/<?php echo $items['image']; ?>" alt="<?php echo $items['name']; ?>">
                                            <?php }?>
                                        </a>
                                    </td>
                                    <td>
                                        <p><?php echo $items['name']; ?></p>
                                        <p>?????????$<?php echo $items['price']; ?></p>
                                        <p>?????????<?php echo $items['qty']; ?></p>
                                        <p>?????????$<?php echo $items['subtotal']; ?></p>
                                    </td>
                                </tr>
                                <?php $i++;?>
                                <?php endforeach;?>
                            </tbody>
                        </table>
                        <hr>
                        <span style="text-align:right;">??????????????????
                            <span style="color: #dd0606;font-weight: bold;"> $<?php echo $this->cart->total() ?></span>
                        </span>
                        <br>
                        <br>
                        <br>
                    </section>
                    <h3>????????????</h3>
                    <section>
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-12 py-2">
                                    <h3 style="margin: 0px;">??????????????????<span style="font-size:24px;color: red;">NT$ <?php echo $this->cart->total() ?></span></h3>
                                </div>
                                <div class="col-12">
                                    <hr>
                                </div>
                                <div class="col-12 py-2">
                                    <h3>????????????</h3>
                                    <p>1. ??????????????????????????????3-5?????????????????????(????????????)???</p>
                                    <p>2. ????????????????????????????????????????????????????????????</p>
                                </div>
                                <div class="col-12">
                                    <hr>
                                </div>
                                <div class="col-12 col-md-6 py-2">
                                    <h3>????????????</h3>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="checkout_delivery" id="checkout_delivery1" value="home_delivery_frozen" checked>
                                        <label class="form-check-label" for="checkout_delivery1">
                                            ??????(??????)(????????????)+150
                                        </label>
                                        <!-- <p>????????????</p> -->
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="checkout_delivery" id="checkout_delivery2" value="family_pickup__frozen">
                                        <label class="form-check-label" for="checkout_delivery2">
                                            ??????(??????)(????????????)+150
                                        </label>
                                        <!-- <p>????????????</p> -->
                                    </div>
                                </div>
                                <div class="col-12 col-md-6 py-2">
                                    <h3>????????????</h3>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="checkout_payment" id="checkout_payment1" value="bank_transfer" checked>
                                        <label class="form-check-label" for="checkout_payment1">
                                            ????????????
                                        </label>
                                        <!-- <p>????????????</p> -->
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="checkout_payment" id="checkout_payment2" value="credit">
                                        <label class="form-check-label" for="checkout_payment2">
                                            ?????????
                                        </label>
                                        <!-- <p>????????????</p> -->
                                    </div>
                                </div>
                                <div class="col-12">
                                    <hr>
                                </div>
                                <div class="col-12">
                                    <h3>?????????<span style="font-size:24px;color: red;">NT$ <?php echo $this->cart->total() ?></span></h3>
                                </div>
                            </div>
                        </div>
                    </section>
                    <h3>????????????</h3>
                    <section>
                        <div class="container-fluid">
                            <div class="form-group row p-3 justify-content-center" style="padding-bottom:50px !important;">
                                <div class="input-group mb-3 col-12 col-sm-4">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">??????</span>
                                    </div>
                                    <input type="text" class="form-control" name="name" placeholder="??????????????????" required>
                                </div>
                                <div class="input-group mb-3 col-12 col-sm-4">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">??????</span>
                                    </div>
                                    <input type="text" class="form-control" name="phone" placeholder="?????????0987654321" required>
                                </div>
                                <div class="input-group mb-3 col-12 col-sm-8">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">Email</span>
                                    </div>
                                    <input type="text" class="form-control" name="email" placeholder="?????????test@test.com.tw" required>
                                </div>
                                <div class="input-group mb-3 col-12 col-sm-8">
                                        <div class="input-group-prepend">
                                            <label class="input-group-text" for="inputGroupSelect01">???/???</label>
                                        </div>
                                        <div style="width: 89.9%;">
                                            <div id="twzipcode"></div>
                                        </div>
                                </div>
                                <div class="input-group mb-3 col-12 col-sm-8">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">??????</span>
                                    </div>
                                    <input type="text" class="form-control" name="address" placeholder="?????????????????????" required>
                                </div>
                            </div>
                        </div>
                    </section>
                    <h3>????????????</h3>
                    <section>
                        <div class="container-fluid">
                            <div class="row p-3">
                                <div class="form-group col-12">
                                    <label class="col-form-label">????????????</label>
                                    <textarea class="form-control" name="remark" rows="3"></textarea>
                                </div>
                                <div class="col-12 py-5">
                                    <p>??????????????? ???????????????????????????????????????????????????????????????????????????????????? ???????????? ???<a href="./PrivacyPolicy.html" target="_blank">????????????</a>???</p>
                                </div>
                                <div class="col-12">
                                    <!-- <a href="#" type="button" id="One-click-checkout" onclick="form_check()" class="btn btn-primary w-100">????????????</a> -->
                                    <button type="submit" class="btn btn-primary w-100">????????????</button>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>
            </div>
        </div>
        <?php echo form_close() ?>
    </section>
</div>

<!-- purchase-steps -->
<script src="/assets/jquery.steps-1.1.0/jquery.steps.min.js"></script>
<script>
$("#wizard").steps({
    headerTag: "h3",
    bodyTag: "section",
    transitionEffect: "slideLeft",
    enableFinishButton: false,
    titleTemplate: '<div class="number row"><i></i><p>#index#</p></div><span class="wizard_section_title">#title#</span>',
    labels: {
        cancel: "??????",
        current: "current step:",
        pagination: "Pagination",
        finish: "??????",
        next: "?????????",
        previous: "?????????",
        loading: "?????????..."
    }
    // autoFocus: true
});
</script>
<!-- purchase-steps -->
<script src="/node_modules/jquery-twzipcode/jquery.twzipcode.min.js"></script>
<script>
    $('#twzipcode').twzipcode({
        // 'detect': true, // ???????????? false
        zipcodeIntoDistrict: true, // ?????????????????????????????????
        'css': ['form-control county', 'form-control district', 'form-control zipcode'],
        // 'countySel': '<?php // echo $user->county ?>',
        // 'districtSel': '<?php // echo $user->district ?>'
    });
</script>