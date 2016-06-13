<?php


$gameVersion=20;
$binaryVersion=29;
$accountID=253;
$gjp="QF5HW1kCDgwK";
$page=0;
$total=0;
$secret="Wmfd2893gb7";







echo '<form action="http://www.boomlings.com/database/getGJUserInfo20.php" method="post">';  

echo "<td><input type='hidden' name='gameVersion' value='$gameVersion'/></td>";
echo "<td><input type='hidden' name='binaryVersion' value='$binaryVersion'/></td>";
echo "<td><input type='hidden' name='accountID' value='253'/></td>";
echo "<td><input type='hidden' name='gjp' value='QF5HW1kCDgwK'/></td>";
echo "<td><input type='hidden' name='targetAccountID' value='253'/></td>";
echo "<td><input type='hidden' name='secret' value='Wmfd2893gb7'/></td>";



echo '<input type="submit" value="Reupload"></form>';



?>