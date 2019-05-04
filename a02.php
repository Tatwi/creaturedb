<?php include("design-top.php"); ?>
<?php include("dbinfo.php"); ?>

<div class="contentbox">
	<div class="contentboxtitle"><span>Quick Answers</span></div>

	<script type="text/javascript">
		function loadCreaturePage(arg1){
			var pg = "creaturepage.php?argument1=" + arg1;
			window.open(pg);
		}
	</script>
	
	<?php
	// Helper functions
	function makePretty($value){
		return ucwords(strtolower(str_replace("_", " ", $value)));
	}
	
	function resistPretty($value){
		$resistvalue = number_format($value);
		if ($resistvalue == -1){
			$resistvalue = "Vulnerable";
		}
		
		return $resistvalue;
	}
	
	function armorRatingIs($value){
		$armorrating = "None";
		if ($value == 1){
			$armorrating = "Light";
		} else if ($value == 2){
			$armorrating = "Medium";
		} else if ($value == 3){
			$armorrating = "Heavy";
		}
		
		return $armorrating;
	}
	
	echo "<h2>What's the easiest way to collect ". makePretty($_POST["resource"]). " using ". $_POST["damage"]. " damage?</h2>";
	
	$restype = "";
	$qnty = "";

	if (strpos($_POST["resource"], 'hide') !== false) {
		$restype = "Hide_Type";
		$qnty = "Hide_Amount";
	} else if (strpos($_POST["resource"], 'meat') !== false) {
		$restype = "Meat_Type";
		$qnty = "Meat_Amount";
	} else if (strpos($_POST["resource"], 'bone') !== false) {
		$restype = "Bone_Type";
		$qnty = "Bone_Amount";
	}
	
	// Create connection
	$conn = new mysqli($servername, $username, $password, $dbname);

	// Check connection
	if ($conn->connect_error) {
		die("Connection failed: " . $conn->connect_error);
	}
	
	//Example: SELECT Creature_Name, Planet, Hide_Amount, Missions_Available, Armor, Base_HAM, Kinetic FROM Tarkin_Creatures WHERE Hide_Type='hide_leathery' AND Kinetic < 20 AND PVP_Bitmask NOT LIKE '%AGGRESSIVE%' AND Creature_Bitmask NOT LIKE '%KILLER%' AND Creature_BitMask NOT LIKE '%PACK%';
	$sql = "SELECT Creature_Name, Planet, ". $qnty. ", Missions_Available, Armor, Base_HAM, ". $_POST["damage"]. " FROM Tarkin_Creatures WHERE ". $restype. "='". $_POST["resource"]. "' AND ". $_POST["damage"]. " < 20 AND PVP_Bitmask NOT LIKE '%AGGRESSIVE%' AND Creature_Bitmask NOT LIKE '%KILLER%' AND Creature_BitMask NOT LIKE '%PACK%'";
	$result = $conn->query($sql);
	$answer = array();
	$answercntr = 0;
	
	// Make local array from results
	if ($result->num_rows > 0) {
		while($row = $result->fetch_assoc()) {
			$answer[$answercntr] = $row;
			$answercntr++;
		}
	}else {
		echo "0 results";
	}
	
	$conn->close();
	
	$answersize = count($answer);
	$tmpeasy = 0;
	$tmpeff = 0;
	$tmpeffvalue = 0;
	$tmpmost = 0;
	
	// Gather Data
	for ($x = 0; $x < $answersize; $x++){
		// Easiest: Lowest HAM without resists
		if ($answer[$x]["Base_HAM"] < $answer[$tmpeasy]["Base_HAM"] && $answer[$x][$_POST["damage"]] < 1){
			$tmpeasy = $x;
		}
		//---- END
	
		// Most Units Per Kill: Largests Quantity
		if ($answer[$x][$qnty] > $answer[$tmpmost][$qnty]){
			$tmpmost = $x;
		}
		//---- END
	
		// Most Efficient: Highest Units / HAM
		$ham = $answer[$x]["Base_HAM"];
		
		// Increase HAM due to resist value
		if ($answer[$x][$_POST["damage"]] > 0){
			$ham += $ham / 2 + ($ham * $answer[$x][$_POST["damage"]] /  100);
		}
		
		// unitsPerMinute = units * creaturesPerMission / (AvgMinutes + (resistAdjustedHAM * creaturesPerMission / aSensiblConstantValue))
		// unitsPerMinute = units * 15 / (3 + (resistAdjustedHAM * 15 / 65000))
		$current = $answer[$x][$qnty];
		$eff = floor($current * 15 / (3 + ($ham * 15 / 65000)));
		
		// Save units / minute value to array
		$answer[$x]["Units_Per_Minute"] = $eff;
		
		if ($eff > $tmpeffvalue){
			$tmpeffvalue = $eff;
			$tmpeff = $x;
		}
		//---- END
	}
	
	// Print Results
	echo "<pre>Due to the nature of the question, these results exclude animals that are aggressive, that will assist each other, or that will death blow.</pre>";
	
	$easist = $answer[$tmpeasy];
	echo "<p><b>Easiest:</b></p><table border='1'><tr><th>Creature Name</th><th>Planet</th><th>Quantity</th><th>Armor Rating</th><th>". $_POST["damage"]. " Resistance</th><th>HAM</th><th>Units/Minute</th><th>Missions</th></tr>";
	echo "<tr>
	<td><a href='#' onclick='loadCreaturePage(\"". $easist["Creature_Name"] . "\")'>". makePretty($easist["Creature_Name"]). "</a></td>
	<td>". $easist["Planet"]. "</td>
	<td>". number_format($easist[$qnty]). "</td>
	<td>". armorRatingIs($easist["Armor"]). "</td>
	<td>". resistPretty($easist[$_POST["damage"]]). "</td>
	<td>". number_format($easist["Base_HAM"]). "</td>
	<td>". number_format($easist["Units_Per_Minute"]). "</td>
	<td>". $easist["Missions_Available"]. "</td>
	</tr>";
	echo "</table><br />";
	
	$efficient = $answer[$tmpeff];
	echo "<p><b>Most Effecient:</b></p><table border='1'><tr><th>Creature Name</th><th>Planet</th><th>Quantity</th><th>Armor Rating</th><th>". $_POST["damage"]. " Resistance</th><th>HAM</th><th>Units/Minute</th><th>Missions</th></tr>";
	echo "<tr>
	<td><a href='#' onclick='loadCreaturePage(\"". $efficient["Creature_Name"] . "\")'>". makePretty($efficient["Creature_Name"]). "</a></td>
	<td>". $efficient["Planet"]. "</td>
	<td>". number_format($efficient[$qnty]). "</td>
	<td>". armorRatingIs($efficient["Armor"]). "</td>
	<td>". resistPretty($efficient[$_POST["damage"]]). "</td>
	<td>". number_format($efficient["Base_HAM"]). "</td>
	<td>". number_format($efficient["Units_Per_Minute"]). "</td>
	<td>". $efficient["Missions_Available"]. "</td>
	</tr>";
	echo "</table><br />";
	
	$mostperkill = $answer[$tmpmost];
	echo "<p><b>Largest Quanity Per Kill:</b></p><table border='1'><tr><th>Creature Name</th><th>Planet</th><th>Quantity</th><th>Armor Rating</th><th>". $_POST["damage"]. " Resistance</th><th>HAM</th><th>Units/Minute</th><th>Missions</th></tr>";
	echo "<tr>
	<td><a href='#' onclick='loadCreaturePage(\"". $mostperkill["Creature_Name"] . "\")'>". makePretty($mostperkill["Creature_Name"]). "</a></td>
	<td>". $mostperkill["Planet"]. "</td><td>". number_format($mostperkill[$qnty]). "</td>
	<td>". armorRatingIs($mostperkill["Armor"]). "</td>
	<td>". resistPretty($mostperkill[$_POST["damage"]]). "</td>
	<td>". number_format($mostperkill["Base_HAM"]). "</td>
	<td>". number_format($mostperkill["Units_Per_Minute"]). "</td>
	<td>". $mostperkill["Missions_Available"]. "</td>
	</tr>";
	echo "</table><br />";
	
	echo "<p><b>Everything of Note:</b></p><table border='1'><tr><th>Creature Name</th><th>Planet</th><th>Quantity</th><th>Armor Rating</th><th>". $_POST["damage"]. " Resistance</th><th>HAM</th><th>Units/Minute</th><th>Missions</th></tr>";
	for ($x = 0; $x < $answersize; $x++) {
		if ($answer[$x][$qnty] >= $easist[$qnty]){
			echo "<tr>
			<td><a href='#' onclick='loadCreaturePage(\"". $answer[$x]["Creature_Name"] . "\")'>". makePretty($answer[$x]["Creature_Name"]). "</a></td>
			<td>". $answer[$x]["Planet"]. "</td><td>". number_format($answer[$x][$qnty]). "</td>
			<td>". armorRatingIs($answer[$x]["Armor"]). "</td>
			<td>". resistPretty($answer[$x][$_POST["damage"]]). "</td>
			<td>". number_format($answer[$x]["Base_HAM"]). "</td>
			<td>". number_format($answer[$x]["Units_Per_Minute"]). "</td>
			<td>". $answer[$x]["Missions_Available"]. "</td>
			</tr>";
		}
	}
	echo "</table><br /><br />";
	
	?>
	
	<pre>
	Calculations for estimated values:
	
	if resistValue > 0 
		resistAdjustedHAM += ham / 2 + (ham * resistValue /  100)
	else
		resistAdjustedHAM = baseHam
		
	unitsPerMinute = units * 15 / (3 + (resistAdjustedHAM * 15 / 65000))
		
	<a href="index.php">Back to main page ...</a>
	</pre>
</div>

<?php include("design-bottom.php"); ?>