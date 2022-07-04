/* streamLiff
*  version: 0.3.6
*  date: 2020/03/09
*  LINE LIFF version: 2 (2.1.9)
*  LINE LIFF source: https://static.line-scdn.net/liff/edge/2.1/sdk.js
*/




class StreamLiff {

    constructor(config) {
        this.config_loadScriptAPIUrl = "https://api3.sstrm.net/util/api";                

        this.doInsertLog = true;

        this.config = config;
        if(this.config !== undefined && this.config !== null){
            if(this.config.hasOwnProperty('liffSDK') && this.config.liffSDK !== undefined && this.config.liffSDK !== null && this.config.liffSDK !== ''){
                this.liffSDK = this.config.liffSDK;
            }
            if(this.config.hasOwnProperty('liffID') && this.config.liffID !== undefined && this.config.liffID !== null && this.config.liffID !== ''){
                this.liffID = this.config.liffID;
            }
            if(this.config.hasOwnProperty('botID') && this.config.botID !== undefined && this.config.botID !== null && this.config.botID !== ''){
                this.botID = this.config.botID;
            }
            if(this.config.hasOwnProperty('doInsertLog') && this.config.doInsertLog !== undefined && this.config.doInsertLog !== null && this.config.doInsertLog !== ''){
                if(this.config.doInsertLog === 'false' || this.config.doInsertLog === false){
                    this.doInsertLog = false;
                }else{
                    this.doInsertLog = true;
                }
            }
        }
        /*
        // sdk
        this.liffSDK = liffSDK;
        // liff id is use in sdk >= 2.0
        this.liffID = liffID;
        */

        this.params = {};
        this.uriParamStr = "";

        this.debugMode = false;

        //this.uriParamStr = getUriParamStr();
        this.setUriParams(true);

        this.UserInfoUpdateDone = false;

        this.tempCall = null;
        var tempThis = this;
        this.ready = new Promise((function(t){            
            tempThis.tempCall = t;            
        }));

        this.bluetooth = {
            getAvailability : function() {
                return this.liffSDK.bluetooth.getAvailability();
            },
            requestDevice : function(o) {
                return this.liffSDK.bluetooth.requestDevice(o);
            },
            referringDevice : function() {
                return this.liffSDK.bluetooth.referringDevice();
            }
        }

        this.logInfo("","",false,"new StreamLiff construct");
    }

    getParamValue(key){
        let paramValue = null;
        if(this.params != undefined && this.params != null &&
            this.params.hasOwnProperty(key) && this.params[key] !== undefined && this.params[key] !== null){
                paramValue = this.params[key]
        }

        return paramValue;
    }

    getUriParamStr(){
        let tempUriParamsStr =  decodeURIComponent(window.location.search).replace("?liff.state=", "")
        if(tempUriParamsStr.startsWith("?")){
            tempUriParamsStr = tempUriParamsStr.substr(1,tempUriParamsStr.length);
        }else if(tempUriParamsStr.indexOf("?") != -1){
            tempUriParamsStr = tempUriParamsStr.substr(tempUriParamsStr.indexOf("?")+1,tempUriParamsStr.length);
        }

        return tempUriParamsStr;
    }

    setUriParams(recheck){
        let needReset = true;
        let nowUriParamStr = this.getUriParamStr();
        if(recheck){
            if(nowUriParamStr === this.uriParamStr){
                needReset = false;
            }else{
                this.uriParamStr = nowUriParamStr;
            }
        }
        if(needReset){
            if(this.uriParamStr != undefined && this.uriParamStr != null && this.uriParamStr.length > 0){
                let tempParamAndValueStrs = this.uriParamStr.split("&");
                for(let i in tempParamAndValueStrs){
                    let tempParamAndValueStr = tempParamAndValueStrs[i];
                    if(tempParamAndValueStr && tempParamAndValueStr.indexOf("=") != -1){
                        let tempParamAndValue = tempParamAndValueStr.split("=");
                        if(tempParamAndValue.length == 2){
                            let paramName = tempParamAndValue[0]; 
                            let paramValue = tempParamAndValue[1];
                            if(paramName){
                                this.params[paramName] = paramValue;
                            } 
                        }
                    }
                }
            }
        }

    }

    delay(timeout) {
        return new Promise(resolve => setTimeout(() => resolve(), timeout))
    }

    switchDebugMode(on){
        if(on !== undefined && on !== null && on){
            this.debugMode = true;
        }else{
            this.debugMode = false;
        }
    }

