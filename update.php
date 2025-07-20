<?php
include_once "User.php";
include_once "Data_base.php";
if (isset($_GET['id'])) {
    $userId = $_GET['id'];
    $userId = intval($userId);

    
}
 

if ($_SERVER["REQUEST_METHOD"] === "POST") {
$db=new Data_base();
$user=$db->handlexss();
$user->update($user,$userId);
}