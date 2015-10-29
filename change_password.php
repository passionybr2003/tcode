<?php
require_once 'functions.php';
//print_arr($_SESSION);
if(!isset($_SESSION['user_id']) && $_SESSION['user_id'] == ''){
	header('location:/');
}
require_once 'classes/geneform.php';
$userId = $_SESSION['user_id'];
if($_SERVER['REQUEST_METHOD']=="POST" && isset($_POST['submit'])){
	$user = new User();
	$res = $user->change_password($_POST);
}

?>
<?php require_once 'includes/header.php';?>
<div class="navbar-wrapper main-body1" style="height:auto;">
	<div class="container">
		<?php if($res['status'] == '1') {?>
		<div id="download" class="alert alert-info" style="text-align:center;">
			<?php echo $res['msg']; ?>
		</div>
		<?php } ?>
	
		<h2>Change password</h2>
		<div class="col-md-4 col-sm-12">
			<div id="form" class=""> 
				<form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
					<div class="form-group col-sm-12">
						<label class=''> Current password</label>
						<input type="password" class="form-control" name="current_pwd" id="current_pwd" data-toggle="tooltip" data-placement="top" title="Enter current password" placeholder="Enter current password">
					</div>
					<div class="form-group  col-sm-12">
						<label class=''> New password </label>
						<input type="password" class="form-control" name="new_pwd" id="new_pwd" data-toggle="tooltip" data-placement="top" title="Enter new password" placeholder="Enter new password">
					</div>
					<div class="form-group col-sm-12">
						<label class=''> Confirm new password</label>
						<input type="password" class="form-control" name="cnfm_new_pwd" id="cnfm_new_pwd" data-toggle="tooltip" data-placement="top" title="Enter confirm new password" placeholder="Enter confirm new password" > 
					</div>
					<div class="form-group col-sm-12">
						<input type="submit" class="btn btn-success " name="submit" id="submit" value ="submit">
					</div>
				</form>
			</div>
		</div>
		
	</div> <!-- End container -->
</div>


<?php require_once 'includes/footer.php';?>

<script type="text/javascript">
$(function(){
	
	$('.tooltip').show();
});
</script>




