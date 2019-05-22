<?php include("design-top.php"); ?>
<?php include("dbinfo.php"); ?>
<?php include("functions_before.php"); ?>

<div class="contentbox">
	<div class="contentboxtitle"><span>Quick Answers</span></div>

	<h2>What creature drops 
	<?php
	// Format the resource name
	$namearr = explode("_", $_POST["resource"]);
	echo ucwords($namearr[1] . " " . $namearr[0]); 
	?> 
	on the planet <?php echo $_POST["planet"]; ?>?</h2> 

	<?php
	$restype = "";
	$resamount = "";

	if (strpos($_POST["resource"], 'hide') !== false) {
		$restype = "Hide_Type";
		$resamount = "Hide_Amount";
	} else if (strpos($_POST["resource"], 'meat') !== false) {
		$restype = "Meat_Type";
		$resamount = "Meat_Amount";
	} else if (strpos($_POST["resource"], 'bone') !== false) {
		$restype = "Bone_Type";
		$resamount = "Bone_Amount";
	} else if (strpos($_POST["resource"], 'milk') !== false) {
		$restype = "Milk_Type";
		$resamount = "Milk_Amount";
	}

	// Create connection
	$conn = new mysqli($servername, $username, $password, $dbname);

	// Check connection
	if ($conn->connect_error) {
		die("Connection failed: " . $conn->connect_error);
	}

	//echo $conn->host_info . "<br>";

	// Example: SELECT Creature_Name, Bone_Amount FROM Tarkin_Creatures WHERE Bone_Type = 'bone_avian' AND Planet='Corellia' ORDER BY length(Bone_Amount) DESC, Bone_Amount DESC;
	$sql = "SELECT Creature_Name, Level, Missions_Available, ". $resamount. " FROM Tarkin_Creatures WHERE ". $restype. "='" . $_POST["resource"] . "' AND Planet='" . $_POST["planet"] . "' ORDER BY length(". $resamount. ") DESC, ". $resamount. " DESC";
	$result = $conn->query($sql);

	if ($result->num_rows > 0) {
		echo "<table id='theTable'><tr>
		<th>Creature Name</th>
		<th>Level</th>
		<th>Quantity</th>
		<th>Missions</th>
		</tr>";
		
		// output data of each row
		while($row = $result->fetch_assoc()) {
			echo "</tr>
			<td><a href='#' onclick='loadCreaturePage(\"". $row["Creature_Name"] . "\")'>". ucwords(str_replace("_", " ", $row["Creature_Name"])). "</a></td>
			<td>" . number_format($row["Level"]) . "</td>
			<td>" . formatInt($row[$resamount]) . "</td>
			<td>" . $row["Missions_Available"] . "</td>
			</tr>";
		}
		echo "</table>";
	} else {
		echo "0 results";
	}

	$conn->close();
	?>
	<br />
	<pre><a href="index.php">Back to main page ...</a></pre>
</div>

<?php include("functions_after.php"); ?>
<?php include("design-bottom.php"); ?>

