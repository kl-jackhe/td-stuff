<html>
<body>
	<h2>Bytheway - 順便一提 [通知訊息]！</h2>
	<h3><?php echo sprintf(lang('email_activate_heading'), $identity);?></h3>
	<h3><?php echo sprintf(lang('email_activate_subheading'), anchor('auth/activate/'. $id .'/'. $activation, lang('email_activate_link')));?></h3>
</body>
</html>