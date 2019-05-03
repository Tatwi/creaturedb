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
	
	echo "<h2>What can I sample DNA from that has ". specialAttackIs($_POST["attack"]). " as a primary or secondary attack?</h2>";
	
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
	
	$sql = "SELECT Creature_Name, Planet, Level, BE_Can_Sample, Attack_1, Attack_2 FROM Tarkin_Creatures WHERE Attack_1 LIKE '". $_POST["attack"]. "' OR Attack_2 LIKE '". $_POST["attack"]. "' ORDER By Planet, length(Level) ASC, Level ASC";
	$result = $conn->query($sql);
	$answer = array();
	$answercntr = 0;
	$results = true;
	
	// Make local array from results
	if ($result->num_rows > 0) {
		while($row = $result->fetch_assoc()) {
			$answer[$answercntr] = $row;
			$answercntr++;
		}
	}else {
		$results = false;
	}
	
	$conn->close();
	
	$answersize = count($answer);
	
	if ($results){
		echo "<table border='1'><tr><th>Creature Name</th><th>Planet</th><th>Level</th><th>Primary</th><th>Secondary</th></tr>";
		for ($x = 0; $x < $answersize; $x++) {
			if ($answer[$x]["BE_Can_Sample"] == "No"){
				continue;
			}
			
			echo "<tr><td><a href='#' onclick='loadCreaturePage(\"". $answer[$x]["Creature_Name"] . "\")'>". makePretty($answer[$x]["Creature_Name"]). "</a></td><td>". $answer[$x]["Planet"]. "</td><td>". number_format($answer[$x]["Level"]). "</td><td>". specialAttackIs($answer[$x]["Attack_1"]). "</td><td>". specialAttackIs($answer[$x]["Attack_2"]). "</td></tr>";
		}
		echo "</table><br />";
	} else{
		echo "<pre>Sorry, no results were found.</pre>";
	}
	
	?>
	
	<pre><a href="index.php">Back to main page ...</a></pre>
</div>

<?php include("design-bottom.php"); ?>