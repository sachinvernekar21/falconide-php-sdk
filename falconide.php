<?php

class Falconide {
	
	private $url;
	private $api_key;
	private $timeout;
	private $falcon_det = array();
	
	function __construct($api_key) {
		$this->api_key = $api_key;
		$this->url = "https://api.falconide.com/falconapi/web.send.json";
		$this->timeout = 20;
	}
	
	function sendmail($email) {
		$json_data = $this->createJson($email);
		$data =array();
		$data['data'] = $json_data;
		print $this->http_post_form($data);
	}
	
	function createJson($email) {
		$falcon_det['api_key'] = $this->api_key;
		
		$falcon_det['email_details']['fromname'] = $email->getFromname();
		$falcon_det['email_details']['from'] = $email->getFrom();
		$falcon_det['email_details']['subject'] = $email->getSubject(); 
		$falcon_det['email_details']['replytoid'] = $email->getReplytoid(); 
		$falcon_det['email_details']['content'] = $email->getContent(); 
		
		if(!empty($email->getTags())) $falcon_det['email_details']['tags'] = explode(",", $email->getTags());
		
		$rcpt_email = $email->getRecipients();
		if (count($rcpt_email) <= 0) {
			throw new Exception("Email id is not in proper format");
		}
		$falcon_det['recipients'] = $rcpt_email;
		
		$settings = $this->createOptionalSettings($email);
		if(!empty($settings)) {
			$falcon_det['settings'] = $settings;
		}			
		
		if(!empty($email->getCC())) $falcon_det['recipients_cc'] = $email->getCC();
		
		if(!empty($email->getXAPIheaders())) $falcon_det['X-APIHEADER'] = $email->getXAPIheaders();
		
		if(!empty($email->getAttachment())){
			$attachment = $email->getAttachment();	
			foreach($attachment as $key => $value) {
				$falcon_det['files'][$key] = $value;
			}
		} 		
		
		$attribute = $email->getAttribute();
		if(!empty($attribute)) {
			foreach($attribute as $key => $value) {
				$falcon_det['attributes'][$key] = $value;
			}
		}
		if(!empty($email->getTrigData())) $falcon_det['trigdata'] = $email->getTrigData();
		
		$json_data = json_encode($falcon_det);
		print json_encode($falcon_det, JSON_PRETTY_PRINT);
		
		return $json_data;
	}
	
	function createOptionalSettings($email) {
		$optional_det = array();
		
		if(!empty($email->getFooter())) $optional_det['footer'] = $email->getFooter();
		if(!empty($email->getClicktrack())) $optional_det['clicktrack'] = $email->getClicktrack();
		if(!empty($email->getOpentrack())) $optional_det['opentrack'] = $email->getOpentrack();
		if(!empty($email->getUnsubscribe())) $optional_det['unsubscribe'] = $email->getUnsubscribe();
		if(!empty($email->getTemplateid())) $optional_det['template'] = $email->getTemplateid();
		if(!empty($email->getBcc())) $optional_det['bcc'] = explode(",", $email->getTemplateid());
		if(!empty($email->getAttachmentid())) $optional_det['attachmentid'] = explode(",", $email->getAttachmentid());
		
		return $optional_det;		
	}
	
	function http_post_form($data) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->url);
        curl_setopt($ch, CURLOPT_FAILONERROR, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_TIMEOUT, $this->timeout);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 0);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        $result = curl_exec($ch);
        $result = curl_error($ch) ? curl_error($ch) : $result;
        curl_close($ch);
        return $result;
    }

}


?>
