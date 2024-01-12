<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="description" content="<?php echo get_setting_general('meta_description') ?>" />
    <meta name="keywords" content="<?php echo get_setting_general('meta_keywords') ?>" />
    <meta property="og:locale" content="zh_TW" />
    <meta property="og:type" content="website" />
    <meta property="og:title" content="<?php echo $page_title; ?> | <?php echo get_setting_general('name') ?>" />
    <meta property="og:url" content="<?php echo base_url() ?>" />
    <meta property="og:site_name" content="<?php echo get_setting_general('name') ?>" />
    <meta property="og:image" content="<?php echo base_url() ?>assets/uploads/<?php echo get_setting_general('logo') ?>" />
    <meta name="twitter:card" content="<?php echo base_url() ?>assets/uploads/<?php echo get_setting_general('logo') ?>" />
    <meta name="twitter:title" content="<?php echo $page_title; ?> | <?php echo get_setting_general('name') ?>" />
    <title><?php echo $page_title; ?> | <?php echo get_setting_general('name') ?></title>
    <!-- Web Fonts  -->
    <link rel="icon" href="/favicon.ico" type="image/x-icon">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800%7CShadows+Into+Light" rel="stylesheet" type="text/css">
    <link href="/assets/bootstrap-4.2.1-dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">
    <link href="/assets/fontawesome-free-6.1.1-web/css/all.css" rel="stylesheet">
    <link href="/assets/fontawesome-free-6.1.1-web/css/fontawesome.css" rel="stylesheet">
    <link href="/assets/fontawesome-free-6.1.1-web/css/brands.css" rel="stylesheet">
    <link href="/assets/fontawesome-free-6.1.1-web/css/solid.css" rel="stylesheet">
    <link href="/assets/jquery.steps-1.1.0/jquery.steps.css" rel="stylesheet">
    <link href="/assets/jquery.steps-1.1.0/main.css" rel="stylesheet">
    <link href="/assets/jquery.steps-1.1.0/normalize.css" rel="stylesheet">
    <?php if ($this->is_partnertoys) : ?>
        <link href="/assets/css/partnertoysPage.css" rel="stylesheet">
        <link href="/assets/magnific-popup/magnific-popup.css" rel="stylesheet">
    <?php endif; ?>
    <script src="/node_modules/jquery/dist/jquery.min.js"></script>
    <?php if ($this->is_partnertoys) : ?>
        <script src="/assets/magnific-popup/jquery.magnific-popup.min.js"></script>
    <?php endif; ?>
    <script src="https://cdn.jsdelivr.net/npm/vue@3"></script>
    <script src="https://unpkg.com/vue@next"></script>
    <script src="https://unpkg.com/vue-router@4"></script>
</head>
<style>
    .top_logo_style {
        max-width: <?= (get_setting_general('logo_max_width') != '' ? get_setting_general('logo_max_width') . 'px' : '130px') ?>;
        position: absolute;
        transform: translate(-50%, -50%);
        left: 50%;
        top: 40%;
    }
</style>