    async init(t, n) {
        let needLoadSDK = false;
        /*
        if((this.liffSDK !== undefined || this.liffSDK !== null) && (this.liffID === undefined || this.liffID === null)){
            //只有一個參數        
            if("string" === typeof this.liffSDK){
                //只輸入 liffID                
                this.liffID = this.liffSDK;
                this.liffSDK = null;
                needLoadSDK = true;                
            }                
        }     
        */
        if((this.liffSDK === undefined || this.liffSDK === null || this.liffSDK === '')){
            needLoadSDK = true;                                                
        }     
        
        if(needLoadSDK){
            if (!window.liff) {            
                import("https://static.line-scdn.net/liff/edge/2.1/sdk.js").then(function(){
                    console.log('load line liff SDK done');
                });
                // import("https://mr-ape-bot.herokuapp.com/LiffTest/liff2.0sdk_2.js").then(function(){
                //     console.log('load line liff SDK done');
                // });

                let maxCountWaitTime = 20;
                let countWaitTime = 0;
                while(!window.liff){
                    countWaitTime++;
                    if(maxCountWaitTime >= countWaitTime){
                        if(this.debugMode){console.log(countWaitTime+": wait 500 ms");}
                        await this.delay(500);                        
                    }else{
                        break;
                    }
                }

                liff.ready.then(()=>{
                    console.log('in ready then');
                });

                this.liffSDK = liff
            }else{
                this.liffSDK = liff
            }            
        }

        var r = "function" == typeof t ? t : Promise.resolve.bind(Promise),
            i = "function" == typeof n ? n : Promise.reject.bind(Promise);
        if (!this.liffID) return i(Object("liffId is necessary for liff.init()"));

        return this.liffSDK.init({
            liffId: this.liffID
        })
        .then(() => {
            
            let tmpInitReturn = {};
            tmpInitReturn.language = this.liffSDK.getLanguage();                    
            tmpInitReturn.version = this.liffSDK.getVersion();            
            tmpInitReturn.os = this.liffSDK.getOS();            
            tmpInitReturn.isInClient = this.liffSDK.isInClient();

            let type = "";
            let viewType = "";
            let userId = "";
            let utouId = "";
            let roomId = "";
            let groupId = "";
            let accessTokenHash = "";
            
            if(tmpInitReturn.isInClient){
                let context = this.liffSDK.getContext();
                if(context !== undefined && context !== null){
                    tmpInitReturn.context = context;
                }
            }

            if(this.liffSDK.isLoggedIn()){
                return this.liffSDK.getProfile()
                .then((data)=>{
                    let profile = data;
                    if(profile !== undefined && profile !== null){
                        tmpInitReturn.profile = profile;
    
                        if(profile.userId !== undefined && profile.userId !== null){
                            userId = profile.userId;
                        }
                    }

                    if(tmpInitReturn.context === undefined || tmpInitReturn.context === null ){
                        tmpInitReturn.context = {
                            "type":type,
                            "viewType":viewType,
                            "userId":userId,
                            "utouId":utouId,
                            "roomId":roomId,
                            "groupId":groupId,
                            "accessTokenHash":accessTokenHash
                        }
                    }

                    let tokenPayload = this.liffSDK.getDecodedIDToken();                    
                    let user_name = "";
                    if(profile.hasOwnProperty("displayName") && profile.displayName !== undefined && profile.displayName !== null && profile.displayName !== ''){
                        user_name = profile.displayName;
                    }
                    let user_picture = "";
                    if(profile.hasOwnProperty("pictureUrl") && profile.pictureUrl !== undefined && profile.pictureUrl !== null && profile.pictureUrl !== ''){
                        user_picture = profile.pictureUrl;
                    }
                    let user_statusMessage = "";
                    if(profile.hasOwnProperty("statusMessage") && profile.statusMessage !== undefined && profile.statusMessage !== null && profile.statusMessage !== ''){
                        user_statusMessage = profile.statusMessage;
                    }
                    let user_email = "";
                    if(tokenPayload !== undefined && tokenPayload !== null){
                        // if(tokenPayload.hasOwnProperty('name') && tokenPayload.name !== undefined && tokenPayload.name !== null){
                        //     user_name = tokenPayload.name;
                        // }
                        if(tokenPayload.hasOwnProperty('picture') && tokenPayload.picture !== undefined && tokenPayload.picture !== null){
                            user_picture = tokenPayload.picture;
                        }
                        if(tokenPayload.hasOwnProperty('email') && tokenPayload.email !== undefined && tokenPayload.email !== null){
                            user_email = tokenPayload.email;
                        }                                                
                    }

                    if(this.botID !== undefined && this.botID !== null && this.botID !== '' && 
                        userId !== undefined && userId !== null && userId !== ''){
                        
                        var xhttp = new XMLHttpRequest();
                        var mainThis = this;
                        xhttp.onreadystatechange = function()
                        {
                            if(xhttp.readyState == 4 && xhttp.status == 200)
                            {
                                console.log("profile update done");     
                                mainThis.UserInfoUpdateDone = true;                           
                            }else{
                                mainThis.logInfo(userId,tmpInitReturn.os,tmpInitReturn.isInClient,"profile update error"); 
                            }
                        }
                        //xhttp.open("POST", this.config_loadScriptAPIUrl+"/lineUserProfileUpdate", true);
                        xhttp.open("POST", this.config_loadScriptAPIUrl+"/lineLiffUserInfoUpdateWithLog", true);
                        xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

                        var sendParam = ""

                        sendParam = "botID="+this.botID+"&userID="+userId+"&displayName="+encodeURIComponent(user_name)+"&pictureUrl="+encodeURIComponent(user_picture)+"&statusMessage="+encodeURIComponent(user_statusMessage)+"&email="+encodeURIComponent(user_email)+"&updateEmptyValue=false&triggerInteractions=true"

                        let needWait = false;
                        if(this.doInsertLog){                        
                            let platform = navigator.platform;
                            let userAgent = navigator.userAgent;
                            let actionUrl = window.location.href;

                            let host = window.location.hostname;
                            let pathname = window.location.pathname;
                            let protocol = window.location.protocol;
                            let search = window.location.search;

                            if(platform === undefined || platform === null){
                                platform = '';
                            }
                            if(userAgent === undefined || userAgent === null){
                                userAgent = '';
                            }                                                                        
                            if(actionUrl === undefined || actionUrl === null){
                                actionUrl = '';
                            }     

                            if(host === undefined || host === null){
                                host = '';
                            }                                                                        
                            if(pathname === undefined || pathname === null){
                                pathname = '';
                            }                                                                        
                            if(protocol === undefined || protocol === null){
                                protocol = '';
                            }                                                                        
                            if(search === undefined || search === null){
                                search = '';
                            }                            
                            if(search.indexOf('liff.state=') == -1){
                                needWait = true;                                
                            }                            
                            sendParam += "&doLog=true"
                            
                            sendParam +="&liffID="+this.liffID
                            sendParam +="&platform="+platform
                            sendParam +="&userAgent="+encodeURIComponent(userAgent)
                            sendParam +="&os="+tmpInitReturn.os
                            sendParam +="&isInClient="+tmpInitReturn.isInClient
                            sendParam +="&actionUrl="+encodeURIComponent(actionUrl)
                            sendParam +="&protocol="+protocol
                            sendParam +="&host="+host
                            sendParam +="&pathname="+pathname
                            sendParam +="&search="+encodeURIComponent(search)
                            sendParam +="&params="+JSON.stringify(this.params)                                                                                                                                                               
                        }else{
                            sendParam += "&doLog=false"
                        }

                        //console.log("sendParam\n="+sendParam);
                        //alert("sendParam=\n"+sendParam);

                        //xhttp.send("botID="+this.botID+"&userID="+userId+"&displayName="+user_name+"&pictureUrl="+user_picture+"&email="+user_email+"&updateEmptyValue=false&triggerInteractions=true");
                        if(needWait){
                            setTimeout(function(){
                                xhttp.send(sendParam);
                            },500);
                        }else{
                            xhttp.send(sendParam);
                        }                           
                    }else{
                        this.logInfo((userId)?userId:"",(tmpInitReturn.os)?tmpInitReturn.os:"",(tmpInitReturn.isInClient)?true:false,'liff init (without update lineuserprofile)')
                    }

                    if(this.tempCall !== undefined && this.tempCall !== null ){
                        this.tempCall();
                    }

                    return r(tmpInitReturn)
                })
                .catch((err)=>{
                    this.logInfo("","",false,"liff.getProfile() error:"+err); 
                    return i(Object(err));
                });            
            }else{
                if(tmpInitReturn.context === undefined || tmpInitReturn.context === null ){
                    tmpInitReturn.context = {
                        "type":type,
                        "viewType":viewType,
                        "userId":userId,
                        "utouId":utouId,
                        "roomId":roomId,
                        "groupId":groupId,
                        "accessTokenHash":accessTokenHash
                    }
                }
                return r(tmpInitReturn)
            }
        })
        .catch((err) => {       
            this.logInfo("","",false,"liff.init() error:"+err);     
            return i(Object(err));
        });
        
    }

