<?php
session_start();
require_once 'functions.php';
$dir_path = USER_FLD_PATH.$_SESSION['user_id']."/".DATE."/";
if(isset($_GET['file'])) { $filname = $dir_path.$_GET['file'] ;}
header("Content-type: application/php"); 
header("Content-Disposition: attachment; filename=$_GET[file]"); 
header("Pragma: no-cache"); 
header("Expires: 0"); 
readfile("$filname");
$user = new User();
$user->user_downloaded_files($filname);
?>