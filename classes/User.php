<?php
class User extends DbConnect {
	public function register($posted_arr=array()){
		foreach($posted_arr as $fname=>$fvalue){
			$fvalue = sanitize($fvalue);
			$fvalue = $this->real_string($fvalue);
			$post_arr[$fname] = $fvalue;
		}
		$username = $post_arr['username'];
                $email = $post_arr['email'];
		$pwd = $post_arr['pwd'];
		$mobile = $post_arr['mobile'];
		//FB Data
		if(isset($post_arr['fb_id']) && $post_arr['fb_id']!= '') $fb_id = $post_arr['fb_id'];
		
		//GPlus Data
		if(isset($post_arr['gp_id']) && $post_arr['gp_id']!= '') $gp_id = $post_arr['gp_id'];
		
		
		$pwd = sha1(md5(sha1($pwd)));
		$activation_key = sha1(md5(uniqid()));
		$activation_status = 0;
		$created = $modified = DATE_TIME;
		
//		$ip_based_locations = $this->getGeoLoaction();
		$country_name = isset($ip_based_locations['countryName'])?$ip_based_locations['countryName']:"0";
		$state_name = isset($ip_based_locations['regionName'])?$ip_based_locations['regionName']:"0";
		$city_name = isset($ip_based_locations['cityName'])?$ip_based_locations['cityName']:"0";
		$ip_address = $_SERVER['REMOTE_ADDR'];

		if(isset($post_arr['fb_id']) && $post_arr['fb_id'] != ''){
			$username = $post_arr['name'];
			$gender = $post_arr['gender'];
			$birthday = $post_arr['birthday'];
			$sql = "INSERT INTO users (username,email,fb_id,gender,birthday,city_name,state_name,country_name,ip_addr,created,modified) 
						VALUES ('$username','$email','$fb_id','$gender','$birthday','$city_name','$state_name','$country_name','$ip_address','$created','$modified')";
		} else if(isset($post_arr['gp_id']) && $post_arr['gp_id'] != ''){
			//GPlus Data
			$username = $post_arr['username'];
			$gp_etag = $post_arr['gp_etag']; 
			$gp_atoken = $post_arr['access_token'] ;
			$gp_url = $post_arr['gp_url'] ;
			$prof_pic = $post_arr['prof_pic'] ;
			$gp_isPlusUser = $post_arr['gp_isPlusUser'];
			$gender = $post_arr['gender'];
			$sql = "INSERT INTO users (username,email,gp_id,gp_etag,gp_atoken,gp_url,gp_isPlusUser,prof_pic,gender,city_name,state_name,country_name,ip_addr,created,modified) 
						VALUES ('$username','$email','$gp_id','$gp_etag','$gp_atoken','$gp_url','$gp_isPlusUser','$prof_pic','$gender','$city_name','$state_name','$country_name','$ip_address','$created','$modified')";
		} else {
			$sql = "INSERT INTO users (username,email,pwd,city_name,state_name,country_name,ip_addr,created,modified) 
						VALUES ('$username','$email','$pwd','$city_name','$state_name','$country_name','$ip_address','$created','$modified')";
		}
		
		$res = $this->qry_insert($sql);
		$user_id = $res->insert_id;
		
		// Create one folder for fb and gplus users e.g: '000'.userid in usr_fldrs
		if(isset($post_arr['fb_id']) ||  isset($post_arr['gp_id']) ){
			$dir_name = USER_FLD_PATH.$user_id;
			mkdir($dir_name);
			return $user_id;
			
		}
		
		if(isset($post_arr['fb_id']) || isset($post_arr['gp_id']) ) {
			$activation_key = 0;
			$activation_status = 1;
		}
		$sql2 = "INSERT INTO users_info (user_id,mobile,activation_key,activation_status,created,modified) VALUES
						('$user_id','$mobile','$activation_key','$activation_status','$created','$modified')";
		$this->qry_insert($sql2);
		
		
		
		//Send Activation key mail here
		if(!isset($post_arr['fb_id']) && !isset($post_arr['gp_id']) ){
			$mail_data['to'] = $email;
			$mail_data['act_link'] = SITE_NAME."/verify_act.php?k=".$activation_key;
			$res = $this->activationMail($mail_data);
			if($res){	
				return $status = 1;
			}
		}
		
	}
	
	
	public function validate_email($email=NULL){
		$sql = "SELECT id FROM users where email like '%$email%'";
		$res = $this->qry_select($sql);
		$user_id = $res['id'];
		// Create one folder for direct user e.g: '000'.userid in usr_fldrs
		if($user_id != '' && $user_id != '0'){
			$dir_name = USER_FLD_PATH.$user_id;
			mkdir($dir_name);
		}
		return $res['id'];
	}
	
	
	
