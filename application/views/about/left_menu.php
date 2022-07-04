<?php $current = $this->uri->segment(2); ?>
<div class="box">
     <div class="col-md-3 mb-lg">
        <ul class="nav nav-list leftlist">
            <li <?php if($current=='brand'){echo "class='active'";} ?>>
                <a href="/about/brand">品牌介紹</a>
            </li>
            <li <?php if($current=='history'){echo "class='active'";} ?>>
                <a href="/about/history">創業故事</a>
            </li>
            <!-- <li <?php if($current=='team'){echo "class='active'";} ?>>
                <a href="/about/team">車隊介紹</a>
            </li> -->
            <li <?php if($current=='cross_industry_alliance' || $current=='shop_alliance'){echo "echo class='active'";} ?>>
                <a href="/about/cross_industry_alliance" data-parent=".leftlist" data-toggle="collapse" data-target=".corp" aria-expanded="false">合作機會
                    <!-- <i class="fa fa-bars"></i> -->
                </a>
            </li>
            <ul class="corp collapse <?php if($current=='cross_industry_alliance' || $current=='shop_alliance'){echo "in";} ?>">
                <li <?php if($current=='cross_industry_alliance'){echo "class='active'";} ?>>
                    <a href="/about/cross_industry_alliance">異業合作</a>
                </li>
                <li <?php if($current=='shop_alliance'){echo "class='active'";} ?>>
                    <a href="/about/shop_alliance">店家合作</a>
                </li>
            </ul>
            <li <?php if($current=='how_to_buy'){echo "class='active'";} ?>>
                <a href="/about/how_to_buy">收費方式</a>
            </li>
        </ul>
    </div>