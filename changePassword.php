<?php
include_once 'connection.php';

class User 
{

    private $db;
    private $connection;

    function __construct() 
    {    
        $this -> db = new DB_Connection();
        $this -> connection = $this -> db -> getConnection();
    }

    public function changePassword($id,$password,$newpassword)
    {
        $sql = "SELECT password FROM userDetails WHERE id='$id' ";
        $result = mysqli_query($this->connection,$sql);   
		if(mysqli_num_rows($result) > 0)
		{
			$row = $result->fetch_assoc();
			$dbPassword = $row['password'];
			if($dbPassword == $password)
			{
				$sql2 = "UPDATE userDetails SET password = '$newpassword' WHERE id = '$id' ";
		        $result2 = mysqli_query($this->connection,$sql2);

	        	if($result2)
	        	{
	        		$json['pass']="Password changed successfully, Please login!";
	        	}
	        	else
	        	{
	        		$json['fail']= "Failed to change the password!";
	        	}
			}
			else
			{
				$json['fail'] = "Your current password is wrong!";	
			}		
		}       
		else
		{
			$json['fail']= "Please try again!";
		}       
	    echo json_encode($json);
	    mysqli_close($this -> connection);
	}
}
    $user=new User();
    @$id = $_POST['id'];
    @$password = $_POST['password'];
    @$newpassword = $_POST['newpassword'];
    		
    if($id != null && $password != null && $newpassword != null)
    {
    	$user->changePassword($id,$password,$newpassword);
    }
    else
    {
    	$json['fail'] = "Unauthorized access";
		echo json_encode($json);
    }
?>
