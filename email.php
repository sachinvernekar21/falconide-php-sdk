<?php

class Email {
	
	private $from;
	private $fromname;
	private $replytoid;
	private $subject;
	private $content;
	private $rcpt_email = array();
	private $footer;
	private $template;
	private $clicktrack;
	private $opentrack;
	private $unsubscribe;
	private $templateid;
	private $bcc = array();
	private $attachmentid = array();
	private $recipents_cc = array();
	private $xapiheaders = array();
	private $tags = array();
	private $attachment = array();
	private $attribute = array();
	private $trigdata = array();
			
	function setFrom($from) {
		if ($this->validateEmail($from)) {
			$this->from = $from;
		}
	}
	
	function getFrom() {
		return $this->from;
	}
	
	function setFromname($fromname) {
		$this->fromname = $this->url_encode($fromname);
	}
	
	function getFromname() {
		return $this->fromname;
	}
	
	function setReplytoid($replytoid) {
		if ($this->validateEmail($replytoid)) {
			$this->replytoid = $replytoid;
		}
	}
		
	function getReplytoid() {
		return $this->replytoid;
	}
	
	function setSubject($subject) {
		if (empty($subject)) {
			throw new Exception("Subject Cannot be Blank");
		}
		$this->subject = $this->url_encode($subject);
	}
	
	function getSubject() {
		return $this->subject;
	}
	
	function setContent($content) {
		if (empty($content)) {
			throw new Exception("Content Cannot be Blank");
		}
		$this->content = $this->url_encode($content);
	}
	
	function getContent() {
			return $this->content;
	}
	
	function addRecipients($email) {
		if ($this->validateEmail($email)) {
			array_push($this->rcpt_email, $email);
		}
	}
	
	function getRecipients() {
		return $this->rcpt_email;
	}
	
	function validateEmail($email) {
		if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
			throw new Exception("Email id is not in proper format");
		}
		return true;
	}
	
	function url_encode($string) {
		return rawurlencode($string);
	}
	
	function setFooter($footer) {
		if((!intval($footer)) && ($footer == 1 || $footer == 0)) {
			throw new Exception("Footer can be 0 or 1");
		}
		$this->footer = $footer;
	}
	
	function getFooter() {
		return $this->footer;
	}

	function setClicktrack($clicktrack) {
		if((!intval($clicktrack)) && ($clicktrack == 1 || $clicktrack == 0)) {
			throw new Exception("Clicktrack can be 0 or 1");
		}
		$this->clicktrack = $clicktrack;
	}
	
	function getClicktrack() {
		return $this->clicktrack;
	}
	
	function setOpentrack($opentrack) {
		if((!intval($opentrack)) && ($opentrack == 1 || $opentrack == 0)) {
			throw new Exception("Opentrack can be 0 or 1");
		}
		$this->opentrack = $opentrack;
	}
	
	function getOpentrack() {
		return $this->opentrack;
	}
	
	function setUnsubscribe($unsubscribe) {
		if((!intval($unsubscribe)) && ($unsubscribe == 1 || $unsubscribe == 0)) {
			throw new Exception("Unsubscribe can be 0 or 1");
		}
		$this->unsubscribe = $unsubscribe;
	}
	
	function getUnsubscribe() {
		return $this->unsubscribe;
	}
	
	function setAttachmentid($attachmentid) {
		if(!intval($attachmentid) && $attachmentid > 0) {
			throw new Exception("Attachment id should be a integer");
		}
		array_push($this->attachmentid, $attachmentid);
	}
	
	function getAttachmentid() {
		return $this->attachmentid;
	}
	
	function setTemplateid($templateid) {
		if(!intval($templateid) && $templateid > 0) {
			throw new Exception("Templateid id should be a integer");
		}
		$this->templateid = $templateid;
	}
	
	function getTemplateid() {
		return $this->templateid;
	}
	
	function setBcc($bcc_address) {
		if ($this->validateEmail($bcc_address)) {
			array_push($this->bcc, $bcc_address);
		}
	}
	
	function getBcc() {
		return $this->bcc;
	}
	
	function setXAPIheaders($xapi) {
		if(strlen($xapi) > 255) {
			throw new Exception("X-APIHEADER cannot be more than 255 characters");
		}
		array_push($this->xapiheaders, $xapi); 
	}
	
	function getXAPIheaders() {
		return $this->xapiheaders;
	}
	
	function setCC($cc_address) {
		if($this->validateEmail($cc_address)) {
			array_push($this->recipents_cc, $cc_address);
		}		 
	}
	
	function getCC() {
		return $this->recipents_cc;
	}
	
	function setTags($tags) {
		if(strlen($tags) > 255) {
			throw new Exception("Length of the tags cannot be greater than 255");
		}
		array_push($this->tags, $tags);
	}
	
	function getTags() {
		return $this>tags;
	}
	
	function addAttachment($filename) {
		if(!file_exists($filename)) {
			throw new Exception("File not exist");
		}
		$fc = file_get_contents($filename);
		$data = base64_encode($fc);
		$att_name = basename($filename);
		$this->attachment[$att_name] = $data;
	}
	
	function getAttachment() {
		return $this->attachment;
	}
	
	function addAttribute($att_name, $att_value) {
		if(!array_key_exists($att_name, $this->attribute)) $this->attribute[$att_name] = array();
		array_push($this->attribute[$att_name], $att_value);
	}
	
	function getAttribute() {
		return $this->attribute;
	}
	
	function addTrigData($table) {
		$this->trigdata[] = $table->get();
	}
	
	function getTrigData() {
		return $this->trigdata;
	}
	
}

?>
