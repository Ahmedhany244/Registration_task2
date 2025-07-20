<?php 
include "User.php";
if ($_SERVER["REQUEST_METHOD"] === "POST") {
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
echo "Full Name: $fullname <br>";
echo "Email: $email <br>";
echo "Password: $password <br>";
echo "Confirm Password: $confirmpassword <br>";
echo "Gender: $gender <br>";
echo "Hobbies: <br>";

for ($x=0;$x<count($hobbies);$x++){
     echo "- " . $hobbies[$x] . "<br>";
}
echo "Country: $country <br>";
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
          $hashed_pass=password_hash($password,PASSWORD_DEFAULT);
          $stmt->bind_param("sssss", $fullname, $email, $hashed_pass, $gender, $country);
          if(!$stmt->execute()){
               echo "failed to insert the data in userstable".$stmt->error;
          }
          $lastid=$conn->insert_id;
         for ($x=0;$x<count($hobbies);$x++){
          $sql="INSERT INTO user_hobbies (hobbyname,userid) values(?,?)";
          $stmt=$conn->prepare($sql);
          $stmt->bind_param("si", $hobbies[$x], $lastid);
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