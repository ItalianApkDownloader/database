<?php
include "connection.php";
include "function.php";


$accountID = $_POST["accountID"];
$gjp = $_POST["gjp"];
$userName = $_POST["userName"];
$comment = $_POST["comment"];
$levelID = $_POST["levelID"];
$udid = $_POST["udid"];



if($accountID != ""){
	if(gjpCheck($accountID,$gjp)){		
		$permission = True;
		$uploadDate = getTime();
		$query = $db->prepare("INSERT INTO accComments (userName, comment, accountID, timestamp)
		VALUES ('$userName', '$comment', '$accountID', '$uploadDate')");
		$query->execute();
		echo 1;
	}else{
		echo -1;
	}
}
?>
