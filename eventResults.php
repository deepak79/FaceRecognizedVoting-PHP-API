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

    public function getAll($admin,$eventid)
    {
    
        if($admin == "admin")
        {
            $sql1 = "SELECT * FROM votingCounter where eventID = '$eventid' ORDER BY id DESC LIMIT 1";

                $result1 = mysqli_query($this->connection,$sql1);
                
                if($result1)
                {

                    $row = $result1->fetch_assoc();
                    $volunteerID = $row['volunteerID'];
                    $totalCount = $row['totalCount'];
                    $eventID = $row['eventID'];


                    $s = "SELECT * FROM `votingEvent` WHERE id = '$eventID' ";
                    $r = mysqli_query($this->connection,$s);
                    $rs = $r->fetch_assoc();
                    $eventName = $rs['eventName'];


                    $sql = "SELECT * FROM `volunteers` WHERE id = '$volunteerID' ";
                    $result = mysqli_query($this->connection,$sql);

                    if ($result)
                    {
                        $response["data"] = array();
                    
                        while ($row1 = mysqli_fetch_array($result))
                        {
                            $product = array();

                            $product["vName"] = $row1["vName"];
                            $product["totalcount"] = $totalCount;
                            $product["eventName"] = $eventName;

                            array_push($response["data"],$product);
                        }
                    }
                }
                else
                {
                    $response['fail'] = 'Please try again!';
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
    $eventid = $_POST['eventid'];
        
    if($admin != null && $eventid != null)
    {
        if($admin == "admin")
        {
            $user->getAll($admin,$eventid);
        }
    }
    else
    {
        $response['fail'] = 'Unauthorized access!';
        echo json_encode($response);
    }
?>
