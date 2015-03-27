<?php
require_once(@$cfg['library_dir']."emailexception.php");
define("BOUNDARY", "--".md5(rand()));
class CMail
{
	var $from;        // Your email
	var $fromName;    // Your name
	var $to;          // Target email
	var $cc;          // Carbon Copy
	var $bcc;         // Blind Carbon Copby
	var $subject;     // Email Subject
	var $priority;    // Email Priority 1-5
	var $returnPath;  // when reply use this email
	var $notify;      // send back notification
	var $message;     // email message
	var $charset;     // text charset, default iso-8859-1
	var $mime;        // text mime, default text/plain
	var $debug;       // if debug mode - show errors
	
	var $body;
	var $header;
	var $attachments = Array();
	var $priorities = Array(1 =>
		'1 (Highest)',
		'2 (High)',
		'3 (Normal)',
		'4 (Low)',
		'5 (Lowest)');
	

	function __construct()
	{
		$this->clear();
	}

	function clear()
	{
		$this->mime        = "text/plain";
		$this->message     = "";
		$this->charset     = "iso-8859-1";
		$this->from        = "";
		$this->fromName    = "";
		$this->to          = "";
		$this->cc          = "";
		$this->bcc         = "";
		$this->subject     = "";
		$this->returnPath  = "";
		$this->notify      = "";
		$this->priority    = 0;
		$this->debug       = FALSE;
		
		$this->clearAttachments();
	}

	function isValidEmail($email)
	{
		return eregi("^([-!#\$%&'*+./0-9=?A-Z^_`a-z{|}~])+@([-!#\$%&'*+/0-9=?A-Z^_`a-z{|}~]+\\.)+[a-zA-Z]{2,6}\$", $email) != 0;
	}
	
	function getMimeType($file)
	{
		// mime types for files
		static $mimeTypes = Array(
			'.gif'  => 'image/gif',
			'.jpg'  => 'image/jpeg',
			'.jpeg' => 'image/jpeg',
			'.jpe'  => 'image/jpeg',
			'.bmp'  => 'image/bmp',
			'.png'  => 'image/png',
			'.tif'  => 'image/tiff',
			'.tiff' => 'image/tiff',
			'.swf'  => 'application/x-shockwave-flash',
			'.doc'  => 'application/msword',
			'.xls'  => 'application/vnd.ms-excel',
			'.ppt'  => 'application/vnd.ms-powerpoint',
			'.pdf'  => 'application/pdf',
			'.ps'   => 'application/postscript',
			'.eps'  => 'application/postscript',
			'.rtf'  => 'application/rtf',
			'.bz2'  => 'application/x-bzip2',
			'.gz'   => 'application/x-gzip',
			'.tgz'  => 'application/x-gzip',
			'.tar'  => 'application/x-tar',
			'.zip'  => 'application/zip',
			'.rar'  => 'application/rar',
			'.js'   => 'text/javascript',
			'.html' => 'text/html',
			'.htm'  => 'text/html',
			'.txt'  => 'text/plain',
			'.css'  => 'text/css'
		);

		$att = StrRChr(StrToLower($file), ".");
		if(!IsSet($mimeTypes[$att]))
			return "application/octet-stream";
		else
			return $mimeTypes[$att];
	}

	function clearAttachments()
	{
		$this->attachments = Array();
	}

	function addAttachment($filename, $inner_name = "", $mime = "")
	{
		if(!file_exists($filename))
		{}//throw new EmailException("Attachment $filename file not found");

		if(!is_readable($filename))
		{}//throw new EmailException("Unable to read $filename attachment");

		if($inner_name == "")
			$inner_name = basename($filename);

		// if not mime selected - look up into MimeTypes array		
		if($mime == "")
			$mime = $this->getMimeType($inner_name);
			
		$attachment = "";
		
		$attachment .= "--".BOUNDARY."\n";
		$attachment .= "Content-Type: $mime; name=\"".$inner_name."\"\n";
		$attachment .= "Content-Transfer-Encoding: base64\n";
		$attachment .= "Content-Disposition: inline; filename=\"".$inner_name."\"\n\n";
		$attachment .= chunk_split(base64_encode(file_get_contents($filename)));
		
		array_push($this->attachments, $attachment);
		
	}

	function stripnl($string)
	{
		return str_replace(array("\n", "\r", "\t"), "", $string);
	}

