<?php echo $_POST['storename'] ?><?php echo $_POST['storeaddress'] ?>
<script src="/node_modules/jquery/dist/jquery.min.js"></script>
<script>
	$(document).ready(function() {
		$(location).attr('href', '/checkout?storename=<?php echo $_POST['storename'] ?>&storeaddress=<?php echo $_POST['storeaddress'] ?>');
	});
</script>