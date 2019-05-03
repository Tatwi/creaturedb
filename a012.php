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
	
	echo "<h2>What animal missions give the most XP on ". $_POST["planet"]. " when using ". $_POST["damage"]. " damage?</h2>";
	
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
	// Example: SELECT Planet, Creature_Name, Level, Base_XP FROM Tarkin_Creatures WHERE Missions_Available LIKE 'Yes' AND Planet LIKE 'Corellia' AND Kinetic < 20 ORDER BY Planet, length(Base_XP) DESC, Base_XP DESC;
	$sql = "SELECT Planet, Creature_Name, Level, Base_XP, ". $_POST["damage"]. " FROM Tarkin_Creatures WHERE Missions_Available LIKE 'Yes' AND Planet LIKE '". $_POST["planet"]. "' AND ". $_POST["damage"]. " <= 10 ORDER BY Planet, length(Base_XP) DESC, Base_XP DESC";
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

	echo "<table border='1'><tr><th>Creature Name</th><th>Level</th><th>". $_POST["damage"]." Resistance</th><th>XP Amount</th></tr>";
	for ($x = 0; $x < $answersize; $x++) {
		$resist = "Vulnerable";
		
		if($answer[$x][$_POST["damage"]] > 0){
			$resist = number_format($answer[$x][$_POST["damage"]]);
		}
		
		echo "<tr><td><a href='#' onclick='loadCreaturePage(\"". $answer[$x]["Creature_Name"] . "\")'>". makePretty($answer[$x]["Creature_Name"]). "</a></td><td>". number_format($answer[$x]["Level"]). "</td><td>". $resist. "</td><td>". number_format($answer[$x]["Base_XP"]). "</td></tr>";
	}
	echo "</table><br />";
	
	?>
	
	<pre><a href="index.php">Back to main page ...</a></pre>
</div>

<?php include("design-bottom.php"); ?>