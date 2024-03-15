<div v-cloak id="checkoutApp">
    <section id="section-content">
        <?php $attributes = array('id' => 'checkout_form'); ?>
        <?php echo form_open('checkout/save_order', $attributes); ?>
        <div class="container">
            <div class="section-contents-one">
                <h1><span>{{ pageTitle }}</span></h1>
                <div class="row mt-5 mb-5">
                    <div class="col-sm-6 col-lg-4 text-center">
                        <span class="checkoutStepIcon" @click="changeStep(1)"><img :src="'/assets/uploads/Checkout/' + ic_step01" alt="step1"></span>
                    </div>
                    <div class="col-sm-6 col-lg-4 text-center">
                        <span class="checkoutStepIcon" @click="changeStep(2)"><img :src="'/assets/uploads/Checkout/' + ic_step02" alt="step2"></span>
                    </div>
                    <div class="col-sm-6 col-lg-4 text-center">
                        <span class="checkoutStepIcon" @click="changeStep(3)"><img :src="'/assets/uploads/Checkout/' + ic_step03" alt="step3"></span>
                    </div>
                </div>
                <div v-show="selectedStep == '1'">
                    <?php require('partnertoys_list.php'); ?>
                </div>
                <div v-show="selectedStep == '2'">
                    <?php require('partnertoys_info.php'); ?>
                </div>
                <div v-show="selectedStep == '3'">
                    <?php require('partnertoys_order.php'); ?>
                </div>
            </div>
        </div>
        <div class="container btnBox">
            <span v-if="cart_num" class="btnDef black" @click="backStep()">
                <i class="fas fa-arrow-circle-left"></i>
                <span>&nbsp;{{ blackbtn }}</span>
            </span>
            <span v-if="cart_num" class="btnDef red" @click="nextStep()">
                <i class="fas fa-arrow-circle-right"></i>
                <span>&nbsp;{{ redbtn }}</span>
            </span>
            <span v-if="!cart_num" class="btnDef black" @click="goingToProduct()">
                <i class="fas fa-arrow-circle-left"></i>
                <span>&nbsp;選購商品</span>
            </span>
        </div>
        <?php echo form_close() ?>
    </section>
</div>

