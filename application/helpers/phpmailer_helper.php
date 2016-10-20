<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

function send_email($recipient, $sender, $subject, $message)
{
    require_once("phpmailer/class.phpmailer.php");

    $mail = new PHPMailer();
		$mail->IsSMTP();		
		$mail->SMTPAuth = true;  
		$mail->IsHTML(true);		
		$mail->Port  = "25";       
		$mail->Username   = "icc@medcrf.com"; 
		$mail->Password   = "M3dcrf1cc-";        
		$mail->FromName = "ICC International Center For Biomedicine";
		$mail->From = "icc@medcrf.com";
		$mail->Subject = $subject;		
		$mail->MsgHTML($message);
		$recipient2 = str_replace(";",",",trim($recipient));
		$correos = explode(",",$recipient2);
		
		if(count($correos) == 1){
			$mail->AddAddress($correos[0]);
		}
		elseif(count($correos) > 1){
			$mail->AddAddress(trim($correos[0]));
			for($i=1;$i<count($correos);$i++){
				$mail->AddCC(trim($correos[$i]));
			}
		}
		else{
			return false;
		}
		
	if ( !$mail->Send())
    {
        return false;
    }
    else
    {
        return true;
    }
}

?>