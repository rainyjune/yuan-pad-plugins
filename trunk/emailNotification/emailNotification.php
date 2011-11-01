<?php
class emailNotification
{
	public static function getConfigs()
	{
		return include dirname(__FILE__).DIRECTORY_SEPARATOR.'config.php';
	}
	public function exec($username,$content,$time)
	{
		$config= self::getConfigs();
		if(!$config['enable']){
			return FALSE;
		}
		
		require_once(dirname(__FILE__).'/phpmailer/class.phpmailer.php');
		
		$mail             = new PHPMailer();
		$body             = sprintf($config['body'], $username,$content,  date('Y-m-d H:i:s',(int)$time));

		$mail->IsSMTP(); // telling the class to use SMTP
		$mail->SMTPDebug  = 2;                     // enables SMTP debug information (for testing)
												   // 1 = errors and messages
												   // 2 = messages only
		$mail->SMTPAuth   = (boolean)$config['SMTPAuth'];                  // enable SMTP authentication
		$mail->Host       = $config['Host']; // sets the SMTP server
		$mail->Port       = (int)$config['Port'];                    // set the SMTP port for the GMAIL server
		$mail->Username   = $config['Username']; // SMTP account username
		$mail->Password   = $config['Password'];        // SMTP account password

		$mail->SetFrom('348106409@163.com', 'YuanPad site Admin');

		$mail->AddReplyTo("348106409@163.com","YuanPad site Admin");

		$mail->Subject    = $config['Subject'];

		$mail->AltBody    = "To view the message, please use an HTML compatible email viewer!"; // optional, comment out and test

		$mail->MsgHTML($body);

		$mail->AddAddress($config['to'], "YuanPad site Admin");

		if(!$mail->Send()){
		  echo "Mailer Error: " . $mail->ErrorInfo;
		} else {
		  echo "Message sent!";
		}
		
	}
}
attachEvent('PostController/actionCreate',array('emailNotification','exec'));