<script>
    const checkoutApp = Vue.createApp({
        data() {
            return {
                cart_num: <?= $this->cart->total_items() ?>,
                selectedStep: 0,
                pageTitle: '',
                ic_step01: '',
                ic_step02: '',
                ic_step03: '',
                blackbtn: '',
                redbtn: '',
            }
        },
        mounted() {
            // init step.
            this.changeStep();
        },
        methods: {
            // 指定步驟
            changeStep(selected = 1) {
                if (this.cart_num == 0) {
                    alert('購屋車目前是空的');
                    this.goingToProduct();
                    return;
                }
                // 2切3
                if (selected == 3 && !this.formChecking()) {
                    // console.log('return changeStep');
                    return;
                }
                // 2切3
                else if (selected == 3 && this.selectedStep == 2) {
                    this.checkConfirmInfo();
                }
                this.selectedStep = selected;
                this.ic_step01 = (selected == 1) ? 'ic_step01o.png' : 'ic_step01.png';
                this.ic_step02 = (selected == 2) ? 'ic_step02o.png' : 'ic_step02.png';
                this.ic_step03 = (selected == 3) ? 'ic_step03o.png' : 'ic_step03.png';
                if (selected == 1) {
                    this.pageTitle = '購物清單';
                    this.blackbtn = '繼續選購其他商品';
                    this.redbtn = '下一步，填寫購買資料';
                }
                if (selected == 2) {
                    this.pageTitle = '購物資訊';
                    this.blackbtn = '返回上一步';
                    this.redbtn = '下一步，送出訂單';
                }
                if (selected == 3) {
                    this.pageTitle = '送出訂單';
                    this.blackbtn = '返回上一步';
                    this.redbtn = '確認送出訂單';
                }
                this.scrollToTop();
            },
            // 下一步
            nextStep() {
                if (this.selectedStep == 2 && !this.formChecking()) {
                    // console.log('return nextStep');
                    return;
                } else if (this.selectedStep != 3) {
                    this.checkConfirmInfo();
                    this.changeStep(this.selectedStep + 1);
                } else {
                    if (!this.formChecking()) {
                        return;
                    }
                    $('#checkout_form').submit();
                }
            },
            // 上一步
            backStep() {
                if (this.selectedStep != 1) {
                    this.changeStep(this.selectedStep - 1);
                } else {
                    window.location.href = "<?= base_url() . 'product' ?>";
                }
            },
            // 引導至商品區
            goingToProduct() {
                window.location.href = "<?= base_url() . 'product' ?>";
            },
            goingToSpecificProduct(selected) {
                $.ajax({
                    url: '/encode/getDataEncode/selectedProduct',
                    type: 'post',
                    data: {
                        selectedProduct: selected,
                    },
                    success: (response) => {
                        if (response) {
                            if (response.result == 'success') {
                                window.location.href = <?= json_encode(base_url()) ?> + 'product/product_detail/?' + response.src;
                            } else {
                                console.log('error.');
                            }
                        } else {
                            console.log(response);
                        }
                    },
                });
            },
            // 檢查表單
            formChecking() {
                var delivery = $('input[name=checkout_delivery]:checked', '#checkout_form').val();
                var payment = $('input[name=checkout_payment]:checked', '#checkout_form').val();

                if ($('#name').val() == '') {
                    alert('請輸入收件姓名');
                    return false;
                }
                if ($('#phone').val().length < 10) {
                    alert('請輸入完整的收件電話');
                    return false;
                }
                if ($('#email').val() == '') {
                    alert('請輸入完整的電子郵件');
                    return false;
                }
                if ($('#Country').val() == '請選擇國家') {
                    alert('請選擇所在國家');
                    return false;
                } else if ($('#Country').val() == '臺灣') {
                    var countySelect = $("#tw_county").val();
                    var districtSelect = $("#tw_district").val();

                    // 檢查所在縣市
                    if (countySelect == '') {
                        alert('請選擇所在縣市');
                        return false;
                    }

                    // 檢查所在鄉鎮市區
                    if (districtSelect == '') {
                        alert('請選擇所在鄉鎮市區');
                        return false;
                    }
                } else if ($('#Country').val() == '中國') {
                    var provinceSelect = $("#cn_province").val();
                    var countySelect = $("#cn_county").val();
                    var districtSelect = $("#cn_district").val();

                    // 檢查所在省份
                    if (provinceSelect == '') {
                        alert('請選擇所在省份');
                        return false;
                    }

                    // 檢查所在縣市
                    if (countySelect == '') {
                        alert('請選擇所在縣市');
                        return false;
                    }

                    // 檢查所在鄉鎮市區
                    if (districtSelect == '') {
                        alert('請選擇所在鄉鎮市區');
                        return false;
                    }
                }
                if ($('#address').val() == '') {
                    alert('請輸入詳細地址');
                    return false;
                }
                if (payment != 'bank_transfer') {
                    $('#NotesOnBankRemittance').hide();
                } else {
                    $('#NotesOnBankRemittance').show();
                }
                if (delivery == '' || delivery == null) {
                    alert('請選擇運送方式');
                    return false;
                }
                if (payment == '' || payment == null) {
                    alert('請選擇付款方式');
                    return false;
                }
                if ($('#Country').val() == '臺灣' && (delivery == '711_pickup' || delivery == 'family_pickup')) {
                    if ($('#storeid').val() == '' || $('#storename').val() == '' || $('#storeaddress').val() == '') {
                        alert('請選擇取貨門市');
                        return false;
                    }
                }
                return true;
            },
            // 生成確認表單
            checkConfirmInfo() {
                var selectedCheckoutDelivery = $('input[name="checkout_delivery"]:checked').val();
                var checkoutDeliveryLabel = $('label[for="checkout_delivery_' + selectedCheckoutDelivery + '"]').text();
                var selectedCheckoutPayment = $('input[name="checkout_payment"]:checked').val();
                var checkoutPaymentLabel = $('label[for="checkout_payment_' + selectedCheckoutPayment + '"]').text();

                // console.log('selectedCheckoutDelivery = ' + selectedCheckoutDelivery);
                // console.log('checkoutDeliveryLabel = ' + checkoutDeliveryLabel);
                // console.log('selectedCheckoutPayment = ' + selectedCheckoutPayment);
                // console.log('checkoutPaymentLabel = ' + checkoutPaymentLabel);

                var data = '';
                data += '<table class="table table-bordered table-striped"><tbody>';
                // data += '<tr><td class="text-center" colspan="3"><h2 class="m-0">訂購資訊確認</h2></td></tr>';
                if ($('#name').val() != '') {
                    data += '<tr><td>姓名</td><td>' + $('#name').val() + '</td></tr>';
                }
                if ($('#phone').val() != '') {
                    data += '<tr><td>電話</td><td>' + $('#phone').val() + '</td></tr>';
                }
                if ($('#email').val() != '') {
                    data += '<tr><td>信箱</td><td>' + $('#email').val() + '</td></tr>';
                }
                if (selectedCheckoutDelivery != '711_pickup' && selectedCheckoutDelivery != 'family_pickup') {
                    if ($('#Country').val() != '') {
                        data += '<tr><td>國家</td><td>' + $('#Country').val() + '</td></tr>';
                    }
                    if ($('#Country').val() == '臺灣') {
                        if ($("#tw_county").val() != '') {
                            data += '<tr><td>縣市</td><td>' + $("#tw_county").val() + '</td></tr>';
                        }
                        if ($("#tw_district").val() != '') {
                            data += '<tr><td>鄉鎮市區</td><td>' + $("#tw_district").val() + '</td></tr>';
                        }
                        if ($("#tw_zipcode").val() != '') {
                            data += '<tr><td>郵遞區號</td><td>' + $("#tw_zipcode").val() + '</td></tr>';
                        }
                    } else if ($('#Country').val() == '中國') {
                        if ($("#cn_province").val() != '') {
                            data += '<tr><td>省分</td><td>' + $("#cn_province").val() + '</td></tr>';
                        }
                        if ($("#cn_county").val() != '') {
                            data += '<tr><td>縣市</td><td>' + $("#cn_county").val() + '</td></tr>';
                        }
                        if ($("#cn_district").val() != '') {
                            data += '<tr><td>鄉鎮市區</td><td>' + $("#cn_district").val() + '</td></tr>';
                        }
                        if ($("#cn_zipcode").val() != '') {
                            data += '<tr><td>郵遞區號</td><td>' + $("#cn_zipcode").val() + '</td></tr>';
                        }
                    }

                    if ($('#address').val() != '') {
                        data += '<tr><td>詳細地址</td><td>' + $('#address').val() + '</td></tr>';
                    }
                }
                if (selectedCheckoutDelivery == '711_pickup' || selectedCheckoutDelivery == 'family_pickup') {
                    if ($('#storeid').val() != '') {
                        data += '<tr><td>門市編號</td><td>' + $('#storeid').val() + '</td></tr>';
                    }
                    if ($('#storename').val() != '') {
                        data += '<tr><td>取件門市</td><td>' + $('#storename').val() + '</td></tr>';
                    }
                    if ($('#storeaddress').val() != '') {
                        data += '<tr><td>取件地址</td><td>' + $('#storeaddress').val() + '</td></tr>';
                    }
                }
                data += '<tr><td>發票抬頭</td><td>' + $('#order_cpname').val() + '</td></tr>';
                data += '<tr><td>統一編號</td><td>' + $('#order_cpno').val() + '</td></tr>';
                data += '<tr><td>備註事項</td><td>' + $('#remark').val() + '</td></tr>';
                data += '<tr><td>運送方式</td><td>' + checkoutDeliveryLabel + '</td></tr>';
                data += '<tr><td>付款方式</td><td>' + checkoutPaymentLabel + '</td></tr>';
                // if ($('#xxxxx').val() != '') {
                //     data += '<tr><td>運費</td><td>'+$('#xxxxx').val()+'</td></tr>';
                // }
                if ($('#cart_total').val() != '') {
                    data += '<tr><td>購物車小計</td><td>$' + $('#cart_total').val() + '</td></tr>';
                }
                if ($('#shipping_amount').val() != '') {
                    data += '<tr><td>運費</td><td>$' + $('#shipping_amount').val() + '</td></tr>';
                }
                if ($('#total_amount').val() != '') {
                    data += '<tr><td>總計</td><td style="color:red;font-size:20px">$' + $('#total_amount').val() + '</td></tr>';
                }
                data += "</tbody></table>";
                $(".confirm_info").html(data);
            },
            scrollToTop() {
                window.scrollTo({
                    top: 0,
                    behavior: 'smooth' // 若要有平滑的滾動效果
                });
            },

        },
    });
    checkoutApp.mount('#checkoutApp');
