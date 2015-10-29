<?php 
			$db_host='';
			$db_username='';
			$db_pass='';
			$db_name='';
			if(isset($_POST['submit']) && $_SERVER['REQUEST_METHOD'] == 'POST'){
		 $username = $_POST['username'];
  $query = "INSERT INTO users (username,created,modified) VALUES ('$username',now(),now())";
				mysql_query($query); 
				if(mysql_affected_rows() > '0') {
					echo 'successfully inserted';
				} else {
					echo 'Not inserted successfully';
				}
			} 
 ?>
<html>
<body>
<form name='' action='<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>' method='post'>
 <label>enter name</label><input type='text' name='username' id='username' ><br>
 
<input type='submit' value='Submit' name='submit' id='submit'>
<input type='reset' value='Cancel' name='reset' id='reset'>
</form>
</body>
</html>