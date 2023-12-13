<?php
// echo $_POST['storename'];
// echo ' ';
// echo $_POST['storeaddress'];
// echo ' ';
// echo $_GET['name'];
// echo ' ';
// echo $_GET['addr'];

// $storename = !empty($_POST['storename']) ? $_POST['storename'] : $_GET['name'];
// $storeaddress = !empty($_POST['storeaddress']) ? $_POST['storeaddress'] : $_GET['addr'];

$storeid = $_POST['CVSStoreID'];
$storename = $_POST['CVSStoreName'];
$storeaddress = $_POST['CVSAddress'];
?>
<script src="/node_modules/jquery/dist/jquery.min.js"></script>
<script>
	$(document).ready(function() {
		// 檢查
		console.log(<?php echo json_encode($_GET); ?>);
		console.log(<?php echo json_encode($_POST); ?>);

		var storeid = "<?php echo $storeid; ?>";
		var storename = "<?php echo $storename; ?>";
		var storeaddress = "<?php echo $storeaddress; ?>";

		opener.set_store_info(storeid, storename, storeaddress);
		window.close();
	});
</script>