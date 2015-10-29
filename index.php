<?php
require_once 'functions.php';
$user = new User();
if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['signin']) ){
	
	$res_arr = $user->login($_POST);
	$expireDate = $res_arr['expireDate'];
	$res = $res_arr['id']; 
	if($res != 0 && $res != '' && strtotime($expireDate) >= strtotime(DATE_TIME)){
		$_SESSION['user_id'] = $res;
		$_SESSION['email_id'] = $_POST['email'];
                $_SESSION['username'] = $res_arr['username'];
		header('location:dashboard.php');
	} else {
		header('location:/');
	}
}
if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['signup']) ){
?>
	<div  style="margin:0 auto;width:300px;">
	<?php 
		array_walk($_POST, 'validate');
		$res = $user->register($_POST);
		if($res == 1){
			$msg = 'Your Registration has been Successfully done.Please Check your mail for activation.(You may also check for the email in SPAM folder if u do not see it in inbox )';
			$class = 'alert-success';
		}
}
?>
</div>
<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Freelancer - Start Bootstrap Theme</title>

    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="css/freelancer.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

  
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    
    <style type="text/css">
    	.has-margin-bottom { margin-bottom:10px; }    
    </style>

</head>

<body id="page-top" class="index">

    <!-- Navigation -->
    <nav class="navbar navbar-default navbar-fixed-top">
        <div class="container">
            <div class="navbar-header page-scroll">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="#page-top">Start Bootstrap</a>
            </div>

            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav navbar-right">
                    <li class="hidden">
                        <a href="#page-top"></a>
                    </li>
                    
                    <li class="page-scroll">
                        <a href="#contact">Contact</a>
                    </li>
                    <li class="page-scroll">
                        <a href="#Signup" class="btn btn-lg" data-toggle="modal" data-target="#myModal">Signup</a>
                    </li>
                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container-fluid -->
    </nav>
<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Signup</h4>
      </div>
      <form id="signup-form1" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" method="post">
	      <div class="modal-body">
        	<div class="signup-form">
            	<div class="col-sm-10 form-group">
                	<input class=" form-control" type="text" placeholder="Your Name" name="username" id="username">
                </div>
                <div class="col-sm-10 form-group">
                	<input class=" form-control" type="text" placeholder="Your E-mail" name="email" id="email">
                </div>
               <div class="col-sm-10 form-group">
                   <input class="form-control" type="text" placeholder="Your Mobile" name="mobile" id="mobile">
               </div>
               <div class="col-sm-10 form-group">
                   <input type="password" class="form-control" placeholder="Password" name="pwd" id="pwd">
               </div>
               <div class="col-sm-10 form-group">
         			<input type="password" class="form-control" placeholder="Confirm Password" name="cpwd" id="cpwd">
               </div>
			</div>
      	</div>
     	<div class="modal-footer" style="clear:both;">
        	<input type="submit" name="signup" value="Signup"  id="signup" class="btn btn-default">
      	</div>
      </form>
    </div>

  </div>
