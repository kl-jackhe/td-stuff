<?php
echo $_POST['storename'];
echo ' ';
echo $_POST['storeaddress'];
$storename = $_POST['storename'];
$storeaddress = $_POST['storeaddress'];
?>
<script src="/node_modules/jquery/dist/jquery.min.js"></script>
<script>
	$(document).ready(function() {
		opener.set_store_info("<?php echo $storename ?>", "<?php echo $storeaddress ?>");
		window.close();
	});
</script>