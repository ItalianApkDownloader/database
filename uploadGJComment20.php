<?php
include "connection.php";
include "function.php";

$accountID = $_POST["accountID"];
$gjp = $_POST["gjp"];
$userName = $_POST["userName"];
$comment = $_POST["comment"];
$levelID = $_POST["levelID"];
$udid = $_POST["udid"];
$userID = 0;


$permission = False;




if($accountID != ""){
	if(gjpCheck($accountID,$gjp)){
		$query2 = $db->prepare("SELECT * FROM users WHERE accountID = '$accountID' ");
		$query2->execute();
		$result = $query2->fetchAll();
		$temp = $result[0];
		$userID = $temp["userID"];
		
		$permission = True;
		
		if(isAdmin($accountID)){
			$decodecomment = base64_decode($comment);
			
			if(substr($decodecomment,0,7) == '!delete'){
				$query = $db->prepare("DELETE from levels WHERE levelID='$levelID' LIMIT 1");
				$query->execute();
			}else{
				if(substr($decodecomment,0,4) == '!set'){
					$commentarray = explode(' ', $decodecomment);
					$cmd = $commentarray[1];
					$value = $commentarray[2];
					switch ($cmd) {
						case "like":
							$query = $db->prepare("UPDATE levels SET likes='$value' WHERE levelID='$levelID'");
							$query->execute();			
							break;
						
						case "download":
							$query = $db->prepare("UPDATE levels SET downloads='$value' WHERE levelID='$levelID'");
							$query->execute();
							break;

						case "name":
							$c = substr($decodecomment,10,15);
							$query = $db->prepare("UPDATE levels SET levelName='$c' WHERE levelID='$levelID'");
							$query->execute();
							break;
							
						case "diff":
							$auto = 0;
							$demon = 0;
							switch($value){
								case "easy":
									$starDifficulty = 10;
									break;
								case "normal":
									$starDifficulty = 20;
									break;
								case "hard":
									$starDifficulty = 30;
									break;
								case "harder":
									$starDifficulty = 40;
									break;
								case "insane":
									$starDifficulty = 50;
									break;
									
								case "demon":
									$starDifficulty = 50;
									$demon = 1;
									break;
								
								case "auto":
									$starDifficulty = 50;
									$auto = 1;
									break;
							}
							$query = $db->prepare("UPDATE levels SET starDifficulty='$starDifficulty', starDemon='$demon', starAuto='$auto' WHERE levelID='$levelID'");
							$query->execute();
							break;
						
						case "stars":
                        
                        	if($value >15){
                            	$query2 = $db->prepare("SELECT * FROM admins WHERE accountID='".$accountID."' and privilege = '1' ");
                                $query2->execute();
                                if($query2->rowCount() > 0){
                                    $query = $db->prepare("UPDATE levels SET starStars='$value' WHERE levelID='$levelID'");
                                    $query->execute();
                                }
                            }else{
                            	$query = $db->prepare("UPDATE levels SET starStars='$value' WHERE levelID='$levelID'");
                                $query->execute();
                            }
                        	
							break;
						
						case "featured":
							$query = $db->prepare("UPDATE levels SET starFeatured='1' WHERE levelID='$levelID'");
							$query->execute();
							break;
							
							
							
						//starFeatured
					}
					$permission = False;
				}
			}
			
		}
		
		
		
		
		
		
	}else{
		echo -1;
	}
}else{
	if($udid != ""){
		$query2 = $db->prepare("SELECT * FROM users WHERE udid = '$udid' and isRegistered != '0' ");
		$query2->execute();
		
		if($query2->rowCount() > 0){
			$result = $query2->fetchAll();
			$temp = $result[0];
			$userID = $temp["userID"];
			$permission = True;
		}else{
			$query2 = $db->prepare("INSERT INTO users (udid)VALUES ('$udid')");
			$query2->execute();
			$userID= $db->lastInsertId();
			$permission = True;
		}
	}else{
		echo -1;
	}
}



if($permission == True){
	$uploadDate = getTime();
	$query = $db->prepare("INSERT INTO comments (userName, comment, levelID, userID, timestamp)
	VALUES ('$userName', '$comment', '$levelID', '$userID', '$uploadDate')");
	$query->execute();
	echo 1;
}else{
	echo -1;
}



?>