/**
 * @namespace
 */
vn = {};
/**
 * @class
 */
vn.Client = function(config) {
	// socket io client
	var socket = io.connect(config.socketioUrl + '?secret=' + config.userSecret);
	
	// handle notify event
	socket.on('notify',function(notification) {
		if(vn.NotificationHandlers[notification.type]) {
			vn.NotificationHandlers[notification.type](notification.message);
		} else {
			vn.NotificationHandlers['__default__'](notification.message);
		}
	});
}

/**
 * Custom Notification handlers
 */
vn.NotificationHandlers = {
	__default__ : function(message) {
		console.log(message);
	}
};


