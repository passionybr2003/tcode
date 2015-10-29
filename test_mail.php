<?php
$from =  'Takescript <admin@takescript.in>';
		$to = 'raghavender.yb@gmail.com';
		$subject = 'Activation Link';
		$message =  '<a href="#">Activation link </a>';
		
		$from = trim($from);
		$headers = '';
		$headers = "From: $from\r\n";
		$headers .= "Reply-To: $from\r\n";
		$headers .= "Return-Path: <".$from.">\r\n";
		$headers .= "MIME-Version: 1.0" . "\r\n";
		$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

		mail($to,$subject,$message,$headers);