	/**
	 * Send Verification Mail 
	 * @params email,act_link
	 */
	private function activationMail($mail_data=array()){
		$from = ADMIN_EMAIL;
		$to = $mail_data['to'];
		$subject = 'Activation Link';
		$href =  $mail_data['act_link'];
		$message = $this->activation_email_content($href);
		
		$from = trim($from);
		$headers = '';
		$headers = "From: $from\r\n";
		$headers .= "Reply-To: $from\r\n";
		$headers .= "Return-Path: <".$from.">\r\n";
		$headers .= "MIME-Version: 1.0" . "\r\n";
		$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
		
		return  mail($to,$subject,$message,$headers);
		
		
//		$SMTPMail = new SMTPClient ($SmtpServer, $SmtpPort, $SmtpUser, $SmtpPass, $from, $to, $subject, $body);
//		$SMTPChat = $SMTPMail->SendMail();
	}

	/**
	 * 
	 * verify email
	 * @param act_key 
	 */
	
	public function verify_email($ack_key=NULL){
		$ack_key = $this->con->real_escape_string($ack_key);
		$qry = "UPDATE users_info SET activation_status = 1 where activation_key = '$ack_key'";	
		return $res = $this->qry_update($qry);
	}

	
	public function login($post_arr=array()){
		if(isset($post_arr['fb_id']) && $post_arr['fb_id'] !=''){
			$fb_id = $post_arr['fb_id'];
			if($fb_id) $sql = "SELECT id from users where fb_id = '$fb_id' ";
			$res = $this->qry_select($sql);
			if($res['id'] == ''){
				$res = $this->register($post_arr);	
			} 		
		}else if(isset($post_arr['gp_id']) && $post_arr['gp_id'] !=''){
			$gp_id = $post_arr['gp_id'];
			if($gp_id) $sql = "SELECT id from users where gp_id = '$gp_id' ";
			$res = $this->qry_select($sql);
			if($res['id'] == ''){
				$res = $this->register($post_arr);	
			} 			
		} else {
			$email = sanitize($post_arr['email']);
			$pwd = sanitize($post_arr['pwd']);
			$email  = $this->con->real_escape_string($email);
			$pwd  = $this->con->real_escape_string($pwd);
			$pwd = sha1(md5(sha1($pwd)));
			$sql = "SELECT u.id,u.username FROM `users` u LEFT JOIN users_info ui ON u.id = ui.user_id WHERE ui.activation_status =1 AND u.email = '$email' AND pwd = '$pwd'";
			$res = $this->qry_select($sql);
		}
		
		// Get expire date of authentic user.
		$demoDays = DEMO_DAYS;
		$userId = $res['id'];
		$qry = "SELECT  DATE_ADD(created,INTERVAL $demoDays DAY) as expire_date  FROM users_info where user_id = '$userId'";
		$expDateRes = $this->qry_select($qry); 
		$res['expireDate'] = $expDateRes['expire_date']; 
                $res['id'] = $userId; 
		return $res;
	}	
	
	
	public function logout(){
		session_start();
		session_destroy();
		header('location:/');
	}

	
	public function real_string($value){
		return $this->con->real_escape_string($value);
	}
	
	
	public function getFormsPerDay(){
		$date = DATE;
		$userId = $_SESSION['user_id'];
		$qry = "SELECT count(id) as noOfFiles from created_files where user_id = '$userId' and date(created) = '$date'";
		$noOfFilesRes = $this->qry_select($qry); 
		$noOfFiles = $noOfFilesRes['noOfFiles']?$noOfFilesRes['noOfFiles']:0;
		return $noOfFiles; 
	}

	
	public function getGeoLoaction(){
	//		Configure::write('debug',2);
			//Load the class
			 
			//Get errors and locations
			$locations = $ipLite->getCity($_SERVER['REMOTE_ADDR']);
			$errors = $ipLite->getError();
			//Getting the result
			if (!empty($locations) && is_array($locations)) {
			  return $locations;
			}
		}
		
