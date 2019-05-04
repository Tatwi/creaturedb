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
	
	echo "<h2>Which creatures are only usable by Creature Handlers? </h2>";

	// Create connection
	$conn = new mysqli($servername, $username, $password, $dbname);

	// Check connection
	if ($conn->connect_error) {
		die("Connection failed: " . $conn->connect_error);
	}
	
	$sql = "SELECT Planet, Creature_Name, Level, Mount, PVP_Bitmask FROM Tarkin_Creatures WHERE CH_Only = 'Yes' ORDER BY Planet, length(Level), Level";
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
	$aggressive = "No";

	echo "<table border='1'><tr><th>Creature Name</th><th>Planet</th><th>Level</th><th>Aggressive</th><th>Mountable</th></tr>";
	for ($x = 0; $x < $answersize; $x++) {
		if (strpos($answer[$x]["PVP_Bitmask"], 'AGGRESSIVE') !== false) {
			$aggressive = "Yes";
		}
			
		echo "<tr><td><a href='#' onclick='loadCreaturePage(\"". $answer[$x]["Creature_Name"] . "\")'>". makePretty($answer[$x]["Creature_Name"]). "</a></td><td>". $answer[$x]["Planet"]. "</td><td>". number_format($answer[$x]["Level"]). "</td><td>". $aggressive. "</td><td>". $answer[$x]["Mount"]. "</td></tr>";
	}
	echo "</table><br />";
	
	?>
	
	<pre><a href="index.php">Back to main page ...</a></pre>
</div>

<?php include("design-bottom.php"); ?>