<body>
    <div class="body h-100">
        <header id="header">
            <div id="headerApp">
                <div class="container-fluid">
                    <div id="absoluteHeader">
                        <div class="container">
                            <!-- 登入顯示 -->
                            <div id="mem_login">
                                <?php
                                // echo '<pre>';
                                // print_r($this->session->userdata());
                                // echo '</pre>';
                                ?>
                                <?php if (!empty($this->session->userdata('username'))) :  ?>
                                    <i class="fas fa-user"></i>：<?= $this->session->userdata('username') ?>
                                    <span class="logoutBnt" @click="confirmLogout"><i class="fa fa-sign-out" aria-hidden="true"></i>登出</span>
                                <?php else : ?>
                                    <i class="fas fa-user"></i>：訪客
                                <?php endif; ?>
                            </div>
                            <!-- 常駐ICON -->
                            <ul class="header-icons">
                                <li>
                                    <a href="javascript:void(0);" id="searchLink" class="search-icon">
                                        <i class="fas fa-search"></i>
                                    </a>
                                </li>
                                <li>
                                    <a href="/auth">
                                        <i class="fas fa-user"></i>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="row py-2 justify-content-center header_fixed_top">
                        <div class="col-5 col-md-3 col-lg-2" style="align-self: center;">
                            <a href="<?php echo base_url() ?>">
                                <img class="header_logo" src="/assets/uploads/<?php echo get_setting_general('logo'); ?>">
                            </a>
                        </div>
                        <!-- PC -->
                        <div class="header-main-nav col-md-6 col-lg-7 d-none d-md-none d-lg-block d-xl-block" style="align-self: center;">
                            <div class="row justify-content-end">
                                <?php if (!empty($header_menu = $this->menu_model->getMenuData())) : ?>
                                    <?php foreach ($header_menu as $key => $self) : ?>
                                        <?php if (!empty($self['status'])) : ?>
                                            <?php if (mb_substr($self['name'], 0, 4, 'utf-8') != '會員專區') : ?>
                                                <div class="menu-item" onmouseover="switchMenu(this, 'SubMenu<?= $key ?>', 'MouseOver')" onmouseout="hideSubMenu('SubMenu<?= $key ?>')">
                                                    <a href="/<?= $self['code'] ?>" class="nav_item_style main-menu"><?= $self['name'] ?></a>
                                                    <!-- 子選單 -->
                                                    <?php if (!empty($header_sub_menu = $this->menu_model->getSubMenuData(0, $self['id']))) : ?>
                                                        <ul id="SubMenu<?= $key ?>" class="sub-menu">
                                                            <?php foreach ($header_sub_menu as $sub_key => $sub_self) : ?>
                                                                <?php if (!empty($sub_self['status'])) : ?>
                                                                    <li><a href="/<?= $self['code'] ?>/index?id=<?= $sub_self['sort'] ?>"><?= $sub_self['name'] ?></a></li>
                                                                <?php endif; ?>
                                                            <?php endforeach; ?>
                                                        </ul>
                                                    <?php endif; ?>
                                                </div>
                                            <?php elseif (!empty($this->session->userdata('username')) && $self['name'] == '會員專區(會員)' || empty($this->session->userdata('username')) && $self['name'] == '會員專區(訪客)') : ?>
                                                <!-- 會員選單 -->
                                                <div class="menu-item" onmouseover="switchMenu(this, 'SubMenu<?= $key ?>', 'MouseOver')" onmouseout="hideSubMenu('SubMenu<?= $key ?>')">
                                                    <a href="/<?= $self['code'] ?>" class="nav_item_style main-menu"><?= mb_substr($self['name'], 0, 4, 'utf-8') ?></a>
                                                    <!-- 子選單 -->
                                                    <?php if (!empty($header_sub_menu = $this->menu_model->getSubMenuData(0, $self['id']))) : ?>
                                                        <ul id="SubMenu<?= $key ?>" class="sub-menu">
                                                            <?php foreach ($header_sub_menu as $sub_key => $sub_self) : ?>
                                                                <?php if (!empty($sub_self['status'])) : ?>
                                                                    <li><a href="/<?= $self['code'] ?>/index?id=<?= $sub_self['sort'] ?>"><?= $sub_self['name'] ?></a></li>
                                                                <?php endif; ?>
                                                            <?php endforeach; ?>
                                                        </ul>
                                                    <?php endif; ?>
                                                </div>
                                            <?php endif; ?>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="header-main-nav col-7 d-block d-md-block d-lg-none d-xl-none p-0" style="align-self: center;">
                            <nav class="navbar navbar-expand-lg navbar-light" style="float: right;">
                                <!-- <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarToggler" aria-controls="navbarToggler" aria-expanded="false" aria-label="Toggle navigation" style="border:none;">
                                    <img src="/assets/images/559mall_official/icon/web%20icon_menu.png" style="width:30px;">
                                </button> -->
                                <a onclick="toggleMobile()">
                                    <img src="/assets/images/559mall_official/icon/web%20icon_menu.png" style="width:30px;">
                                </a>
                            </nav>
                        </div>
                    </div>
                </div>
                <!-- 待修 -->
                <!-- Mobile -->
                <div id="mobileMenu" style="display: none;">
                    <div class="mobile-header-container">
                        <ul class="navbar-nav" id="mobileNav">
                            <!-- Mobile Header -->
                            <?php foreach ($header_menu as $self) : ?>
                                <?php if (!empty($self['status'])) : ?>
                                    <?php if (mb_substr($self['name'], 0, 4, 'utf-8') != '會員專區') : ?>
                                        <li class="navBorderBottom">
                                            <!-- <a href="/<?= $self['code'] ?>" class="nav_item_style"><?= $self['name'] ?></a> -->
                                            <div class="nav_item_mb_style">
                                                <a onclick="toggleMobileMenu('<?= $self['id'] ?>')" class="nav_item_style"><?= $self['name'] ?></a>
                                            </div>
                                            <?php if (!empty($header_sub_menu = $this->menu_model->getSubMenuData(0, $self['id']))) : ?>
                                                <ul class="mobile-menu-list" id="mobileMenu<?= $self['id'] ?>" style="display: none;">
                                                    <?php foreach ($header_sub_menu as $sub_key => $sub_self) : ?>
                                                        <?php if (!empty($sub_self['status'])) : ?>
                                                            <li class="mobileSubMenu"><a href="/<?= $self['code'] ?>/index?id=<?= $sub_self['sort'] ?>"><?= $sub_self['name'] ?></a></li>
                                                        <?php endif; ?>
                                                    <?php endforeach; ?>
                                                </ul>
                                            <?php endif; ?>
                                        </li>
                                    <?php elseif (!empty($this->session->userdata('username')) && $self['name'] == '會員專區(會員)' || empty($this->session->userdata('username')) && $self['name'] == '會員專區(訪客)') : ?>
                                        <li class="navBorderBottom">
                                            <div class="nav_item_mb_style">
                                                <!-- <a href="/<?= $self['code'] ?>" class="nav_item_style"><?= mb_substr($self['name'], 0, 4, 'utf-8') ?></a> -->
                                                <a onclick="toggleMobileMenu('<?= $self['id'] ?>')" class="nav_item_style"><?= mb_substr($self['name'], 0, 4, 'utf-8') ?></a>
                                            </div>
                                            <?php if (!empty($header_sub_menu = $this->menu_model->getSubMenuData(0, $self['id']))) : ?>
                                                <ul class="mobile-menu-list" id="mobileMenu<?= $self['id'] ?>" style="display: none;">
                                                    <?php foreach ($header_sub_menu as $sub_key => $sub_self) : ?>
                                                        <?php if (!empty($sub_self['status'])) : ?>
                                                            <li class="mobileSubMenu"><a href="/<?= $self['code'] ?>/index?id=<?= $sub_self['sort'] ?>"><?= $sub_self['name'] ?></a></li>
                                                        <?php endif; ?>
                                                    <?php endforeach; ?>
                                                </ul>
                                            <?php endif; ?>
                                        </li>
                                    <?php endif; ?>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                </div>
        </header>