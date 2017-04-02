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

    public function getAll($admin,$flag,$ward)
    {
    
        if($admin == "admin")
        {
            if($ward == "0")
            {
                $sql1 = "SELECT * FROM volunteers";

                $result1 = mysqli_query($this->connection,$sql1);
                
                if($result1)
                {
                    $response["data"] = array();
                    
                    while ($row = mysqli_fetch_array($result1))
                    {
                        $product = array();

                        $product["id"] = $row["id"];
                        $product["name"] = $row["vName"];
                        $product["partyName"] = $row["vParty"];
                        $product["logo"] = $row["vLogo"];
                        $product["flag"] = $row["isActive"];
                        $product["ward"] = $row["vWard"];
                        $product["volunteer"] = $flag;

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
                $sql1 = "SELECT * FROM volunteers WHERE vWard = '$ward' ";

                $result1 = mysqli_query($this->connection,$sql1);
                
                if($result1)
                {
                    $response["data"] = array();
                    
                    while ($row = mysqli_fetch_array($result1))
                    {
                        $product = array();

                        $product["id"] = $row["id"];
                        $product["name"] = $row["vName"];
                        $product["partyName"] = $row["vParty"];
                        $product["logo"] = $row["vLogo"];
                        $product["flag"] = $row["isActive"];
                        $product["ward"] = $row["vWard"];
                        $product["volunteer"] = $flag;

                        array_push($response["data"],$product);
                    }
                }
                else
                {
                    $response['fail'] = 'Please try again!';
                }
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
    $flag = $_POST['flag'];
    $ward = $_POST['ward'];     
        
    if($admin != null && $flag != null)
    {
        if($admin == "admin")
        {
            $user->getAll($admin,$flag,$ward);
        }
    }
    else
    {
        $response['fail'] = 'Unauthorized access!';
        echo json_encode($response);
    }
?>
