function callNativeApp(sender, handler, data) {
  var wrapper = { sender: sender, handler: handler };
  if (data) {
    wrapper.withObject = data;
  }

  // iOS
  if (window['webkit'] && webkit.messageHandlers.callbackHandler) {
    webkit.messageHandlers.callbackHandler.postMessage(wrapper);
    // Chrome on Android
  } else if (window['nativeApp']) {
    nativeApp.callFromJS(JSON.stringify(wrapper));
  } else {
    console.log('The native context does not exist yet');
  }
}
