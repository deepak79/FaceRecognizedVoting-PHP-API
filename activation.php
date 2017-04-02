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

    public function insert_user($code)
    {
	$sql = "UPDATE agents SET status=1 WHERE code='$code' ";
	$insert = mysqli_query($this -> connection, $sql) or mysqli_error();
	$rows = mysqli_num_rows($insert);
	
	if($rows == 1)
	{
		$json['success'] = 'Account successfully activated..!';
	}
	else
	{
		$json['fail'] = 'No such user';
	}

        echo json_encode($json);
        mysqli_close($this -> connection);
    }

}
    $user=new User();
    
    $code=$_GET['code'];
    
    $user->insert_user($code);
?>