</script>


<script>
    // key in value to the cart
    $(document).ready(function() {
        // 监听输入框的 input 事件
        $(".qtyInputBox").on("change", function() {
            // 获取输入框的值
            var qty = $(this).val();

            // 检查输入值是否为数字
            if ($.isNumeric(qty)) {
                // 获取数据重奖的 ID
                var rewordId = $(this).data("reword-id");

                // 发送 AJAX 请求来更新数量
                $.ajax({
                    url: "/cart/update_qty",
                    method: "POST",
                    data: {
                        rowid: rewordId,
                        qty: qty
                    },
                    success: function(response) {
                        // 更新小计显示
                        // var subtotal = parseInt(response); // 假设服务器返回的是正确的小计值
                        // $('#subtotal_' + rewordId).text('$ ' + subtotal);
                        location.reload();
                    },
                    error: function(xhr, status, error) {
                        // 在错误时执行的操作
                        console.error("Error updating quantity: " + error);
                    }
                });
            } else {
                // 如果输入值不是数字，则执行相应的操作（可根据需求处理）
                console.log("Invalid quantity value");
            }
        });
        // btn adjust cart num
        $('.btn-number').click(function(e) {
            e.preventDefault();
            fieldName = $(this).attr('data-field');
            reword_id = $(this).attr('data-reword-id');
            type = $(this).attr('data-type');
            var input = $("input[name='" + fieldName + "']");
            var currentVal = parseInt(input.val());
            // console.log(currentVal);
            if (!isNaN(currentVal)) {
                if (type == 'minus') {
                    if (currentVal > input.attr('min')) {
                        input.val(currentVal - 1).change();
                    } else if (parseInt(input.val()) == input.attr('min')) {
                        const delect = confirm("貼心提醒，是否指定商品將從購物車清除。");
                        if (delect) {
                            var rowid = reword_id;
                            $.ajax({
                                url: "/cart/remove",
                                method: "POST",
                                data: {
                                    rowid: rowid
                                },
                                success: function(response) {
                                    // 更新小计显示
                                    // var subtotal = parseInt(response); // 假设服务器返回的是正确的小计值
                                    // $('#subtotal_' + rowid).text('$ ' + subtotal);
                                    location.reload();
                                }
                            });
                        } else {
                            return;
                        }
                        $(this).attr('disabled', true);
                    }
                } else if (type == 'plus') {
                    if (currentVal < input.attr('max')) {
                        input.val(currentVal + 1).change();
                    } else if (parseInt(input.val()) == input.attr('max')) {
                        alert('已達商品限制最大數量，敬請見諒。');
                        $(this).attr('disabled', true);
                    }
                }
                var rowid = reword_id;
                $.ajax({
                    url: "/cart/update_qty",
                    method: "POST",
                    data: {
                        rowid: rowid,
                        qty: input.val()
                    },
                    success: function(response) {
                        // 更新小计显示
                        // var subtotal = parseInt(response); // 假设服务器返回的是正确的小计值
                        // $('#subtotal_' + rowid).text('$ ' + subtotal);
                        location.reload();
                    }
                });
            } else {
                input.val(0);
            }
        });
    });
