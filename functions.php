<?php
session_start();
require_once 'libs/config.php';
function __autoload($name) {
	require_once CLASS_PATH.$name . '.php';
}	     


if(isset($_REQUEST['email']) && $_REQUEST['email'] != '' ) $email = trim($_REQUEST['email']);
if(isset($_REQUEST['method']) && $_REQUEST['method'] != '' ) {
	$method = trim($_REQUEST['method']);
	if($method == 'email_validation') {
		$user_id = validate($email,$method);
		if($user_id != ''){
			echo "false";
		} else {
			echo "true";
		}		
	} else {
		ajax_calls($method,$_POST);	
		
	}
}

function ajax_calls($method,$data){
	$user = new User();
	switch ($method) {
			case 'fb_reg':
					$res = $user->login($data);
					if($res != 0){
						unset($_SESSION['gplusdata']);
						$_SESSION['user_id'] = $res;
						$_SESSION['email_id'] = $data['email'];
						$url = 'php_script.php';
					} else {
						$url = '';
					}
					echo $url;
			break;
			case 'gp_reg':
					$res = $user->login($data);
					if($res != 0){
						unset($_SESSION['fb_id']);
						$_SESSION['user_id'] = $res;
						$_SESSION['email_id'] = $data['email'];
						$url = 'php_script.php';
					} else {
						$url = '';
					}
					echo $url;
			break;
			
	}
}


 
	
	function sanitize($data){
	  $data = filter_var($data, FILTER_SANITIZE_STRING);
	  $data = trim($data);
          $data = stripslashes($data);
          return $data;	
	}
	
	function print_arr($reqArr = array()){
		echo "<pre>";
		print_r($reqArr);
                echo "</pre>";
	}
	
	function validate($value,$key){
		switch ($key) {
			case 'email':
				if($value == ''){
					echo $msg = "<br>Please enter email";
				}
			break;
			case 'mobile':
				if($value == ''){
					echo $msg = "<br>Please enter mobile";	
				}
			break;
			case 'pwd':
				if($value == ''){
					echo $msg = "<br>Please enter password";	
				}
			break;
			case 'cpwd':
				if($value == ''){
					echo $msg = "<br>Please enter confirm password";	
				}
			break;
			case 'email_validation' :
				$user = new User();
					return $user_id = $user->validate_email($value); 
					
			break;	
		}
			
	}
	
	
	//require_once '../libs/mail/SMTPClass.php';
//echo $to = $mail_data['to'] = 'passionybr2003@gmail.com';
//		$subject = 'Activation Link';
//		$body =  $mail_data['act_link'];
//		$SMTPMail = new SMTPClient ($SmtpServer, $SmtpPort, $SmtpUser, $SmtpPass, $from, $to, $subject, $body);
//		print_r($SMTPMail);
//		$SMTPChat = $SMTPMail->SendMail();

	
?>