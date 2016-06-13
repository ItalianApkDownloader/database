<?php
include "connection.php";
include "function.php";




$accountID = $_POST["accountID"];
$gjp = $_POST["gjp"];
$requestID = $_POST["requestID"];



if($accountID != ""){
	if(gjpCheck($accountID,$gjp)){
		$query=$db->prepare("UPDATE friendRequests SET isNew = 0 WHERE requestID = '".$requestID."'");
		$query->execute();
	}
}


?>