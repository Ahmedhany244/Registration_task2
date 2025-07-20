<?php
if (isset($_GET['id'])) {
    $userId = $_GET['id'];
    $userId = intval($userId);

    
}
 $conn = new mysqli("localhost", "root", "", "website_users");
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

if ($_SERVER["REQUEST_METHOD"] === "POST") {
$fullname=htmlspecialchars( $_POST["fullname"]);
$email=htmlspecialchars($_POST["email"]);
$password=htmlspecialchars($_POST["password"]);
$hashedpass=password_hash($password,PASSWORD_DEFAULT);
$confirmpassword=htmlspecialchars($_POST["confirmpassword"]);
if ($password!=$confirmpassword){
    header("Location: restoredata.php?id=" . urlencode($userId) . "&error=pass_mismatch");
   exit;
}
$gender=htmlspecialchars($_POST["gender"]);
$hobbies=array_map("htmlspecialchars",($_POST["Hobbies"]));
$country=htmlspecialchars($_POST["country"]);
$stmt = $conn->prepare("UPDATE users SET fullname = ?, email = ?, password = ?, gender = ?, country = ? WHERE id = ?");
$stmt->bind_param("sssssi", $fullname, $email, $hashedpass, $gender, $country, $userId);
$stmt->execute();


header("Location: restoredata.php?id=" . urlencode($userId) . "&success=1");
exit;
}