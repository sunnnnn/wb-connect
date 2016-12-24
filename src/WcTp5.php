<?php
namespace sunnnnn\wbconnect;

class WcTp5{
	private $inc;
	private $oauth;
	private $client;
	
	public function __construct(){
		$this->inc = config('wbconnect');
		
		if(empty($this->inc)){
			exit('Please set the configuration file <param:wbconnect>!');
		}
		
		$this->oauth  = new SaeTOAuthV2($this->inc['key'], $this->inc['secret'], null, null);
	}
	
	public function getOauthObj(){
		return $this->oauth;
	}
	
	public function getClientObj($access_token){
		$this->client = new SaeTClientV2($this->inc['key'], $this->inc['secret'], $access_token);
		return $this->client;
	}
	
	public function getLoginUrl(){
		return $this->oauth->getAuthorizeURL($this->inc['callback']);
	}
	
	public function getAccessToken($code){
		if(empty($code)){
			exit('Please input param code !');
		}
		return $this->oauth->getAccessToken('code', ['code' => $code, 'redirect_uri' => $this->inc['callback']]) ;
	}
	
	public function getUserId($access_token){
		if(empty($access_token)){
			exit('Please input param access_token !');
		}
		$this->client = new SaeTClientV2($this->inc['key'], $this->inc['secret'], $access_token);
		$ms  = $this->client->home_timeline();
		$uid_get = $this->client->get_uid();
		$uid = $uid_get['uid'];
		return empty($uid) ? 0 : intval($uid);
	}
	
	public function getUserInfoById($uid){
		if(empty($uid)){
			exit('Please input param uid !');
		}
		return $this->client->show_user_by_id($uid);
	}
	
	public function getUserInfo($code){
		if(empty($code)){
			exit('Please input param code !');
		}
		$token = $this->oauth->getAccessToken('code', ['code' => $code, 'redirect_uri' => $this->inc['callback']]) ;
		if(empty($token)){
			exit('get access token error !');
		}
		$this->client = new SaeTClientV2($this->inc['key'], $this->inc['secret'], $token['access_token']);
		$ms  = $this->client->home_timeline();
		$uid_get = $this->client->get_uid();
		$uid = $uid_get['uid'];
		$user_message = $this->client->show_user_by_id($uid);
		return empty($user_message) ? [] : $user_message;
	}
}