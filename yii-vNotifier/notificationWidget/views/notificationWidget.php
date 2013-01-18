<h1>Notifications</h1>
<div id="notification-area">
	<ul data-bind="foreach: notifications">
		<li data-bind="text: message"></li>
	</ul>
</div>
<?php
	/* @var $this NotificationWidget */
	$config = CJSON::encode(array(
		'userSecret' => Yii::app()->user->getSecret(),
		'socketioUrl' => $this->getNotifier()->socketioUrl,
	));

	

	$script = <<<EOT
	(function() {
			// notification area
		var notificationArea = document.getElementById('notification-area'),
			// KnockoutJS View Model
			viewModel = {
				notifications : ko.observableArray()
			};

		ko.applyBindings(viewModel,notificationArea);
	
		vn.NotificationHandlers.__default__ = function(notification) {
			viewModel.notifications.push({message : notification});
	
			setTimeout(function() {
				viewModel.notifications.shift();
			}, 5000);
		};
		var notifierClient = new vn.Client({$config});
	})();
EOT;
	Yii::app()->clientScript->registerScript('vNotifierClient',$script);
?>