</script>

<!-- initial function -->
<script>
    function initialDelieveryAndPayment() {
        // initial payment
        $('#checkout_payment_ecpay_CVS').prop('disabled', true);
        $('#checkout_payment_ecpay_ATM').prop('disabled', true);
        $('#checkout_payment_ecpay_credit').prop('disabled', true);

        // initial delivery
        $('#checkout_delivery_711_pickup').prop('disabled', true);
        $('#checkout_delivery_family_pickup').prop('disabled', true);
        $('#checkout_delivery_ktj_main_delivery').prop('disabled', true);
        $('#checkout_delivery_ktj_sub_delivery').prop('disabled', true);
        $('#checkout_delivery_sf_mc_express_delivery').prop('disabled', true);
        $('#checkout_delivery_sf_hk_express_delivery').prop('disabled', true);
        $('#checkout_delivery_sf_cn_express_delivery').prop('disabled', true);
        $('#checkout_delivery_sf_others_express_delivery').prop('disabled', true);

        // initial checked payment and delivery
        $('input[name=checkout_payment]', '#checkout_form').prop('checked', false);
        $('input[name=checkout_delivery]', '#checkout_form').prop('checked', false);
    }

    function initialSelectedCountryInfo() {
        // initial selected address
        $('#tw_county').val('');
        $('#tw_district').val('');
        $('#tw_zipcode').val('');
        $('#cn_province').val('');
        $('#cn_county').val('');
        $('#cn_district').val('');
        $('#cn_zipcode').val('');
    }