</div>
    <!-- Header -->
    <header>
        <div class="container">
         	<?php if(isset($msg) && $msg != '') { ?><div class="alert <?php echo $class?>" role="alert"><?php echo $msg; ?> </div> <?php } ?>
            <div class="row">
                <div class="col-lg-8 starter-template">
                    <p class="lead"> Takescript is a stupendous web application which is user friendly to create php based forms.</p>
					<p class="lead"> The backend script and MySQL database management can be done automatically by the application based on your selection. </p>	 
					<p class="lead">This helps you to build forms and data management with great ease, fast and attractive way. </p> 
                </div>
                <div class="signin-form col-lg-4">
                	
                	<div id="slogins">
                            <a href="javascript:void(0);" onclick="fb_login();">
                                <div style="width:150px;height:50px;margin:5px;background-image:url('img/SocialLogin.png');float:left; background-position:-7px -4px;">
                                </div>
                            </a>
                            <?php include_once 'slogins/gplus/gplus_login.php' ?>    
                            
                            <a href="slogins/tlogin/login-twitter.php">
                                <div style="width:150px;height:50px;margin:5px;background-image:url('img/SocialLogin.png');float:left;background-position:-5px -64px">
                                </div>  
                            </a>
                            <a href="slogins/mlogin/microsoft_login.php">
                                <div style="width:150px;height:50px;margin:5px;background-image:url('img/SocialLogin.png');float:left;background-position:-7px -124px;">
                                </div>
                            </a>
				       
	   		</div>
		      	<div class="signin">
                                    <div class="col-lg-10  has-margin-bottom clearfix">
                                        <h4 class="text-left">Sign in</h4> 
			            </div>
			            <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" method="post" id="login-form1">
			                    <div class="col-lg-11   has-margin-bottom clearfix">
			                    	<input class="form-control " type="text" placeholder="Your E-mail" name="email" id="email"> 
			                    </div>
			                    <div class="col-lg-11   has-margin-bottom clearfix">
			                    	<input class="form-control" type="password"  placeholder="Password" name="pwd" id="pwd"> 
			                    </div>
			                   	<div class="col-lg-11   has-margin-bottom clearfix">
			                      	<button type="submit" class="btn btn-block  btn-info" name="signin">Sign In</button>
			                   </div>
			            </form>
		          	</div>
                </div>
            </div>
        </div>
    </header>

    <!-- Portfolio Grid Section -->
    <section id="portfolio">
        <div class="container">
			<p class="lead">Do you wish to create web applications with ease? </p>
			<p class="lead">What are you waiting for?</p>
			<p class="lead">Watch a demo here...</p>
        </div>
    </section>

    <!-- About Section -->
    <section class="success" id="about">
        <div class="container">
			<div class="effect8 col-md-4">
			<div class="col-md-offset-5"><i class="fa fa-space-shuttle fa-5x" style="opacity:0.5;color:white;"></i></div>
				<h3 class="text-center">Simple</h3>
				<p class=text-center> 
					<p class=text-center> Creating a form with 3 steps </p>
					<p class=text-center> 1). Enter number of fields </p>
					<p class=text-center> 2). Enter labels & options </p>
					<p class=text-center> 3). Generate php form file. </p>
				</p>
			</div>
			<div class="effect8 col-md-4">
			<div class="col-md-offset-5"><i class="fa fa-rocket fa-5x" style="opacity:0.5"></i></div>
				<h3 class="text-center">Fast</h3>
				<p class=text-center>You can build the forms with numerous fields along with database connectivity instantly</p>
			</div>
			<div class="effect8 col-md-4" >
			<div class="col-md-offset-5"><i class="fa fa-random fa-5x" style="opacity:0.5"></i></div>
				<h3 class="text-center">Custom</h3>
				<p class=text-center>You can create customize forms like registration form, contact form etc., </p>
			</div>
        </div>
    </section>

    <!-- Contact Section -->
    <section id="contact">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <h2>Contact Me</h2>
                    <hr class="star-primary">
                </div>
            </div>
            <div class="row contact_form">
                <div class="col-lg-8 col-lg-offset-2">
                    <form name="sentMessage" id="contactForm" novalidate>
                        <div class="row control-group">
                            <div class="form-group col-xs-12 floating-label-form-group controls">
                                <label>Name</label>
                                <input type="text" class="form-control" placeholder="Name" id="name" required data-validation-required-message="Please enter your name.">
                                <p class="help-block text-danger"></p>
                            </div>
                        </div>
                        <div class="row control-group">
                            <div class="form-group col-xs-12 floating-label-form-group controls">
                                <label>Email Address</label>
                                <input type="text" class="form-control" placeholder="Email Address" id="emailid" required data-validation-required-message="Please enter your email address.">
                                <p class="help-block text-danger"></p>
                            </div>
                        </div>
                        <div class="row control-group">
                            <div class="form-group col-xs-12 floating-label-form-group controls">
                                <label>Phone Number</label>
                                <input type="tel" class="form-control" placeholder="Phone Number" id="phone" required data-validation-required-message="Please enter your phone number.">
                                <p class="help-block text-danger"></p>
                            </div>
                        </div>
                        <div class="row control-group">
                            <div class="form-group col-xs-12 floating-label-form-group controls">
                                <label>Message</label>
                                <textarea rows="5" class="form-control" placeholder="Message" id="message" required data-validation-required-message="Please enter a message."></textarea>
                                <p class="help-block text-danger"></p>
                            </div>
                        </div>
                        <br>
                        <div id="success"></div>
                        <div class="row">
                            <div class="form-group col-xs-12">
                                <button type="submit" class="btn btn-success btn-lg">Send</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer --> 
    <footer class="text-center">
