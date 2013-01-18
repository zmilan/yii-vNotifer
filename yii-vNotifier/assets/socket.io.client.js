/**
 * @namespace
 */
vn = {};
/**
 * @class
 */
vn.Client = function(config) {
		// socket io client
		console.log(config);
	var socket = io.connect(config.socketioUrl + '?secret=' + config.userSecret);
	
	// handle notify event
	socket.on('notify',function(notification) {
		if(vn.NotificationHandlers['__default__']) {
			vn.NotificationHandlers['__default__'](notification);
		}
	});
}

/**
 * Custom Notification handlers
 */
vn.NotificationHandlers = {};