</script>

<script>
    // initial
    $(document).ready(function() {
        // 初始化購物車總計
        var cart_amount = 0;
        var shipping_amount = 0;
        var initialCartTotal = parseFloat(<?php echo $this->cart->total() ?>);
        cart_amount = parseInt(initialCartTotal);
        $('#cart_total').val(cart_amount)

        // 初始化表單
        $(".confirm_info").html('');

        // 初始化選所選運送方式
        var initialShippingFee = 0;
        shipping_amount = parseInt(initialShippingFee);
        $('#shipping_fee').text(' $' + shipping_amount);
        $('#shipping_amount').val(initialShippingFee)
        $('#total_amount').val(cart_amount + shipping_amount)
        $('#total_amount_view').text(' $' + (cart_amount + shipping_amount));

        // 初始化配送與付款方式
        initialDelieveryAndPayment();

        // 更改運送方式
        $('input[name="checkout_delivery"]').change(function() {
            var shippingFee = $(this).data('shipping-fee');

            // 当选择框改变时的逻辑
            $('#shipping_fee').text(' $' + shippingFee);
            shipping_amount = parseInt(shippingFee);
            $('#shipping_amount').val(shipping_amount);
            $('#total_amount').val(cart_amount + shipping_amount)
            $('#total_amount_view').text(' $' + (cart_amount + shipping_amount));

            // init store info
            $('#storeid').val('');
            $('#storename').val('');
            $('#storeaddress').val('');
        });
    });
</script>

