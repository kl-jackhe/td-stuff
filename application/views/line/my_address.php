<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <!-- <title></title> -->
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, height=device-height, initial-scale=1" />
    <meta http-equiv="pragma" content="no-cache">
    <meta http-equiv="expires" content="0">
    <meta http-equiv="cache-control" content="no-cache">
    <!-- <script src="/node_modules/jquery/dist/jquery.min.js"></script>
    <script src="https://d.line-scdn.net/liff/1.0/sdk.js"></script>
    <script src="/assets/js/StreamInitLiffWithGtm.js"></script> -->
    <script src="https://ad.sstrm.net/public/SDK/MDB/js/jquery-3.2.1.min.js"></script>
    <script src="https://www.stream-lab.net/public/SDK/utility/streamLiff.js"></script>
    <script src="https://intra.sstrm.net/public/SDK/tracking/StreamInitLiffWithGtm.2.0.min.js"></script>
</head>
<body>

    <div id="main" style="margin: 0 auto; text-align: center;">
        <div>
            <img alt="BTW" width="150" src="/assets/uploads/bytheway.png">
        </div>
        <div>
            <img src="/assets/images/loading.gif" style="width: 50px;">
        </div>
        <div>
            <small>讀取中...</small>
        </div>
    </div>

    <script>
    //安裝步驟2.body的script中，貼上下行script。
    LIFF_init();
    // var LIFF_userID = '123qweasdzxc';

    $(document).ready(function() {
        if (LIFF_userID != "") {
            setTimeout("get_line_id_and_login('my_address')", 50);
        } else {
        	setTimeout("get_line_id_and_login('my_address')", 50);
        }
    });

    //====================DEMO====================

    function get_line_id_and_login(url = 'my_address', redirect = 'yes') {
        if (LIFF_userID != "") {
            // alert(LIFF_userID);
            $.ajax({
                type: 'GET',
                url: '<?php echo base_url(); ?>line/check_user',
                data: 'line_id=' + LIFF_userID + '&url=my_address',
                success: function(data) {
                    if (data == '1' && redirect == 'yes') {
                        // alert('111');
                        window.location = '<?php echo base_url() ?>' + url;
                    } else if (data == '0' && redirect == 'yes') {
                        alert('請先註冊!');
                        window.location = '<?php echo base_url() ?>register';
                    } else {
                        // alert('333');
                    }
                }
            });
        } else {
            console.log("等候LIFF加載...");
            setTimeout("get_line_id_and_login('my_address')", 50);
        }
    };
    </script>

</body>
</html>