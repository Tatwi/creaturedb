<?php include("design-top.php"); ?>
<?php include("dbinfo.php"); ?>

<div class="contentbox">
	<div class="contentboxtitle"><span>Creatures</span></div>

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

	$arg1 = $_GET['arg1'];

	echo "<h2>Creatures beginning with the letter ". strtoupper($arg1). "</h2>";

	// Create connection
	$conn = new mysqli($servername, $username, $password, $dbname);

	// Check connection
	if ($conn->connect_error) {
		die("Connection failed: " . $conn->connect_error);
	}

	$sql = "SELECT Creature_Name, Planet, Level, Meat_Type, Hide_Type, Bone_Type, Milk_Type, Missions_Available, BE_Can_Sample, Taming_Chance FROM Tarkin_Creatures WHERE Creature_Name LIKE '". $arg1. "%'";
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
		echo "<table><tr><th>Creature Name</th><th>Planet</th><th>Level</th><th>Bone</th><th>Hide</th><th>Meat</th><th>Milk</th><th>Missions</th><th>DNA</th><th>Tamable</th></tr>";
		
		for ($x = 0; $x < $answersize; $x++) {
			$tamable = "No";

			if ($answer[$x]["Taming_Chance"] > 0){
				$tamable = "Yes";
			}

			echo "<tr>
			<td><a href='#' onclick='loadCreaturePage(\"". $answer[$x]["Creature_Name"] . "\")'>". makePretty($answer[$x]["Creature_Name"]). "</a></td>
			<td>". $answer[$x]["Planet"]. "</td>
			<td>". number_format($answer[$x]["Level"]). "</td>
			<td>". makePretty(str_replace("bone", " ", $answer[$x]["Bone_Type"])). "</td>
			<td>". makePretty(str_replace("hide", " ", $answer[$x]["Hide_Type"])). "</td>
			<td>". makePretty(str_replace("meat", " ", $answer[$x]["Meat_Type"])). "</td>
			<td>". makePretty(str_replace("milk", " ", $answer[$x]["Milk_Type"])). "</td>
			<td>". $answer[$x]["Missions_Available"]. "</td>
			<td>". $answer[$x]["BE_Can_Sample"]. "</td>
			<td>". $tamable. "</td>
			</tr>";
		}
		echo "</table><br />";
	} else {
		echo "<pre>There aren't any creatures that start with this letter.</pre>";
	}

	?>

	<pre><a href="index.php">Back to main page ...</a></pre>
</div>

<?php include("design-bottom.php"); ?>