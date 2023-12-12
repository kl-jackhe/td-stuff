<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<?php $current = $this->uri->segment(2);
$sales_current = $this->uri->segment(3);?>
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
        <i class="fa fa-shopping-basket"></i>
        <span>商品管理</span>
      </a>
    </li>
    <li class="<?php if ($current == "order") {echo "active";}?>">
      <a href="/admin/order">
        <i class="fa-solid fa-list-check"></i>
        <span>訂單管理</span>
      </a>
    </li>
    <?if ($this->is_partnertoys) {?>
    <li class="<?php if ($current == "lottery") {echo "active";}?>">
      <a href="/admin/lottery">
        <i class="fa-solid fa-gifts"></i>
        <span>抽選管理</span>
      </a>
    </li>
    <!-- <li class="<?php if ($current == "mail") {echo "active";}?>">
      <a href="/admin/mail">
        <i class="fa-solid fa-envelopes-bulk"></i>
        <span>郵件管理</span>
      </a>
    </li> -->
    <?}?>
    <?if ($this->is_td_stuff || $this->is_liqun_food) {?>
    <li <?php if ($sales_current == "page" || $sales_current == "history") {echo "class='active'";}?>>
      <a href="#" class="dropdown-toggle">
        <i class="fa-solid fa-file-circle-check"></i>
        <span>銷售管理</span>
        <b class="arrow fa fa-angle-right"></b>
      </a>
      <ul class="submenu">
        <li <?php if ($sales_current == "page") {echo 'class="active"';}?>>
          <a href="/admin/sales/page">銷售頁面</a>
        </li>
        <li <?php if ($sales_current == "history") {echo 'class="active"';}?>>
          <a href="/admin/sales/history">銷售紀錄</a>
        </li>
      </ul>
    </li>
    <li class="<?php if ($current == "agent") {echo "active";}?>">
      <a href="/admin/agent">
        <i class="fa-solid fa-handshake"></i>
        <span>代言人管理</span>
      </a>
    </li>
    <li <?php if ($sales_current == "page" || $sales_current == "history") {echo "class='active'";}?>>
      <a href="#" class="dropdown-toggle">
        <i class="fa-solid fa-id-card-clip"></i>
        <span>加盟主管理</span>
        <b class="arrow fa fa-angle-right"></b>
      </a>
      <ul class="submenu">
        <li <?php if ($sales_current == "history") {echo 'class="active"';}?>>
          <a href="/admin/franchise/history">銷售紀錄</a>
        </li>
        <li <?php if ($sales_current == "pages") {echo 'class="active"';}?>>
          <a href="/admin/franchise/pages">頁面管理</a>
        </li>
        <li <?php if ($sales_current == "auth") {echo 'class="active"';}?>>
          <a href="/admin/franchise/auth">帳號管理</a>
        </li>
      </ul>
    </li>
    <?}?>
    <li class="<?php if ($current == "delivery") {echo "active";}?>">
      <a href="/admin/delivery">
        <i class="fa fa-truck"></i>
        <span>配送管理</span>
      </a>
    </li>
    <li class="<?php if ($current == "payment") {echo "active";}?>">
      <a href="/admin/payment">
        <i class="fa fa-credit-card-alt"></i>
        <span>支付管理</span>
      </a>
    </li>
    <li class="<?php if ($current == "posts") {echo "active";}?>">
      <a href="/admin/posts">
        <i class="fa-solid fa-newspaper"></i>
        <span>最新消息</span>
      </a>
    </li>
    <li class="<?php if ($current == "banner") {echo "active";}?>">
      <a href="/admin/banner">
        <i class="fas fa-ad"></i>
        <span>首頁輪播</span>
      </a>
    </li>
    <li class="<?php if ($current == "user") {echo "active";}?>">
      <a href="/admin/user">
        <i class="fa-solid fa-people-group"></i>
        <span>會員管理</span>
      </a>
    </li>
    <li class="<?php if ($current == "auth") {echo "active";}?>">
      <a href="/admin/auth">
        <i class="fa-solid fa-user-gear"></i>
        <span>管理員</span>
      </a>
    </li>
    <li class="<?php if ($current == "setting") {echo "active";}?>">
      <a href="/admin/setting/general">
        <i class="fa fa-cogs"></i>
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