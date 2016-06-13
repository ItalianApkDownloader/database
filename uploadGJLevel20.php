<?php
include "connection.php";
include "function.php";



	



	$udid = $_POST["udid"];
	$accountID = $_POST["accountID"];
	$gjp = $_POST["gjp"]; 
	
	
	if(checkBan()){
		exit;
	}
	
	
	
	$userName = $_POST["userName"]; 
	$levelID = $_POST["levelID"]; 
	$levelName = $_POST["levelName"]; 
	$levelDesc = $_POST["levelDesc"]; 
	$levelVersion = $_POST["levelVersion"]; 
	$levelLength = $_POST["levelLength"]; 
	$audioTrack = $_POST["audioTrack"]; 
	$auto = $_POST["auto"]; 
	$password = $_POST["password"]; 
	$original = $_POST["original"]; 
	$twoPlayer = $_POST["twoPlayer"]; 
	$songID = $_POST["songID"]; 
	$objects = $_POST["objects"]; 
	$coins = $_POST["coins"]; 
	$requestedStars = $_POST["requestedStars"]; 
	$extraString = $_POST["extraString"]; 
	$levelString = $_POST["levelString"]; 
	$levelInfo = $_POST["levelInfo"]; 

	
	
	
	
	
	
	
	if($accountID != ""){
		
		if(gjpCheck($accountID,$gjp)){
			
			
			
			$query2 = $db->prepare("SELECT * FROM users WHERE accountID = '$accountID' ");
			$query2->execute();
			$result = $query2->fetchAll();
			$user = $result[0];
			$userID = $user["userID"];
			if($levelID != 0){
				$query2 = $db->prepare("SELECT * FROM levels WHERE accountID = '$accountID' and levelID = '$levelID' ");
				$query2->execute();
				if($query2->rowCount() > 0){
					$query2 = $db->prepare("UPDATE levels SET extraString = '$extraString' , levelString = '$levelString' , levelInfo = '$levelInfo' , levelVersion = '$levelVersion' , levelLength = '$levelLength' , audioTrack = '$audioTrack' , auto = '$auto' , password = '$password' , original = '$original' , twoPlayer = '$twoPlayer' , songID = '$songID' , objects = '$objects' , coins = '$coins' , requestedStars = '$requestedStars' , userID = '$userID' WHERE levelID = '$levelID' ");
					$query2->execute();
					echo $levelID;
				}else{
					$query2 = $db->prepare("INSERT INTO levels (accountID , userName, levelName, levelDesc , levelVersion , levelLength , audioTrack , auto , password , original , twoPlayer , songID , objects , coins , requestedStars , extraString , levelString , levelInfo , uploadTime,userID)
					VALUES ('$accountID' , '$userName' , '$levelName' , '$levelDesc' , '$levelVersion' , '$levelLength' , '$audioTrack' , '$auto' , '$password' , '$original' , '$twoPlayer' , '$songID' , '$objects' , '$coins' , '$requestedStars' , '$extraString' , '$levelString' , '$levelInfo' , '".getTime()."' , '$userID')");
					$query2->execute();
					echo $db->lastInsertId(); 
				}
			}else{
				$query2 = $db->prepare("SELECT * FROM levels WHERE levelName = '$levelName' and levelString = '$levelString' and accountID = '$accountID'  ");
				$query2->execute();
				if($query2->rowCount() > 0){
					$result = $query2->fetchAll();
					$temp = $result[0];
					echo $temp["levelID"];
				}else{
					$query2 = $db->prepare("INSERT INTO levels (accountID , userName, levelName, levelDesc , levelVersion , levelLength , audioTrack , auto , password , original , twoPlayer , songID , objects , coins , requestedStars , extraString , levelString , levelInfo , uploadTime,userID)
					VALUES ('$accountID' , '$userName' , '$levelName' , '$levelDesc' , '$levelVersion' , '$levelLength' , '$audioTrack' , '$auto' , '$password' , '$original' , '$twoPlayer' , '$songID' , '$objects' , '$coins' , '$requestedStars' , '$extraString' , '$levelString' , '$levelInfo' , '".getTime()."' , '$userID' )");
					$query2->execute();
					echo $db->lastInsertId();
				}
			}
		}else{
			echo -1;
		}
	}else{
		if($udid != ""){
			
			
			
			
			$query2 = $db->prepare("SELECT * FROM users WHERE udid = '$udid' and isRegistered != '1' ");
			$query2->execute();
			
			if($query2->rowCount() > 0){
				$result = $query2->fetchAll();
				$temp = $result[0];
				$userID = $temp["userID"];
				if($levelID != 0){
					$query2 = $db->prepare("SELECT * FROM levels WHERE accountID = '$udid' and levelID = '$levelID' ");
					$query2->execute();
					if($query2->rowCount() > 0){
						$query2 = $db->prepare("UPDATE levels SET extraString = '$extraString' , levelString = '$levelString' , levelInfo = '$levelInfo' , levelVersion = '$levelVersion' , levelLength = '$levelLength' , audioTrack = '$audioTrack' , auto = '$auto' , password = '$password' , original = '$original' , twoPlayer = '$twoPlayer' , songID = '$songID' , objects = '$objects' , coins = '$coins' , requestedStars = '$requestedStars' , userID = '$userID' WHERE levelID = '$levelID' ");
						$query2->execute();
						echo $levelID;
					}else{
						$query2 = $db->prepare("INSERT INTO levels (udid , userName, levelName, levelDesc , levelVersion , levelLength , audioTrack , auto , password , original , twoPlayer , songID , objects , coins , requestedStars , extraString , levelString , levelInfo , uploadTime,userID)
						VALUES ('$udid' , '$userName' , '$levelName' , '$levelDesc' , '$levelVersion' , '$levelLength' , '$audioTrack' , '$auto' , '$password' , '$original' , '$twoPlayer' , '$songID' , '$objects' , '$coins' , '$requestedStars' , '$extraString' , '$levelString' , '$levelInfo' , '".getTime()."' , '$userID')");
						$query2->execute();
						$levelID = $db->lastInsertId();
						echo $db->lastInsertId(); 
					}
				}else{
					$query2 = $db->prepare("SELECT * FROM levels WHERE levelName = '$levelName' and levelString = '$levelString' and udid = '$udid'  ");
					$query2->execute();
					if($query2->rowCount() > 0){
						$result = $query2->fetchAll();
						$temp = $result[0];
						$levelID = $temp["levelID"];
						echo $temp["levelID"];
					}else{
						$query2 = $db->prepare("INSERT INTO levels (udid , userName, levelName, levelDesc , levelVersion , levelLength , audioTrack , auto , password , original , twoPlayer , songID , objects , coins , requestedStars , extraString , levelString , levelInfo , uploadTime ,  userID)
						VALUES ('$udid' , '$userName' , '$levelName' , '$levelDesc' , '$levelVersion' , '$levelLength' , '$audioTrack' , '$auto' , '$password' , '$original' , '$twoPlayer' , '$songID' , '$objects' , '$coins' , '$requestedStars' , '$extraString' , '$levelString' , '$levelInfo' , '".getTime()."' , $userID)");
						$query2->execute();
						$levelID = $db->lastInsertId();
						echo $db->lastInsertId();
					}
				}
			}else{
				
				
				$query2 = $db->prepare("INSERT INTO users (udid)VALUES ('$udid')");
				$query2->execute();
				$userID= $db->lastInsertId();
				if($levelID != 0){
					$query2 = $db->prepare("SELECT * FROM levels WHERE accountID = '$accountID' and levelID = '$levelID' ");
					$query2->execute();
					if($query2->rowCount() > 0){
						$query2 = $db->prepare("UPDATE levels SET extraString = '$extraString' , levelString = '$levelString' , levelInfo = '$levelInfo' , levelVersion = '$levelVersion' , levelLength = '$levelLength' , audioTrack = '$audioTrack' , auto = '$auto' , password = '$password' , original = '$original' , twoPlayer = '$twoPlayer' , songID = '$songID' , objects = '$objects' , coins = '$coins' , requestedStars = '$requestedStars' , userID = '$userID' WHERE levelID = '$levelID' ");
						$query2->execute();
						echo $levelID;
					}else{
						$query2 = $db->prepare("INSERT INTO levels (udid , userName, levelName, levelDesc , levelVersion , levelLength , audioTrack , auto , password , original , twoPlayer , songID , objects , coins , requestedStars , extraString , levelString , levelInfo , uploadTime,userID)
						VALUES ('$udid' , '$userName' , '$levelName' , '$levelDesc' , '$levelVersion' , '$levelLength' , '$audioTrack' , '$auto' , '$password' , '$original' , '$twoPlayer' , '$songID' , '$objects' , '$coins' , '$requestedStars' , '$extraString' , '$levelString' , '$levelInfo' , '".getTime()."' , '$userID')");
						$query2->execute();
						$levelID = $db->lastInsertId();
						echo $db->lastInsertId(); 
					}
				}else{
					$query2 = $db->prepare("SELECT * FROM levels WHERE levelName = '$levelName' and levelString = '$levelString' and udid = '$udid'  ");
					$query2->execute();
					if($query2->rowCount() > 0){
						$result = $query2->fetchAll();
						$temp = $result[0];
						$levelID = $temp["levelID"];
						
						echo $temp["levelID"];
					}else{
						$query2 = $db->prepare("INSERT INTO levels (udid , userName, levelName, levelDesc , levelVersion , levelLength , audioTrack , auto , password , original , twoPlayer , songID , objects , coins , requestedStars , extraString , levelString , levelInfo , uploadTime ,  userID)
						VALUES ('$udid' , '$userName' , '$levelName' , '$levelDesc' , '$levelVersion' , '$levelLength' , '$audioTrack' , '$auto' , '$password' , '$original' , '$twoPlayer' , '$songID' , '$objects' , '$coins' , '$requestedStars' , '$extraString' , '$levelString' , '$levelInfo' , '".getTime()."' , $userID)");
						$query2->execute();
						$levelID = $db->lastInsertId();
						echo $db->lastInsertId();
					}
				}
			}
			
			if($songID != "" or $songID !=0 ){
				
				$url = 'http://www.boomlings.com/database/getGJSongInfo.php';
				$data = array('songID' => $songID, 'secret' => 'Wmfd2893gb7');
				$options = array(
					'http' => array(
						'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
						'method'  => 'POST',
						'content' => http_build_query($data),
					),
				);
				$context  = stream_context_create($options);
				$result = file_get_contents($url, false, $context);
				
				$query2 = $db->prepare("INSERT INTO songs (levelID , songString)
				VALUES ('$levelID' , '$result' )");
				$query2->execute();
				
			}
		}else{
			echo -1;
		}
	}
?>