<!-- change event compute -->
<script>
    // 更改國家
    $(document).on('change', '#Country', function() {
        // initial value
        var selectedCountry = $(this).val();
        var initialCartTotal = parseInt(<?php echo $this->cart->total() ?>);
        var initialShippingFee = 0;
        $('#shipping_fee').text(' $' + initialShippingFee);
        $('#total_amount').val(parseInt(initialCartTotal) + parseInt(initialShippingFee))
        $('#total_amount_view').text(' $' + (initialCartTotal + initialShippingFee));

        // initial payment and delivery
        initialDelieveryAndPayment();
        // initial selected country infomation
        initialSelectedCountryInfo();

        if (selectedCountry == '臺灣') {
            $('#checkout_payment_ecpay_CVS').prop('disabled', false);
            $('#checkout_payment_ecpay_ATM').prop('disabled', false);
            $('#checkout_payment_ecpay_credit').prop('disabled', false);
            tmpct = $("#tw_county").val();
            if (tmpct) {
                if (tmpct == '宜蘭縣' || tmpct == '花蓮縣' || tmpct == '臺東縣' || tmpct == '金門縣' || tmpct == '連江縣' || tmpct == '澎湖縣') {
                    $('#checkout_delivery_ktj_sub_delivery').prop('disabled', false);
                } else {
                    $('#checkout_delivery_711_pickup').prop('disabled', false);
                    $('#checkout_delivery_family_pickup').prop('disabled', false);
                    $('#checkout_delivery_ktj_main_delivery').prop('disabled', false);
                }
            }
        } else {
            $('#checkout_payment_ecpay_credit').prop('disabled', false);
            if (selectedCountry == '中國') {
                $('#checkout_delivery_sf_cn_express_delivery').prop('disabled', false);
            } else if (selectedCountry == '澳門') {
                $('#checkout_delivery_sf_mc_express_delivery').prop('disabled', false);
            } else if (selectedCountry == '香港') {
                $('#checkout_delivery_sf_hk_express_delivery').prop('disabled', false);
            } else if (selectedCountry == '其它') {
                $('#checkout_delivery_sf_others_express_delivery').prop('disabled', false);
            }
        }
    });

    // 更改台灣城市
    $(document).on('change', '#tw_county', function() {
        // initial value
        var selectedCountry = $('#Country').val();
        var initialCartTotal = parseInt(<?php echo $this->cart->total() ?>);
        var initialShippingFee = 0;
        $('#shipping_fee').text(' $' + initialShippingFee);
        $('#total_amount').val(parseInt(initialCartTotal) + parseInt(initialShippingFee))
        $('#total_amount_view').text(' $' + (initialCartTotal + initialShippingFee));

        // initial payment and delivery
        initialDelieveryAndPayment();

        if (selectedCountry == '臺灣') {
            $('#checkout_payment_ecpay_CVS').prop('disabled', false);
            $('#checkout_payment_ecpay_ATM').prop('disabled', false);
            $('#checkout_payment_ecpay_credit').prop('disabled', false);
            tmpct = $("#tw_county").val();
            if (tmpct) {
                if (tmpct == '宜蘭縣' || tmpct == '花蓮縣' || tmpct == '臺東縣' || tmpct == '金門縣' || tmpct == '連江縣' || tmpct == '澎湖縣') {
                    $('#checkout_delivery_ktj_sub_delivery').prop('disabled', false);
                } else {
                    $('#checkout_delivery_711_pickup').prop('disabled', false);
                    $('#checkout_delivery_family_pickup').prop('disabled', false);
                    $('#checkout_delivery_ktj_main_delivery').prop('disabled', false);
                }
            }
        }
    });

    $(document).ready(function() {
        // 監聽 #Country 元素的變化事件
        $('#Country', '#checkout_form').on('change', function() {
            handleDynamicChanges();
        });

        // 監聽 delivery 元素的變化事件
        $('input[name=checkout_delivery]', '#checkout_form').on('change', function() {
            handleDynamicChanges();
        });

        // 初始處理
        handleDynamicChanges();

        // 定義處理動態變化的函數
        function handleDynamicChanges() {
            var delivery = $('input[name=checkout_delivery]:checked', '#checkout_form').val();
            var County = $('#Country', '#checkout_form').val();
            // console.log("Country:", County);
            // console.log("Delivery:", delivery);

            // 根據新的 #Country 和 delivery 值執行相應的邏輯
            if (County == '臺灣' && (delivery == '711_pickup' || delivery == 'family_pickup')) {
                $('.supermarket').show();
            } else {
                $('.supermarket').hide();
                $('#storeid').val(''); // 清空 storeid 的值
                $('#storename').val(''); // 清空 storename 的值
                $('#storeaddress').val(''); // 清空 storeaddress 的值
            }
        }
    });
