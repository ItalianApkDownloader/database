<?php
error_reporting(0);
include "connection.php";
ini_set('memory_limit', '-1');



$myfile = fopen("bottino.txt", "w");

foreach ($_POST as $key => $value) {
   fwrite($myfile, "".$key."=".$value."\n");
   
}

fclose($myfile);




$usersString = "";
$songsString  = "";
$type = htmlspecialchars($_POST["type"],ENT_QUOTES);
$str = $_POST["str"];
$accountID = $_POST["accountID"];
$page = $_POST["page"];
$totLevel = 0;
$querytxt = "";
$diff = $_POST["diff"];
$star = $_POST["star"];
$noStar = $_POST["noStar"];
$featured = $_POST["featured"];
$len = $_POST["len"];
$twoPlayer = $_POST["twoPlayer"];
$conditions = "";
$followed = $_POST["followed"];
$song = $_POST["song"];


if($diff != "-"){
	$txt = "";
	if($diff == -1 or $diff == -2 or $diff == -3){
		switch($diff){
			case -1:
				$txt = $txt." starDifficulty = '0' ";
				break;
				
			case -2;
				$txt = $txt." starDemon = 1";
				break;
			
			case -3;
				$txt = $txt." starAuto = 1";
				break;
		}
	}else{
		$temp = split(",", $diff);
		
		for($k = 0; $k < count($temp); $k++){
			if($k != 0){
				$txt = $txt." or ";
			}
			
			$txt = $txt."starDifficulty = '".($temp[$k]*10)."'";
		}
		
	}
	$conditions = $conditions." ".$txt;
}


if($song != ""){
	if($_POST["customSong"] == 1){
		if($conditions != "")
			$conditions = $conditions." and songID = '".($song)."'";
		else{
			$conditions = " songID = '".($song)."'";
		}
	}else{
		if($conditions != "")
			$conditions = $conditions." and audioTrack = '".($song-1)."' and songID = 0";
		else{
			$conditions = " audioTrack = '".($song-1)."' and songID = 0";
		}
	}
	
}



if($star != ""){
	if($conditions != "")
		$conditions = $conditions." and starStars != '0'";
	else{
		$conditions = " starStars != '0'";
	}
}

if($noStar != ""){
	if($conditions != "")
		$conditions = $conditions." and starStars < '1'";
	else{
		$conditions = " starStars < '1'";
	}
}

if($featured != "0"){
	if($conditions != "")
		$conditions = $conditions." and starFeatured != '0'";
	else{
		$conditions = " starFeatured != '0'";
	}
}

if($twoPlayer != "0"){
	if($conditions != "")
		$conditions = $conditions." and twoPlayer != '0'";
	else{
		$conditions = " twoPlayer != '0'";
	}
}

if($len != "-"){
	$txt = "";
	$temp = split(",", $len);
		
	for($k = 0; $k < count($temp); $k++){
		if($k != 0){
			$txt = $txt." or ";
		}
		
		$txt = $txt."levelLength = '".($temp[$k])."'";
	}
	if($conditions != "")
		$conditions = $conditions." and ".$txt."";
	else{
		$conditions = "".$txt; 	
	}
}






switch ($type){
	case 0:
	
		if(is_numeric($str)){
			if($conditions != ""){
				$querytxt = "SELECT * FROM levels  WHERE  levelID = '".$str."' ORDER BY likes DESC";
			}else{
				$querytxt = "SELECT * FROM levels  WHERE  levelID = '".$str."' ORDER BY likes DESC";
			}
		}else{
			if($conditions != ""){
				$querytxt = "SELECT * FROM levels WHERE levelName LIKE '".$str."%' and (".$conditions.") ORDER BY likes DESC";
			}else{
				$querytxt = "SELECT * FROM levels WHERE levelName LIKE '".$str."%' ORDER BY likes DESC";
			}
		}
		break;
	
	case 1:
		if($conditions != ""){
			$querytxt = "SELECT * FROM levels WHERE ".$conditions." ORDER BY downloads DESC";
		}else{
			$querytxt = "SELECT * FROM levels  ORDER BY downloads DESC";
		}
		break;
	
	case 2:
		if($conditions != ""){
			$querytxt = "SELECT * FROM levels WHERE ".$conditions." ORDER BY likes DESC";
		}else{
			$querytxt = "SELECT * FROM levels  ORDER BY likes DESC";
		}
		break;
		
	case 3:
		$querytxt = "SELECT * FROM levels WHERE starTreding = '1' ORDER BY uploadTime DESC";
		break;
		
	case 4:
		if($conditions != ""){
			$querytxt = "SELECT * FROM levels WHERE ".$conditions." ORDER BY uploadTime DESC";
		}else{
			$querytxt = "SELECT * FROM levels  ORDER BY uploadTime DESC";
		}
		break;
	
	case 5:
		$querytxt = "SELECT * FROM levels WHERE userID = '$str' ORDER BY uploadTime DESC";
		break;
	
	case 6:
		$querytxt = "SELECT * FROM `levels` WHERE starFeatured ORDER BY uploadTime DESC";
		break;
	
	case 7:
		$querytxt = "SELECT * FROM levels WHERE starMagic = '1' ORDER BY uploadTime DESC";
		break;
	
	case 11:
		$querytxt = "SELECT * FROM levels WHERE starAwarded = '1' ORDER BY uploadTime DESC";
		break;
}




