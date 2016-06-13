<?php
include "connection.php";
include "function.php";

$accountID = $_POST["accountID"];
$gjp = $_POST["gjp"];
$targetAccountID = $_POST["targetAccountID"];
$requestID = $_POST["requestID"];



if($accountID != ""){
	if(gjpCheck($accountID,$gjp)){
		//accepting request for the user 1
		$query = $db->prepare("INSERT INTO `friends`(`accountID1`, `accountID2`) VALUES ('".$accountID."','".$targetAccountID."')");
		$query->execute();		
		//accepting request for the user 2
		$query = $db->prepare("INSERT INTO `friends`(`accountID1`, `accountID2`) VALUES ('".$targetAccountID."','".$accountID."')");
		$query->execute();
		//removing the request
		$query = $db->prepare("DELETE FROM `friendRequests` WHERE requestID = '".$requestID."'");
		$query->execute();
		echo 1;
	}
}


?>