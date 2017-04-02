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

    public function verifyToken($token,$email)
    {
        $sql = "SELECT * FROM tokens WHERE tokenNumber='$token' ";
        $result = mysqli_query($this->connection,$sql);   
		if(mysqli_num_rows($result) > 0)
		{
			$row = $result->fetch_assoc();
			$attempts = $row['attempts'];
			$status =  $row['status'];
			$tbEmail = $row['usedBy'];
			$isActive = $row['isActive'];
			if($tbEmail == 0 && $isActive == 0 && $status == 0)
			{
				if($attempts < 3)
				{
					$sql1 = "SELECT email FROM userDetails WHERE email='$email'";
		        	$result1 = mysqli_query($this->connection,$sql1);  
					$total = mysqli_num_rows($result1);
					if($total == 0)
					{
						$sql2 = "UPDATE tokens SET status = '1', usedBy = '$email', attempts = $attempts + 1 WHERE tokenNumber = '$token' ";
		        		$result2 = mysqli_query($this->connection,$sql2);

		        		if($result2)
		        		{
		        			$json['pass']="You've used ".($attempts+1)." attempts for registration!";
		        		}
		        		else
		        		{
		        			$json['fail']= "Failed to access token!";
		        		}
					}
					else
					{
						$json['fail']="Email address is already in use!";
					}
				}
				else
				{
					$json['fail'] = "Your token number exceeded the limit please contact administrator!";
				}
			}
			else
			{
				if($attempts < 3 && $tbEmail == $email)
				{
					$sql1 = "SELECT email FROM userDetails WHERE email='$email'";
		        	$result1 = mysqli_query($this->connection,$sql1);  
					$total = mysqli_num_rows($result1);
					if($total == 0)
					{
						$sql2 = "UPDATE tokens SET status = '1', usedBy = '$email', attempts = $attempts + 1 WHERE tokenNumber = '$token' ";
		        		$result2 = mysqli_query($this->connection,$sql2);

		        		if($result2)
		        		{
		        			$json['pass']="You've used ".($attempts+1)." attempts for registration!";
		        		}
		        		else
		        		{
		        			$json['fail']= "Failed to access token!";
		        		}
					}
					else
					{
						$json['fail']="Email address is already in use!";
					}
				}
				else
				{
					$json['fail'] = "Not a valid token number!";
				}
			}		
		}       
		else
		{
			$json['fail']= "Token number doesn't exist!";
		}       
	    echo json_encode($json);
	    mysqli_close($this -> connection);
	}
}
    $user=new User();
    
    @$token = $_POST['token'];
    @$email = $_POST['email'];
    		
    if($token != null && $email != null)
    {
    	$user->verifyToken($token,$email);
    }
    else
    {
    	$json['fail'] = "Unauthorized access";
		echo json_encode($json);
    }
?>
