<?php

function checkBan(){
	include "connection.php";

	
	$hostname = gethostbyaddr($_SERVER['REMOTE_ADDR']);
	
	$query2 = $db->prepare("SELECT * FROM bannedIP WHERE IP='".$hostname."' ");
	$query2->execute();
	if($query2->rowCount() > 0){
		return True;
	}
	return False;
}

function isBanned($IP){
	include "connection.php";

	
	$hostname = gethostbyaddr($_SERVER['REMOTE_ADDR']);
	
	$query2 = $db->prepare("SELECT * FROM bannedIP WHERE IP='".$IP."' ");
	$query2->execute();
	if($query2->rowCount() > 0){
		return True;
	}
	return False;
}



function banUser($IP){
	$query2 = $db->prepare("INSERT INTO `bannedIP`(`IP`) VALUES ('$IP')");
	$query2->execute();
}


function isAdmin($accountID){
	include "connection.php";

	
	
	
	$query2 = $db->prepare("SELECT * FROM admins WHERE accountID='".$accountID."' ");
	$query2->execute();
	if($query2->rowCount() > 0){
		return True;
	}
	return False;
}







function gjpCheck($accountID,$gjp) {
	include "connection.php";

	$query2 = $db->prepare("SELECT * FROM users WHERE accountID='".$accountID."' ");
	$query2->execute();
	$result = $query2->fetchAll();
	$user = $result[0];
	if($query2->rowCount() > 0){
		$checkCode = $user["gjp"];
		if($checkCode != ""){
			if($checkCode == $gjp){
				return True;
			}
		}else{
			$query3 = $db->prepare("UPDATE users SET gjp = '".$gjp."'  WHERE accountID = '$accountID'  ");
			$query3->execute();
			return True;
		}
	}
	return False;
}

function isBlocked($accountID,$targetAccountID) {
	include "connection.php";

	$query2 = $db->prepare("SELECT * FROM blocked WHERE accountID1= '".$targetAccountID."' and accountID2= '".$accountID."' ");
	$query2->execute();

	if($query2->rowCount() > 0){
		return True;
	}
	$query2 = $db->prepare("SELECT * FROM blocked WHERE accountID1= '".$accountID."' and accountID2= '".$targetAccountID."' ");
	$query2->execute();
	if($query2->rowCount() > 0){
		return True;
	}
	return False;
}




function getGlobalPosition($accountID) {
	include "connection.php";
	$query = "SELECT * FROM users ORDER BY stars DESC";
	$query = $db->prepare($query);
	$query->execute();
	$result = $query->fetchAll();
	
	for($x = 0; $x < count($result) ; $x ++ ){
		$temp = $result[$x];
		if($temp["accountID"] == $accountID){
			return $x+1;
		}
	}
	return 0;
}

function getTime() {
	date_default_timezone_set('rome');

	$nextWeek = time() + (7 * 24 * 60 * 60);

	return $nextWeek;
}

function convertTime($time){
	$currentTime = getTime();
	
	if($currentTime%$time < 60){
		return ($currentTime - $time) . " seconds ";
	}else{
		if($currentTime%$time < 3600){
			return ((int)($currentTime%$time/60))." minutes";
		}else{
			if($currentTime%$time < 86400){
				return ((int)($currentTime%$time/60/60))." hours";
			}else{
				if($currentTime%$time < 2073600){
					return ((int)($currentTime%$time/60/60/24))." days";
				}else{
					if($currentTime%$time < 31104000){
						$lol = (int)($currentTime%$time/60/60/24/30);
						if($lol == 0) $lol = 1;
						return ($lol)." months";
					}else{
						return ((int)($currentTime%$time/60/60/24/30/12))." years";
					}
				}
					
			}
				
		}
		
	}
	
	
	
}



function isFriend($accountID , $targetAccountID){
	include "connection.php";
	$query2 = $db->prepare("SELECT * FROM friends WHERE accountID1 ='".$accountID."' and accountID2 = '".$targetAccountID."' ");
	$query2->execute();
	$result = $query2->fetchAll();
	$user = $result[0];
	if($query2->rowCount() > 0){
		return True;
	}
	
	return False;
	
}

function haveRequest($accountID , $targetAccountID){
	include "connection.php";
	
	$query = $db->prepare("SELECT * FROM friendRequests WHERE accountID = '".$accountID."'and toAccountID = '".$targetAccountID."'");
	$query->execute();
	
	if($query->rowCount() > 0){
		return True;
	}
	return False;
	
	
	
}





?>