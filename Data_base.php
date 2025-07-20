<?php
include_once "User.php";
class Data_base{
private $conn;
public function handlexss(){
$fullname=htmlspecialchars( $_POST["fullname"]);
$email=htmlspecialchars($_POST["email"]);
$password=htmlspecialchars($_POST["password"]);
$confirmpassword=htmlspecialchars($_POST["confirmpassword"]);
$gender=htmlspecialchars($_POST["gender"]);
$hobbies=array_map("htmlspecialchars",($_POST["Hobbies"]));
$country=htmlspecialchars($_POST["country"]);
if ($password==$confirmpassword){
$user= new User($fullname,$email,$password,$gender,$hobbies,$country);
}
else{
     header("Location: registration.html?error=pass_mismatch");
   exit;
}

$user=new User($fullname,$email,$password,$gender,$hobbies,$country);
return $user;
}



}


?>