		public function activation_email_content($href = 'null'){
	 		 return $message = "
					<div id='mail_body' style='margin:auto;width:600px;height:auto;background-color:#408c99;padding:10px;font-family:helvetica;font-size:14px;'>
						<div class='econtent bg-style' style='background-color:white;padding:10px;-webkit-box-shadow: 0 0 10px rgba(0,0,0, .65);
																									-moz-box-shadow: 0 0 10px rgba(0,0,0, .65);
																									box-shadow: 0 0 10px rgba(0,0,0, .65);'>
					<div class='header bg-style' >
						<h2>LOGO</h2>
					</div>
					<div class='content bg-style'>
						<h2>Takescript.in Email Verification</h2>
						<p> Welcome to Takescript, </P>
						<p> To activate Takescript you must first verify your email address by clicking the link.</p>
						
						<a href='$href ' class='myButton' style='
									margin-left:200px;
									-moz-box-shadow: 0px 10px 14px -7px #3e7327;
									-webkit-box-shadow: 0px 10px 14px -7px #3e7327;
									box-shadow: 0px 10px 14px -7px #3e7327;
									background-color:#77b55a;
									-moz-border-radius:4px;
									-webkit-border-radius:4px;
									border-radius:4px;
									border:1px solid #4b8f29;
									display:inline-block;
									cursor:auto;
									color:#ffffff;
									font-family:arial;
									font-size:13px;
									font-weight:bold;
									padding:6px 12px;
									text-decoration:none;
									text-shadow:0px 1px 0px #5b8a3c; '> Activate your account </a>
						
						<p> If clicking the link above does not work, copy and paste the URL in a new browser window instead. </p>					
						<p> $href </p>
						<p>Thank you for using Takescript.in</p> 
					</div>
				</div>
			</div>
		";
	}

	/*
	 * Change password
	 * 
	 */
	public function change_password($posted_arr = array()){
		$user_id = $_SESSION['user_id'];
		$qry = "select pwd from users where id= '$user_id' ";
		$db_pwd = $this->qry_select($qry);
		$db_passwd = $db_pwd['pwd'];
		foreach($posted_arr as $fname=>$fvalue){
			$fvalue = sanitize($fvalue);
			$fvalue = $this->real_string($fvalue);
			$post_arr[$fname] = $fvalue;
		}
		if($post_arr['current_pwd'] == '' || $post_arr['new_pwd'] == '' || $post_arr['cnfm_new_pwd'] == ''){
			$res['msg'] = "Enter all fields";
			$res['status'] = "0";
		} else if(sha1(md5(sha1($post_arr['current_pwd']))) != $db_passwd){
			$res['msg'] = "Current passowrd is wrong";
			$res['status'] = "0";
		} else if($post_arr['new_pwd'] != $post_arr['cnfm_new_pwd']){
			$res['msg'] = "New password and confirm password are not match";
			$res['status'] = "0";
		} else {
			$new_pwd = $post_arr['new_pwd'];
			$new_pwd = sha1(md5(sha1($new_pwd)));
			$qry = "UPDATE users set pwd='$new_pwd' where id= '$user_id' ";
			$result = $this->qry_insert($qry);
			if($result->affected_rows == 1){
				$res['msg'] = "Password is updated successfully.";
				$res['status'] = "1";
			} else {
				$res['msg'] = "Password is not updated";
				$res['status'] = "0";
			}
			return $res;
		}		
	}
	
	/*
	 * Contact form
	 * 
	 */
	public function contact_me($posted_arr = array()){
		foreach($posted_arr as $fname=>$fvalue){
			$fvalue = sanitize($fvalue);
			$fvalue = $this->real_string($fvalue);
			$post_arr[$fname] = $fvalue;
		}
		$name = $post_arr['name'] ;
		$phone = $post_arr['phone'];
		$email = $post_arr['email'];
		$message = $post_arr['message'] ;
		$created = $modified = DATE_TIME;
		$sql = "INSERT INTO contact_us (name,email,phone,message,created,modified) 
						VALUES ('$name','$email','$phone','$message','$created','$modified')";
		$result = $this->qry_insert($sql);
		return true;
	}
	
        public function user_created_files($records=''){
            $sql = "INSERT INTO created_files (user_id,file_name,created ) VALUES $records";
            $this->qry_insert($sql);
            return true;
        }
        
        
        
        public function user_downloaded_files($fileName=''){
            $userId = $_SESSION['user_id'];
            $created = $modified = DATE_TIME;
            $sql = "INSERT INTO downloaded_files (user_id,file_name,created ) 
						VALUES ('$userId','$fileName','$created' )";
            $result = $this->qry_insert($sql);
            return true;
        }
        
		
}
