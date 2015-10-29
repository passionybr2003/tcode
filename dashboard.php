<?php
require_once 'functions.php';

//Register Gplus Data
if(isset($_SESSION['gplusdata']['id']) && $_SESSION['gplusdata']['id'] != ''){
	$a = json_decode($_SESSION['access_token'],true);
	$data['access_token'] = $a['access_token'];
	$data['email'] = $_SESSION['gplusdata']['emails']['0']['value'];
	$data['gp_etag'] = $_SESSION['gplusdata']['etag'];
	$data['gender'] = $_SESSION['gplusdata']['gender'];
	$data['gp_id'] = $_SESSION['gplusdata']['id'];
	$data['username'] = $_SESSION['gplusdata']['name']['givenName']." ".$_SESSION['gplusdata']['name']['familyName'];
	$data['gp_url'] = $_SESSION['gplusdata']['url'];
	$data['prof_pic'] = $_SESSION['gplusdata']['image']['url'];
	$data['gp_isPlusUser'] = $_SESSION['gplusdata']['isPlusUser'];
	$method = 'gp_reg';
	ajax_calls($method,$data);
}

if(!isset($_SESSION['user_id']) && $_SESSION['user_id'] == ''){
	header('location:/');
}
require_once 'classes/geneform.php';
$userId = $_SESSION['user_id'];
if($_SERVER['REQUEST_METHOD']=="POST" && isset($_POST['submit'])){
	
   // Get no of files has been used per day
	$user = new User();
	$noOfFiles = $user->getFormsPerDay();
	
        if($noOfFiles == DEMO_MAX_FORM_VALUE_PER_DAY){
		header('location:dashboard.php');
		echo "<div class='bg-warning'> Your max no of forms are completed. Try again </div>";
	}
	$form = $gform->makeForm($_POST);
	if($form['status'] == 1){
		$download =  "<a href='download.php?file=$form[file]'>Download File</a>";
	}
}
//echo $form;
?>
<?php require_once 'includes/header.php';?>
<div class="navbar-wrapper main-body1" style="height:auto;">
	<div class="container">
		<?php if($download != '') {?>
		<div id="download" class="alert alert-info" style="text-align:center;">
			<?php echo $download; ?>
		</div>
		<?php } ?>
	
		<h2> Php Form</h2>
		<div id="form" class="col-lg-4"> 
		<form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
				<div class="form-group col-lg-6" style="float:none;">
					<label class=' '>Input Fields </label>
					<input type="text" class="form-control" name="infield" id="infield" data-toggle="tooltip" data-placement="top" title="No of Input Fields" placeholder="No of Input Fields">
				</div>
				<div class="form-group  col-lg-6" style="float:none;">
					<label class=' '>Password Fields </label>
					<input type="text" class="form-control" name="passfield" id="passfield" data-toggle="tooltip" data-placement="top" title="No of Password Fields" placeholder="No of Password Fields">
				</div>
				<div class="form-group col-lg-6" style="float:none;">
					<label class=' '>Radio Button Fields </label>
					<input type="text" class="form-control" name="radiofield" id="radiofield" data-toggle="tooltip" data-placement="top" title="No of Radio Fields" placeholder="No of Radio Fields" > 
				</div>
				<span class="radio_options"></span>	
				<div class="form-group col-lg-6" style="float:none;">
					<label class=' '>Checkbox Fields </label>
					<input type="text" class="form-control" name="checkfield" id="checkfield" data-toggle="tooltip" data-placement="top" title="No of Checkbox Fields" placeholder="No of Checkbox Fields">
				</div>
				<span class="checkbox_options"></span>
				<div class="form-group col-lg-6" style="float:none;">
					<label class=' '>Select Tag Fields </label>
					<input type="text" class="form-control" name="selectfield" id="selectfield" data-toggle="tooltip" data-placement="top" title="No of Select Tag Fields" placeholder="No of Select Tag Fields">
				</div>
				<div class="form-group col-lg-6" style="float:none;">
					<label class=' '>Textarea Fields </label>
					<input type="text"  class="form-control" name="tareafield" id="tareafield" data-toggle="tooltip" data-placement="top" title="No of Textarea Fields" placeholder="No of Textarea Fields">
				</div>
				<div class="form-group col-lg-6" style="float:none;">
					<input type="button" class="btn btn-success " name="submit" id="submit" value ="submit">
				</div>
		</form>
		</div>
		<div id="layout" class="col-lg-4"> </div>
		
	</div> <!-- End container -->
</div>


<?php require_once 'includes/footer.php';?>

<script type="text/javascript">
$(function(){
	
	$('#radiofield').keyup(function(){
		var options = str = '';
		var no_of_radios = $('#radiofield').val();
		for(var i=1;i<=no_of_radios;i++){
			str = "<div class='col-sm-3'><input class='form-control rops'  type='text' data-toggle='tooltip' data-placement='top' title='No of Options' placeholder='' name='radio"+i+"'></div>";
			options += "<div class='form-group form-group-sm'><label class='col-sm-6 control-label'>" +  i + " RB Options </label>" + str+"</div>";
		}
		$('.radio_options').html(options+"<br>");
	});
	$('#checkfield').keyup(function(){
		var options = str = '';
		var no_of_checkboxes = $('#checkfield').val();
		for(var i=1;i<=no_of_checkboxes;i++){
			str = "<div class='col-sm-3'><input  class='form-control cops' type='text' name='check"+i+"' ></div>";
			options += "<div class='form-group form-group-sm'><label class='col-sm-6 control-label'> "+ i +" CB Options </label>"+str+"</div>";
		}
		$('.checkbox_options').html(options+"<br>");
	});
	$('#submit').click(function(){
		var radioFops = checkFops = '';
		var textF = $('#infield').val();
		var passF = $('#passfield').val();
		var radioF = $('#radiofield').val();
			$('.rops').each(function(){
				if($(this).val()){
					radioFops += $(this).val()+",";
				}
			});
		if(radioF != '' && radioFops == ''){
			alert("Please enter Radio Button Options");
			return false;
		}	
		var checkboxF = $('#checkfield').val();
			$('.cops').each(function(){
				if($(this).val()){
					checkFops += $(this).val()+",";
				}
			});
		if(checkboxF != '' && checkFops == ''){
			alert("Please enter Checkbox Field Options");
			return false;
		}	
		var selectF = $('#selectfield').val();
		var textareaF = $('#tareafield').val();
		$.ajax({
			type: "POST",
			url: "generate_layout.php",
			data: {textFv:textF,passFv:passF,radioFv:radioF,radioFvOps:radioFops,checkboxFv:checkboxF,checkboxFvOps:checkFops,selectFv:selectF,textareaFv:textareaF }, 
			success:function(result){
		  		$("#layout").html(result);
			}	  
		});
	});
	$('#infield,#passfield,#radiofield,#checkfield,#selectfield,#tareafield,.rops').tooltip();
});
</script>




