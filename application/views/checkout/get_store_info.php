<?php
// if($_POST){
// 	print_r($_POST);
// }
?>

<!-- <input type="button" value="set_store_info" onclick="opener.set_store_info('<?php echo $this->input->post('storename') ?>', '<?php echo $this->input->post('storeaddress') ?>');"> -->

<script src="/node_modules/jquery/dist/jquery.min.js"></script>
<script>
	$(document).ready(function() {
		opener.set_store_info("<?php echo $this->input->post('storename') ?>", "<?php echo $this->input->post('storeaddress') ?>");
		window.close();
	});
</script>