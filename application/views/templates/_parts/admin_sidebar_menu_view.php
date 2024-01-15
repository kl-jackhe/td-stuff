<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php $current = $this->uri->segment(2);
$sub_current = $this->uri->segment(3); ?>
<!-- BEGIN Sidebar -->
<div id="sidebar" class="navbar-collapse collapse sidebar-fixed">
  <!-- BEGIN Navlist -->
  <ul class="nav nav-list hidden-print">
    <li class="<?= ($current == "admin") ? "active" : ''; ?>">
      <a href="/admin">
        <i class="fa fa-dashboard"></i>
        <span>控制台</span>
      </a>
    </li>
    <?php if ($this->is_liqun_food || $this->is_td_stuff) : ?>
      <li <?= (($current == "product" && $sub_current != "category") || ($current == "product" && $sub_current == "category")) ? "class='active'" : ''; ?>>
        <a href="#" class="dropdown-toggle">
          <i class="fa fa-shopping-basket"></i>
          <span>商品管理</span>
          <b class="arrow fa fa-angle-right"></b>
        </a>
        <ul class="submenu">
          <li <?= ($current == "product" && $sub_current == "category") ? 'class="active"' : ""; ?>>
            <a href="/admin/product/category">商品分類</a>
          </li>
          <li <?= ($current == "product" && $sub_current != "category") ? 'class="active"' : ''; ?>>
            <a href="/admin/product">商品清單</a>
          </li>
        </ul>
      </li>
    <?php elseif ($this->is_partnertoys) : ?>
      <li class="<?= ($current == "product") ? "active" : ''; ?>">
        <a href="/admin/product">
          <i class="fa fa-shopping-basket"></i>
          <span>商品管理</span>
        </a>
      </li>
    <?php endif; ?>
    <li class="<?= ($current == "order") ? "active" : ''; ?>">
      <a href="/admin/order">
        <i class="fa-solid fa-list-check"></i>
        <span>訂單管理</span>
      </a>
    </li>
    <? if ($this->is_partnertoys) { ?>
      <li class="<?= ($current == "lottery") ? "active" : ''; ?>">
        <a href="/admin/lottery">
          <i class="fa-solid fa-gifts"></i>
          <span>抽選管理</span>
        </a>
      </li>
      <!-- <li class="<?php if ($current == "mail") {
                        echo "active";
                      } ?>">
      <a href="/admin/mail">
        <i class="fa-solid fa-envelopes-bulk"></i>
        <span>郵件管理</span>
      </a>
    </li> -->
    <? } ?>
    <? if ($this->is_td_stuff || $this->is_liqun_food) { ?>
      <li <?= ($sub_current == "page" || $sub_current == "history") ? "class='active'" : ''; ?>>
        <a href="#" class="dropdown-toggle">
          <i class="fa-solid fa-file-circle-check"></i>
          <span>銷售管理</span>
          <b class="arrow fa fa-angle-right"></b>
        </a>
        <ul class="submenu">
          <li <?= ($sub_current == "page") ? 'class="active"' : ''; ?>>
            <a href="/admin/sales/page">銷售頁面</a>
          </li>
          <li <?= ($sub_current == "history") ? 'class="active"' : ''; ?>>
            <a href="/admin/sales/history">銷售紀錄</a>
          </li>
        </ul>
      </li>
      <li class="<?= ($current == "agent") ? "active" : ''; ?>">
        <a href="/admin/agent">
          <i class="fa-solid fa-handshake"></i>
          <span>代言人管理</span>
        </a>
      </li>
    <? }
    if ($this->is_liqun_food) { ?>
      <!-- <li <?php if ($sub_current == "page" || $sub_current == "history") {
                  echo "class='active'";
                } ?>>
      <a href="#" class="dropdown-toggle">
        <i class="fa-solid fa-id-card-clip"></i>
        <span>加盟主管理</span>
        <b class="arrow fa fa-angle-right"></b>
      </a>
      <ul class="submenu">
        <li <?php if ($sub_current == "history") {
              echo 'class="active"';
            } ?>>
          <a href="/admin/franchisee/history">銷售紀錄</a>
        </li>
        <li <?php if ($sub_current == "pages") {
              echo 'class="active"';
            } ?>>
          <a href="/admin/franchisee/pages">頁面管理</a>
        </li>
        <li <?php if ($sub_current == "auth") {
              echo 'class="active"';
            } ?>>
          <a href="/admin/franchisee/auth">帳號管理</a>
        </li>
      </ul>
    </li> -->
    <? } ?>
    <li class="<?= ($current == "delivery") ? "active" : ''; ?>">
      <a href="/admin/delivery">
        <i class="fa fa-truck"></i>
        <span>配送管理</span>
      </a>
    </li>
    <li class="<?= ($current == "payment") ? "active" : ''; ?>">
      <a href="/admin/payment">
        <i class="fa fa-credit-card-alt"></i>
        <span>支付管理</span>
      </a>
    </li>
    <li class="<?= ($current == "posts") ? "active" : ''; ?>">
      <a href="/admin/posts">
        <i class="fa-solid fa-newspaper"></i>
        <span>最新消息</span>
      </a>
    </li>
    <li class="<?= ($current == "banner") ? "active" : ''; ?>">
      <a href="/admin/banner">
        <i class="fas fa-ad"></i>
        <span>首頁輪播</span>
      </a>
    </li>
    <?php if ($this->is_partnertoys) : ?>
      <li class="<?= ($current == "menu") ? "active" : ''; ?>">
        <a href="/admin/menu">
          <i class="fa-solid fa-file-lines"></i>
          <span>選單管理</span>
        </a>
      </li>
    <?php endif; ?>
    <?php if ($this->is_liqun_food) : ?>
      <li class="<?= ($current == "coupon") ? "active" : ''; ?>">
        <a href="/admin/coupon">
          <i class="fa-solid fa-file-lines"></i>
          <span>優惠券管理</span>
        </a>
      </li>
    <?php endif; ?>
    <li class="<?= ($current == "StandardPage") ? "active" : ''; ?>">
      <a href="/admin/StandardPage">
        <i class="fa-regular fa-file-word"></i>
        <span>制式頁面管理</span>
      </a>
    </li>
    <li class="<?= ($current == "user") ? "active" : ''; ?>">
      <a href="/admin/user">
        <i class="fa-solid fa-people-group"></i>
        <span>會員管理</span>
      </a>
    </li>
    <li class="<?= ($current == "auth") ? "active" : ''; ?>">
      <a href="/admin/auth">
        <i class="fa-solid fa-user-gear"></i>
        <span>管理員</span>
      </a>
    </li>
    <li class="<?= ($current == "setting") ? "active" : ''; ?>">
      <a href="/admin/setting/general">
        <i class="fa fa-cogs"></i>
        <span>全站設定</span>
      </a>
    </li>
  </ul>
  <!-- END Navlist -->
  <!-- BEGIN Sidebar Collapse Button -->
  <!-- <div id="sidebar-collapse" class="hidden-print"></div> -->
  <!-- END Sidebar Collapse Button -->
</div>
<!-- END Sidebar -->