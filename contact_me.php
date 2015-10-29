<?php
require_once 'functions.php';
	$post_arr['name'] = $_REQUEST['name'];
	$post_arr['phone'] = $_REQUEST['phone'];
	$post_arr['email'] = $_REQUEST['email'];
	$post_arr['message'] = $_REQUEST['message'];
	$user = new User();
	$res = $user->contact_me($post_arr);
?>





