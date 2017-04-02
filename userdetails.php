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

    public function insert_user($email)
    {
    $email = mysqli_real_escape_string($this->connection,$email);
        
    $sql1 = "SELECT name,image,phone,user_type,id FROM agents WHERE email = '$email' ";

    $result1 = mysqli_query($this->connection,$sql1);
    
    if($result1)
    {
        $response["details"] = array();
        
        while ($row = mysqli_fetch_array($result1))
        {
            $product = array();

            $product["name"] = $row["name"];
            $product["image"] = $row["image"];
            $product["phone"] = $row["phone"];
            $product["type"] = $row["user_type"];
            $product["agentid"] = $row["id"];
            
            array_push($response["details"],$product);
        }
    }
    else
    {
        $response['error'] = 'Please try again!';
    }
    echo json_encode($response);
    mysqli_close($this -> connection);

    }

}
    $user=new User();
                
    $email = $_POST['email'];    
        
    $user->insert_user($email);
?>