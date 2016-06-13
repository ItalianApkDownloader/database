<?php
include "connection.php";
include "function.php";

$accountID = $_POST["accountID"];
$gjp = $_POST["gjp"];
$isSender = $_POST["isSender"];
$messageID = $_POST["messageID"];
$messages = $_POST["messages"];

if($accountID != ""){
	if(gjpCheck($accountID,$gjp)){
		if($isSender == 1){
			if($messageID != ""){
				$query = $db->prepare("DELETE FROM `messages` WHERE messageID = '".$messageID."'");
				$query->execute();
				echo 1;
			}else{
				$messagesID = explode(",", $messages);
				foreach ($messagesID as $value){
					$query = $db->prepare("DELETE FROM `messages` WHERE messageID = '".$value."'");
					$query->execute();
				}
				echo 1;
			}
		}else{
			if($messageID != ""){
				$query = $db->prepare("DELETE FROM `messages` WHERE messageID = '".$messageID."'");
				$query->execute();
				echo 1;
			}else{
				$messagesID = explode(",", $messages);
				foreach ($messagesID as $value){
					$query = $db->prepare("DELETE FROM `messages` WHERE messageID = '".$value."'");
					$query->execute();
				}
				echo 1;
			}
		}
	}else{
		echo -1;
	}
}else{
	echo -1;
}



?>