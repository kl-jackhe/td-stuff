<?php
$storeid = $_GET['StoreID'];
$storename = $_GET['StoreName'];
$ReservedNo = $_GET['ReservedNo'];
?>
<script src="/node_modules/jquery/dist/jquery.min.js"></script>
<script>
    function getCookie(name) {
        var value = "; " + document.cookie;
        var parts = value.split("; " + name + "=");
        if (parts.length == 2) return parts.pop().split(";").shift();
    }
    var selectedDelivery = getCookie('selectedDelivery');
    var storeid = "<?php echo $storeid; ?>";
    var storename = "<?php echo $storename; ?>";
    var storeaddress = "<?php echo $storeaddress; ?>";

    $(document).ready(function() {
        $(location).attr('href', '/checkout?storeid=<?php echo $storeid; ?>&storename=<?php echo $storename; ?>&ReservedNo=<?php echo $ReservedNo; ?>&step=2&checkout=' + selectedDelivery);
    });
</script>