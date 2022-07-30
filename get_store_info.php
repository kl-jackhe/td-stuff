<?php echo $_POST['storename'] ?><?php echo $_POST['storeaddress'] ?>
<script src="/node_modules/jquery/dist/jquery.min.js"></script>
<script>
	$(document).ready(function() {
		opener.set_store_info("<?php echo $_POST['storename'] ?>", "<?php echo $_POST['storeaddress'] ?>");
		window.close();
	});
</script>