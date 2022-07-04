<?php defined('BASEPATH') OR exit('No direct script access allowed.');

class MY_phpmailer {

	public function __construct(){
		// $this->ci =& get_instance();
	}

	private function _get_config($mail){
		$mail->IsSMTP();
        $mail->IsHTML(true);
        $mail->SMTPAuth = true;
        $mail->SMTPSecure = 'ssl';
        $mail->Host = 'tsmtw.com';
        $mail->Port = '465';
        $mail->CharSet = "utf-8";
        $mail->Username = 'test@tsmtw.com';
        $mail->Password = 'kl61757273';
        $mail->From = 'test@tsmtw.com';
        $mail->FromName = 'bytheway 順便一提';
	}

	public function send($to,$subject,$body){
		$this->_get_config($mail= new PHPMailer());

		$mail->AddAddress($to); //設定收件者郵件
		$mail->Subject = $subject; //設定郵件標題
		$mail->Body = $body; //設定郵件內容
		// $mail->Send();

		if(!$mail->Send()){
            // echo "Error: " . $mail->ErrorInfo;
            return 0;
        } else {
            // echo "<b>您好!已收到您的留言，會盡快回覆</b>";
            return 1;
        }
	}

}