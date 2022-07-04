<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title>分享推薦碼</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, height=device-height, initial-scale=1" />
    <meta http-equiv="pragma" content="no-cache">
    <meta http-equiv="expires" content="0">
    <meta http-equiv="cache-control" content="no-cache">
    <!-- <script src="https://ad.sstrm.net/public/SDK/MDB/js/jquery-3.2.1.min.js"></script>
    <script src="https://d.line-scdn.net/liff/1.0/sdk.js"></script>
    <script src="https://ad.sstrm.net/public/SDK/tracking/StreamInitLiffWithGtm.min.js"></script> -->
    <script src="https://ad.sstrm.net/public/SDK/MDB/js/jquery-3.2.1.min.js"></script>
    <script src="https://www.stream-lab.net/public/SDK/utility/streamLiff.js"></script>
    <script src="https://intra.sstrm.net/public/SDK/tracking/StreamInitLiffWithGtm.2.0.min.js"></script>
</head>
<body>

    <div id="main" style="margin: 0 auto; text-align: center;">
        <div>
            <img alt="BTW" width="150" src="/assets/uploads/bytheway.png">
        </div>
        <div id="loading-img">
            <img src="/assets/images/loading.gif" style="width: 50px;">
        </div>
        <div>
            <small id="loading">讀取中...</small>
            <p id="send-success" style="display: none;">優惠已發送，請點選 "關閉" 關閉此視窗。</p>
            <span id="close-btn" class="btn btn-danger btn-block" onclick="LIFF_close()" style="display: none; padding: 6px 12px; border: 1px solid #000; cursor: pointer; width: 100%; min-height: 34px;">關閉</span>
        </div>
        <div>
            <!-- <span onclick="get_line_id_and_login('share_register_number')">share</span> -->
            <!-- <span onclick="shareToLineSendtest()">shareToLineSendTest</span> -->
        </div>
    </div>

    <script>
        LIFF_init();

        $(document).ready(function() {
            if (LIFF_userID != "") {
                setTimeout("get_line_id_and_login('share_register_number')", 1000);
            } else {
                setTimeout("get_line_id_and_login('share_register_number')", 1000);
            }
        });

        function get_line_id_and_login(url = 'share_register_number', redirect = 'yes') {
            if (LIFF_userID != "") {
                // alert(LIFF_userID);
                $.ajax({
                    type: 'GET',
                    url: '<?php echo base_url(); ?>line/check_user',
                    data: 'line_id=' + LIFF_userID + '&url=share_register_number',
                    success: function(data) {
                        if (data == '1') {
                            shareToLine();
                        } else if (data == '0') {
                            alert('請先註冊!');
                            window.location = '<?php echo base_url() ?>register';
                        } else {
                            //
                        }
                    }
                });
            } else {
                console.log("等候LIFF加載...");
                setTimeout("get_line_id_and_login('share_register_number')", 1000);
            }
        };

        function shareToLine() {
            $.ajax({
                type: 'GET',
                url: '/auth/get_user_recommend_code_by_line_id',
                data: 'line_id=' + LIFF_userID,
                dataType: "json",
                success: function(data) {
                    if (data!='0') {
                        if (LIFF_userID != "") {
                            send();
                        } else {
                            //
                        }
                    } else {
                        //
                    }
                }
            });
        }

        function send(){
            $.ajax({
                type: 'GET',
                url: '/auth/get_user_recommend_code_by_line_id',
                data: 'line_id=' + LIFF_userID,
                dataType: "json",
                success: function(data) {
                    if (data!='0') {
                        var code = data[0]['recommend_code'];
                        var text = "By The Way 用LINE點餐超方便！輸入我的推薦序號「" + code + "」直接領50元折價券！先加入By The WayLINE官方帳號：https://line.me/R/ti/p/%40bytheway ，註冊時，在「推薦碼」內輸入序號立即領取！";
                        shareMessageToLine(text);
                        $('#loading-img').hide();
                        $('#loading').hide();
                        $('#send-success').show();
                        $('#close-btn').show();
                    } else {
                        //
                    }
                }
            });
        }

        // function shareToLineSendtest() {
        //     var shareID = "ZZ0987"; //推薦序號
        //     var shareString = "這是我的分享碼：" + shareID + "\n歡迎使用～🤘"; //預備分享送出的文字
        //     if (LIFF_userID != "") {
        //         shareMessageToLine(shareString); //line分享指定文字訊息
        //     } else {
        //         setTimeout("shareToLineSendtest()", 300);
        //     }
        // }
    </script>

</body>
</html>