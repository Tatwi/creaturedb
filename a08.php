<?php include("design-top.php"); ?>
<?php include("dbinfo.php"); ?>
<?php include("functions_before.php"); ?>

<div class="contentbox">
	<div class="contentboxtitle"><span>Quick Answers</span></div>

	<?php
	echo "<h2>What passive creatures can I sample DNA from?</h2>";

	// Create connection
	$conn = new mysqli($servername, $username, $password, $dbname);

	// Check connection
	if ($conn->connect_error) {
		die("Connection failed: " . $conn->connect_error);
	}
	
	$sql = "SELECT Planet, Creature_Name, Level, Attack_1, Attack_2 FROM Tarkin_Creatures WHERE PVP_Bitmask NOT LIKE '%AGGRESSIVE%' AND BE_Can_Sample = 'Yes' ORDER BY Planet, length(Level), Level";
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
	<th>Primary</th>
	<th>Secondary</th>
	</tr>";
	for ($x = 0; $x < $answersize; $x++) {
		if ($answer[$x]["Planet"] == "BE-Only"){
				continue;
			}
		
		echo "<tr><td><a href='#' onclick='loadCreaturePage(\"". $answer[$x]["Creature_Name"] . "\")'>". makePretty($answer[$x]["Creature_Name"]). "</a></td>
		<td>". $answer[$x]["Planet"]. "</td>
		<td>". number_format($answer[$x]["Level"]). "</td>
		<td>". specialAttackIs($answer[$x]["Attack_1"]). "</td>
		<td>". specialAttackIs($answer[$x]["Attack_2"]). "</td>
		</tr>";
	}
	echo "</table><br />";
	
	?>
	
	<pre><a href="index.php">Back to main page ...</a></pre>
</div>

<?php include("functions_after.php"); ?>
<?php include("design-bottom.php"); ?>