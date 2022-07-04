<style>
.bs-wizard {
    margin-top: 20px;
}

.bs-wizard {
    border-bottom: solid 1px #e0e0e0;
    padding: 0 0 10px 0;
}

.bs-wizard>.bs-wizard-step {
    padding: 0;
    position: relative;
}

.bs-wizard>.bs-wizard-step+.bs-wizard-step {}

.bs-wizard>.bs-wizard-step .bs-wizard-stepnum {
    color: #595757;
    font-size: 11pt;
    font-weight: bold;
    margin-bottom: 5px;
}

.bs-wizard>.bs-wizard-step .bs-wizard-info {
    color: #999;
    font-size: 14px;
}

.bs-wizard>.bs-wizard-step>.bs-wizard-dot {
    position: absolute;
    width: 30px;
    height: 30px;
    display: block;
    background: #fff;
    top: 45px;
    left: 50%;
    margin-top: -15px;
    margin-left: -15px;
    border-radius: 50%;
    border: 2px solid #595757;
}

.bs-wizard>.bs-wizard-step>.bs-wizard-dot:after {
    content: ' ';
    width: 18px;
    height: 18px;
    background: #fbbd19;
    border-radius: 50px;
    position: absolute;
    top: 4px;
    left: 4px;
}

.bs-wizard>.bs-wizard-step>.progress {
    position: relative;
    border-radius: 0px;
    height: 4px;
    box-shadow: none;
    margin: 22px 0;
    background: #595757;
}

.bs-wizard>.bs-wizard-step>.progress>.progress-bar {
    width: 0px;
    box-shadow: none;
    background: #fbbd19;
}

.bs-wizard>.bs-wizard-step.complete>.progress>.progress-bar {
    width: 100%;
}

.bs-wizard>.bs-wizard-step.active>.progress>.progress-bar {
    width: 50%;
}

.bs-wizard>.bs-wizard-step:first-child.active>.progress>.progress-bar {
    width: 0%;
}

.bs-wizard>.bs-wizard-step:last-child.active>.progress>.progress-bar {
    width: 100%;
}

.bs-wizard>.bs-wizard-step.disabled>.bs-wizard-dot {
    background-color: #f5f5f5;
}

.bs-wizard>.bs-wizard-step.disabled>.bs-wizard-dot:after {
    opacity: 0;
}

.bs-wizard>.bs-wizard-step:first-child>.progress {
    left: 50%;
    width: 50%;
}

.bs-wizard>.bs-wizard-step:last-child>.progress {
    width: 50%;
}

.bs-wizard>.bs-wizard-step.disabled a.bs-wizard-dot {
    pointer-events: none;
}

table {
    margin: auto;
    /*padding: 20px;*/
    border-collapse: separate;
    border-spacing: 0;
}

tr {
    /*border: 1px solid #E0607E;*/
}

td {
    /*border: 1px solid #607ee0;*/
    /*padding: 10px 30px;*/
    /*background-color: #E0607E;*/
    /*color: #FFF;*/
}

/*第一欄第一列：左上*/
tr:first-child td:first-child {
    border-top-left-radius: 8px;
}

/*第一欄最後列：左下*/
tr:last-child td:first-child {
    border-bottom-left-radius: 8px;
}

/*最後欄第一列：右上*/
tr:first-child td:last-child {
    border-top-right-radius: 8px;
}

/*最後欄第一列：右下*/
tr:last-child td:last-child {
    border-bottom-right-radius: 8px;
}

