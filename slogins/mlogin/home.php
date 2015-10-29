<!doctype html>
<html>
<title>Home - Login with Microsoft Live Account Oauth</title>

<body >
<?php
include('db.php');
session_start();
if (!isset($_SESSION['userdata'])) {
// Redirection to login page 
header("location: index.php");
}
else
{
$userdata=$_SESSION['userdata'];
$name =$userdata->name;
$microsoft_id =$userdata->id;
$first_name =$userdata->first_name;
$last_name =$userdata->last_name;
$gender=$userdata->gender;
$email=$userdata->emails->account;
$email2=$userdata->emails->preferred;
$locale=$userdata->locale;
$birth_day=$userdata->birth_day.'-'.$userdata->birth_month.'-'.$userdata->birth_year;
//$sql=mysqli_query($db,"insert into users(full_name,first_name,last_name,email,gender,birthday,provider_id) values("$name","$first_name","$last_name","$email","$gender","$birth_day","$microsoft_id")");
}
?>

<h2 colo> Welcome <?php echo $name; ?></h2>
<div>
<b>Full Name:</b> <?php echo $name; ?><br/>
<b>Email:</b> <?php echo  $email; ?><br/>
<b>Email Preferred:</b> <?php echo  $email2; ?><br/>
<b>First Name:</b> <?php echo $first_name; ?><br/>
<b>Last Name:</b> <?php echo $last_name; ?><br/>
<b>Microsoft Id</b> <?php echo $microsoft_id; ?><br/>
<b>Gender:</b> <?php echo $gender; ?><br/>
<b>Birthday:</b> <?php echo $birth_day; ?><br/>
</div>
</body>
</html>
