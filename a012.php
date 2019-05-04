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
	
	echo "<h2>What animal missions give the most XP on ". $_POST["planet"]. " when using ". $_POST["damage"]. " damage with Armor Piercing ". armorRatingIs($_POST["ap"]). "?</h2>";

	// Create connection
	$conn = new mysqli($servername, $username, $password, $dbname);

	// Check connection
	if ($conn->connect_error) {
		die("Connection failed: " . $conn->connect_error);
	}
	// Example: SELECT Planet, Creature_Name, Level, Armor, Base_XP FROM Tarkin_Creatures WHERE Missions_Available LIKE 'Yes' AND Planet LIKE 'Corellia' AND Kinetic < 20 ORDER BY Planet, length(Base_XP) DESC, Base_XP DESC;
	$sql = "SELECT Planet, Creature_Name, Level, Armor, Base_XP, ". $_POST["damage"]. " FROM Tarkin_Creatures WHERE Missions_Available LIKE 'Yes' AND Planet LIKE '". $_POST["planet"]. "' AND ". $_POST["damage"]. " <= 20 ". " AND Armor <= ". $_POST["ap"]. " ORDER BY Planet, length(Base_XP) DESC, Base_XP DESC";
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

	echo "<table border='1'><tr><th>Creature Name</th><th>Level</th><th>Armor Rating</th><th>". $_POST["damage"]." Resistance</th><th>XP Amount</th></tr>";
	for ($x = 0; $x < $answersize; $x++) {
		echo "<tr>
		<td><a href='#' onclick='loadCreaturePage(\"". $answer[$x]["Creature_Name"] . "\")'>". makePretty($answer[$x]["Creature_Name"]). "</a></td>
		<td>". number_format($answer[$x]["Level"]). "</td>
		<td>". armorRatingIs($answer[$x]["Armor"]). "</td>
		<td>". resistPretty($answer[$x][$_POST["damage"]]). "</td><td>". number_format($answer[$x]["Base_XP"]). "</td>
		</tr>";
	}
	echo "</table><br />";
	
	?>
	
	<pre><a href="index.php">Back to main page ...</a></pre>
</div>

<?php include("design-bottom.php"); ?>