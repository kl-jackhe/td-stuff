<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<!DOCTYPE html>
<html>
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo $page_title; ?></title>
    <?php echo $include_style; ?>
  </head>
  <style>
    .nav-list>li>a {
      padding: 0px 15px 0px 15px!important;
    }
  </style>
<body class="skin-blue">

<?php echo $admin_navbar_menu; ?>

<!-- BEGIN Container -->
<div class="container" id="main-container">

  <img src="/assets/images/loading.gif" id="loading" style="width: 75px; position: fixed; right: 50px; top: 50px; z-index: 999; display: none;">

  <?php echo $admin_sidebar_menu; ?>

  <!-- BEGIN Content -->
  <div id="main-content">
    <!-- BEGIN Main Content -->
    <div class="row">
      <div class="col-md-12" style="padding: 0px 5px;">
        <div class="box">
          <div class="box-title hidden-print">
            <h3><?php echo $page_title; ?></h3>
          </div>
          <div class="box-content">
            <?php if ($this->session->flashdata('message')) {?>
              <div class="alert alert-warning alert-dismissible hidden-print" role="alert" style="position: fixed; right: 10px; top: 45px; z-index: 9;">
                <!-- <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button> -->
                <h3 style="margin: 0; padding: 0;"><?php echo $this->session->flashdata('message'); ?></h3>
              </div>
            <?php }?>
            <?php if ($this->session->flashdata('error_message')) {?>
              <div class="alert alert-danger alert-dismissible hidden-print" role="alert" style="position: fixed; right: 10px; top: 45px; z-index: 9;">
                <!-- <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button> -->
                <h3 style="margin: 0; padding: 0;"><?php echo $this->session->flashdata('error_message'); ?></h3>
              </div>
            <?php }?>