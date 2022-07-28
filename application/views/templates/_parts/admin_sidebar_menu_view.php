<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<?php $current = $this->uri->segment(2);?>
<!-- BEGIN Sidebar -->
<div id="sidebar" class="navbar-collapse collapse sidebar-fixed">
  <!-- BEGIN Navlist -->
  <ul class="nav nav-list hidden-print">
    <li class="<?php if (($current == "admin")) {echo "active";}?>">
      <a href="/admin">
        <i class="fa fa-dashboard"></i>
        <span>控制台</span>
      </a>
    </li>
    <li class="<?php if ($current == "product") {echo "active";}?>">
      <a href="/admin/product">
        <i class="fa fa-dashboard"></i>
        <span>商品管理</span>
      </a>
    </li>
    <li class="<?php if ($current == "order") {echo "active";}?>">
      <a href="/admin/order">
        <i class="fa fa-dashboard"></i>
        <span>訂單管理</span>
      </a>
    </li>
    <!-- <li class="<?php if ($current == "store") {echo "active";}?>">
      <a href="/admin/store">
        <i class="fa fa-dashboard"></i>
        <span>店家管理</span>
      </a>
    </li> -->
    <li class="<?php if ($current == "posts") {echo "active";}?>">
      <a href="/admin/posts">
        <i class="fa fa-dashboard"></i>
        <span>最新消息管理</span>
      </a>
    </li>
    <li <?php if ($current == "banner" || $current == "product_banner" || $current == "coupon") {echo "class='active'";}?>>
      <a href="#" class="dropdown-toggle">
        <i class="fa fa-dashboard"></i>
        <span>活動行銷管理</span>
        <b class="arrow fa fa-angle-right"></b>
      </a>
      <ul class="submenu">
        <li <?php if ($current == "banner") {echo 'class="active"';}?>>
          <a href="/admin/banner">首頁Banner</a>
        </li>
      </ul>
    </li>
    <li <?php if ($current == "user" || $current == "driver" || $current == "auth") {echo "class='active'";}?>>
      <a href="#" class="dropdown-toggle">
        <i class="fa fa-dashboard"></i>
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
    <!-- <li>
      <a href="/assets/admin/ckfinder/samples/full-page-open.html" target="_blank">
        <i class="fa fa-dashboard"></i>
        <span>檔案管理</span>
      </a>
    </li> -->
    <li class="<?php if ($current == "setting") {echo "active";}?>">
      <a href="/admin/setting/general">
        <i class="fa fa-dashboard"></i>
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