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

    public function getAll($admin)
    {
    
        if($admin == "admin")
        {
            $sql1 = "SELECT * FROM userDetails";

                $result1 = mysqli_query($this->connection,$sql1);
                
                if($result1)
                {
                    $response["data"] = array();
                    
                    while ($row = mysqli_fetch_array($result1))
                    {
                        $product = array();

                        $product["id"] = $row["id"];
                        $product["name"] = $row["name"];
                        $product["profilePhoto"] = $row["profilePhoto"];
                        $product["ward"] = $row["ward"];
                        $product["isActiveByAdmin"] = $row["isActiveByAdmin"];

                        array_push($response["data"],$product);
                    }
                }
                else
                {
                    $response['error'] = 'Please try again!';
                }
        }
        else
        {
            $response['fail'] = 'Unauthorized access!';
        }
        echo json_encode($response);
        mysqli_close($this -> connection);

    }

}
    $user=new User();
                
    $admin = $_POST['admin'];
        
    if($admin != null)
    {
        if($admin == "admin")
        {
            $user->getAll($admin);
        }
    }
    else
    {
        $response['fail'] = 'Unauthorized access!';
        echo json_encode($response);
    }
?>
