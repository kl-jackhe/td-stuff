<?php
// echo $_POST['storename'];
// echo ' ';
// echo $_POST['storeaddress'];
// echo ' ';
// echo $_GET['name'];
// echo ' ';
// echo $_GET['addr'];

$storename = !empty($_POST['storename']) ? $_POST['storename'] : $_GET['name'];
$storeaddress = !empty($_POST['storeaddress']) ? $_POST['storeaddress'] : $_GET['addr'];
?>
<script src="/node_modules/jquery/dist/jquery.min.js"></script>
<script>
	$(document).ready(function() {
		console.log(<?php echo json_encode($_GET); ?>);
		console.log(<?php echo json_encode($_POST); ?>);

		var storename = "<?php echo $storename; ?>";
		var storeaddress = "<?php echo $storeaddress; ?>";

		opener.set_store_info(storename, storeaddress);
		// window.close();
	});
</script>