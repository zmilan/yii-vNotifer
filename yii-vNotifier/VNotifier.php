<?php

/**
 * VdxNotification Singleton application component
 *
 * @author pgee
 */


Yii::setPathOfAlias('vNotifier',dirname(__FILE__));
Yii::import('vNotifier.LocalMessageStore');

class VNotifier extends CApplicationComponent {
	/**
	 * Should we save the notifications to a persistent database or not
	 * @var boolean
	 */
	public $saveHistory = false;


	/**
	 * Url of the notification server
	 * @var string
	 */
	public $socketioUrl;
	/**
	 * The port where socket.io listens
	 * @var string
	 */
	public $socketioPort = 4001;
	/**
	 * Config params of the message store
	 * @var array
	 */
	public $messageStoreConfig = array();
	/**
	 * MessageStore object
	 * @var IMessageStore
	 */
	private $_ms;

	public function init() {
		parent::init();
		
		if(!isset($this->socketioUrl)) {
			// set the default notification server url
			$this->socketioUrl = Yii::app()->request->getHostInfo().':'.$this->socketioPort;
		}

		$this->_ms = Yii::createComponent($this->messageStoreConfig);
		if(! $this->_ms instanceof IMessageStore) {
			throw new CException('Message Store must implement IMessageStore');
		}
	}

	/**
	 * Sends a message to the given user
	 * @param type $user_id
	 * @param type $message
	 */
	public function send($user_id,$message) {
		$this->publish($this->getUserSecret($user_id), $message);
	}
	
	/**
	 * Send a broadcast message
	 * @param type $message
	 */
	public function broadcast($message) {
		$this->publish('broadcast', $message);
	}

	/**
	 * Publish the given message to the message store
	 * @param type $channel
	 * @param type $message
	 */
	private function publish($channel,$message) {
		$this->_ms->publishMessage($channel,$message);
	}
	
	/**
	 * Reads the user's secret from the message store
	 * @param type $user_id
	 * @return type
	 */
	public function getUserSecret($user_id) {
		return $this->_ms->getUserSecret($user_id);
	}


	/**
	 * Generates a uniqe secret hash for the given user
	 * @param type $user_id
	 * @return type
	 */
	public function generateUserSecret($user_id) {
		$this->_ms->generateUserSecret($user_id);
	}

}

?>
