<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>

<!-- BEGIN Navbar -->
<div id="navbar" class="navbar navbar-fixed">
  <button type="button" class="navbar-toggle navbar-btn collapsed" data-toggle="collapse" data-target="#sidebar">
    <span class="fa fa-bars"></span>
  </button>
  <?php if ($this->ion_auth->is_admin()) { ?>
    <a class="navbar-brand" href="<?php echo base_url(); ?>">
      <img src="/assets/uploads/<?php echo get_setting_general('logo'); ?>" class="img-fluid" style="height: 40px; padding: 5px 15px;">
    </a>
  <?php } else { ?>
    <a class="navbar-brand" href="#">
      <img src="/assets/uploads/<?php echo get_setting_general('logo'); ?>" class="img-fluid" style="height: 40px; padding: 5px 15px;">
    </a>
  <?php } ?>
  <!-- BEGIN Navbar Buttons -->
  <ul class="nav flaty-nav pull-right">
    <li class="hidden-sm-down">
      <a href="#">
        <span id="NowTime" style="color: white;"></span>
      </a>
    </li>
    <?php if ($this->is_partnertoys) : ?>
      <!-- paid hint -->
      <li class="hidden-sm-down">
        <a href="/admin/order">
          <?php if (get_unread_order_count() > 0) : ?>
            <span class="MailBox" style="color: #ffff3e; position: relative;">
              <i class="fa fa-balance-scale" aria-hidden="true"></i>
              <span>&nbsp;<?php echo get_unread_order_count(); ?></span>
            </span>
          <?php else : ?>
            <span class="MailBox" style="color: white; position: relative;">
              <i class="fa fa-balance-scale" aria-hidden="true"></i>
            </span>
          <?php endif; ?>
        </a>
      </li>
      <!-- truck hint -->
      <li class="hidden-sm-down">
        <a href="/admin/order">
          <?php if (get_comfire_incomplete_count() > 0) : ?>
            <span class="MailBox" style="color: #f737ea; position: relative;">
              <i class="fa fa-truck" aria-hidden="true"></i>
              <span>&nbsp;<?php echo get_comfire_incomplete_count(); ?></span>
            </span>
          <?php else : ?>
            <span class="MailBox" style="color: white; position: relative;">
              <i class="fa fa-truck" aria-hidden="true"></i>
            </span>
          <?php endif; ?>
        </a>
      </li>
      <!-- mail hint -->
      <li class="hidden-sm-down">
        <a href="/admin/mail">
          <?php if (get_unread_mail_count(0, 'admin') > 0) : ?>
            <span class="MailBox" style="color: #ff4949; position: relative;">
              <i class="fa fa-envelope" aria-hidden="true"></i>
              <span>&nbsp;<?php echo get_unread_mail_count(0, 'admin'); ?></span>
            </span>
          <?php else : ?>
            <span class="MailBox" style="color: white; position: relative;">
              <i class="fa fa-envelope" aria-hidden="true"></i>
            </span>
          <?php endif; ?>
        </a>
      </li>
    <?php endif; ?>
    <!-- END Button Notifications -->
    <?php if (!empty($this->session->userdata('user_id'))) { ?>
      <!-- BEGIN Button User -->
      <li class="user-profile">
        <a data-toggle="dropdown" href="#" class="user-menu dropdown-toggle">
          <i class="fa fa-user"></i>
          <span id="user_info">
            <?php echo $this->session->userdata('identity'); ?>
          </span>
          <i class="fa fa-caret-down"></i>
        </a>
        <!-- BEGIN User Dropdown -->
        <ul class="dropdown-menu dropdown-navbar" id="user_menu">
          <!-- <li class="divider"></li> -->
          <!-- <li><a href="/employee/edit/<?php echo $this->ion_auth->user()->row()->id; ?>"><i class="fa fa-edit"></i> 修改基本資料</a></li> -->
          <!-- <li class="divider"></li> -->
          <li><a href="/admin/auth/edit_user/<?php echo $this->ion_auth->user()->row()->id; ?>"><i class="fa fa-edit"></i> 修改密碼</a></li>
          <!-- <li class="divider"></li> -->
          <?php //echo $admin_user_menu; ;;
          ?>
          <li>
            <a href="/logout">
              <i class="fa fa-power-off"></i> 登出
            </a>
          </li>
        </ul>
        <!-- BEGIN User Dropdown -->
      </li>
      <!-- END Button User -->
    <?php } ?>
  </ul>
  <!-- END Navbar Buttons -->
</div>
<!-- END Navbar -->