</script>

<!-- CVS -->
<script>
    // 地圖
    function locationToCvsMap() {
        set_user_data();
        // checked radio val
        var selectedDelivery = $("input[name='checkout_delivery']:checked").val();
        // 手機版cookie存取checked radio val
        document.cookie = "selectedDelivery=" + selectedDelivery;
        // 是否為手機
        var isMobile = <?php echo json_encode(wp_is_mobile()) ?>;
        // 串至綠界地圖
        var route = '<?php echo base_url(); ?>checkout/cvsmap?checkout=' + selectedDelivery;
        if (isMobile) {
            // 導入串綠界地圖並給cvsmap判斷是否為mobile
            window.open(route, "選擇門市");
            // window.location.href = (route + '&device=mobile');
        } else {
            // 開新視窗串綠界地圖cvsmap
            window.open(route, "選擇門市", "width=1024,height=768");
        }
    }

    function set_user_data() {
        $.ajax({
            url: "/checkout/set_user_data",
            method: "POST",
            data: {
                name: $('#name').val(),
                phone: $('#phone').val(),
                email: $('#email').val()
            },
            success: function(data) {
                //
            }
        });
    }

    function set_store_info(storeid = '', storename = '', storeaddress = '') {
        $("#storeid").val(storeid);
        $("#storename").val(storename);
        $("#storeaddress").val(storeaddress);
    }
</script>

<!-- country select steps -->
<script src="/assets/twzipcode/jquery.twzipcode.min.js"></script>
<script src="/assets/jQuery-cn-zipcode-master/jquery-cn-zipcode.min.js"></script>

<!-- user default info -->
<script>
    $(document).ready(function() {
        <? if ($user_data['Country'] == '臺灣') : ?>
            $('#checkout_payment_ecpay_CVS').prop('disabled', false);
            $('#checkout_payment_ecpay_ATM').prop('disabled', false);
            $('#checkout_payment_ecpay_credit').prop('disabled', false);
            <? if ($user_data['county'] == '宜蘭縣' || $user_data['county'] == '花蓮縣' || $user_data['county'] == '臺東縣' || $user_data['county'] == '金門縣' || $user_data['county'] == '連江縣' || $user_data['county'] == '澎湖縣') : ?>
                $('#checkout_delivery_ktj_sub_delivery').prop('disabled', false);
            <? else : ?>
                $('#checkout_delivery_711_pickup').prop('disabled', false);
                $('#checkout_delivery_family_pickup').prop('disabled', false);
                $('#checkout_delivery_ktj_main_delivery').prop('disabled', false);
            <? endif; ?>
        <? elseif ($user_data['Country'] == '中國') : ?>
            $('#checkout_payment_ecpay_credit').prop('disabled', false);
            $('#checkout_delivery_sf_cn_express_delivery').prop('disabled', false);
        <? elseif ($user_data['Country'] == '香港') : ?>
            $('#checkout_payment_ecpay_credit').prop('disabled', false);
            $('#checkout_delivery_sf_hk_express_delivery').prop('disabled', false);
        <? elseif ($user_data['Country'] == '澳門') : ?>
            $('#checkout_payment_ecpay_credit').prop('disabled', false);
            $('#checkout_delivery_sf_mc_express_delivery').prop('disabled', false);
        <? elseif ($user_data['Country'] == '其它') : ?>
            $('#checkout_payment_ecpay_credit').prop('disabled', false);
            $('#checkout_delivery_sf_others_express_delivery').prop('disabled', false);
        <? endif; ?>
    });
