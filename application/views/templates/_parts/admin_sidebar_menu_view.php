<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<?php $current = $this->uri->segment(2);?>
<!-- BEGIN Sidebar -->
<div id="sidebar" class="navbar-collapse collapse sidebar-fixed">
  <!-- BEGIN Navlist -->
  <ul class="nav nav-list hidden-print">
    <li class="<?php if (($current == "admin")) {echo "active";}?>">
      <a href="/admin">
        <span>控制台</span>
      </a>
    </li>
    <li class="<?php if ($current == "product") {echo "active";}?>">
      <a href="/admin/product">
        <span>商品管理</span>
      </a>
    </li>
    <li class="<?php if ($current == "order") {echo "active";}?>">
      <a href="/admin/order">
        <span>訂單管理</span>
      </a>
    </li>
    <li class="<?php if ($current == "store") {echo "active";}?>">
      <a href="/admin/store">
        <span>店家管理</span>
      </a>
    </li>
    <li class="<?php if ($current == "store_order_time_area") {echo "active";}?>">
      <a href="/admin/store_order_time_area">
        <span>可訂購時段管理</span>
      </a>
    </li>
    <li class="<?php if ($current == "store_order_time") {echo "active";}?>">
      <a href="/admin/store_order_time">
        <span>可訂購時段管理</span>
      </a>
    </li>
    <li <?php if ($current == "delivery_place" || $current == "service_area" || $current == "meal_time") {echo "class='active'";}?>>
      <a href="#" class="dropdown-toggle">
        <span>取餐管理</span>
        <b class="arrow fa fa-angle-right"></b>
      </a>
      <ul class="submenu">
        <!-- <li <?php if ($current == "delivery_place") {echo 'class="active"';}?>>
          <a href="/admin/delivery_place">取餐點管理</a>
        </li> -->
        <li <?php if ($current == "service_area") {echo 'class="active"';}?>>
          <a href="/admin/service_area">開放區域管理</a>
        </li>
        <li <?php if ($current == "meal_time") {echo 'class="active"';}?>>
          <a href="/admin/meal_time">用餐時段管理</a>
        </li>
      </ul>
    </li>
    <li <?php if ($current == "banner" || $current == "product_banner" || $current == "coupon") {echo "class='active'";}?>>
      <a href="#" class="dropdown-toggle">
        <span>活動行銷管理</span>
        <b class="arrow fa fa-angle-right"></b>
      </a>
      <ul class="submenu">
        <li <?php if ($current == "banner") {echo 'class="active"';}?>>
          <a href="/admin/banner">首頁Banner</a>
        </li>
        <!-- <li <?php if ($current == "product_banner") {echo 'class="active"';}?>>
          <a href="/admin/product_banner">商品頁Banner</a>
        </li> -->
        <li <?php if ($current == "coupon" && $this->uri->segment(3) == '') {echo 'class="active"';}?>>
          <a href="/admin/coupon">優惠券管理</a>
        </li>
        <li <?php if ($current == "coupon" && $this->uri->segment(3) == 'all_coupon') {echo 'class="active"';}?>>
          <a href="/admin/coupon/all_coupon">全站優惠設定</a>
        </li>
        <li <?php if ($current == "coupon" && $this->uri->segment(3) == 'recommend_coupon') {echo 'class="active"';}?>>
          <a href="/admin/coupon/recommend_coupon">推薦碼優惠券設定</a>
        </li>
      </ul>
    </li>
    <li class="<?php if ($current == "posts") {echo "active";}?>">
      <a href="/admin/posts">
        <span>最新消息管理</span>
      </a>
    </li>
    <li <?php if ($current == "about") {echo "class='active'";}?>>
      <a href="#" class="dropdown-toggle">
        <span>頁面管理</span>
        <b class="arrow fa fa-angle-right"></b>
      </a>
      <ul class="submenu">
        <!-- <li <?php if (($this->uri->segment(3) == "brand")) {echo 'class="active"';}?>>
          <a href="/admin/about/brand">品牌介紹</a>
        </li>
        <li <?php if (($this->uri->segment(3) == "history")) {echo 'class="active"';}?>>
          <a href="/admin/about/history">創業故事</a>
        </li>
        <li <?php if (($this->uri->segment(3) == "team")) {echo 'class="active"';}?>>
          <a href="/admin/about/team">車隊介紹</a>
        </li>
        <li <?php if (($this->uri->segment(3) == "cross_industry_alliance")) {echo 'class="active"';}?>>
          <a href="/admin/about/cross_industry_alliance">異業合作</a>
        </li>
        <li <?php if (($this->uri->segment(3) == "shop_alliance")) {echo 'class="active"';}?>>
          <a href="/admin/about/shop_alliance">店家合作</a>
        </li>
        <li <?php if (($this->uri->segment(3) == "how_to_buy")) {echo 'class="active"';}?>>
          <a href="/admin/about/how_to_buy">收費方式</a>
        </li> -->
        <li <?php if (($this->uri->segment(3) == "privacy_policy")) {echo 'class="active"';}?>>
          <a href="/admin/about/privacy_policy">隱私權保護政策</a>
        </li>
        <li <?php if (($this->uri->segment(3) == "rule")) {echo 'class="active"';}?>>
          <a href="/admin/about/rule">使用條款與條件</a>
        </li>
      </ul>
    </li>
    <!-- <li <?php if ($current == "shop_alliance" || $current == "cross_industry_alliance") {echo "class='active'";}?>>
      <a href="#" class="dropdown-toggle">
        <span>表單回應管理</span>
        <b class="arrow fa fa-angle-right"></b>
      </a>
      <ul class="submenu">
        <li <?php if (($current == "shop_alliance")) {echo 'class="active"';}?>>
          <a href="/admin/shop_alliance">店家合作</a>
        </li>
        <li <?php if (($current == "cross_industry_alliance")) {echo 'class="active"';}?>>
          <a href="/admin/cross_industry_alliance">異業合作</a>
        <li>
      </ul>
    </li> -->
    <li <?php if ($current == "user" || $current == "driver" || $current == "auth") {echo "class='active'";}?>>
      <a href="#" class="dropdown-toggle">
        <span>帳號管理</span>
        <b class="arrow fa fa-angle-right"></b>
      </a>
      <ul class="submenu">
        <li <?php if ($current == "user") {echo 'class="active"';}?>>
          <a href="/admin/user">使用者管理</a>
        </li>
        <!-- <li <?php if ($current == "driver") {echo 'class="active"';}?>>
          <a href="/admin/driver">司機管理</a>
        </li> -->
        <li <?php if ($current == "auth") {echo 'class="active"';}?>>
          <a href="/admin/auth">管理員系統</a>
        </li>
      </ul>
    </li>
    <li>
      <a href="/assets/admin/ckfinder/samples/full-page-open.html" target="_blank">
        <span>檔案管理</span>
      </a>
    </li>
    <li class="<?php if ($current == "setting") {echo "active";}?>">
      <a href="/admin/setting/general">
        <span>全站設定</span>
      </a>
    </li>
  </ul>
  <!-- END Navlist -->
  <!-- BEGIN Sidebar Collapse Button -->
  <div id="sidebar-collapse" class="hidden-print">
  </div>
  <!-- END Sidebar Collapse Button -->
</div>
<!-- END Sidebar -->