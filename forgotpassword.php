<?php
include_once 'connection.php';

class User 
{

    private $db;
    private $connection;

    function __construct() 
    {    
        $this->db = new DB_Connection();
        $this->connection = $this->db-> getConnection();
    }
    
    
    public function insert_user($email)
    {	
	    function generateRandomString($length = 8 ) 
	    {
		    $characters = '123456789';
		    $charactersLength = strlen($characters);
		    $randomString = '';
		    for ($i = 0; $i < $length; $i++) 
		    {
		        $randomString .= $characters[rand(0, $charactersLength - 1)];
		    }
		    return $randomString;
	    }

        $sql = "SELECT id FROM userDetails WHERE email='$email' ";
	        $result = mysqli_query($this->connection,$sql);   
		if(mysqli_num_rows($result) > 0)
		{
			$token = generateRandomString();
			
			$hashedtoken = md5($token);
			
			$sql1 = "UPDATE userDetails SET tokenForgotPass = '$hashedtoken' WHERE email = '$email' ";
			mysqli_query($this->connection,$sql1);
			
			$to      = $email;
			$subject = 'Verify email';				
			$message = 'Please click on this link to verify your email http://localhost/api/resetpassword.php?token='.$hashedtoken;
			$headers = 'From: webmaster@localhost.in' . "\r\n" .
			'Reply-To: webmaster@localhost.in' . "\r\n" .
			'X-Mailer: PHP/' . phpversion();
					
			mail($to, $subject, $message, $headers);
			
			$json['pass']= "Password reset link successfully mailed to you.";
		}       
		else
		{
			$json['fail']= "No such user exist!";
		}
	       
	    echo json_encode($json);
	    mysqli_close($this->connection);
	}
}
    $user=new User();
    
    $email=$_POST['email'];
    		
    if($email != null)
    {
    	$user->insert_user($email);
    }
    else
    {
    	$json['fail']= "Unauthorized access";
    }
?>
