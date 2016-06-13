<?php
include "connection.php";
include "function.php";


$accountID = $_POST["accountID"];
$gjp = $_POST["gjp"];
$toAccountID = $_POST["toAccountID"];
$comment = $_POST["comment"];
$userName = "";

if($accountID != ""){
	if(gjpCheck($accountID,$gjp)){	
		$query = $db->prepare("SELECT * FROM users WHERE accountID = '".$accountID."'");
		$query->execute();
		$result = $query->fetchAll();
		$temp = $result[0];
		$userName = $temp["userName"];
		$query = $db->prepare("SELECT * FROM users WHERE accountID = '".$toAccountID."'");
		$query->execute();
		$result = $query->fetchAll();
		$temp = $result[0];
		$targetUserName = $temp["userName"];
		$uploadDate = getTime();
		$query = $db->prepare("INSERT INTO friendRequests (userName, targetUserName ,accountID, toAccountID, comment ,timestamp)
		VALUES ('$userName' , '$targetUserName','$accountID' , '$toAccountID' , '$comment' , '$uploadDate')");
		$query->execute();
		echo 1;
	}else{
		echo -1;
	}
}





?>