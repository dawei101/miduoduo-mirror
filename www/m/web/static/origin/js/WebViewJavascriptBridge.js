//notation: js file can only use this kind of comments
//since comments will cause error when use in webview.loadurl,
//comments will be remove by java use regexp
(function() {
if (window.WebViewJavascriptBridge) {
    return;
}

var messagingIframe;
var sendMessageQueue = [];
var receiveMessageQueue = [];
var messageHandlers = {};
 var defaultHandler;

var CUSTOM_PROTOCOL_SCHEME = 'miduoduo';
var QUEUE_HAS_MESSAGE = '__QUEUE_MESSAGE__/';

var responseCallbacks = {};
var uniqueId = 1;

function _createQueueReadyIframe(doc) {
    messagingIframe = doc.createElement('iframe');
    messagingIframe.style.display = 'none';
    doc.documentElement.appendChild(messagingIframe);
}

function isAndroid() {
    var ua = navigator.userAgent.toLowerCase();
    var isA = ua.indexOf("android") > -1;

    if (isA) {
        return true;
    }
    return false;
}

function isIphone() {
    var ua = navigator.userAgent.toLowerCase();
    var isIph = ua.indexOf("iphone") > -1;

    if (isIph) {
        return true;
    }
    return false;
}

//set default messageHandler
function init(messageHandler) {
    if (WebViewJavascriptBridge._messageHandler) {
        throw new Error('WebViewJavascriptBridge.init called twice');
    }

    WebViewJavascriptBridge._messageHandler = messageHandler;
    var receivedMessages = receiveMessageQueue;
    receiveMessageQueue = null;
    for (var i = 0; i < receivedMessages.length; i++) {
        _dispatchMessageFromNative(receivedMessages[i]);
    }
}

function send(data, responseCallback) {
    _doSend({
        data: data
    }, responseCallback);
}

 function defaultHandler(handler) {
    defaultHandler = handler;
 }
 
function registerHandler(handlerName, handler) {
    messageHandlers[handlerName] = handler;
}

function callHandler(handlerName, data, responseCallback) {
    _doSend({ handlerName: handlerName, data: data }, responseCallback);
}

//sendMessage add message, è§¦å‘nativeå¤„ç† sendMessage
function _doSend(message, responseCallback) {
    if (responseCallback) {
        var callbackId = 'cb_' + (uniqueId++) + '_' + new Date().getTime();
        responseCallbacks[callbackId] = responseCallback;
        message.callbackId = callbackId;
    }

    sendMessageQueue.push(message);
    messagingIframe.src = CUSTOM_PROTOCOL_SCHEME + '://' + QUEUE_HAS_MESSAGE;
}

// æä¾›ç»™nativeè°ƒç”¨,è¯¥å‡½æ•°ä½œç”¨:èŽ·å–sendMessageQueueè¿”å›žç»™native,ç”±äºŽandroidä¸èƒ½ç›´æŽ¥èŽ·å–è¿”å›žçš„å†…å®¹,æ‰€ä»¥ä½¿ç”¨url shouldOverrideUrlLoading çš„æ–¹å¼è¿”å›žå†…å®¹
function _fetchQueue() {
    var messageQueueString = JSON.stringify(sendMessageQueue);
    sendMessageQueue = [];
    //add by hq
    if (isIphone()) {
        return messageQueueString;
    //android can't read directly the return data, so we can reload iframe src to communicate with java
    } else if (isAndroid()) {
        messagingIframe.src = CUSTOM_PROTOCOL_SCHEME + '://return/_fetchQueue@' + messageQueueString;
    }
}

//æä¾›ç»™nativeä½¿ç”¨,
function _dispatchMessageFromNative(messageJSON) {
    setTimeout(function timeoutDispatchMessageFromNative() {
        var message = JSON.parse(messageJSON);
        var responseCallback;

        //java call finished, now need to call js callback function
        if (message.responseId) {
            responseCallback = responseCallbacks[message.responseId];

            if (!responseCallback) {
                return;
            }
            responseCallback(message.responseData);
            delete responseCallbacks[message.responseId];
        } else {
            //ç”± native å‘ html å‘é€æ¶ˆæ¯
            if (message.callbackId) { // åˆ›å»ºç”± html å‘ native å‘é€æ¶ˆæ¯çš„å›žè°ƒå‡½æ•°
                var callbackResponseId = message.callbackId;
                responseCallback = function(responseData) {
                _doSend({ responseId: callbackResponseId,responseData: responseData });
                }
            }

            var handler = WebViewJavascriptBridge._messageHandler;
            if (message.handlerName) {// æ‰¾åˆ° html æ³¨å†Œçš„handler
                handler = messageHandlers[message.handlerName];
               } else {// å‘é€é»˜è®¤ handler
               handler = defaultHandler;
               }
            //æŸ¥æ‰¾æŒ‡å®šhandler
            try {
                handler(message.data, responseCallback);
            } catch (exception) {
                if (typeof console != 'undefined') {
                    console.log("WebViewJavascriptBridge: WARNING: javascript handler threw.", message, exception);
                }
            }
        }
    });
}

//æä¾›ç»™nativeè°ƒç”¨,receiveMessageQueue åœ¨ä¼šåœ¨é¡µé¢åŠ è½½å®ŒåŽèµ‹å€¼ä¸ºnull,æ‰€ä»¥
function _handleMessageFromNative(messageJSON) {
    if (receiveMessageQueue) {
        receiveMessageQueue.push(messageJSON);
    } else {
        _dispatchMessageFromNative(messageJSON);
    }
}

var WebViewJavascriptBridge = window.WebViewJavascriptBridge = {
    init: init,
    send: send,
    defaultHandler:defaultHandler,
    registerHandler: registerHandler,
    callHandler: callHandler,
    _fetchQueue: _fetchQueue,
    _handleMessageFromNative: _handleMessageFromNative
};

var doc = document;
_createQueueReadyIframe(doc);
init(function (data, responseCallback) {
    responseCallback();
});

var readyEvent = doc.createEvent('Events');
readyEvent.initEvent('WebViewJavascriptBridgeReady');
readyEvent.bridge = WebViewJavascriptBridge;
doc.dispatchEvent(readyEvent);
})();
