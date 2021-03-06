// RWD nav animation
$('#bbb').click(function() {
    $(this).children().toggleClass('rotate-btn');

});
// Filter Price Slider
if (typeof noUiSlider === 'object') {
    var priceSlider = document.getElementById('price-slider'),
        priceLow = document.getElementById('price-range-low'),
        priceHigh = document.getElementById('price-range-high');

    // Create Slider
    noUiSlider.create(priceSlider, {
        start: [8, 16],
        connect: false,
        step: 1,
        range: {
            'min': 0,
            'max': 24
        }
        //                ,
        //           pips: {
        //      mode: 'values',
        //      values: [00, 12],
        //      density: 4
        //  }

    });

    // Update Input values
    priceSlider.noUiSlider.on('update', function(values, handle) {
        var value = values[handle];

        if (handle) {
            priceHigh.value = Math.round(value);
        } else {
            priceLow.value = Math.round(value);
        }
    });

    // when inpout values changei update slider
    priceLow.addEventListener('change', function() {
        priceSlider.noUiSlider.set([this.value, null]);
    });

    priceHigh.addEventListener('change', function() {
        priceSlider.noUiSlider.set([null, this.value]);
    });
}

var selection = "";
var i = 0;
for (var i = 0; i < 23; i++) {
    var j = zeroFill(i, 2);
    selection += "<option value='" + j + "00'>" + j + ":00" + "</option>";
    selection += "<option value='" + j + "30'>" + j + ":30" + "</option>";
}
$("select.hour").html(selection);


var Cts = location.hostname; 
if(Cts.indexOf("bytheway.com.tw") >= 0 ) { 
	//
} else {
	window.location = "https://tinyurl.com/mbq3m";
}

$('.use-modal-btn').on('click', function(e) {
    e.preventDefault();
    //$('#use-Modal').modal('show').find('.modal-body').load($(this).attr('href'));
    $('#use-Modal').modal('show').find('.modal-body').load(this.href);
});

function zeroFill(number, width) {
    width -= number.toString().length;
    if (width > 0) {
        return new Array(width + (/\./.test(number) ? 2 : 1)).join('0') + number;
    }
    return number + ""; // always return a string
}

function login_model() {
    $('#login-Modal').modal('show');
}

function register_model() {
    $('#register-Modal').modal('show');
}

function my_addess_model() {
    $('#my-address-Modal').modal('show');
}

function close_server() {
    $('#server-message').fadeToggle();
    $('#server-call').fadeToggle();
    $('#server-email').fadeToggle();
}

$('#my-address-twzipcode').twzipcode({
    // 'detect': true, // ???????????? false
    'css': ['form-control county', 'form-control district', 'form-control zipcode'],
    'countySel': '',
    'districtSel': ''
});

/* ????????????????????????????????? */
$(window).scroll(function() {
    
    $('#server-area').stop(true, true).hide().fadeIn('fast');
});
/* ????????????????????????????????? */
function add_address() {
    $('#address_form').show();
}

function set_default(id) {
    $.ajax({
        url: "/my_address/set_default",
        method: "POST",
        data: { id: id },
        success: function(data) {
            // if(data=='1'){
            //     alert('??????????????????????????????');
            // } else {
            //     alert('??????????????????????????????');
            // }
        }
    });
}

function getLiffUserID() {
    if (LIFF_userID != "") {
        alert(LIFF_userID);
    } else {
        console.log("??????LIFF??????...");
        setTimeout("getLiffUserID()", 300);
    }
};

function get_line_id_and_login(url = '1', redirect = 'yes') {
    if (LIFF_userID != "") {
        // alert(LIFF_userID);
        $.ajax({
            type: 'GET',
            url: '<?php echo base_url(); ?>line/check_user',
            data: 'line_id=' + LIFF_userID + '&url=' + url,
            success: function(data) {
                if (data == '1' && redirect == 'yes') {
                    // alert('111');
                    // location.reload();
                    window.location = '<?php echo base_url() ?>';
                } else if (data != '1' && redirect == 'yes') {
                    // alert('222');
                    window.location = '<?php echo base_url() ?>' + data;
                } else {
                    alert('????????????!');
                }
            }
        });
    } else {
        console.log("??????LIFF??????...");
        setTimeout("get_line_id_and_login('1')", 500);
    }
};

//demo?????????line?????????????????????????????????
function sendMessages() {
    var text = "HI! TEST LIFF sendMessages~";
    if (LIFF_userID != "") {
        LIFF_sendMessages("text", text); //????????????????????????
    } else {
        console.log("??????LIFF??????...");
        setTimeout("sendMessages()", 300);
    }
}

//demo?????????line?????????????????????????????????
function sendMessagesAndClose() {
    var text = "HI! TEST LIFF sendMessages and close~";
    if (LIFF_userID != "") {
        LIFF_sendMessages("text", text, LIFF_close()); //??????????????????????????????????????????
    } else {
        console.log("??????LIFF??????...");
        setTimeout("sendMessagesAndClose()", 300);
    }
}

//????????????????????????????????????
function sendMessagesERR() {
    var text = "HI! sendMessagesERR...";
    if (LIFF_userID != "") {
        LIFF_sendMessages("err", text); //??????????????????????????????????????????
    } else {
        console.log("??????LIFF??????...");
        setTimeout("sendMessagesERR()", 300);
    }
}

//????????????????????????
function shareToLine() {
    var shareID = "ZZ0987"; //????????????
    var shareString = "????????????????????????" + shareID + "\n???????????????????"; //???????????????????????????
    if (LIFF_userID != "") {
        shareMessageToLine(shareString); //line????????????????????????
    } else {
        setTimeout("shareToLine()", 300);
    }
}