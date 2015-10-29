<?php
require_once 'config.php';
require_once CLASS_PATH.'functions.php';
require_once 'includes/header.php';
if(isset($_GET['k']) && $_GET['k'] != ''){
	$ack_key = trim($_GET['k']);
	$user = new User();
	$res = $user->verify_email($ack_key);
	if($res == 0){
		$msg='Not Activated';
		$class = 'alert-warning';
	} else {
		$msg='Your activation has done successfully. <a href="/">Login</a>';
		$class = 'alert-success';
	}
}
?>

<div class="navbar-wrapper main-body">
	<div class="container">
		<div class="alert <?php echo $class?>" role="alert"><?php echo $msg; ?> </div>
	</div>  
</div>
<?php require_once 'includes/footer.php';?>