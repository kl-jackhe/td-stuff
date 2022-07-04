/*******詳細參考public/temp/StreamLiffDemo.html
LIFF建立URL範例 = https://ad.sstrm.net/public/temp/StreamLiffDemo.html?botID=1605431883"

安裝共兩個步驟：
    步驟1.
        於head中，依序貼上下面三行script。
        請注意三者順序不可互換！
        如果jquery已有其他版本，請確定新舊是否影響運行。
    步驟2.body的script中，貼上下行script。

javascript API list：
    getLiffUserID()
        取得userID

    LIFF_close()
        關閉LIFF視窗

    LIFF_sendMessages("text", myMessage)
        傳送「文字」訊息

    LIFF_sendMessages("text", myMessage, nextEvent)
        傳送「文字」訊息，並指定傳送完成後接續執行的動作。
*******/

const Version = 0.8;
var GTM_onloadCheck = false;
var LIFF_userID = "";
var LIFF_botID = "";
var LIFF_liffProfile = {};
var LIFF_senderProfile = {};

var LIFF_close = null;
var LIFF_sendMessages = null;
function LIFF_init(){
    if(GTM_onloadCheck !== undefined && GTM_onloadCheck){
        jlog("GTM GO!!!");

        LIFF_botID = getUrlParameter("botID");
        jlog("LIFF_botID=>" + LIFF_botID);

        liff.init(
            data => {
                liff.getProfile().then(function (profile) {
                    jlog(JSON.stringify(liff));
                    jlog(JSON.stringify(profile));
                
                    LIFF_userID = profile.userId;
                    jlog("LIFF_userID=>" + LIFF_userID);

                    LIFF_liffProfile = liff;
                    LIFF_senderProfile = profile;

                    LIFF_close = function(){
                        liff.closeWindow();
                    };

                    LIFF_sendMessages = function(type, messages, thenFunc){
                        var sendedMessage = [];
                        if(type == "text"){
                            sendedMessage.push({
                                type:'text',
                                text: messages
                            });
                        }else{
                            var response = "LIFF.sendMessages type is NOT defined!";
                            sendToIpsolr("LIFF.sendMessages.ERR! type=>"+type + " messages=>"+messages, 400, response)
                            alert(response);
                            return;
                        }

                        liff.sendMessages(sendedMessage)
                        .then(() => {
                            var successString = 'LIFF message sent';
                          jlog(successString);
                          sendToIpsolr(sendedMessage, 200, successString, thenFunc);
                        })
                        .catch((err) => {
                          jlog('LIFF error!' + err);
                          sendToIpsolr(sendedMessage, 400, err);
                          alert("LIFF.sendMessages ERROR!");
                        });
                    }
                })
            },
            err => {
                // alert("liff初始化失敗！");
            }
        );
    }else{
        console.log("等候GTM加載...");
        setTimeout("LIFF_init()", 1000);
        return;
    }
}

function sendToIpsolr(sendedMessage, responseStatus, response, thenFunc){
    var url_ipsolr = "https://api2.sstrm.net/ip-solr/lineat_message_log-"+new Date().getFullYear() + "/log";
    var postData_ipsolr = {
        "botID" : LIFF_botID,
        "userID" : LIFF_userID,
        "event" : "MessageSentByLIFF",
        "sendType" : "liff_reply",
        "response" : "",
        "rawData" : JSON.stringify(sendedMessage),
        "responseStatus" : responseStatus,
        "response" : response,
        "liffProfile" : LIFF_liffProfile,
        "senderProfile" : LIFF_senderProfile,
        "timestamp" : getEsTimestamp(new Date())
    };
    jlog("url_ipsolr=>" + url_ipsolr);
    jlog("postData_ipsolr<br/>" + JSON.stringify(postData_ipsolr));

    $.ajax({
        type: 'POST',
        url: url_ipsolr,
        dataType: 'json',
        contentType: 'text/plain;charset=utf-8',
        data: JSON.stringify(postData_ipsolr),
        success: function(msg){
            jlog(JSON.stringify(msg, null, ' \t'));
        },
        error: function(err){
            jlog("ipsolrERR!" + JSON.stringify(err, null, ' \t'));
        },
        complete:function(data) {
            if(thenFunc != undefined)   thenFunc();
        }
    });
}

$(document).ready(function() {
    (function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
    new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
    j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
    'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
    })(window,document,'script','dataLayer','GTM-T98NQV3');

    $("body").append('<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-T98NQV3" height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>');    
});