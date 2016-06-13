<?php
include "connection.php";
include "function.php";




/*
type=friends
type=relative
type=creators
*/

	$accountID = $_POST["accountID"];
	
	$gjp = $_POST["gjp"];
	$type = $_POST["type"];
	$count = $_POST["count"];
	$udid = $_POST["udid"];
	
	$permission = False;
	$query = "";
	
	
	if($accountID != ""){
		if(gjpCheck($accountID,$gjp)){			
			$permission = True;
		}
	}else{
		$permission = True;
	}

	
	
	
	if($permission){
		switch($type){
			case "top":
				$query = "SELECT * FROM users ORDER BY stars DESC";
				break;
			
			case "creators":
				$query = "SELECT * FROM users ORDER BY creatorPoints DESC";
				break;
			
			
		}
		
		
		
		
		if($type == "top" or $type == "creators"){
			$query = $db->prepare($query);
			$query->execute();
			$result = $query->fetchAll();
				
			$myAccount = 0;	
			
			for($k = 0; $k<= 99 ; $k++){
				
				$temp = $result[$k];
				
				
				
				if($k >= count($result)) break;
				
				
				if(isBanned($temp["IP"])) continue;
				
				
				
				$position = $k +1;
				
				if($temp["accountID"] == $accountID ){
					$myAccount++;
				}
				
				if($temp["isRegistered"] == '0' and $temp["udid"] == $udid and $accountID==""){
					$myAccount++;
				}
				
				
				if($myAccount == 1){
					echo "1:".$temp["userName"].":2:".$temp["userID"].":13:".$temp["coins"].":17:".$temp["userCoins"].":6:".$position.":9:".$temp["icon"].":10:".$temp["color1"].":11:".$temp["color2"].":14:".$temp["iconType"].":15:".$temp["special"].":16:".$temp["accountID"].":3:".$temp["stars"].":8:".$temp["creatorPoints"].":4:".$temp["demons"]."".":7:".$temp["udid"];
					$myAccount++;
				}else{
					echo "1:".$temp["userName"].":2:".$temp["userID"].":13:".$temp["coins"].":17:".$temp["userCoins"].":6:".$position.":9:".$temp["icon"].":10:".$temp["color1"].":11:".$temp["color2"].":14:".$temp["iconType"].":15:".$temp["special"].":16:".$temp["accountID"].":3:".$temp["stars"].":8:".$temp["creatorPoints"].":4:".$temp["demons"];
				}
				
				if($k != 99) echo "|";
				
			}
		}
		if($accountID != ""){
			if($type == "friends"){
				$query2 = $db->prepare("SELECT * FROM `friends` WHERE `accountID1` = '".$accountID."'");
				$query2->execute();
				$friends = $query2->fetchAll();				
				
				$friendArray = array();
				
				$friendArray[0] = $accountID;
				
				$k = 1;

				foreach ($friends as $key) {
					$temp = $frieds[$k-1];
					$friendArray[$k] = $key["accountID2"];
					$k++;
				}

				
				
				for($k = 0 ; $k < count($friends) + 1 ; $k ++){
					$query = $db->prepare("SELECT * FROM users WHERE accountID = '".$friendArray[$k]."'");
					$query->execute();
					$result = $query->fetchAll();
					$temp = $result[0];
					
					
					$friend = $friends[$k];
					
					if($k != 0) echo "|";
					
					
					
					echo "1:".$temp["userName"].":2:".$temp["userID"].":13:".$temp["coins"].":17:".$temp["userCoins"].":6:".$position.":9:".$temp["icon"].":10:".$temp["color1"].":11:".$temp["color2"].":14:".$temp["iconType"].":15:".$temp["special"].":16:".$temp["accountID"].":3:".$temp["stars"].":8:".$temp["creatorPoints"].":4:".$temp["demons"].":7:".$temp["udid"];
				}
				
			}
		}
		if($type == "relative"){
			
			
			$ID = array(71,173,174,428,2449);
			$query1 = $db->prepare("SELECT * FROM admins WHERE 1");
			$query1->execute();
			$result1 = $query1->fetchAll();
			
            
			echo "1:---Admin List---:2:".$temp["userID"].":13:".$temp["coins"].":17:".$temp["userCoins"].":6:".$position.":9:".$temp["icon"].":10:".$temp["color1"].":11:".$temp["color2"].":14:".$temp["iconType"].":15:".$temp["special"].":16:".$temp["accountID"].":3:".$temp["stars"].":8:".$temp["creatorPoints"].":4:".$temp["demons"].":7:".$temp["udid"];
			
			
            for($k = 0; $k < count($result1); $k++){
            	$temp1 = $result1[$k];
                
                $query = $db->prepare("SELECT * FROM users WHERE accountID = '".$temp1["accountID"]."'");
				$query->execute();
				$result = $query->fetchAll();
				$temp = $result[0];
				echo "|";
				echo "1:".$temp["userName"].":2:".$temp["userID"].":13:".$temp["coins"].":17:".$temp["userCoins"].":6:".$position.":9:".$temp["icon"].":10:".$temp["color1"].":11:".$temp["color2"].":14:".$temp["iconType"].":15:".$temp["special"].":16:".$temp["accountID"].":3:".$temp["stars"].":8:".$temp["creatorPoints"].":4:".$temp["demons"].":7:".$temp["udid"];
                
            }
            
			/*
			foreach ($ID as $value){
            
				$query = $db->prepare("SELECT * FROM users WHERE accountID = '".$value."'");
				$query->execute();
				$result = $query->fetchAll();
				$temp = $result[0];
				echo "|";
				echo "1:".$temp["userName"].":2:".$temp["userID"].":13:".$temp["coins"].":17:".$temp["userCoins"].":6:".$position.":9:".$temp["icon"].":10:".$temp["color1"].":11:".$temp["color2"].":14:".$temp["iconType"].":15:".$temp["special"].":16:".$temp["accountID"].":3:".$temp["stars"].":8:".$temp["creatorPoints"].":4:".$temp["demons"].":7:".$temp["udid"];
			}
                        
			*/
		}
		
		
		
		
	}
	
	
?>			