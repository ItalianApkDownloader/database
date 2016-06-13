<?php
include "connection.php";
include "function.php";

	
	$hostname = gethostbyaddr($_SERVER['REMOTE_ADDR']);

	//getting all game data
	$accountID = htmlspecialchars($_POST["accountID"],ENT_QUOTES);
    $gjp = htmlspecialchars($_POST["gjp"],ENT_QUOTES);
    $userName = htmlspecialchars($_POST["userName"],ENT_QUOTES);
    $stars = htmlspecialchars($_POST["stars"],ENT_QUOTES);

        if($stars>10000 and $accountID == ""){
            $stars = 0;
        }


	$query = $db->prepare("SELECT * FROM `serverSetting` WHERE `setting` = 'maxStars' ");
	$query->execute();
    $result = $query->fetchAll();
    $temp = $result[0];
    $limit = $temp["value"];
    
    if(isAdmin($accountID)){
    	if($stars > 10000)
    		$stars = 10000;
    }
    
	
	if($stars>=$limit){
		
		if(!isBanned($hostname)){
			if(accountID != ""){
              if(!isAdmin($accountID)){
				$query = $db->prepare("UPDATE `users` SET 'stars' = '0' WHERE  accountID = '".$accountID."'");
				$query->execute();
                $query5 = $db->prepare("INSERT INTO `bannedIP`(  `IP` , `accountID`,'reason' ) VALUES ('".$hostname."' ,'".$accountID."' , 'stars = ".$stars."' )");
                $query5->execute();
                $stars = 0;
              }else{
              		$stars = $limit-3627;
              }
				
			}else{
              $query5 = $db->prepare("INSERT INTO `bannedIP`(  `IP` ) VALUES ('".$hostname."'  )");
              $query5->execute();
              $stars = 0;
            }
		}
		
		
	}
	
	
    $demons = htmlspecialchars($_POST["demons"],ENT_QUOTES);
    $icon = htmlspecialchars($_POST["icon"],ENT_QUOTES);
    $color1 = htmlspecialchars($_POST["color1"],ENT_QUOTES);
    $color2 = htmlspecialchars($_POST["color2"],ENT_QUOTES);
    $iconType = htmlspecialchars($_POST["iconType"],ENT_QUOTES);
    $coins = htmlspecialchars($_POST["coins"],ENT_QUOTES);
    $userCoins = htmlspecialchars($_POST["userCoins"],ENT_QUOTES);
    $special = htmlspecialchars($_POST["special"],ENT_QUOTES);
    $accIcon = htmlspecialchars($_POST["accIcon"],ENT_QUOTES);
    $accShip = htmlspecialchars($_POST["accShip"],ENT_QUOTES);
    $accBall = htmlspecialchars($_POST["accBall"],ENT_QUOTES);
    $accBird = htmlspecialchars($_POST["accBird"],ENT_QUOTES);
    $accDart = htmlspecialchars($_POST["accDart"],ENT_QUOTES);
    $accRobot = htmlspecialchars($_POST["accRobot"],ENT_QUOTES);
    $accGlow = htmlspecialchars($_POST["accGlow"],ENT_QUOTES);
	
	
	
	if(checkBan()){
		exit;
	}
	
	
	//check if is an account or a normal user
	if($accountID != ""){
		if(gjpCheck($accountID,$gjp)){
			$query3 = $db->prepare("UPDATE users SET stars = '$stars' , demons = '$demons' , icon = '$icon' , color1 = '$color1' , color2 = '$color2' , iconType = '$iconType' ,  coins  = '$coins' , userCoins = '$userCoins' , special = '$special'  , accIcon = '$accIcon' , accShip = '$accShip' , accBall = '$accBall' ,  accBird = '$accBird' , accDart = '$accDart' , accRobot = '$accRobot' , accGlow = '$accGlow' , IP = '".$hostname."'    WHERE accountID = '$accountID'  ");
			$query3->execute();
			$query2 = $db->prepare("SELECT * FROM users WHERE accountID = '$accountID'   ");
			$query2->execute();
			$result = $query2->fetchAll();
			$temp = $result[0];
			echo $temp["userID"];
		}else{
			echo -1;
		}
	}else{
		//checking if the user is in the users table
		$udid = $_POST["udid"];
		if($udid != ""){
			$query2 = $db->prepare("SELECT * FROM users WHERE udid = '$udid' and isRegistered = '0' ");
			$query2->execute();
			if($query2->rowCount() > 0){
				$query4 = $db->prepare("UPDATE users SET userName = '".$userName."' ,stars = '$stars' , demons = '$demons' , icon = '$icon' , color1 = '$color1' , color2 = '$color2' , iconType = '$iconType' ,  coins  = '$coins' , userCoins = '$userCoins' , special = '$special' , IP = '".$hostname."'  WHERE udid = '$udid' and isRegistered = '0' ");
				$query4->execute();
				$result = $query2->fetchAll();
				$temp = $result[0];
				echo $temp["userID"];
			}else{
				$query5 = $db->prepare("INSERT INTO `users`( `isRegistered` , `userName`, `udid` , `stars`, `demons`, `icon`, `color1`, `color2`, `iconType`, `coins`, `userCoins`, `special`, `IP` ) VALUES ('0','$userName', '$udid' , '$stars' , '$demon' , '$icon' , '$color1' , $color2 , '$iconType' , '$coins' , '$userCoins'  , '$special' , '".$hostname."'  )");
				$query5->execute();
				echo $db->lastInsertId();
			}
		}else{
			echo -1	;
		}
		
	}

?>		