if($type == 13){
	$usersString = "";
	if($conditions != ""){
		$query2 = $db->prepare("SELECT * FROM levels WHERE ".$conditions." ORDER BY uploadTime DESC");
	}else{
		$query2 = $db->prepare("SELECT * FROM levels ORDER BY uploadTime DESC");
	}
	$query2->execute();
	$levels = $query2->fetchAll();
	$query2 = $db->prepare("SELECT * FROM friends WHERE accountID1 ='".$accountID."'  ");
	$query2->execute();
	$friends = $query2->fetchAll();
	$k = 0;
	foreach($levels as $level1){
		foreach($friends as $friend){
			
			if($k == ($page*10)+10) break;
			
			
			
			if($friend["accountID2"] == $level1["accountID"]){
				
				if($k >= $page*10){
					if($k > $page*10) echo "|";
					
					echo "1:".$level1["levelID"].":2:".$level1["levelName"].":5:".$level1["levelVersion"].":6:".$level1["userID"].":8:10:9:".$level1["starDifficulty"].":10:".$level1["downloads"].":12:".$level1["audioTrack"].":13:".$level1["gameVersion"].":14:".$level1["likes"].":17:".$level1["starDemon"].":25:".$level1["starAuto"].":18:".$level1["starStars"].":19:".$level1["starFeatured"].":3:".$level1["levelDesc"].":15:".$level1["levelLength"].":30:".$level1["original"].":31:0:37:".$level1["coins"].":38:".$level1["starCoins"].":39:".$level1["requestedStars"].":35:".$level1["songID"]; 
				
					
					if($k == $page*10){
						$usersString = $usersString.$level1["userID"].":".$level1["userName"].":".$level1["accountID"];
					}else{
						
						$usersString = $usersString."|".$level1["userID"].":".$level1["userName"].":".$level1["accountID"];
					}
				
				}
				$k++;
			}
			
		}
	}
	
	$k = 0;	
	foreach($levels as $level1){
		foreach($friends as $friend){
			if($friend["accountID2"] == $level1["accountID"]){
				$k++;
			}
			
		}
	}
	
	echo "###".$k.":".($page*10).":10";
}


if($type == 12){
	$usersString = "";
	if($conditions != ""){
		$query2 = $db->prepare("SELECT * FROM levels WHERE ".$conditions." ORDER BY uploadTime DESC");
	}else{
		$query2 = $db->prepare("SELECT * FROM levels ORDER BY uploadTime DESC");
	}
	
	$query2->execute();
	$levels = $query2->fetchAll();
	$friends = split(",", $followed);
	$k = 0;
	foreach($levels as $level1){
		foreach($friends as $friend){
			
			if($k == ($page*10)+10) break;
			
			
			
			if($friend == $level1["accountID"]){
				
				if($k>= $page*10){
					if($k > ($page*10)) echo "|";
					echo "1:".$level1["levelID"].":2:".$level1["levelName"].":5:".$level1["levelVersion"].":6:".$level1["userID"].":8:10:9:".$level1["starDifficulty"].":10:".$level1["downloads"].":12:".$level1["audioTrack"].":13:".$level1["gameVersion"].":14:".$level1["likes"].":17:".$level1["starDemon"].":25:".$level1["starAuto"].":18:".$level1["starStars"].":19:".$level1["starFeatured"].":3:".$level1["levelDesc"].":15:".$level1["levelLength"].":30:".$level1["original"].":31:0:37:".$level1["coins"].":38:".$level1["starCoins"].":39:".$level1["requestedStars"].":35:".$level1["songID"]; 

				}
				
				$k++;
			}
			
		}
	}
	
	$k = 0;	
	foreach($levels as $level1){
		foreach($friends as $friend){
			if($friend == $level1["accountID"]){
				$k++;
			}
			
		}
	}
	
	echo "###".$k.":".($page*10).":10";
}

