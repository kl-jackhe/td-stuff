<style>
.header_fixed_icon {
    display: none;
}
.policy_box {
    padding: 0px 25px 0px 25px;
}
.text-bold {
    font-weight: bold;
}
.tab-content {
    overflow-y: auto;
    padding: 0px 30px 0px 30px !important;
}
.straight_line {
    border-right: 1px solid #988B7A;
    position: absolute;
    top: -20px;
    z-index: 0;
}
.m_border {
    display: none;
}
.title-text {
    font-weight: bold;
    margin: 3px 0px 0px 0px;
    font-size: 24px !important;
    padding: 0px !important;
}
.tab-content p {
    letter-spacing: 1px;
    font-size: 14px;
    line-height: 24px;
    padding-bottom: 10px;
}
.nav-pills .nav-link.active, .nav-pills .show>.nav-link {
    <?if ($this->is_td_stuff) {?>
        background-color: #68396D;
    <?}?>
    <?if ($this->is_liqun_food) {?>
        background-color: #585656;
    <?}?>
}
.nav-link {
    font-weight: bold;
    padding-top: 3px;
    padding-bottom: 3px;
    margin-bottom: 15px;
}
#footer {
    position: relative;
    z-index: 10;
}
#v-pills-tab-other {
    display: none;
}
@media (max-width: 767px) {
    .nav-link {
        margin: 5px 0px 5px 0px;
    }
    .title-text {
        font-size: 20px !important;
    }
    .straight_line {
        display: none;
    }
    .m_border {
        display: block;
        border-top: 1px solid #988B7A;
        margin: 15px 0px 20px 0px;
    }
    .policy_box {
        padding: 0px 15px 0px 15px;
    }
}
</style>
<div role="main" class="main">
    <section class="page-header no-padding sm-slide-fix">
        <div class="container">
            <div class="row justify-content-center policy_box">
                <div class="col-md-12 text-center">
                    <div class="row">
                        <div class="col-12 col-md-3">
                            <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                                <?if (!empty($standard_page_list)) {
                                    $count = 0;
                                    foreach ($standard_page_list as $spl_row) {
                                        if ($spl_row['page_info'] != '') {?>
                                            <a href="#" class="nav-link nav-tab-link btn <?=($count==0?'active':'')?>" id="<?=$spl_row['page_name']?>-tab" data-toggle="pill" data-target="#<?=$spl_row['page_name']?>" role="tab" aria-controls="<?=$spl_row['page_name']?>" aria-selected="<?=($count==0?'true':'false')?>"><?=$this->lang->line($spl_row['page_name'])?></a>
                                            <?$count++;
                                        }
                                    }
                                }?>
                            </div>
                        </div>
                        <div class="col-12 m_border"></div>
                        <div class="col-12 col-md-9">
                            <div class="straight_line"></div>
                            <div class="tab-content text-justify px-3" id="v-pills-tabContent">
                                <?if (!empty($standard_page_list)) {
                                    $count = 0;
                                    foreach ($standard_page_list as $spl_row) {
                                        if ($spl_row['page_info'] != '') {?>
                                            <div class="tab-pane fade show <?=($count==0?'active':'')?>" id="<?=$spl_row['page_name']?>" role="tabpanel" aria-labelledby="<?=$spl_row['page_name']?>-tab">
                                                <p class="title-text"><?=$spl_row['page_title']?></p>
                                                <p><?=$spl_row['page_info']?></p>
                                            </div>
                                            <?$count++;
                                        }
                                    }
                                }?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
<script>
$(document).ready(function() {
    <?if ($_GET['target'] != '' && !empty($standard_page_list)) {
        $target = $_GET['target'];
        foreach ($standard_page_list as $spl_row) {
            if ($spl_row['page_info'] != '' && $_GET['target'] == $spl_row['page_name']) {
                $target = $spl_row['page_name'];
                echo '$(".nav-tab-link").removeClass("active show");';
                echo '$(".tab-pane").removeClass("active show");';
                echo '$(".nav-tab-link").attr("aria-selected", false);';
            }
        }
        foreach ($standard_page_list as $spl_row) {
            if ($spl_row['page_info'] != '' && $target == $spl_row['page_name']) {
                echo '$("#' . $target . '-tab").addClass("active show");';
                echo '$("#' . $target . '").addClass("active show");';
                echo '$("#' . $target . '-tab").attr("aria-selected", true);';
            }
        }
    }?>
});
$('#v-pills-tab a').on('click', function(event) {
    event.preventDefault()
    $(this).tab('show')
    var w = $(window).width();
    var h = $(window).height();
    var header_h = $("#header").height();
    var footer_h = $("#footer").height();
    var h_sum = h - header_h - footer_h;
    <?if ($this->is_td_stuff) {?>
        $(".tab-pane").css('height', h_sum*0.95);
    <?}?>
    <?if ($this->is_liqun_food) {?>
        if (w < 769) {
            $(".tab-pane").css('height', h_sum*3);
        } else {
            $(".tab-pane").css('height', h_sum*1);
        }
    <?}?>
})
</script>
<!-- Window Height -->
<script>
$(function() {
    var w = $(window).width();
    var h = $(window).height();
    var main_h = $(".main").height();
    var header_h = $("#header").height();
    var footer_h = $("#footer").height();
    var h_sum = h - header_h - footer_h;
    <?if ($this->is_td_stuff) {?>
        $(".tab-pane").css('height', h_sum*0.95);
    <?}?>
    $(".straight_line").css('height', h_sum+50);
    <?if ($this->is_liqun_food) {?>
        if (w < 768) {
            $(".main").css('padding-top', header_h*1.2);
            $(".main").css('padding-bottom', header_h*0.5);
            $(".tab-pane").css('height', h_sum*3);
        } else {
            $(".main").css('padding-top', header_h*2);
            $(".main").css('padding-bottom', header_h*1.2);
            $(".tab-pane").css('height', h_sum*1);
        }
    <?}?>
});
</script>
<!-- Window Height -->