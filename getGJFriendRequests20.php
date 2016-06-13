<?php
include "connection.php";
include "function.php";




$accountID = $_POST["accountID"];
$gjp = $_POST["gjp"];
$page = $_POST["page"];
$total = $_POST["total"];
$getSent = $_POST["getSent"];


if($accountID != ""){
	if(gjpCheck($accountID,$gjp)){	
		if($getSent!=1){
			$query = $db->prepare("SELECT * FROM friendRequests WHERE toAccountID = '".$accountID."' ORDER BY requestID DESC");
			$query->execute();
			$result = $query->fetchAll();
			
			for($k = 0; $k < 10 ; $k++){
				$x = $page*10+$k;
				$request1 = $result[$x];
				if($k >= count($result)){
					break;
				}
				if($k != 0){
					echo "|";
				}
				
				$query3 = $db->prepare("SELECT * FROM users WHERE accountID = '".$request1["accountID"]."'");
				$query3->execute();
				$result3 = $query3->fetchAll();
				$temp = $result3[0];
				echo "1:".$temp["userName"].":2:".$temp["userID"].":9:".$temp["icon"].":10:".$temp["color1"].":11:".$temp["color2"].":14:".$temp["iconType"].":15:".$temp["special"].":16:".$temp["accountID"].":35:".$request1["comment"].":32:".$request1["requestID"].":41:".$request1["isNew"].":37:".convertTime($request1["timestamp"]);
			}
			if(count($result) == 0){
				echo -2;
			}else{
				echo "#:0:20";
			}
		}else{
			$query = $db->prepare("SELECT * FROM friendRequests WHERE accountID = '".$accountID."' ORDER BY requestID DESC");
			$query->execute();
			$result = $query->fetchAll();
			
			for($k = 0; $k < 20 ; $k++){
				$x = $page*10+$k;
				$request1 = $result[$x];
				if($k >= count($result)){
					break;
				}
				if($k != 0){
					echo "|";
				}
				
				$query3 = $db->prepare("SELECT * FROM users WHERE accountID = '".$request1["toAccountID"]."'");
				$query3->execute();
				$result3 = $query3->fetchAll();
				$temp = $result3[0];
				echo "1:".$temp["userName"].":2:".$temp["userID"].":9:".$temp["icon"].":10:".$temp["color1"].":11:".$temp["color2"].":14:".$temp["iconType"].":15:".$temp["special"].":16:".$temp["accountID"].":32:".$request1["requestID"].":41:1:37:4 months";
			}
			if(count($result) == 0){
				echo -2;
			}else{
				echo "#:0:20";
			}
			echo -2;
		}
	}else{
		echo -1;
	}
}
?>