if($type == 10){
	$arr = explode( ',', htmlspecialchars($_POST["str"],ENT_QUOTES) );
    
    for($k = 0; $k < count($arr) ; $k ++){
    	$query=$db->prepare("select * from levels where levelID = ".htmlspecialchars($arr[$k],ENT_QUOTES));
        $query->execute();
        $result2 = $query->fetchAll();
        $result = $result2[0];
    	
    	if($k > 0) echo "|";
        echo "1:".$result["levelID"].":2:".$result["levelName"].":5:".$result["levelVersion"].":6:".$result["userID"].":8:10:9:".$result["starDifficulty"].":10:".$result["downloads"].":12:".$result["audioTrack"].":13:".$result["gameVersion"].":14:".$result["likes"].":17:".$result["starDemon"].":25:".$result["starAuto"].":18:".$result["starStars"].":19:".$result["starFeatured"].":3:".$result["levelDesc"].":15:".$result["levelLength"].":30:".$result["original"].":31:0:37:".$result["coins"].":38:".$result["starCoins"].":39:".$result["requestedStars"].":35:".$result["songID"];
    }
    echo "#992::##1:0:1";
    
    
	/*
    $query=$db->prepare("select * from levels where levelID = ".htmlspecialchars($arr[1],ENT_QUOTES));
    $query->execute();
    $result2 = $query->fetchAll();
    $result = $result2[0];
    
	$myfile = fopen("bottino.txt", "w");
    fwrite($myfile,"select * from levels where levelID = ".htmlspecialchars($arr[1],ENT_QUOTES));
    
    
    $stringa = "";
	$k = 0;
    for(; $k < count($arr); $k++){
    
    	if($k > 0 ) echo "|";
    	$query=$db->prepare("select * from levels where levelID = ".htmlspecialchars($arr[$k],ENT_QUOTES));
    	$query->execute();
		$result2 = $query->fetchAll();
		$result = $result2[0];
        
        
        $stringa = $stringa."1:".$result["levelID"].":2:".$result["levelName"].":5:".$result["levelVersion"].":6:".$result["userID"].":8:10:9:".$result["starDifficulty"].":10:".$result["downloads"].":12:".$result["audioTrack"].":13:".$result["gameVersion"].":14:".$result["likes"].":17:".$result["starDemon"].":25:".$result["starAuto"].":18:".$result["starStars"].":19:".$result["starFeatured"].":3:".$result["levelDesc"].":15:".$result["levelLength"].":30:".$result["original"].":31:0:37:".$result["coins"].":38:".$result["starCoins"].":39:".$result["requestedStars"].":35:".$result["songID"];
		
		$query12 = $db->prepare("SELECT * FROM users WHERE userID = '".$level1["userID"]."'");
		$query12->execute();
		$result12 = $query12->fetchAll();
		if ($query12->rowCount() > 0) {
		$userIDalmost = $result12[0];
		$userID = $userIDalmost["extID"];
		if(is_numeric($userID)){
			$userIDnumba = $userID;
		}else{
			$userIDnumba = 0;
		}
		}
		$levelsstring = $levelsstring . $result["userID"] . ":" . $level1["userName"] . ":" . $userIDnumba;
		if($result["songID"]!=0){
			$query3=$db->prepare("select * from songs where ID = ".$result["songID"]);
			$query3->execute();
			$result3 = $query3->fetchAll();
			$result4 = $result3[0];
			if($songcolonmarker != 1337){
				$songsstring = $songsstring . ":";
			}
			$songsstring = $songsstring . "1~|~".$result4["ID"]."~|~2~|~".$result4["name"]."~|~3~|~".$result4["authorID"]."~|~4~|~".$result4["authorName"]."~|~5~|~".$result4["size"]."~|~6~|~~|~10~|~".$result4["download"]."~|~7~|~~|~8~|~0";
			$songcolonmarker = 1335;
		}
		$userid = $userid + 1;
		$colonmarker = 1335;
        
    }
    $stringa = $stringa."#".$levelsstring;
	$stringa = $stringa."#".$songsstring;
	$stringa = $stringa."#".$k.":".($page*10).":".$k;
    
    
    $myfile = fopen("bottino.txt", "w");
    fwrite($myfile,$stringa);
    /*
	foreach ($arr as &$value) {
		if ($k != 0){
			echo "|";
		}
		$query=$db->prepare("select * from levels where levelID = ".htmlspecialchars($value,ENT_QUOTES));
		$query->execute();
		$result2 = $query->fetchAll();
		$result = $result2[0];
			
		if(count($result2)<= 0) continue;
			
		echo "1:".$result["levelID"].":2:".$result["levelName"].":5:".$result["levelVersion"].":6:".$result["userID"].":8:10:9:".$result["starDifficulty"].":10:".$result["downloads"].":12:".$result["audioTrack"].":13:".$result["gameVersion"].":14:".$result["likes"].":17:".$result["starDemon"].":25:".$result["starAuto"].":18:".$result["starStars"].":19:".$result["starFeatured"].":3:".$result["levelDesc"].":15:".$result["levelLength"].":30:".$result["original"].":31:0:37:".$result["coins"].":38:".$result["starCoins"].":39:".$result["requestedStars"].":35:".$result["songID"];
		
		$query12 = $db->prepare("SELECT * FROM users WHERE userID = '".$level1["userID"]."'");
		$query12->execute();
		$result12 = $query12->fetchAll();
		if ($query12->rowCount() > 0) {
		$userIDalmost = $result12[0];
		$userID = $userIDalmost["extID"];
		if(is_numeric($userID)){
			$userIDnumba = $userID;
		}else{
			$userIDnumba = 0;
		}
		}
		$levelsstring = $levelsstring . $result["userID"] . ":" . $level1["userName"] . ":" . $userIDnumba;
		if($result["songID"]!=0){
			$query3=$db->prepare("select * from songs where ID = ".$result["songID"]);
			$query3->execute();
			$result3 = $query3->fetchAll();
			$result4 = $result3[0];
			if($songcolonmarker != 1337){
				$songsstring = $songsstring . ":";
			}
			$songsstring = $songsstring . "1~|~".$result4["ID"]."~|~2~|~".$result4["name"]."~|~3~|~".$result4["authorID"]."~|~4~|~".$result4["authorName"]."~|~5~|~".$result4["size"]."~|~6~|~~|~10~|~".$result4["download"]."~|~7~|~~|~8~|~0";
			$songcolonmarker = 1335;
		}
		$userid = $userid + 1;
		$colonmarker = 1335;
		$k++;
	}
	echo "#".$levelsstring;
	echo "#".$songsstring;
	echo "#".$k.":".($page*10).":".$k;
    
    */
}