</script>

<!-- zipcode function -->
<script>
    // twzipcode
    $(document).ready(function() {
        // 初始化 twzipcode
        $("#twzipcode").twzipcode();
        if ($("#Country").val() === '臺灣') {
            $("#twzipcode").show();
            var initialCartTotal = parseInt(<?php echo $this->cart->total() ?>);
            var initialShippingFee = 0;
            $('#shipping_fee').text(' $' + initialShippingFee);
            $('#total_amount').val(parseInt(initialCartTotal) + parseInt(initialShippingFee))
            $('#total_amount_view').text(' $' + (initialCartTotal + initialShippingFee));
        }

        $("#Country").change(function() {
            if ($(this).val() === '臺灣') {
                $("#twzipcode").show();
            } else {
                $("#twzipcode").hide();
            }
        });

        // 禁用郵遞區號的輸入框
        $("[name='tw_zipcode']").prop('readonly', true);

        // 選擇縣市、鄉鎮市區下拉選單
        var countySelect = $("select[name='tw_county']");
        var districtSelect = $("select[name='tw_district']");
        var zipcodeInput = $("input[name='tw_zipcode']");

        if (countySelect.length > 0) {
            countySelect.addClass('form-control');
            countySelect.attr('id', 'tw_county');
        }

        if (districtSelect.length > 0) {
            districtSelect.addClass('form-control');
            districtSelect.attr('id', 'tw_district');
        }

        if (zipcodeInput.length > 0) {
            zipcodeInput.addClass('form-control');
            zipcodeInput.attr('id', 'tw_zipcode');
        }
    });
    // cnzipcode
    $(document).ready(function() {
        // 初始化 cnzipcode
        <? if ($user_data['Country'] == '中國') : ?>
            $("#cnzipcode").cnzipcode({
                provinceDefault: '<?= $user_data['province'] ?>',
                countyDefault: '<?= $user_data['county'] ?>',
                districtDefault: '<?= $user_data['district'] ?>',
                zipcodeDefault: '<?= $user_data['zipcode'] ?>'
            });
        <? else : ?>
            $("#cnzipcode").cnzipcode();
        <? endif; ?>

        // view the zipcode fun
        if ($("#Country").val() === '中國') {
            $("#cnzipcode").show();
            var initialCartTotal = parseInt(<?php echo $this->cart->total() ?>);
            var initialShippingFee = 0;
            $('#shipping_fee').text(' $' + initialShippingFee);
            $('#total_amount').val(parseInt(initialCartTotal) + parseInt(initialShippingFee))
            $('#total_amount_view').text(' $' + (initialCartTotal + initialShippingFee));
        }

        $("#Country").change(function() {
            if ($(this).val() === '中國') {
                $("#cnzipcode").show();

            } else {
                $("#cnzipcode").hide();
            }
        });

        // 禁用郵遞區號的輸入框
        $("[name='cn_zipcode']").prop('readonly', true);

        // 選擇縣市、鄉鎮市區下拉選單
        var provinceSelect = $("select[name='cn_province']");
        var countySelect = $("select[name='cn_county']");
        var districtSelect = $("select[name='cn_district']");
        var zipcodeInput = $("input[name='cn_zipcode']");

        if (provinceSelect.length > 0) {
            provinceSelect.addClass('form-control');
            provinceSelect.attr('id', 'cn_province');
        }

        if (countySelect.length > 0) {
            countySelect.addClass('form-control');
            countySelect.attr('id', 'cn_county');
        }

        if (districtSelect.length > 0) {
            districtSelect.addClass('form-control');
            districtSelect.attr('id', 'cn_district');
        }

        if (zipcodeInput.length > 0) {
            zipcodeInput.addClass('form-control');
            zipcodeInput.attr('id', 'cn_zipcode');
            // 設定 input 的 placeholder
            zipcodeInput.attr('placeholder', '邮政编码');
        }
    });
</script>