<html>
<body>
	<h2><?php echo get_setting_general('name') ?> [通知訊息]！</h2>
	<h3>您的電話號碼：<?php echo $identity ?></h3>
	<!-- <h3><?php echo sprintf(lang('email_forgot_password_heading'), $identity);?></h3> -->
	<h3><?php echo sprintf(lang('email_forgot_password_subheading'), anchor('auth/reset_password/'. $forgotten_password_code, lang('email_forgot_password_link')));?></h3>
</body>
</html>