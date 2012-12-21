# yii-vNotifier


This extensions provide a Node.js application (notification server), and a set of Yii class for the easy usage.

Please notice: at the current stage this is only a tech demo, as many error handling and function are not implemented yet.

### Requirements:


* Working Node.js
* Node.js modules: redis, socket.io
* Working Redis server 

### What's in?

* Node.js server app (in /bin)
* <a href="https://github.com/nrk/predis">predis library</a>
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
        'redisConnectionString' => 'tcp://examplt.com:3000', // optional redis connection string
        'socketioUrl' => 'http://localhost', // optional socket.io url, if omitted the request's hostname will be used
        'socketioPort' => 4001, // optionsl, if omitted 4001 will be used
      ),
  ),
...
```

* start redis
* start notification-server.js
* send notifications from your app :)