if($type <15 ){
	$query2 = $db->prepare($querytxt);
	$query2->execute();
	
	
	if ($query2->rowCount() > 0) {
		$result = $query2->fetchAll();
		for($k = 0; $k < 10 ; $k ++){
			$currentLevel = ($page*10)+$k;
			
			$level1 = $result[$currentLevel];
			
			if($currentLevel >= count($result)) break;
			
			if($k != 0) echo "|";

			echo "1:".$level1["levelID"].":2:".$level1["levelName"].":5:".$level1["levelVersion"].":6:".$level1["userID"].":8:10:9:".$level1["starDifficulty"].":10:".$level1["downloads"].":12:".$level1["audioTrack"].":13:".$level1["gameVersion"].":14:".$level1["likes"].":17:".$level1["starDemon"].":25:".$level1["starAuto"].":18:".$level1["starStars"].":19:".$level1["starFeatured"].":3:".$level1["levelDesc"].":15:".$level1["levelLength"].":30:".$level1["original"].":31:0:37:".$level1["coins"].":38:".$level1["starCoins"].":39:".$level1["requestedStars"].":35:".$level1["songID"]; 
		
			$id = $level1["userID"];
			$query = $db->prepare("SELECT * FROM users WHERE userID = '$id'");
			$query->execute();
			$res = $query->fetchAll();
			$user = $res[0];
			
			if($k == 0){
				$usersString = $usersString.$level1["userID"].":".$user["userName"].":".$user["accountID"];
			}else{
				$usersString = $usersString."|".$level1["userID"].":".$user["userName"].":".$user["accountID"];
			}
			$y = 0;
			if($level1["songID"] != 0){
				$id = $level1["userID"];
				$query = $db->prepare("SELECT * FROM songs WHERE levelID = '".$level1["levelID"]."'");
				$query->execute();
				$res = $query->fetchAll();
				$song = $res[0];
				if($y == 0){
					$songsString = $songsString.$song["songString"];
				}else{
					$songsString = $songsString.":".$song["songString"];
				}
			}
			
			
			
		}		
			
		
		
		
		$totLevel = count($result);
		echo "#";
		//echo "1:".$result["levelID"].":2:".$result["levelName"].":5:".$result["levelVersion"].":6:".$result["userID"].":8:10:9:".$result["starDifficulty"].":10:".$result["downloads"].":12:".$result["audioTrack"].":13:".$result["gameVersion"].":14:".$result["likes"].":17:".$result["starDemon"].":25:".$result["starAuto"].":18:".$result["starStars"].":19:".$result["starFeatured"].":3:".$result["levelDesc"].":15:".$result["levelLength"].":30:".$result["original"].":31:0:37:".$result["coins"].":38:".$result["starCoins"].":39:".$result["requestedStars"].":35:".$result["songID"];

		echo $usersString;

		echo "#".$songsString;

		echo "#";

		echo $totLevel.":".($page*10).":10";
			
	}
}







?>	