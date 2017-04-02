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

    public function insert_user($name,$email,$password,$phoneNumber,$dob,$ward,$gender)
    {
        function generateRandomString($length = 8) 
        {
            $characters = '1234567890';
            $charactersLength = strlen($characters);
            $randomString = '';
            for ($i = 0; $i < $length; $i++) 
            {
                $randomString .= $characters[rand(0, $charactersLength - 1)];
            }
            return $randomString;
        }
        $query_count = "SELECT email FROM userDetails WHERE email='$email' ";
        $insert = mysqli_query($this->connection,$query_count);
        $num_rows = mysqli_num_rows($insert);
       
        if ($num_rows == 1) 
		{
			$json['fail'] = 'Email address already in use!';

        } 
		else
		{	 		
			$salt = sha1($email.time());
			$pass1 = sha1($password);

            $query =  "INSERT INTO `userDetails` (`id`, `token`, `name`, `profilePhoto`, `email`, `password`,`phonenumber`, `dob`, `ward`, `gender`, `faceID`, `subjectID`, `isActive`, `isActiveByAdmin`, `tstamp`, `gallery_name`, `type`, `confidence`) VALUES (NULL, '$token', '$name', '', '$email', '$password','$phoneNumber', '$dob', '$ward', '$gender', '', '', '0', '0', '', '', '', '')";

            $inserted = mysqli_query($this->connection,$query);
            if ($inserted) 
			{
                $id = mysqli_insert_id($this->connection);
                $token = generateRandomString();

                $s =  "UPDATE `userDetails` SET `token` = '$token' WHERE `id` = '$id'";
                $r = mysqli_query($this->connection,$s);

                if($r)
                {
                    $json['pass'] = "You have successfully registered, Please verify your account and get token number to get logged in to system!";

                    $message = "Your token number is ".$token;
                }
                else
                {
                    $json['fail'] = 'Failed to generate token, Please try again!';
                }

				
			} 
			else 
			{
                $json['fail'] = 'Please try again!';
            }
        }
        echo json_encode($json);
        mysqli_close($this -> connection);
    }

}
    $user=new User();
    
    $name=$_POST['name'];
    $email=$_POST['email'];
    $password=$_POST['password'];
    $phoneNumber=$_POST['phoneNumber'];
    $dob=$_POST['dob'];
    $ward=$_POST['ward'];
    $gender=$_POST['gender'];

    if($name != null && $email != null && $password != null && $phoneNumber != null && $dob != null && $ward != null && $gender != null){
    	$user->insert_user($name,$email,$password,$phoneNumber,$dob,$ward,$gender);
    }
    else
    {
    	$json['fail'] = "Unauthorized access";
		echo json_encode($json);
    }
	
?>
