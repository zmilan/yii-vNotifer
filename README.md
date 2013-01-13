# yii-vNotifier


This extension provides a Node.js application (notification server), and a set of Yii classes for easy usage.

Please note: at the current stage this is only a tech demo, as many error handling and functions are not implemented yet.

### Requirements:


* Working Node.js
* Node.js modules: redis, socket.io
* Working Redis server
* <a href="https://github.com/nrk/predis">predis library</a> copied into the notifier extension folder

### What's included?

* Node.js server app (in /bin)
* Notifier application component
* WebUser base class
* Notification area widget

### Usage

* set yii application component in config/main.php
```php
...
  'components' => array(
      'user' => array(
        'class' => 'ext.yii-vNotifier.NotifiedWebUser',
        ...
      ),
      ...
      'notifier' => array(
    	    'class' => 'ext.yii-vNotifier.VNotifier',
          'messageStoreConfig' => array(	
              'class' => 'LocalMessageStore',
			    ),
		  ),
  ),
...
```

* start redis
* start notification-server.js
* send notifications from your app :)


