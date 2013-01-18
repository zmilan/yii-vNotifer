<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of vdxMessagestore
 *
 * @author pgee
 */
class vdxMessageStore extends CComponent implements IMessageStore {
	/**
	 * Hostname of the apiserver
	 * @var string
	 */
	public $apiHost = 'localhost';
	public $apiPort = 1337;

	public function __construct() {
	}

	private function api($url,$data) {
		$ch = curl_init();
		
		curl_setopt($ch,CURLOPT_URL, 'http://'.$this->apiHost.':'.$this->apiPort.$url);
		curl_setopt($ch,CURLOPT_POSTFIELDS, CJSON::encode($data));
		curl_setopt($ch,CURLOPT_RETURNTRANSFER, 1);

		$response = curl_exec($ch);

		//close connection
		curl_close($ch);

		return CJSON::decode($response);
	}

	/**
	 * Publish the given message to redis
	 * @param type $channel
	 * @param type $message
	 */
	public function publishMessage($channel,$message) {
		$this->api('/publish',array(
			'channel' => $channel,
			'message' => $message,
		));	
	}
	
	/**
	 * Reads the user's secret from redis
	 * @param type $user_id
	 * @return type
	 */
	public function getUserSecret($user_id) {
		$response = $this->api('/getusersecret', array(
			'user_id' => $user_id,
		));

		return $response['userSecret'];
	}

	/**
	 * Generates a uniqe secret hash for the given user
	 * @param type $user_id
	 * @return type
	 */
	public function generateUserSecret($user_id,$refresh = false) {
		$response = $this->api('/generateusersecret',array(
			'user_id' => $user_id,
		));

		return $response['userSecret'];
	}
}

?>
