<?php
error_reporting(0);
include "connection.php";
include "function.php";

$accountID = $_POST["accountID"];
$gjp = $_POST["gjp"];
$type = $_POST["type"];

if($accountID != ""){
	if(gjpCheck($accountID,$gjp)){
		if($type == 0){
			$query = $db->prepare("SELECT * FROM friends WHERE accountID1 = '".$accountID."' ");
			$query->execute();
			$result = $query->fetchAll();
			if(count($result)== 0) echo -2;
			for($k = 0; $k < count($result) ; $k ++){
				$friend = $result[$k];
				$query = $db->prepare("SELECT * FROM users WHERE accountID = '".$friend["accountID2"]."' ");
				$query->execute();
				$users = $query->fetchAll();
				$temp = $users[0];
				if($k != 0){
					echo "|";
				}
				echo "1:".$temp["userName"].":2:".$temp["userID"].":9:".$temp["icon"].":10:".$temp["color1"].":11:".$temp["color2"].":14:".$temp["iconType"].":15:".$temp["special"].":16:".$temp["accountID"].":18:0:41:".$friend["isNew"];		
			}
			$query = $db->prepare("UPDATE `friends` SET `isNew` = 0 WHERE accountID1 = '".$accountID."' ");
			$query->execute();
		}else{
			$query = $db->prepare("SELECT * FROM blocked WHERE accountID1 = '".$accountID."' ");
			$query->execute();
			$result = $query->fetchAll();
			if(count($result)== 0) echo -2;
			for($k = 0; $k < count($result) ; $k ++){
				$friend = $result[$k];
				$query = $db->prepare("SELECT * FROM users WHERE accountID = '".$friend["accountID2"]."' ");
				$query->execute();
				$users = $query->fetchAll();
				$temp = $users[0];
				if($k != 0){
					echo "|";
				}
				echo "1:".$temp["userName"].":2:".$temp["userID"].":9:".$temp["icon"].":10:".$temp["color1"].":11:".$temp["color2"].":14:".$temp["iconType"].":15:".$temp["special"].":16:".$temp["accountID"].":18:0:41:";		
			}		
		}		
	}else{
		echo -1;
	}
}else{
	echo -1;
}
?>