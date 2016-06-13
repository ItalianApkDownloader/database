<?php
include "connection.php";

include "function.php";





$str= $_POST["str"];
$total= $_POST["total"];
$page= $_POST["page"];






  
  $query2 = $db->prepare("SELECT * FROM users WHERE UPPER(userName) LIKE '%$str%'  AND accountID!=0  ");
  $query2->execute();

  if ($query2->rowCount() > 0) {
       $result = $query2->fetchAll();
 
     $nUser = count($result);
     $user = $result[0];
     
     $comment = $page*10;
      

     for($x = 0; $x < 10;$x++){
		 $user = $result[$x];
        if($x != 0 & $x < $nUser){
          echo '|';
        }
        if($page==0){
           if($nUser>$x){
              echo "1:".$user["userName"].":2:".$user["userID"].":13:".$user["coins"].":17:".$user["userCoins"].":6::9:".$user["icon"].":10:".$user["color1"].":11:".$user["color2"].":14:".$user["iconType"].":15:".$user["accGlow"].":16:".$user["accountID"].":3:".$user["stars"].":8:".$user["creatorPoints"].":4:".$user["demons"]."";
           }else{
              break;
           }
        }else{
           if($nUser-($page*10)>$x){
              
              echo "1:".$user["userName"].":2:".$user["userID"].":13:".$user["coins"].":17:".$user["userCoins"].":6::9:".$user["icon"].":10:".$user["color1"].":11:".$user["color2"].":14:".$user["iconType"].":15:".$user["accGlow"].":16:".$user["accountID"].":3:".$user["stars"].":8:".$user["creatorPoints"].":4:".$user["demons"]."";
           }else{
              break;
           }

        }
     }
     $page = $page*10;
     //$npage = $nUser/10 +1;
     echo "#".$nUser.":".$page.":10";
  }
  
  
  





  //echo $nUser;





//echo "1:98macdj:2:3359832:13:121212:17:0:6::9:2:10:3:11:6:14:1:15:2:16:253:3:0:8:2:4:0|1:98macdjiad:2:11427771:13:0:17:0:6::9:1:10:0:11:3:14:0:15:0:16:2368094:3:0:8:0:4:0#2:0:10";


exit;

?>