    getOS(){
        return this.liffSDK.getOS();
    }

    getLanguage(){
        return this.liffSDK.getLanguage();
    }

    getVersion(){
        return this.liffSDK.getVersion();
    }

    isInClient(){
        return this.liffSDK.isInClient();
    }

    isLoggedIn(){
        return this.liffSDK.isLoggedIn();
    }

    login(o){
        let tempLoginConfig = null;
        if(o !== undefined && o !== null){
            if(o.hasOwnProperty('redirectUri') && o.redirectUri !== undefined && o.redirectUri !== null){
                tempLoginConfig = o;
            }
        }

        if(tempLoginConfig !== undefined && tempLoginConfig !== null){
            this.liffSDK.login(tempLoginConfig);
        }else{
            this.liffSDK.login();
        }
    }

    logout(){
        return this.liffSDK.logout();
    }

    getAccessToken(){
        return this.liffSDK.getAccessToken();
    }

    getContext(){
        return this.liffSDK.getContext();
    }

    getDecodedIDToken(){
        return this.liffSDK.getDecodedIDToken();
    }

    getProfile() {
        return this.liffSDK.getProfile()
    }

    sendMessages(m, t, n) {
        var r = "function" == typeof t ? t : Promise.resolve.bind(Promise),
        i = "function" == typeof n ? n : Promise.reject.bind(Promise);

        return this.liffSDK.sendMessages(m)
          .then(() => {
            return r();
          })
          .catch((err) => {
            return i(err);
          });
    }

