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

    public function voteNow($admin,$id,$eventid,$userid)
    {
        $sql1 = "SELECT * FROM votingEvent WHERE id = '$eventid' ";
        $result1 = mysqli_query($this->connection,$sql1);

        if(mysqli_num_rows($result1) > 0)
        {
            while($row = @mysqli_fetch_assoc($result1))
            {
                $eventID = $row['id'];                  
                
                $sql = "SELECT * FROM votingCounter WHERE eventID = '$eventid'";
                $result = mysqli_query($this->connection,$sql);

                $sq = "SELECT * FROM voteMaster WHERE userid = '$userid' AND eventid = '$eventid' ";
                $sqr = mysqli_query($this->connection,$sq);
                if(mysqli_num_rows($sqr) == 0)
                {
                    if(mysqli_num_rows($result) == 0)
                    {
                        $s = "INSERT INTO votingCounter(id,volunteerID,totalCount,eventID) VALUES(NULL,'$id','1','$eventid') ";
                        $r = mysqli_query($this->connection,$s);

                        if($r)
                        {
                            $sm = "INSERT INTO voteMaster(id,userid,eventid,created) VALUES(NULL,'$userid','$eventid',DEFAULT)";
                            $smr = mysqli_query($this->connection,$sm);
                            if($smr)
                            {
                                $json['pass'] = "Your precious vote is secured with us!";
                            }
                            else
                            {
                                $json['fail'] = "Failed to register your vote!";
                            }                            
                        }
                        else
                        {
                             $json['fail'] = "Failed to register your vote!";
                        }
                    }
                    else
                    {                    
                        $s = "UPDATE votingCounter SET totalCount = totalCount + 1 WHERE volunteerID = '$id' ";
                        $r = mysqli_query($this->connection,$s);

                        if($r)
                        {
                            $sm = "INSERT INTO voteMaster(id,userid,eventid,created) VALUES(NULL,'$userid','$eventid',DEFAULT)";
                            $smr = mysqli_query($this->connection,$sm);
                            if($smr)
                            {
                                $json['pass'] = "Your precious vote is secured with us!";
                            }
                            else
                            {
                                $json['fail'] = "Failed to register your vote!";
                            }
                        }
                        else
                        {
                             $json['fail'] = "Failed to register your vote!";
                        }
                    }                            
                }
                else
                {
                    $json['fail'] = 'You have already voted for this events';
                }
            }       
        }
        else
        {
            $json['fail'] = "Failed to get live event data!";
        }
        echo json_encode($json);
        mysqli_close($this -> connection);
    }
}
    $user=new User();
                
    $admin = $_POST['admin'];    
    $id = $_POST['id'];
    $eventid = $_POST['eventid'];
    $userid = $_POST['userid']; 
        
    if($admin != null && $id != null)
    {
        if($admin == "admin")
        {
            $user->voteNow($admin,$id,$eventid,$userid);
        }
    }
    else
    {
        $response['fail'] = 'Unauthorized access!';
        echo json_encode($response);
    }
?>