@media (max-width: 480px) {

    .bs-wizard {
        margin-top: 0px;
        margin-left: -15px;
        margin-right: -15px;
    }

    .bs-wizard>.bs-wizard-step .bs-wizard-stepnum {
        padding-top: 50px;
        padding-bottom: 100px;
        width: 15px;
        margin: 0 auto;
    }

    .bs-wizard>.bs-wizard-step>.progress {
        margin: 0;
        margin-top: -211px;
        margin-bottom: 120px;
    }

    .bs-wizard>.bs-wizard-step>.bs-wizard-dot {
        top: 20px;
    }

    #order_list th {
        vertical-align: middle;
        padding: 3px !important;
    }

    #order_list td {
        vertical-align: middle;
        padding: 10px 3px !important;
    }

    #sub_menu a {
        width: 24%;
        padding: 6px;
    }

}
</style>
<div role="main" class="main pt-signinfo">
    <section>
        <div class="container">
            <div class="box row">
                <div class="col-md-12" id="sub_menu">
                    <h3 class="fs-18 color-595757">Hi
                        <?php echo $this->ion_auth->user()->row()->full_name ?>
                    </h3>
                    <div class="form-group">
                        <a href="/auth/edit_user/<?php echo $this->ion_auth->user()->row()->id ?>" class="btn fs-13" style="border: 1px solid gray; color: gray;">個人資料</a>
                        <a href="/coupon" class="btn fs-13" style="border: 1px solid gray; color: gray;">優惠券管理</a>
                        <a href="/order" class="btn fs-13" style="background: gray; color: white;">訂單管理</a>
                        <a href="/my_address" class="btn fs-13" style="border: 1px solid gray; color: gray;">常用地址</a>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="row">
                        <div class="col-md-6" style="margin-top: 20px;">
                            <div class="form-inline text-left">
                                <label class="fs-13 color-595757">訂單狀態</label>
                                <select id="order_status" class="form-control" onchange="get_order()">
                                    <option value="all">全部</option>
                                    <option value="not_paid">未付款</option>
                                    <option value="paid">已付款</option>
                                    <option value="picked">已完成</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-12" style="margin-top: 40px;">
                            <?php if(wp_is_mobile()){ ?>

                                <?php $status=''; ?>
                                <?php $step=''; ?>
                                <?php if(!empty($orders)) { foreach($orders as $data) { ?>
                                <?php if($data['order_pay_status']=='not_paid'){$status='not_paid';} ?>
                                <?php if($data['order_pay_status']=='paid'){$status='paid';} ?>
                                <?php if($data['order_step']=='picked'){$step='picked';} ?>
                                <?php if($data['order_step']=='picked'){$style='color: #fefefe; background: #A0A0A0;';}else{$style='color: #fefefe; background: #FFB718;';} ?>
                                <table class="table table-bordered text-center <?php echo $data['order_pay_status']; ?> <?php echo $data['order_step']; ?>" id="order_list" style="border: none;">
                                    <tr >
                                        <td class="text-center fs-12" style="width: 24%; <?php echo $style ?>">訂購時間</td>
                                         <td class="fs-11 color-595757" style="width: 24%;">
                                            <?php echo $data['order_date'] ?>
                                        </td>
                                        <td class="text-center fs-12" style="width: 24%; <?php echo $style ?>">訂單明細</td>
                                        <td class="fs-11 color-595757" style="width: 24%;">
                                            <a href="/order/view/<?php echo $data['order_id'] ?>" class="order-modal-btn fs-12">查看</a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-center fs-12" style="<?php echo $style ?>">付款狀態</td>
                                        <td class="fs-11 color-595757">
                                            <?php echo get_pay_status($data['order_pay_status']) ?>
                                            <?php // echo get_order_step($data['order_step']) ?>
                                        </td>
                                        <td class="text-center fs-12" style="<?php echo $style ?>">付款期限</td>
                                        <td class="fs-11 color-595757">
                                            <?php echo substr($data['created_at'], 0, 10) ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-center fs-12" style="width: 24%; <?php echo $style ?>">送達地點</td>
                                        <td colspan="3" class="fs-11 color-595757">
                                            <?php if(!empty($data['order_delivery_address'])){
                                                echo $data['order_delivery_address'];
                                            } else {
                                                echo get_delivery_place_name($data['order_delivery_place']);
                                            } ?>
                                        </td>
                                    </tr>
                                        
                                    <tr>
                                        <td colspan="6">
                                            <div class="bs-wizard" style="border-bottom:0;">
                                                <div class="col-xs-2 col-xs-offset-1 col-md-2 col-md-offset-1 bs-wizard-step <?php if($data['order_step']=='accept' || $data['order_step']=='prepare' || $data['order_step']=='shipping' || $data['order_step']=='arrive' || $data['order_step']=='picked'){echo 'complete';}else{echo 'disabled';} ?>">
                                                    <div class="text-center bs-wizard-stepnum">接收訂單</div>
                                                    <div class="progress">
                                                        <div class="progress-bar"></div>
                                                    </div>
                                                    <a href="#" class="bs-wizard-dot"></a>
                                                </div>
                                                <div class="col-xs-2 col-md-2 bs-wizard-step <?php if($data['order_step']=='prepare' || $data['order_step']=='shipping' || $data['order_step']=='arrive' || $data['order_step']=='picked'){echo 'complete';}else{echo 'disabled';} ?>">
                                                    <div class="text-center bs-wizard-stepnum">餐點準備</div>
                                                    <div class="progress">
                                                        <div class="progress-bar"></div>
                                                    </div>
                                                    <a href="#" class="bs-wizard-dot"></a>
                                                </div>
                                                <div class="col-xs-2 col-md-2 bs-wizard-step <?php if($data['order_step']=='shipping' || $data['order_step']=='arrive' || $data['order_step']=='picked'){echo 'complete';}else{echo 'disabled';} ?>">
                                                    <div class="text-center bs-wizard-stepnum">餐點運送</div>
                                                    <div class="progress">
                                                        <div class="progress-bar"></div>
                                                    </div>
                                                    <a href="#" class="bs-wizard-dot"></a>
                                                </div>
                                                <div class="col-xs-2 col-md-2 bs-wizard-step <?php if($data['order_step']=='arrive' || $data['order_step']=='picked'){echo 'complete';}else{echo 'disabled';} ?>">
                                                    <div class="text-center bs-wizard-stepnum">司機抵達</div>
                                                    <div class="progress">
                                                        <div class="progress-bar"></div>
                                                    </div>
                                                    <a href="#" class="bs-wizard-dot"></a>
                                                </div>
                                                <div class="col-xs-2 col-md-2 bs-wizard-step <?php if($data['order_step']=='picked'){echo 'complete';}else{echo 'disabled';} ?>">
                                                    <div class="text-center bs-wizard-stepnum">您已取餐</div>
                                                    <div class="progress">
                                                        <div class="progress-bar"></div>
                                                    </div>
                                                    <a href="#" class="bs-wizard-dot"></a>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                </table>
                                <?php }} ?>

                            <?php } else { ?>

                                <?php $status=''; ?>
                                <?php $step=''; ?>
                                <?php if(!empty($orders)) { foreach($orders as $data) { ?>
                                <?php if($data['order_pay_status']=='not_paid'){$status='not_paid';} ?>
                                <?php if($data['order_pay_status']=='paid'){$status='paid';} ?>
                                <?php if($data['order_step']=='picked'){$step='picked';} ?>
                                <table class="table table-bordered text-center <?php echo $data['order_pay_status']; ?> <?php echo $data['order_step']; ?>" id="order_list" style="border: none;">
                                    <tr style="color: #fefefe; background: <?php if($data['order_step']=='picked'){echo '#A0A0A0';}else{echo '#FFB718;';} ?>">
                                        <td class="text-center fs-12" style="width: 12%;">訂購時間</td>
                                        <!-- <td class="text-center fs-12" style="width: 12%;">送達時間</td> -->
                                        <td class="text-center fs-12" style="width: 40%;">送達地點</td>
                                        <td class="text-center fs-12" style="width: 12%;">付款期限</td>
                                        <td class="text-center fs-12" style="width: 12%;">付款狀態</td>
                                        <td class="text-center fs-12" style="width: 12%;">訂單狀態</td>
                                        <td class="text-center fs-12" style="width: 12%;">訂單明細</td>
                                    </tr>
                                    <tr>
                                        <td class="fs-11 color-595757">
                                            <?php echo $data['order_date'] ?>
                                        </td>
                                        <!-- <td class="fs-11 color-595757"><?php echo $data['created_at'] ?></td> -->
                                        <td class="fs-11 color-595757">
                                            <?php if(!empty($data['order_delivery_address'])){
                                                echo $data['order_delivery_address'];
                                            } else {
                                                echo get_delivery_place_name($data['order_delivery_place']);
                                            } ?>
                                        </td>
                                        <td class="fs-11 color-595757">
                                            <?php echo substr($data['created_at'], 0, 10) ?>
                                        </td>
                                        <td class="fs-11 color-595757">
                                            <?php echo get_pay_status($data['order_pay_status']) ?>
                                        </td>
                                        <td class="fs-11 color-595757">
                                            <?php echo get_order_step($data['order_step']) ?>
                                        </td>
                                        <td class="fs-11 color-595757"><a href="/order/view/<?php echo $data['order_id'] ?>" class="order-modal-btn fs-12">查看</a></td>
                                    </tr>
                                    <tr>
                                        <td colspan="6">
                                            <div class="bs-wizard" style="border-bottom:0;">
                                                <div class="col-xs-2 col-xs-offset-1 col-md-2 col-md-offset-1 bs-wizard-step <?php if($data['order_step']=='accept' || $data['order_step']=='prepare' || $data['order_step']=='shipping' || $data['order_step']=='arrive' || $data['order_step']=='picked'){echo 'complete';}else{echo 'disabled';} ?>">
                                                    <div class="text-center bs-wizard-stepnum">接收訂單</div>
                                                    <div class="progress">
                                                        <div class="progress-bar"></div>
                                                    </div>
                                                    <a href="#" class="bs-wizard-dot"></a>
                                                </div>
                                                <div class="col-xs-2 col-md-2 bs-wizard-step <?php if($data['order_step']=='prepare' || $data['order_step']=='shipping' || $data['order_step']=='arrive' || $data['order_step']=='picked'){echo 'complete';}else{echo 'disabled';} ?>">
                                                    <div class="text-center bs-wizard-stepnum">餐點準備</div>
                                                    <div class="progress">
                                                        <div class="progress-bar"></div>
                                                    </div>
                                                    <a href="#" class="bs-wizard-dot"></a>
                                                </div>
                                                <div class="col-xs-2 col-md-2 bs-wizard-step <?php if($data['order_step']=='shipping' || $data['order_step']=='arrive' || $data['order_step']=='picked'){echo 'complete';}else{echo 'disabled';} ?>">
                                                    <div class="text-center bs-wizard-stepnum">餐點運送</div>
                                                    <div class="progress">
                                                        <div class="progress-bar"></div>
                                                    </div>
                                                    <a href="#" class="bs-wizard-dot"></a>
                                                </div>
                                                <div class="col-xs-2 col-md-2 bs-wizard-step <?php if($data['order_step']=='arrive' || $data['order_step']=='picked'){echo 'complete';}else{echo 'disabled';} ?>">
                                                    <div class="text-center bs-wizard-stepnum">司機抵達</div>
                                                    <div class="progress">
                                                        <div class="progress-bar"></div>
                                                    </div>
                                                    <a href="#" class="bs-wizard-dot"></a>
                                                </div>
                                                <div class="col-xs-2 col-md-2 bs-wizard-step <?php if($data['order_step']=='picked'){echo 'complete';}else{echo 'disabled';} ?>">
                                                    <div class="text-center bs-wizard-stepnum">您已取餐</div>
                                                    <div class="progress">
                                                        <div class="progress-bar"></div>
                                                    </div>
                                                    <a href="#" class="bs-wizard-dot"></a>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                </table>
                                <?php }} ?>

                            <?php } ?>
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
<div id="order-Modal" class="modal fade">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <!-- <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title"></h4>
            </div> -->
            <div class="modal-body" style="padding: 15px;">
                <p>讀取中...</p>
            </div>
            <!-- <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">關閉</button>
                <button type="submit" class="btn btn-primary">Save changes</button>
            </div> -->
        </div>
    </div>
</div>
<script>
$('.order-modal-btn').on('click', function(e) {
    e.preventDefault();
    //$('#use-Modal').modal('show').find('.modal-body').load($(this).attr('href'));
    $('#order-Modal').modal('show').find('.modal-body').load(this.href);
});
</script>
<script>
function get_order() {
    var order_status = $('#order_status').val();
    if (order_status == 'not_paid') {
        $("table.paid").fadeOut('fast');
        $("table.picked").fadeOut('fast');
        $("table.not_paid").fadeIn('fast');
    } else if (order_status == 'paid') {
        $("table.not_paid").fadeOut('fast');
        $("table.picked").fadeOut('fast');
        $("table.paid").fadeIn('fast');
    } else if (order_status == 'picked') {
        $("table.not_paid").fadeOut('fast');
        $("table.paid").fadeOut('fast');
        $("table.picked").fadeIn('fast');
    } else {
        $("table.not_paid").fadeIn('fast');
        $("table.paid").fadeIn('fast');
        $("table.picked").fadeIn('fast');
    }
}
</script>