<?php 
			
			if(isset($_POST['submit']) && $_SERVER['REQUEST_METHOD'] == 'POST'){
			$id =  $_POST['id'];
		 $username = $_POST['username'];
  $query = "UPDATE users SET username='$username',modified=now(),modified_by=$_SESSION['user_id'] WHERE id = $id";
				mysql_query($query); 
				if(mysql_affected_rows() > '0') {
					echo 'successfully inserted';
				} else {
					echo 'Not inserted successfully';
				}
			} 
 
			
			if(isset($_GET['id']) && $_GET['id'] != ''){   
				$id = $_GET['id'];
				$query = "SELECT * FROM users where id = $id";
				$result = mysql_query($query);				
			}
			?>
<html>
<body>
<form name='' action='<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>' method='post'>
 <input type='hidden' value='<?php echo $result['id']?>' name='id' ><br><label>enter name</label><input type='text' value='<?php echo $result['username'];?>' name='username' id='username' ><br>
 
<input type='submit' value='Submit' name='submit' id='submit'>
<input type='reset' value='Cancel' name='reset' id='reset'>
</form>
</body>
</html>