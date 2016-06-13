<?php
include "connection.php";
include "function.php";


$accountID = $_POST["accountID"];
$gjp = $_POST["gjp"];
$commentID = $_POST["commentID"];
$levelID = $_POST["levelID"];

if($accountID != ""){
	if(gjpCheck($accountID,$gjp)){
		$query2 = $db->prepare("DELETE FROM `comments` WHERE commentID = '".$commentID."' ");
		$query2->execute();
	}
}

?>