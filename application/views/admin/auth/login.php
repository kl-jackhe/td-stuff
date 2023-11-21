<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<!DOCTYPE html>
<html>
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>登入</title>
  <link rel="stylesheet" href="/assets/admin/bootstrap/dist/css/bootstrap.min.css?v=3.3.7">
  <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/css/bootstrap.min.css"> -->
  <link rel="stylesheet" href="/node_modules/font-awesome/css/font-awesome.min.css?v=4.7.0">
  <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"> -->
  <link rel="stylesheet" href="/assets/admin/css/flaty.css">
  <link rel="stylesheet" href="/assets/admin/css/flaty-responsive.css">
  <link rel="stylesheet" href="/assets/admin/jqueryui/1.12.1/jquery-ui.min.css">
  <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.css"> -->
  <link rel="stylesheet" href="/assets/admin/keyboard/keyboard.css">
  <style>
    .ui-widget button{
      font-size: 1.5em;
    }
  </style>
</head>
<body class="login-page" onload="document.getElementById('identity').focus();">
  <!-- BEGIN Main Content -->
    <div class="login-wrapper">
      <!-- BEGIN Login Form -->

      <?php echo form_open("login"); ?>
        <img src="/assets/uploads/<?php echo get_setting_general('logo') ?>" class="img-responsive" style="margin: 0 auto;">
        <!-- <h3>登入您的帳號</h3> -->
        <hr/>
        <?php if ($this->session->flashdata('message')) {?>
          <div class="alert alert-danger" role="alert">
            <?php echo $this->session->flashdata('message'); ?>
          </div>
        <?php }?>
        <div class="input-group">
          <!-- <div class="controls"> -->
            <?php $identity = array(
	'type' => 'text',
	'name' => 'identity',
	'id' => 'identity',
	'value' => '',
	'class' => 'form-control',
	'placeholder' => '使用者名稱',
);?>
            <?php echo form_input($identity); ?>
            <span class="input-group-addon" id="identity_keyboard" style="border:none; color: #555;"><i class="fa fa-keyboard-o"></i></span>
          <!-- </div> -->
        </div>
        <div class="input-group">
          <!-- <div class="controls"> -->
          <?php $password = array(
	'type' => 'password',
	'name' => 'password',
	'id' => 'password',
	'value' => '',
	'class' => 'form-control',
	'placeholder' => '密碼',
);?>
          <?php echo form_input($password); ?>
          <span class="input-group-addon" id="password_keyboard" style="border:none; color: #555;"><i class="fa fa-keyboard-o"></i></span>
          <!-- </div> -->
        </div>
        <div class="form-group">
          <div class="controls">
              <label class="checkbox">
                  <?php echo form_checkbox('remember', '1', FALSE, 'id="remember"'); ?> 記住我的登入資訊
              </label>
          </div>
        </div>
        <div class="form-group">
          <div class="controls">
            <button type="submit" class="btn btn-primary form-control">登入</button>
          </div>
        </div>
        <hr>
        <h5 class="text-center">Copyright © 2022  <?=get_setting_general('name')?>.<br>All rights reserved.</h5>
      <?php echo form_close(); ?>
      <script src="/node_modules/jquery/dist/jquery.min.js"></script>
      <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script> -->
      <script src="/node_modules/jquery-migrate/dist/jquery-migrate.min.js"></script>
      <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-migrate/3.0.1/jquery-migrate.min.js"></script> -->
      <script src="/node_modules/bootstrap/dist/js/bootstrap.min.js?v=3.3.7"></script>
      <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/js/bootstrap.min.js"></script> -->
      <script src="/assets/admin/keyboard/jquery.keyboard.js"></script>
      <script>
        $(document).ready(function() {
          // $('#identity').keyboard();
          // $('#password').keyboard();
          // $('#identity_keyboard').click(function(){
          //   //onload="document.getElementById('identity').focus();"
          //   document.getElementById('identity').focus();
          // });
          // $('#password_keyboard').click(function(){
          //   document.getElementById('password').focus();
          // });
          $('#identity').keyboard({
            openOn   : null,
            // stayOpen : true,
            layout   : 'qwerty',
            display : {
              'a'      : '\u2714:Accept (Shift+Enter)', // check mark - same action as accept
              'accept' : '確認:Accept (Shift+Enter)',
              'alt'    : 'AltGr:Alternate Graphemes',
              'b'      : '\u2190:Backspace',    // Left arrow (same as &larr;)
              'bksp'   : 'Bksp:Backspace',
              'c'      : '\u2716:Cancel (Esc)', // big X, close - same action as cancel
              'cancel' : '取消:Cancel (Esc)',
              'clear'  : 'C:Clear',             // clear num pad
              'combo'  : '\u00f6:Toggle Combo Keys',
              'dec'    : '.:Decimal',           // decimal point for num pad (optional), change '.' to ',' for European format
              'e'      : '\u21b5:Enter',        // down, then left arrow - enter symbol
              'enter'  : 'Enter:Enter',
              'lock'   : '\u21ea Lock:Caps Lock', // caps lock
              's'      : '\u21e7:Shift',        // thick hollow up arrow
              'shift'  : 'Shift:Shift',
              'sign'   : '\u00b1:Change Sign',  // +/- sign for num pad
              'space'  : '&nbsp;:Space',
              't'      : '\u21e5:Tab',          // right arrow to bar (used since this virtual keyboard works with one directional tabs)
              'tab'    : '\u21e5 Tab:Tab'       // \u21b9 is the true tab symbol (left & right arrows)
            },
          });
          $('#identity_keyboard').click(function(){
            var kb = $('#identity').getkeyboard();
            // close the keyboard if the keyboard is visible and the button is clicked a second time
            if ( kb.isOpen ) {
              kb.close();
            } else {
              kb.reveal();
            }
          });
          $('#password').keyboard({
            openOn   : null,
            // stayOpen : true,
            layout   : 'qwerty',
            display : {
              'a'      : '\u2714:Accept (Shift+Enter)', // check mark - same action as accept
              'accept' : '確認:Accept (Shift+Enter)',
              'alt'    : 'AltGr:Alternate Graphemes',
              'b'      : '\u2190:Backspace',    // Left arrow (same as &larr;)
              'bksp'   : 'Bksp:Backspace',
              'c'      : '\u2716:Cancel (Esc)', // big X, close - same action as cancel
              'cancel' : '取消:Cancel (Esc)',
              'clear'  : 'C:Clear',             // clear num pad
              'combo'  : '\u00f6:Toggle Combo Keys',
              'dec'    : '.:Decimal',           // decimal point for num pad (optional), change '.' to ',' for European format
              'e'      : '\u21b5:Enter',        // down, then left arrow - enter symbol
              'enter'  : 'Enter:Enter',
              'lock'   : '\u21ea Lock:Caps Lock', // caps lock
              's'      : '\u21e7:Shift',        // thick hollow up arrow
              'shift'  : 'Shift:Shift',
              'sign'   : '\u00b1:Change Sign',  // +/- sign for num pad
              'space'  : '&nbsp;:Space',
              't'      : '\u21e5:Tab',          // right arrow to bar (used since this virtual keyboard works with one directional tabs)
              'tab'    : '\u21e5 Tab:Tab'       // \u21b9 is the true tab symbol (left & right arrows)
            },
          });
          $('#password_keyboard').click(function(){
            var kb = $('#password').getkeyboard();
            // close the keyboard if the keyboard is visible and the button is clicked a second time
            if ( kb.isOpen ) {
              kb.close();
            } else {
              kb.reveal();
            }
          });
        });
      </script>
</body>
</html>