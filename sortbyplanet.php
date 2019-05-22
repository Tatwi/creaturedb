<?php include("design-top.php"); ?>
<?php include("dbinfo.php"); ?>
<?php include("functions_before.php"); ?>

<div class="contentbox">
	<div class="contentboxtitle"><span>Creatures</span></div>

	<?php
	$arg1 = $_GET['arg1'];

	echo "<h2>Creatures who live on ". $arg1. "</h2>";

	// Create connection
	$conn = new mysqli($servername, $username, $password, $dbname);

	// Check connection
	if ($conn->connect_error) {
		die("Connection failed: " . $conn->connect_error);
	}

	$sql = "SELECT Creature_Name, Level, Meat_Type, Hide_Type, Bone_Type, Milk_Type, Missions_Available, BE_Can_Sample, Taming_Chance FROM Tarkin_Creatures WHERE Planet LIKE '". $arg1. "'";
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
		<th>Level</th><th>Bone</th>
		<th>Hide</th><th>Meat</th>
		<th>Milk</th><th>Missions</th>
		<th>DNA</th><th>Tamable</th>
		</tr>";
		
		for ($x = 0; $x < $answersize; $x++) {
			$tamable = "No";

			if ($answer[$x]["Taming_Chance"] > 0){
				$tamable = "Yes";
			}

			echo "<tr>
			<td><a href='#' onclick='loadCreaturePage(\"". $answer[$x]["Creature_Name"] . "\")'>". makePretty($answer[$x]["Creature_Name"]). "</a></td>
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

<?php include("functions_after.php"); ?>
<?php include("design-bottom.php"); ?>