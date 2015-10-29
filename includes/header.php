<?php error_reporting(0);?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Starter Template for Bootstrap</title>
	<link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="css/tpl_style.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="http://fonts.googleapis.com">
    <link href="bootstrap/css/font-awesome.min.css" rel="stylesheet">
    <link href="bootstrap/css/font-awesome.css" rel="stylesheet">
    
    <script src="js/jquery.js"></script>
    <script src="js/jquery.validate.js"></script>
    <script src="js/validations.js"></script>
    <script src="bootstrap/js/bootstrap.min.js"></script>
	
<style type="text/css">
body {
  background-color:#2c3e50;
}
</style>
    <!-- Just for debugging purposes. Don't actually copy these 2 lines! -->
    <!--[if lt IE 9]><script src="../../assets/js/ie8-responsive-file-warning.js"></script><![endif]-->

    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>

<body>
  <div class="container" >
		<!-- Header -->
   		<div  class="header ">
            <div class="navbar-form  pull-left ">
                <a class="brand" href="#"><img src="img/logo@2x.png" width="50" height="50" alt=""> Startup</a>
            </div>
            <div class="navbar-form pull-right">
               <?php if(!isset($_SESSION['user_id']) && $_SESSION['user_id'] == '') {?>	
               <button class="btn btn-primary btn-lg" data-toggle="modal" data-target="#myModal">
  					Sign Up
				</button>
				<?php } else {?>
					<div class="dropdown">
						<button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
						    Welcome,<?php echo $_SESSION['username']; ?> 
						    <span class="caret"></span>
						</button>
						<ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
						    <li><a href="change_password.php">Change Password</a></li>
						    <li role="separator" class="divider"></li>
						    <li><a href="logout.php">Log out </a></li>

						</ul>
					</div>
				<?php } ?>
            </div>
   		</div>
   </div> 
   
   <?php if(isset($_SESSION['user_id']) && $_SESSION['user_id'] != '') {?>
    <div class="navbar-wrapper navbar-inverse" role="navigation" >
          <div class="container">
            <div class="navbar-header">
              <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target=".navbar-collapse">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
              </button>
            </div>
            <div class="navbar-collapse collapse" style="height: 1px;">
              <ul class="nav navbar-nav">
                <li class="active"><a href="#">Home</a></li>
                <li><a href="downloads.php">Archives</a></li>
                <!-- 
                <li class="dropdown">
                  <a href="#" class="dropdown-toggle" data-toggle="dropdown">Dropdown <span class="caret"></span></a>
                  <ul class="dropdown-menu" role="menu">
                    <li><a href="#">Action</a></li>
                    <li><a href="#">Another action</a></li>
                    <li><a href="#">Something else here</a></li>
                    <li class="divider"></li>
                    <li class="dropdown-header">Nav header</li>
                    <li><a href="#">Separated link</a></li>
                    <li><a href="#">One more separated link</a></li>
                  </ul>
                </li>
                 -->
              </ul>
            </div>
          </div>
        </div>
       
  <?php } ?>  
   