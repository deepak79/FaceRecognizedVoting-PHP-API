<?php
include_once 'connection.php';

class User
{
    
    private $db;
    private $connection;
    
    function __construct()
    {
        $this->db         = new DB_Connection();
        $this->connection = $this->db->getConnection();
    }
    
    public function insert_user($id, $faceID, $subjectID, $timestamp, $galleryName, $type, $confidence, $profilePhoto)
    {
        function generateRandomString($length = 8)
        {
            $characters       = '123456789';
            $charactersLength = strlen($characters);
            $randomString     = '';
            for ($i = 0; $i < $length; $i++) {
                $randomString .= $characters[rand(0, $charactersLength - 1)];
            }
            return $randomString;
        }
        
        $nums = generateRandomString();
        
        $path = "uploads/profilepics/$nums.png";
        
        $actualpath = "http://192.168.1.100/api/uploads/profilepics/$nums.png";
        file_put_contents($path, base64_decode($profilePhoto));
        
        $salt  = sha1($email . time());
        $pass1 = sha1($password);
        
        $query = "UPDATE `userDetails` SET `profilePhoto` = '$actualpath', `faceID` = '$faceID' , `subjectID` = '$subjectID' , `tstamp` = '$timestamp' , `gallery_name` = '$galleryName' , `type` = '$type', `confidence` = '$confidence' WHERE `id` = '$id' ";
        
        $inserted = mysqli_query($this->connection, $query);
        if ($inserted) {
           $json['pass'] = 'Your details has been successfully updated!';
        } else {
            $json['fail'] = 'Please try agains!'.mysqli_error($this->connection);
        }
        
        echo json_encode($json);
        mysqli_close($this->connection);
    }
    
}
$user = new User();

$id           = $_POST['id'];
$faceID       = $_POST['faceID'];
$subjectID    = $_POST['subjectID'];
$timestamp    = $_POST['timestamp'];
$galleryName  = $_POST['galleryName'];
$type         = $_POST['type'];
$confidence   = $_POST['confidence'];
$profilePhoto = $_POST['profilePhoto'];

$user->insert_user($id, $faceID, $subjectID, $timestamp, $galleryName, $type, $confidence, $profilePhoto);

?>
