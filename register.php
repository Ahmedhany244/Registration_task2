<?php 
include_once "User.php";
include_once "Data_base.php";
if ($_SERVER["REQUEST_METHOD"] === "POST") {
$db=new Data_base();
$user=$db->handlexss();
echo "Full Name: $user->fullname <br>";
echo "Email: $user->email <br>";
echo "Password: $user->password <br>";
echo "Gender: $user->gender <br>";
echo "Hobbies: <br>";

for ($x=0;$x<count($user->hobbies);$x++){
     echo "- " . $user->hobbies[$x] . "<br>";
}
echo "Country: $user->country <br>";
$conn=new mysqli("localhost","root","");
if ($conn->connect_error){
     die ("connection to database is failed ".$conn->connect_error);
}
else{
     $sql="CREATE DATABASE IF NOT EXISTS website_users";
     
     if ($conn->query($sql)!==true){
          echo "creation of database is failed".$conn->error;
     }
     else{
          $conn->select_db("website_users");
          $sql="CREATE table  IF NOT EXISTS users(
          id int AUTO_INCREMENT PRIMARY KEY,
          fullname varchar(50),
          email varchar(50),
          password varchar(255),
          gender varchar(10),
          country varchar(50)
          )";
          
          $sql1="CREATE table IF NOT EXISTS user_hobbies(
          hobbyname varchar(20),
          userid int,
          primary key (hobbyname,userid)

          )";
          if ($conn->query($sql)!==true or $conn->query($sql1)!==true){
          echo "creation of table is failed".$conn->error;
     }
     else{
          $sql="INSERT INTO users (fullname,email,password,gender,country) values(?,?,?,?,?)";
          $stmt=$conn->prepare($sql);
          $hashed_pass=password_hash($user->password,PASSWORD_DEFAULT);
          $stmt->bind_param("sssss", $user->fullname,$user->email, $hashed_pass,$user->gender,$user->country);
          if(!$stmt->execute()){
               echo "failed to insert the data in userstable".$stmt->error;
          }
          $lastid=$conn->insert_id;
         for ($x=0;$x<count($user->hobbies);$x++){
          $sql="INSERT INTO user_hobbies (hobbyname,userid) values(?,?)";
          $stmt=$conn->prepare($sql);
          $stmt->bind_param("si", $user->hobbies[$x], $lastid);
          if(!$stmt->execute()){
               echo "failed to insert the data in user_hobbies".$stmt->error;
          }

          }
         
          
     }
     
     $stmt->close();
     $conn->close();
     }
}

}

?>