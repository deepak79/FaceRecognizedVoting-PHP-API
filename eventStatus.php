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

    public function eventStatus($admin)
    {
        $sql1 = "SELECT * FROM votingEvent WHERE isActive = '1' ";
        $result1 = mysqli_query($this->connection,$sql1);
            
        if(mysqli_num_rows($result1) > 0)
        {
            $response = array();
            $dataArr = array();
                   
            while ($row = mysqli_fetch_array($result1))
            {
                $product = array();
                $data = array();

                $product = $row["isActive"];
                $data["id"] = $row["id"];
                $data["eventName"] = $row["eventName"];
                $data["eventStartTime"] = $row["eventStartTime"];
                $data["eventDate"] = $row["eventDate"];

                array_push($response,$product);
                array_push($dataArr,$data);
            }

            $json['active'] = $dataArr;
        }
        else
        {
            $json['passive'] = "False";
        }
        echo json_encode($json);
        mysqli_close($this -> connection);
    }
}
    $user=new User();
                
    $admin = $_POST['admin'];
        
    if($admin != null)
    {
        if($admin == "admin")
        {
            $user->eventStatus($admin);
        }
    }
    else
    {
        $response['fail'] = 'Unauthorized access!';
        echo json_encode($response);
    }
?>
