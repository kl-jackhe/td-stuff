<!-- <script src="/node_modules/jquery/dist/jquery.min.js"></script>
<script src="https://d.line-scdn.net/liff/1.0/sdk.js"></script>
<script src="/assets/js/StreamInitLiffWithGtm.js"></script> -->
<script src="https://ad.sstrm.net/public/SDK/MDB/js/jquery-3.2.1.min.js"></script>
<script src="https://www.stream-lab.net/public/SDK/utility/streamLiff.js"></script>
<script src="https://intra.sstrm.net/public/SDK/tracking/StreamInitLiffWithGtm.2.0.min.js"></script>
<script>
alert = function() {};
//安裝步驟2.body的script中，貼上下行script。
LIFF_init();
// var LIFF_userID = '123qweasdzxc';

$(document).ready(function() {
    get_line_id();
    // if (LIFF_userID != "") {
    //     setTimeout("get_line_id()", 50);
    // } else {
    //     setTimeout("get_line_id()", 50);
    // }
});

//====================DEMO====================

var count = 1;
function get_line_id() {
    // if (LIFF_userID != "") {
    //     LIFF_close();
    // } else {
    //     console.log("等候LIFF加載...");
    //     setTimeout("get_line_id('close')", 500);
    // }

    if (LIFF_userID != "") {
        // close();
        LIFF_close();
    } else {
        count++;
        setTimeout("get_line_id()", 250);
    }

    if(count>=12) {
        just_close();
    }
};

function close() {
    if (LIFF_userID != "") {
        LIFF_close();
    } else {
        window.location = '<?php echo base_url() ?>';
    }
}

function just_close() {
    // if (LIFF_userID != "") {
    //     LIFF_close();
    // } else {
        window.location = '<?php echo base_url() ?>';
    // }
}
</script>