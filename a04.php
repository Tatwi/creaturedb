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
	
	echo "<h2>What creatures can I tame between levels ". $_POST["levelmin"]. " and ". $_POST["levelmax"]. "?</h2>";
	
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
	
	$sql = "SELECT Creature_Name, Planet, Level, Mount, Missions_Available, PVP_Bitmask FROM Tarkin_Creatures WHERE Taming_Chance > 0 AND Level >= ". $_POST["levelmin"]. " AND Level <= ". $_POST["levelmax"]. " ORDER BY Planet, length(Level) ASC, Level ASC";
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
	$aggressive = "No";
	
	if ($results){
		echo "<table border='1'><tr><th>Creature Name</th><th>Planet</th><th>Level</th><th>Aggressive</th><th>Mountable</th><th>Missions</th></tr>";
		for ($x = 0; $x < $answersize; $x++) {
			if (strpos($answer[$x]["PVP_Bitmask"], 'AGGRESSIVE') !== false) {
				$aggressive = "Yes";
			}
			
			echo "<tr><td><a href='#' onclick='loadCreaturePage(\"". $answer[$x]["Creature_Name"] . "\")'>". makePretty($answer[$x]["Creature_Name"]). "</a></td><td>". $answer[$x]["Planet"]. "</td><td>". $answer[$x]["Level"]. "</td><td>". $aggressive. "</td><td>". $answer[$x]["Mount"]. "</td><td>". $answer[$x]["Missions_Available"]. "</td></tr>";
		}
		echo "</table><br />";
	} else{
		$reason = "";
		
		if ($_POST["levelmin"] > $_POST["levelmax"]){
			$reason = ", because the minimum level was set higher than the maximum level";
		}
		
		echo "<pre>Sorry, no results were found$reason.</pre>";
	}
	
	?>
	
	<pre><a href="index.php">Back to main page ...</a></pre>
</div>

<?php include("design-bottom.php"); ?>