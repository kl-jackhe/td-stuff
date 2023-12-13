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
	function getCookie(name) {
		var value = "; " + document.cookie;
		var parts = value.split("; " + name + "=");
		if (parts.length == 2) return parts.pop().split(";").shift();
	}
	var selectedDelivery = getCookie('selectedDelivery');
	$(document).ready(function() {
		$(location).attr('href', '/checkout?storename=<?php echo $storename; ?>&storeaddress=<?php echo $storeaddress; ?>&step=2&checkout_delivery=' + selectedDelivery);
	});
</script>