    openWindow(o) {
        let tempParams = null;
        if(o !== undefined && o !== null){
            if(o.hasOwnProperty('url') && o.url !== undefined && o.url !== null){
                tempParams = o;
            }
        }

        if(tempParams !== undefined && tempParams !== null){
            this.liffSDK.openWindow(tempParams)
        }else{
            console.log("openWindow error:","missing param url");
        }
    }

    scanCode() {
        return this.liffSDK.scanCode();
    }

    closeWindow() {
        this.liffSDK.closeWindow()
    }
    
    initPlugins(a) {
        return this.liffSDK.initPlugins(a);
    }

    //format : yyyy-MM-ddTHH:mm:ss.sss+08:00
    getEsTimestamp(a) {
        var b = a.getHours();
        return a.setHours(b + 8), a = a.toJSON(), a = a.replace("Z", "+08:00")
    }

    //format : yyyyMMddHHmmss
    getEsTimestamp2(a) {
        var b = a.getHours();
        a.setHours(b + 8);
        a = a.toJSON();
        a = a.replace("T", "");
        a = a.replace(/:/g, "");
        a = a.replace(/-/g, "");
        a = a.substring(0,a.indexOf('.'));
        return a;
    }

    logInfo(log_userId,log_os,log_isInClient,action){
        let platform = navigator.platform;
        let userAgent = navigator.userAgent;
        let actionUrl = window.location.href;

        let host = window.location.hostname;
        let pathname = window.location.pathname;
        let protocol = window.location.protocol;
        let search = window.location.search;

        if(platform === undefined || platform === null){
            platform = '';
        }
        if(userAgent === undefined || userAgent === null){
            userAgent = '';
        }                                                                        
        if(actionUrl === undefined || actionUrl === null){
            actionUrl = '';
        }     

        if(host === undefined || host === null){
            host = '';
        }                                                                        
        if(pathname === undefined || pathname === null){
            pathname = '';
        }                                                                        
        if(protocol === undefined || protocol === null){
            protocol = '';
        }                                                                        
        if(search === undefined || search === null){
            search = '';
        }


        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function()
        {
            if(xhttp.readyState == 4 && xhttp.status == 200)
            {
                console.log("do log done");                     
            }
        }

        xhttp.open("POST", this.config_loadScriptAPIUrl+"/basicLog", true);
        xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        var sendParam = ""
        sendParam = "botID="+this.botID+"&userID="+log_userId+""
        sendParam +="&liffID="+this.liffID
        sendParam +="&platform="+platform
        sendParam +="&userAgent="+encodeURIComponent(userAgent)
        sendParam +="&os="+log_os
        sendParam +="&isInClient="+log_isInClient
        sendParam +="&actionUrl="+encodeURIComponent(actionUrl)
        sendParam +="&protocol="+protocol
        sendParam +="&host="+host
        sendParam +="&pathname="+pathname
        sendParam +="&search="+encodeURIComponent(search)
        sendParam +="&params="+JSON.stringify(this.params)  
        sendParam +="&action="+action

        xhttp.send(sendParam);
    }

    getFriendship() {
        return this.liffSDK.getFriendship();
    }
    
    shareTargetPicker(a) {
        return this.liffSDK.shareTargetPicker(a);
    }

    getVersion(){
        return this.liffSDK.getVersion();
    }

}