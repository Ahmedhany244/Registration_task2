<?php
if ($_SERVER["REQUEST_METHOD"] === "POST") {
$email=htmlspecialchars( $_POST["email"]);
$password=htmlspecialchars($_POST["password"]);
$conn=new mysqli("localhost","root","");
if ($conn->connect_error){
     die ("connection to database is failed ".$conn->connect_error);
}
else{
    $conn->select_db("website_users");
   $sql="SELECT * FROM users where email=? ";
   $stmt=$conn->prepare($sql);
   $stmt->bind_param("s",$email);
   $stmt->execute();
   $result = $stmt->get_result();
   if ($result->num_rows==1){
    $row = $result->fetch_assoc();
    $hashedPassword = $row['password'];
    
    if (password_verify($password, $hashedPassword)) {
            header("Location: user_options.html");
            exit;
        } else {
            echo "Wrong password.";
        }
    } else {
        echo "Email not found.";
   }
   
   $stmt->close();
   $conn->close();
}
}


?>