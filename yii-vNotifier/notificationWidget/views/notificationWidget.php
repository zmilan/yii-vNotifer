<h1>Notifications</h1>
<div id="notification-area">
	<ul data-bind="template : {foreach: notifications, beforeRemove: beforeRemove, afterAdd : afterAdd }">
		<li class="gradient" data-bind="text: message"></li>
	</ul>
</div>
<script type="text/html">
</script>
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
				notifications : ko.observableArray(),
				beforeRemove : function(el) {
					$(el).fadeOut(400);
				},
				afterAdd : function(el) {
					$(el).hide().fadeIn(400);
				}
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