	function send($emailfile = "")
	{
		$this->body        = "";
		$this->header      = "";

		if(strlen($this->from))
			if(!$this->isValidEmail($this->from))
			{} //throw new EmailException("From: ".$this->from." is not valid email");

		if(strlen($this->returnPath))
		{
			if(!$this->isValidEmail($this->returnPath))
			{}//throw new EmailException("Return Path ".$this->returnPath." is not valid email");
			$this->header .= "Return-path: <".$this->returnPath.">\n";
		}
		
		if(strlen($this->from))
			$this->header .= "From: ".$this->stripnl($this->fromName)." <".$this->from.">\n";

		$invalidEmail = $this->getInvalidEmail($this->to);
		if(!Empty($invalidEmail))
		{}//throw new EmailException("Email To: $invalidEmail is not valid!");
		
		if(!Empty($this->cc))
		{
			$invalidEmail = $this->getInvalidEmail($this->to);
			if(!Empty($invalidEmail))
			{}//throw new EmailException("Email Cc: $invalidEmail is not valid!");
			$this->header .= "Cc: ";
			$this->header .= is_array($this->cc) ? implode(", ", $this->cc) : $this->cc;
			$this->header .= "\n";
		}
			
		if(!Empty($this->bcc))
		{
			$invalidEmail = $this->getInvalidEmail($this->to);
			if(!Empty($invalidEmail))
			{}//throw new EmailException("Email Bcc: $invalidEmail is not valid!");

			$this->header .= "Bcc: ";
			$this->header .= is_array($this->bcc) ? implode(", ", $this->bcc) : $this->bcc;
			$this->header .= "\n";
		}

		$this->header .= "Mime-Version: 1.0\n";
		
		if(IntVal($this->notify) == 1)
			$this->header .= "Disposition-Notification-To: <".$this->from.">\n";
		else if(strlen($this->notify))
			$this->header .= "Disposition-Notification-To: <".$this->notify.">\n";
			
		if(!Empty($this->attachments))
		{
			// header with attachments
			$this->header .= "Content-Type: multipart/mixed; boundary=\"".BOUNDARY."\"\n";
			$this->header .= "Content-Transfer-Encoding: 7bit\n";
			$this->body   .= "This is a multi-part message in MIME format.\n\n";
		}
		else
		{
			// header with no attachments
			$this->header .= "Content-Transfer-Encoding: 8bit\n";
			$this->header .= "Content-Type: ".$this->stripnl($this->mime)."; charset=\"".$this->stripnl($this->charset)."\"".(Empty($emailfile) ? "" : " name=\"$emailfile\"")."\n";
			$this->body   .= $this->message;
		}

		if($this->priority)
			$this->header .= "X-Priority: ".$this->priorities[$this->priority]."\n";
		
		if(!Empty($this->attachments))
		{
			$this->body .= "\n\n--".BOUNDARY."\n";
			$this->body .= "Content-Transfer-Encoding: 8bit\n";
			$this->body .= "Content-Type: ".$this->stripnl($this->mime)."; charset=\"".$this->stripnl($this->charset)."\"".(Empty($emailfile) ? "" : " name=\"$emailfile\"")."\n";
			$this->body .= "Mime-Version: 1.0\n\n";
			$this->body .= $this->message."\n\n\n";

			foreach($this->attachments as $attachment)
			{
    			$this->body .= $attachment;
			}
			
			$this->body .= "--".BOUNDARY."--";
		}
		
		if($this->debug)
		{
			echo "<pre>";
			echo "\nTO\n".HTMLSpecialChars($this->to);
			echo "\nSUBJECT\n".HTMLSpecialChars($this->subject);
			echo "\nBODY\n".HTMLSpecialChars($this->body);
			echo "\nHEADER\n".HTMLSpecialChars($this->header);
			echo "</pre>";
		}

		// send to more people, if param is array of emails
		if(is_array($this->to))
		{
			foreach($this->to as $email_to)
			{
				$this->sendTo($email_to);
			}
		}
		else
		{
			$this->sendTo($this->to);
		}
	}
	
	function sendTo($to)
	{
		if(!@mail($to, $this->subject, $this->body, $this->header))
		{}//throw new EmailException("PHP::Mail() failed sent email to $to");
	}
	
	function getInvalidEmail($email)
	{
		if(is_array($email))
		{
			foreach($email as $my_email)
				if(!$this->isValidEmail($my_email))
					return $val;
		}
		else
		{
			if(!$this->isValidEmail($email))
				return $email;
		}
		
		return NULL;
	}
}

?>
