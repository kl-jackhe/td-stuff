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
		$(location).attr('href', '/checkout?storename=<?php echo $storename; ?>&storeaddress=<?php echo $storeaddress; ?>');
	});
</script>