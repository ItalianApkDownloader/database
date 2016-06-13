<?php
include "connection.php";
include "function.php";


$accountID = $_POST["accountID"];
$gjp = $_POST["gjp"];
$targetAccountID = $_POST["targetAccountID"];
$isSender = $_POST["isSender"];
$accounts = $_POST["accounts"];

if($accountID != ""){
	if(gjpCheck($accountID,$gjp)){
		if($isSender!=1){
			if($accounts!= ""){
				$accountsID = explode(",", $accounts);
				foreach ($accountsID as $value){
					$query3 = $db->prepare("DELETE FROM `friendRequests` WHERE accountID = '".$value."' and toAccountID = '".$accountID."' ");
					$query3->execute();
				}
				echo 1;
			}else{
				$query3 = $db->prepare("DELETE FROM `friendRequests` WHERE accountID = '".$targetAccountID."' and toAccountID = '".$accountID."' ");
				$query3->execute();
				echo 1;
			}
		}else{
			if($accounts!= ""){
				$accountsID = explode(",", $accounts);
				foreach ($messagesID as $value){
					$query3 = $db->prepare("DELETE FROM `friendRequests` WHERE toAccountID = '".$value."' and accountID = '".$accountID."'");
					$query3->execute();
				}
				echo 1;
			}else{
				$query3 = $db->prepare("DELETE FROM `friendRequests` WHERE toAccountID = '".$targetAccountID."' and accountID = '".$accountID."'");
				$query3->execute();
				echo 1;
			}
		}
	}
}





?>