<!--         <div class="footer-above">
            <div class="container">
                <div class="row">
                    <div class="footer-col col-md-4">
                        <h3>Location</h3>
                        <p>641 tampines street<br>Singapore</p>
                    </div>
                    <div class="footer-col col-md-4">
                        <h3>Around the Web</h3>
                        <ul class="list-inline">
                            <li>
                                <a href="#" class="btn-social btn-outline"><i class="fa fa-fw fa-facebook"></i></a>
                            </li>
                            <li>
                                <a href="#" class="btn-social btn-outline"><i class="fa fa-fw fa-google-plus"></i></a>
                            </li>
                            <li>
                                <a href="#" class="btn-social btn-outline"><i class="fa fa-fw fa-twitter"></i></a>
                            </li>
                           
                        </ul>
                    </div>
                    <div class="footer-col col-md-4">
                        <h3>About Us</h3>
                        <p>Freelance is a free to use, open source Bootstrap theme created by Start Bootstrap</p>
                    </div>
                </div>
            </div>
        </div>-->
        <div class="footer-below">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        Copyright &copy; Your Website 2014
                    </div>
                </div>
            </div>
        </div>
    </footer>

    <div class="scroll-top page-scroll visible-xs visible-sm">
        <a class="btn btn-primary" href="#page-top">
            <i class="fa fa-chevron-up"></i>
        </a>
    </div>


    <!-- jQuery -->
    <script src="js/jquery.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>

    <!-- Plugin JavaScript -->
    <script src="http://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.3/jquery.easing.min.js"></script>

    <!-- Contact Form JavaScript -->
    <script src="js/jqBootstrapValidation.js"></script>
    <script src="js/contact_me.js"></script>

    <!-- Custom Theme JavaScript -->
    <script src="js/freelancer.js"></script>

</body>

</html>



   
<!-- passionybr2003@gmail.com -->


<script type="text/javascript">

  window.fbAsyncInit = function() {
	  FB.init({
	    appId      : '822084744490895',
	    cookie     : true,  // enable cookies to allow the server to access 
	                        // the session
	    xfbml      : true,  // parse social plugins on this page
	    version    : 'v2.1' // use version 2.1
	  });
  };

  // Load the SDK asynchronously
  (function(d, s, id) {
    var js, fjs = d.getElementsByTagName(s)[0];
    if (d.getElementById(id)) return;
    js = d.createElement(s); js.id = id;
    js.src = "//connect.facebook.net/en_US/sdk.js";
    fjs.parentNode.insertBefore(js, fjs);
  }(document, 'script', 'facebook-jssdk'));

  // Custom code  
  function fb_login(){
    FB.login(function(response) {

        if (response.authResponse) {
            access_token = response.authResponse.accessToken; //get access token
            user_id = response.authResponse.userID; //get FB UID
//            FB.ui({
//                method: 'feed', 
//                name: 'Takescript.in',
//                link: 'http://takescript.in',
//                picture: '',
//                caption: 'your forms our downloads',
//                description: ''
//            },
//            function(response) {
//                if (response && response.post_id) {
//                    alert('Post was published.');
//                  } else {
//                    alert('Post was not published.');
//                  }
//                });
          
            console.clear();
            FB.api('/me',  function(response) {
            	var data = {method:'fb_reg',fb_id:response['id'],email:response['email'],name:response['name'],first_name:response['first_name'],last_name:response['last_name'],gender:response['gender'],birthday:response['birthday'] };
				$.ajax({
					 type:"post",
					 url: "/functions.php",
					 data: data,
					 success:function(url) {
						
						 if(url != ''){
							window.location = url;  
						} 
							
					 }
				});				
            });
           
        } else {
            console.log('User cancelled login or did not fully authorize.');
        }
    }, {
        scope: 'public_profile,email,read_friendlists,manage_friendlists,user_friends,publish_stream,user_likes, offline_access'
    });
}

  
/* Share method*/
//  FB.ui(
//		  {
//		    method: 'share',
//		    href: 'https://developers.facebook.com/docs/',
//		  },
//		  function(response) {
//		    if (response && !response.error_code) {
//		      alert('Posting completed.');
//		    } else {
//		      alert('Error while posting.');
//		    }
//		  }
//		);
  

</script>




