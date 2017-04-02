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

    public function endEvent($id)
    {
        $sql1 = "UPDATE `votingEvent` SET eventEndTime = now() , isActive = '0' WHERE `id` = '$id' ";

        $result1 = mysqli_query($this->connection,$sql1);
            
        if($result1)
        {
            $response['pass'] = 'Event ended successfully!';
        }
        else
        {
            $response['fail'] = 'Please try again!';
        }
        echo json_encode($response);
        mysqli_close($this -> connection);
    }
}
    $user=new User();
                
    $id = $_POST['id'];
        
    if($id != null)
    {
        $user->endEvent($id);
    }
    else
    {
        $response['fail'] = 'Unauthorized access!';
        echo json_encode($response);
    }
?>
