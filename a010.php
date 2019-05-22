<?php include("design-top.php"); ?>
<?php include("dbinfo.php"); ?>
<?php include("functions_before.php"); ?>

<div class="contentbox">
	<div class="contentboxtitle"><span>Quick Answers</span></div>
	
	<?php
	echo "<h2>What can I sample DNA from that has ". specialAttackIs($_POST["attack"]). " as a primary or secondary attack?</h2>";

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
		echo "<table id='theTable'><tr>
		<th>Creature Name</th>
		<th>Planet</th>
		<th>Level</th>
		<th>Primary</th>
		<th>Secondary</th>
		</tr>";
		for ($x = 0; $x < $answersize; $x++) {
			if ($answer[$x]["BE_Can_Sample"] == "No"){
				continue;
			}
			
			echo "<tr>
			<td><a href='#' onclick='loadCreaturePage(\"". $answer[$x]["Creature_Name"] . "\")'>". makePretty($answer[$x]["Creature_Name"]). "</a></td>
			<td>". $answer[$x]["Planet"]. "</td>
			<td>". number_format($answer[$x]["Level"]). "</td>
			<td>". specialAttackIs($answer[$x]["Attack_1"]). "</td>
			<td>". specialAttackIs($answer[$x]["Attack_2"]). "</td></tr>";
		}
		echo "</table><br />";
	} else{
		echo "<pre>Sorry, no results were found.</pre>";
	}
	
	?>
	
	<pre><a href="index.php">Back to main page ...</a></pre>
</div>

<?php include("functions_after.php"); ?>
<?php include("design-bottom.php"); ?>