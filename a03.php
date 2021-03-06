<?php include("design-top.php"); ?>
<?php include("dbinfo.php"); ?>
<?php include("functions_before.php"); ?>

<div class="contentbox">
	<div class="contentboxtitle"><span>Quick Answers</span></div>

	<?php
	echo "<h2>What creatures are tamable by a Novice Creature Handler?</h2>";

	// Create connection
	$conn = new mysqli($servername, $username, $password, $dbname);

	// Check connection
	if ($conn->connect_error) {
		die("Connection failed: " . $conn->connect_error);
	}
	
	$sql = "SELECT Creature_Name, Planet, Level, Mount, Missions_Available FROM Tarkin_Creatures WHERE Taming_Chance > 0 AND Level < 13 AND PVP_Bitmask NOT LIKE '%AGGRESSIVE%' ORDER BY Planet, length(Level) ASC, Level ASC";
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

	echo "<table id='theTable'><tr>
	<th>Creature Name</th>
	<th>Planet</th>
	<th>Level</th>
	<th>Mountable</th>
	<th>Missions</th>
	</tr>";
	for ($x = 0; $x < $answersize; $x++) {
		echo "<tr><td><a href='#' onclick='loadCreaturePage(\"". $answer[$x]["Creature_Name"] . "\")'>". makePretty($answer[$x]["Creature_Name"]). "</a></td>
		<td>". $answer[$x]["Planet"]. "</td>
		<td>". number_format($answer[$x]["Level"]). "</td>
		<td>". $answer[$x]["Mount"]. "</td>
		<td>". $answer[$x]["Missions_Available"]. "</td>
		</tr>";
	}
	echo "</table><br />";
	
	?>
	
	<pre><a href="index.php">Back to main page ...</a></pre>
</div>

<?php include("functions_after.php"); ?>
<?php include("design-bottom.php"); ?>