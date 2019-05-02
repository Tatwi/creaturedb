<?php include("design-top.php"); ?>

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
		if ($resistvalue < 1){
			$resistvalue = "Vulnerable";
		}
		
		return $resistvalue;
	}
	
	echo "<h2>What's the easiest way to collect ". makePretty($_POST["resource"]). " using ". $_POST["damage"]. " damage?</h2>";
	
	$servername = "localhost";
	$username = "rob";
	$password = "123456";
	$dbname = "creatures";
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
	
	//Example: SELECT Creature_Name, Planet, Hide_Amount, Missions_Available, Base_HAM, Kinetic FROM Tarkin_Creatures WHERE Hide_Type='hide_leathery' AND Kinetic < 20;
	$sql = "SELECT Creature_Name, Planet, ". $qnty. ", Missions_Available, Base_HAM, ". $_POST["damage"]. " FROM Tarkin_Creatures WHERE ". $restype. "='". $_POST["resource"]. "' AND ". $_POST["damage"]. " < 20";
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
	
	// Find the best targets
	$bestcreature = "";
	$bestplanet = "";
	$bestamount = 1;
	$bestham = 100000;
	$bestresist = 100000;
	$mission = "";
		
	$bestresults = array();
	$bestresultscntr = 0;
	for ($x = 0; $x < $answercntr; $x++) {
		if ($answer[$x][$qnty] >= $bestamount && $answer[$x][$_POST["damage"]] <= $bestresist && $answer[$x]["Missions_Available"] == "Yes"){
			$skip = false;
			
			/*
			for ($y = 0; $y < count($bestresults); $y++) {
				if ($bestresults[$y][$qnty] >= $answer[$x][$qnty] && $bestresults[$y]["Base_HAM"] <= $answer[$x]["Base_HAM"]){
					echo "farts ". $answer[$x]["Creature_Name"]. "<br />";
					$skip = true;
				}
			}*/
			
			// Ignore if worse than existing entry
			if ($skip){
				continue;
			}

			$bestcreature = $answer[$x]["Creature_Name"];
			$bestplanet = $answer[$x]["Planet"];
			$bestamount = $answer[$x][$qnty];
			$bestham = $answer[$x]["Base_HAM"];
			$bestresist = $answer[$x][$_POST["damage"]];
			$mission = $answer[$x]["Missions_Available"];

			$bestresults[$bestresultscntr] = $answer[$x];
			$bestresultscntr++;
		}
	}
	
	$arrlength = count($bestresults);
	$bestqntyindex = 0;
	$besthamindex = 0;
	
	for ($x = 0; $x < $arrlength; $x++) {
		if ($bestresults[$x][$qnty] > $bestresults[$bestqntyindex][$qnty]){
			$bestqntyindex = $x;
		}
		
		if ($bestresults[$x]["Base_HAM"] < $bestresults[$besthamindex]["Base_HAM"]){
			$besthamindex = $x;
		}
	}
	
	// Make sure this is the lowest ham version of the best resource quanity critter
	for ($x = 0; $x < $answercntr; $x++) {
		if ($bestresults[$bestqntyindex][$qnty] == $answer[$x][$qnty] && $bestresults[$bestqntyindex]["Base_HAM"] > $answer[$x]["Base_HAM"]){
			$bestresults[$bestqntyindex] = $answer[$x];
		}
	}

	// Print results
	echo "<p><b>Lowest HAM, Highest Quantity:</b></p><table border='1'><tr><th>Creature Name</th><th>Planet</th><th>Quantity</th><th>Missions</th><th>". $_POST["damage"]. " Resistance</th><th>HAM</th></tr>";
	$resistvalue = resistPretty($bestresults[$besthamindex][$_POST["damage"]]);
	echo "<tr><td>". makePretty($bestresults[$besthamindex]["Creature_Name"]). "</td><td>". $bestresults[$besthamindex]["Planet"]. "</td><td>". number_format($bestresults[$besthamindex][$qnty]). "</td><td>". $bestresults[$besthamindex]["Missions_Available"]. "</td><td>". $resistvalue. "</td><td>". number_format($bestresults[$besthamindex]["Base_HAM"]). "</td></tr>";
	echo "</table><br />";
	
	echo "<p><b>Highest Quantity:</b></p><table border='1'><tr><th>Creature Name</th><th>Planet</th><th>Quantity</th><th>Missions</th><th>". $_POST["damage"]. " Resistance</th><th>HAM</th></tr>";
	$resistvalue = resistPretty($bestresults[$bestqntyindex][$_POST["damage"]]);
	echo "<tr><td>". makePretty($bestresults[$bestqntyindex]["Creature_Name"]). "</td><td>". $bestresults[$bestqntyindex]["Planet"]. "</td><td>". number_format($bestresults[$bestqntyindex][$qnty]). "</td><td>". $bestresults[$bestqntyindex]["Missions_Available"]. "</td><td>". $resistvalue. "</td><td>". number_format($bestresults[$bestqntyindex]["Base_HAM"]). "</td></tr>";
	echo "</table><br /><br />";
	
	echo "<p><b>Everything of Note:</b></p><table border='1'><tr><th>Creature Name</th><th>Planet</th><th>Quantity</th><th>Missions</th><th>". $_POST["damage"]. " Resistance</th><th>HAM</th></tr>";
	for ($x = 0; $x < $answercntr; $x++) {
		if ($answer[$x][$qnty] >= $bestresults[$besthamindex][$qnty]){
			$resistvalue = resistPretty($answer[$x][$_POST["damage"]]);
			echo "<tr><td>". makePretty($answer[$x]["Creature_Name"]). "</td><td>". $answer[$x]["Planet"]. "</td><td>". number_format($answer[$x][$qnty]). "</td><td>". $answer[$x]["Missions_Available"]. "</td><td>". $resistvalue. "</td><td>". number_format($answer[$x]["Base_HAM"]). "</td></tr>";
		}
	}
	echo "</table><br /><br />";
	
	
	?>
	
	<pre><a href="index.php">Back to main page ...</a></pre>
</div>

<?php include("design-bottom.php"); ?>