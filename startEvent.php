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

    public function startEvent($eventName,$volunteers)
    {
        $sql1 = "INSERT INTO `votingEvent` (`id`, `eventName`, `eventStartTime`, `eventEndTime`, `eventVolunteers`, `eventDate`, `isActive`) VALUES (NULL,'$eventName',now(),'0','$volunteers',now(),'1')";

        $result1 = mysqli_query($this->connection,$sql1) or die(mysqli_error($this->connection));
            
        if($result1)
        {
            $response['pass'] = 'Event started successfully!';
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
                
    $eventName = $_POST['eventName'];    
    $volunteers = $_POST['volunteers'];    
        
    if($eventName != null && $volunteers != null)
    {
        $user->startEvent($eventName,$volunteers);
    }
    else
    {
        $response['fail'] = 'Unauthorized access!';
        echo json_encode($response);
    }
?>
