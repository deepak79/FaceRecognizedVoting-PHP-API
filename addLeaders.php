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

    public function verifyToken($logo,$name,$party,$ward)
    {

        function generateRandomString($length = 8) 
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

		$query_count = "SELECT vName FROM volunteers WHERE vName='$name' ";
        $insert = mysqli_query($this->connection,$query_count) or die(mysqli_error($this->connection));
        $num_rows = mysqli_num_rows($insert);
       
        if ($num_rows == 1) 
		{
			$json['fail'] = 'Duplicate entry of Volunteer';
        }
        else
        {
			$nums = generateRandomString();

			$path = "uploads/partyLogos/$nums.png";

		 	$actualpath = "http://localhost:8888/api/uploads/partyLogos/$nums.png";
		 	file_put_contents($path,base64_decode($logo));

		 	$sql = "INSERT INTO volunteers() VALUES('','$name','$ward','$party','$actualpath','0') ";
 			$result= mysqli_query($this->connection,$sql);
		 	if($result)
		 	{
		 		$json['pass'] = 'Volunteer details added successfully!';
		 	}
		 	else
		 	{
		 		$json['fail'] = 'Please try again!';
		 	}
        }

	    echo json_encode($json);
	    mysqli_close($this->connection);
	}
}
    $user=new User();
    
    $logo=$_POST['logo'];
    $name=$_POST['name'];
    $party=$_POST['party'];
    $ward=$_POST['ward'];
    
    if($logo != null && $name != null && $party != null && $ward != null)
    {
    	$user->verifyToken($logo,$name,$party,$ward);
    }
    else
    {
    	$json['fail']= "Unauthorized access";
    	echo json_encode($json);
    }
?>
