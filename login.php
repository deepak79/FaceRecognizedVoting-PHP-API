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

    public function login($email,$password,$role,$tokenno)
    {
        if($role == "0")
        {
        	$sql = "SELECT email FROM userDetails WHERE email = '$email'";
	        $result = mysqli_query($this->connection,$sql);   
			if(mysqli_num_rows($result) > 0)
			{

		        $sql1 = "SELECT * FROM userDetails WHERE email = '$email' AND password = '$password'";
		        $result1 = mysqli_query($this->connection,$sql1);   
				
				$row = $result1->fetch_assoc();
				$isActive = $row['isActive'];
				$isActiveByAdmin = $row['isActiveByAdmin'];
				$token = $row['token'];

				if(mysqli_num_rows($result1) > 0)
				{
					if($isActiveByAdmin == "1")
					{
						if($tokenno == "")
						{
					        $sql2 = "SELECT * FROM userDetails WHERE email = '$email'";
					        $result2 = mysqli_query($this->connection,$sql2);  

							$rows = $result2->fetch_assoc();
							$product = array();
							$data['data'] = array();

							$product['token'] = $rows['token'];
							$product['name'] = $rows['name'];
							$product['profilePhoto'] = $rows['profilePhoto'];
							$product['email'] = $rows['email'];
							$product['dob'] = $rows['dob'];
							$product['ward'] = $rows['ward'];
							$product['gender'] = $rows['gender'];
							$product['phonenumber'] = $rows['phonenumber'];
							$product['faceID'] = $rows['faceID'];
							$product['subjectID'] = $rows['subjectID'];
							$product['id'] = $rows['id'];
							$product['isActive'] = $rows['isActive'];
							if($result2)
							{
								array_push($data["data"],$product);
								$json['pass']="Successfully logged in";

								$json['data']= $data;
							}
							else
							{
								$json['pass']="Please try again!";
							}
						}
						else
						{
							if($tokenno != $token)
							{
								$json['fail']="Wrong token number!";
							}
							else if($token == $tokenno)
							{
								$sm = "UPDATE userDetails SET isActive = '1' WHERE email = '$email' ";
								$rm = mysqli_query($this->connection,$sm);

						        $sql2 = "SELECT * FROM userDetails WHERE email = '$email'";
						        $result2 = mysqli_query($this->connection,$sql2);  

								$rows = $result2->fetch_assoc();
								$product = array();
								$data['data'] = array();

								$product['token'] = $rows['token'];
								$product['name'] = $rows['name'];
								$product['profilePhoto'] = $rows['profilePhoto'];
								$product['email'] = $rows['email'];
								$product['dob'] = $rows['dob'];
								$product['ward'] = $rows['ward'];
								$product['gender'] = $rows['gender'];
								$product['phonenumber'] = $rows['phonenumber'];
								$product['faceID'] = $rows['faceID'];
								$product['subjectID'] = $rows['subjectID'];
								$product['id'] = $rows['id'];
								$product['isActive'] = $rows['isActive'];
								if($result2)
								{
									array_push($data["data"],$product);
									$json['pass']="Welcome to Face recognized voting";

									$json['data']= $data;
								}
								else
								{
									$json['pass']="Please try again!";
								}
							}
						}
					}
					else
					{
						$json['fail']="Your account is not activated by admin yet. Your request is being processed!";
					}
				}
				else
				{
					$json['fail']= "Wrong password!";
				}			
			}       
			else
			{
				$json['fail']= "User not found, Please register to login!";
			}
        }
        else if($role == "1")
        {
			$sql = "SELECT email FROM adminDetails WHERE email = '$email' AND password = '$password' ";
	        $result = mysqli_query($this->connection,$sql);
	        if(mysqli_num_rows($result) > 0)
			{
				$json['pass']= "Welcome Mr.Admin!";	
			}
			else
			{
				$json['fail']= "User not found, Please register to login!";
			}
        }
        else
        {
        	$json['fail']= "Unauthorized access";
        }
	    echo json_encode($json);
	    mysqli_close($this->connection);
	}
}
    $user=new User();
    
    $email=$_POST['email'];
    $password=$_POST['password'];
    $role=$_POST['role'];
    $tokenno = $_POST['tokenno'];
    
    if($email != null && $password != null && $role != null)
    {
    	$user->login($email,$password,$role,$tokenno);
    }
    else
    {
    	$json['fail']= "Unauthorized access";
    	echo json_encode($json);
    }
?>
