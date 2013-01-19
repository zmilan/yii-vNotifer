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
//	public $apiUrl = 'localhost:1337;
	public $apiUrl = 'http://vdx-messagestore.eu01.aws.af.cm';
	public $appSecret = 'Coming Soon';

	/**
	 * Returns the url where socket.io listens
	 * @return  string
	 */
	public function getSocketIOUrl() {
		return $this->apiUrl;
	}

	/**
	 * Makes an api call
	 * @param string $url the action as a pathname
	 * @param array $data the params of the specified action
	 * @return array the response from the api server
	 */
	private function api($url,$data) {
		$ch = curl_init();

		$data['__app_secret__'] = $this->appSecret; 
		
		curl_setopt($ch,CURLOPT_URL, $this->apiUrl.$url);
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
