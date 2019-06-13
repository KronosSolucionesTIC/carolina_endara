<? 

/*****************************
 * 
 * Class InfoEmail
 * 
 * ****************************/

class InfoEmail 
{

	private $name;
	function setName($n) 
	{
		$this->name = $n;
	}
	function getName() 
	{
		return $this->name;
	}
	
	private $email;
	function setEmail($n) 
	{
		$this->email = $n;
	}
	function getEmail() 
	{
		return $this->email;
	}

	function InfoEmail($n="", $e="")
	{
		$this->name = $n;
		$this->email = $e;
	}
	
	function toString()
	{
		return $this->name . " <" . $this->email . ">";
	}
	
}

/*****************************
 * 
 * Class Email
 * 
 * ****************************/

class Email 
{
	
	private $emailsFor = array();
	function addEmailFor($name, $email) 
	{
		$this->emailsFor[$name] = new InfoEmail($name, $email);
	}
	function getEmailsFor() 
	{
		return $this->emailsFor;
	}
	
	private $emailsCC = array();
	function addEmailCC($name, $email) 
	{
		$this->emailsCC[$name] = new InfoEmail($name, $email);
	}
	function getEmailsCC() 
	{
		return $this->emailsCC;
	}
	
	private $emailsBCC = array();
	function addEmailBCC($name, $email) 
	{
		$this->emailsBCC[$name] = new InfoEmail($name, $email);
	}
	function getEmailsBCC() 
	{
		return $this->emailsBCC;
	}
	
	private $emailFrom;
	function setEmailFrom($name, $email) 
	{
		$this->emailFrom = new InfoEmail($name, $email);
	}
	function getEmailFrom() 
	{
		return $this->emailFrom;
	}
	
	public $isHTML;
	
	private $subject;
	function setSubject($s) 
	{
		$this->subject = $s;
	}
	function getSubject() 
	{
		return $this->subject;
	}
	
	private $body;
	function setBody($s) 
	{
		$this->body = $s;
	}
	function getBody() 
	{
		return $this->body;
	}
	
	function Email()
	{
		$this->isHTML = false;
	}
	
	private function getStringEmails($ar)
	{
		$result = "";
		$sw =  true;
		foreach ($ar as $f) {
			if ($sw) {
				$sw = false;
			} else {
				$result .= ",";
			}
			$result .= $f->toString();
		}
		return $result;
	}
	
	function send() 
	{
		
		$heads = "";
		if ($this->isHTML) {
			$heads  .= 'MIME-Version: 1.0' . "\r\n";
			$heads .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
		}
		
		$heads .= 'To: ' . $this->getStringEmails($this->emailsFor) . "\r\n";
		$heads .= 'From: ' . $this->emailFrom->toString() . "\r\n";
		$heads .= 'Cc: ' . $this->getStringEmails($this->emailsCC) . "\r\n";
		$heads .= 'Bcc: ' . $this->getStringEmails($this->emailsBCC) . "\r\n";
		
		return mail($this->getStringEmails($this->emailsFor), $this->subject, $this->body, $heads); 
	}
	
	
}


?>