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

    public function verifyToken($token)
    {
        $sql = "UPDATE tokens SET usedBy = '0' AND status = '0' WHERE tokenNumber='$token' ";
        $result = mysqli_query($this->connection,$sql);   
		if($result)
		{
			$json['pass']= "1";
		}       
		else
		{
			$json['fail']= "0";
		}       
	    echo json_encode($json);
	    mysqli_close($this -> connection);
	}
}
    $user=new User();
    
    @$token = $_POST['token'];
    		
    if($token != null)
    {
    	$user->verifyToken($token);
    }
    else
    {
    	$json['fail'] = "Unauthorized access";
		echo json_encode($json);
    }
?>
