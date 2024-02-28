<?php
$storeid = $_GET['StoreID'];
$storename = $_GET['StoreName'];
$ReservedNo = $_GET['ReservedNo'];
?>
<script src="/node_modules/jquery/dist/jquery.min.js"></script>

<script>
    $(document).ready(function() {
        // 檢查
        console.log(<?php echo json_encode($_GET); ?>);
        console.log(<?php echo json_encode($_POST); ?>);

        var storeid = "<?php echo $storeid; ?>";
        var storename = "<?php echo $storename; ?>";
        var ReservedNo = "<?php echo $ReservedNo; ?>";

        opener.set_fm_store_info(storeid, storename, ReservedNo);
        window.close();
    });
</script>