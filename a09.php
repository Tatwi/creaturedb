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
	
	function specialAttackIs($value){
			if ($value == ""){
				return "None";
			} else if ($value == ""){
			
			} else if ($value == "creatureareacombo"){
				return "Area Combo";
			} else if ($value == "blindattack"){
				return "Blinding Strike";
			} else if ($value == "creatureareaattack"){
				return "Creature Area Attack";
			} else if ($value == "posturedownattack"){
				return "Crippling Strike";
			} else if ($value == "dizzyattack"){
				return "Dizzy Strike";
			} else if ($value == "creatureareaknockdown"){
				return "Force Strike";
			} else if ($value == "intimidationattack"){
				return "Intimidation";
			} else if ($value == "knockdownattack"){
				return "Knockdown";
			} else if ($value == "mediumdisease"){
				return "Medium Disease";
			} else if ($value == "mediumpoison"){
				return "Medium Poison";
			} else if ($value == "milddisease"){
				return "Mild Disease";
			} else if ($value == "mildpoison"){
				return "Mild Poison";
			} else if ($value == "creatureareableeding"){
				return "Open Wounds";
			} else if ($value == "creatureareadisease"){
				return "Plague Strike";
			} else if ($value == "creatureareapoison"){
				return "Poison Spray";
			} else if ($value == "strongdisease"){
				return "Strong Disease";
			} else if ($value == "strongpoison"){
				return "Strong Poison";
			} else if ($value == "stunattack"){
				return "Stunning Strike";
			} 
			
			// There are a few cases the value will be NA
			return $value;
		}
	
	echo "<h2>What aggressive creatures can I sample DNA from?</h2>";
	
	$servername = "localhost";
	$username = "rob";
	$password = "123456";
	$dbname = "creatures";

	// Create connection
	$conn = new mysqli($servername, $username, $password, $dbname);

	// Check connection
	if ($conn->connect_error) {
		die("Connection failed: " . $conn->connect_error);
	}
	
	$sql = "SELECT Planet, Creature_Name, Level, Attack_1, Attack_2 FROM Tarkin_Creatures WHERE PVP_Bitmask LIKE '%AGGRESSIVE%' AND BE_Can_Sample = 'Yes' ORDER BY Planet, length(Level), Level";
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

	echo "<table border='1'><tr><th>Creature Name</th><th>Planet</th><th>Level</th><th>Primary</th><th>Secondary</th></tr>";
	for ($x = 0; $x < $answersize; $x++) {
		if ($answer[$x]["Planet"] == "BE-Only"){
				continue;
			}
		
		echo "<tr><td><a href='#' onclick='loadCreaturePage(\"". $answer[$x]["Creature_Name"] . "\")'>". makePretty($answer[$x]["Creature_Name"]). "</a></td><td>". $answer[$x]["Planet"]. "</td><td>". $answer[$x]["Level"]. "</td><td>". specialAttackIs($answer[$x]["Attack_1"]). "</td><td>". specialAttackIs($answer[$x]["Attack_2"]). "</td></tr>";
	}
	echo "</table><br />";
	
	?>
	
	<pre><a href="index.php">Back to main page ...</a></pre>
</div>

<?php include("design-bottom.php"); ?>