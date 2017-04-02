<?php
include_once 'connection.php';

?>



<!DOCTYPE html>
<html lang="en">
<head>
  <title>FRV Reset Password</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
  <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
</head>
<body>
<div class="container">
 
  <h2>Reset your Face recognized voting account password</h2>
  <form method="post" action="">
  
   <?php
  
  
class User 
{

    private $db;
    private $connection;

    function __construct() 
    {    
        $this -> db = new DB_Connection();
        $this -> connection = $this -> db -> getConnection();
    }
   
    public function insert_user($token)
    {	
        $sql = "SELECT id FROM userDetails WHERE tokenForgotPass ='$token' ";
        $result = mysqli_query($this->connection,$sql);   
      	if(mysqli_num_rows($result) > 0)
      	{
      		while ($row = $result->fetch_assoc()) 
      		{
      			$id = $row['id']; 
      		}
      		
      		$password = $_POST['newpassword'];
      		$npassword = $_POST['newpagain'];
      		
      		if($password == null)
      		{
      		  echo "<p><span style=color:red; font-weight:bold>Please fill new password</span></p>";
      		}
      		else if($npassword == null)
      		{
      		  echo "<p><span style=color:red; font-weight:bold>Please fill new password again</span></p>";
      		}
      		else if($password == $npassword)
      		{
      			$sql1 = "UPDATE userDetails SET password = '$password' WHERE id = '$id' ";
      			$result1 = mysqli_query($this->connection,$sql1);
      			
      			$null = "";
      			
      			$sql2 = "UPDATE userDetails SET tokenForgotPass = '$null' WHERE id = '$id' ";
      			mysqli_query($this->connection,$sql2);  
      			echo "<p><span style=color:green; font-weight:bold>Password changed successfully</span></p>";
      		}
      		else
      		{
      			echo "<p><span style=color:red; font-weight:bold>Password not matched</span></p>";
      		}
      	}       
      	else
      	{
      		echo "<p><span style=color:red; font-weight:bold>Token expired</span></p>";
      	}
        mysqli_close($this -> connection);
    }
}

    $token=$_GET['token'];
    
    if($token == null)
    {
  	echo "<p><span style=color:red; font-weight:bold>Token missing</span></p>";
    }
    if(isset($_POST['submit']))
    {
    	$user=new User();
    	
    	$user->insert_user($token);
    }
    
    
  ?>	
  	
    <div class="form-group">
      <label for="newpassword">New Password:</label>
      <input type="password" class="form-control" id="newpassword" name="newpassword" placeholder="Enter new password">
    </div>
    <div class="form-group">
      <label for="newpagain">New Password Again:</label>
      <input type="password" class="form-control" id="newpagain" name="newpagain" placeholder="Enter password again">
    </div>
    

    <button type="submit" id="submit" name="submit" class="btn btn-default">Submit</button>
  </form>
</div>

</body>
</html>
