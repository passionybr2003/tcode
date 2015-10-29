<?php
header("Content-type: application/php"); 
		header("Content-Disposition: attachment; filename=downloads/$_GET[file]"); 
		header("Pragma: no-cache"); 
		header("Expires: 0"); 
		readfile("$_GET[file]");
?>