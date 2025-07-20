<?php
include_once "Data_base.php";
class User{
public $fullname;
public $email;
public $password;
public $gender;
public $hobbies;
public $country;
public function  __construct($fullname,$email,$password,$gender,$hobbies,$country){
$this->fullname=$fullname;
$this->email=$email;
$this->password=$password;
$this->gender=$gender;
$this->hobbies=$hobbies;
$this->country=$country;

}
public function update($user,$userId){
$conn = new mysqli("localhost", "root", "", "website_users");
 if ($conn->connect_error) {
     die("Connection failed: " . $conn->connect_error);
 }
$hashed_pass=password_hash($user->password,PASSWORD_DEFAULT);
$stmt = $conn->prepare("UPDATE users SET fullname = ?, email = ?, password = ?, gender = ?, country = ? WHERE id = ?");
$stmt->bind_param("sssssi", $user->fullname, $user->email, $hashed_pass, $user->gender, $user->country,$userId);
$stmt->execute();
header("Location: restoredata.php?id=" . urlencode($userId) . "&success=1");
exit;
    
}
public static function delete($userId){
    $conn=new mysqli("localhost","root","");
      $conn->select_db("website_users");
      $sql="DELETE from users where id=$userId";
      $conn->query($sql);
      $sql="DELETE from user_hobbies where userid=$userId";
      $conn->query($sql);
}



}
?>