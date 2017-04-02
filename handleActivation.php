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

    public function modify($id,$flag)
    {

    	$sql = "SELECT id FROM volunteers WHERE id = '$id' ";
		$result = mysqli_query($this->connection,$sql);

        if(mysqli_num_rows($result) > 0)
        {
        	$sql2 = "UPDATE volunteers SET isActive = '$flag' WHERE id = '$id' ";
			$result2 = mysqli_query($this->connection,$sql2);

		    if($result2)
		    {
		        if($flag == "0")
		        {
		        	$json['pass']="Successfully blocked the volunteer!";
		        }
		        else if($flag == "1")
		        {
		        	$json['pass']="Successfully activated the volunteer!";
		        }
		    }
		    else
		    {
		        $json['fail']= "Please try again!";
		    }
        }
        else
		{
		    $json['fail'] = "Unauthorized access";
		}
	    echo json_encode($json);
	    mysqli_close($this -> connection);
	}
}
    $user=new User();
    @$id = $_POST['id'];
    @$flag = $_POST['flag'];
    		
    if($id != null && $flag != null)
    {
    	$user->modify($id,$flag);
    }
    else
    {
    	$json['fail'] = "Unauthorized access";
		echo json_encode($json);
    }
?>
