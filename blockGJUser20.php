<?php
include "connection.php";
include "function.php";

$accountID = $_POST["accountID"];
$gjp = $_POST["gjp"];
$targetAccountID = $_POST["targetAccountID"];

if(isAdmin($targetAccountID)){
   echo -1;
}else{


if($accountID != ""){
	if(gjpCheck($accountID,$gjp)){
		$query = $db->prepare("INSERT INTO `blocked`(`accountID1`, `accountID2`) VALUES ('".$accountID."','".$targetAccountID."')");
		$query->execute();
		$query = $db->prepare("DELETE FROM `friends` WHERE accountID1 = '".$accountID."' and accountID2 = '".$targetAccountID."' ");
		$query->execute();
		$query = $db->prepare("DELETE FROM `friends` WHERE accountID1 = '".$targetAccountID."' and accountID2 = '".$accountID."' ");
		$query->execute();
		echo 1;
	}
}
}
echo -1;







?>