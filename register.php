<?php 
if ($_SERVER["REQUEST_METHOD"] === "POST") {
$fullname=$_POST["fullname"];
$email=$_POST["email"];
$password=$_POST["password"];
$confirmpassword=$_POST["confirmpassword"];
$gender=$_POST["gender"];
$hobbies=$_POST["Hobbies"];
$country=$_POST["country"];


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

}
?>