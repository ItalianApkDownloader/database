<?php
include "../connection.php";
//here im getting all the data
$userName = htmlspecialchars($_POST["userName"],ENT_QUOTES);
$password = md5($_POST["password"]);
$secret = "";
//registering
$query = $db->prepare("select * from accounts where userName = '".$userName."' AND password = '".$password."'");

$query->execute();
$result = $query->fetchAll();
$account = $result[0];
echo $account["saveData"];
?>