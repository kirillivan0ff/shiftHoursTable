<?php
function day2digit($var){
    $zero = 0;
    if (strlen($var) === 1){
        $result = $zero.$var;
    }else{
        $result = $var;
    }
    return $result;
}

$suns = array();
$suns[] = 0; 
?>

<!-- CSS goes in the document HEAD or added to your external stylesheet -->
<style type="text/css">
table.gridtable {
    font-family: verdana,arial,sans-serif;
	font-size:15px;
	color:#333333;
	border-width: 1px;
	border-color: #666666;
	border-collapse: collapse;
}
table.gridtable th {
	border-width: 1px;
	padding: 2px;
	border-style: solid;
	border-color: #666666;
	background-color: #dedede;
}
table.gridtable td {
	border-width: 1px;
	padding: 2px;
	border-style: solid;
	border-color: #666666;
	background-color: #ffffff;
}
</style>

<?php
$arrStart = unserialize(stripslashes($_POST['arr1']));
$arrFinish = unserialize(stripslashes($_POST['arr3']));
$month = (int)$_POST['month'];
$year = (int)$_POST['year'];
$userName = $_POST['userName'];
$total = $_POST['total'];

//////////////////////////////UNCOMENT FOLLOWING LINES FOR TEST/////////////////////////////

//$arrStart = array("0101", "0202", "0305");
//$arrFinish = array("0109", "0210", "0311");
//$month = 8;
//$year = 2013;
//$total = 177;
//$userName = "User";

/////////////////////////////////////////////////////////////////////////////////////////////

//this is for the last array element match with ($arrStart[($key+1)] > $x) 
array_push($arrStart, "9999");
array_push($arrFinish, "9999");


$monthLength = date("t", mktime(0,0,0,$month,1,$year));
$monthName = date("F", mktime(0,0,0,$month,1,$year));


echo "<p>Name: <b>{$userName}</b> Month: <b>{$monthName}</b> Year: <b>{$year}</b> TOTAL: <b>{$total}</b></p>";

echo "<table class='gridtable'>\n";
    //top horizontal row of the table with days.
    echo "<tr>";
	echo "<td></td>";
	for($d = 1; $d <= $monthLength; $d++){
		if ((date("D", mktime(0,0,0,$month,$d,$year))) == "Sat")
			$suns[] = (int)$d;
		echo "<th>
				{$d}<br>".date("D", mktime(0,0,0,$month,$d,$year))."
			</th>";
	}
	//first vertical row with hours.
	echo "</tr>\n";
    for($h=0;$h<24;$h++){
		echo "<tr>";
        echo "<th background-color='#dedede'>$h</th>\n";
		for($dId=1;$dId<=$monthLength;$dId++){
			$x = day2digit($dId).day2digit($h);
			echo "<td ";
			if(array_search($dId, $suns))
				echo "style='background-color:lightblue;'";
			echo " align='center'>";
						//find if the x val exists at array as start or finish A - start B - finish
						$st = array_search($x, $arrStart);
						$fn = array_search($x, $arrFinish);
						$mdl = 0;
						$middleShift = false;
						foreach ($arrStart as $key => $value){
							$mdl = 0;
							if((strlen($x) == strlen($value))&&($arrStart[($key+1)] > $x)&&(strncasecmp($x, $value, 2) == 0)&&((substr($value, -2)) <= (substr($x, -2)))){
								$middleShift = (int)$key;
								$y = $value;
								if ($arrFinish[$middleShift] > $x)
									$mdl = 1;
								break;
							}	
						}
						
						
							
							
						if(is_int($st)){
							echo "<b>x</b>";
						}elseif(is_int($fn)){
							if(substr($arrFinish[$fn], -2) == "23")
								echo "<b>x</b>";
							else
								echo "&nbsp;";
						}elseif($mdl == 1){
							echo "<b>x</b>";
							unset($mdl);
							unset($value);
							unset($key);
						}else{
							echo "&nbsp;";
						}
			echo "</td>";
		}
		echo "</tr>\n";
        }
echo "</table>\n";
?>
