<?php include("design-top.php"); ?>
	
	<div class="contentbox">
		<div class="contentboxtitle"><span>Creature Information</span></div>
		
		<?php
		// Helper functions
		function checkVulnerable($value){
			if ($value < 0) {
				return "Vulnerable";
			}
			
			return number_format($value);
		}
		
		function makePretty($value){
			return ucwords(strtolower(str_replace("_", " ", $value)));
		}
		
		$argument1 = $_GET['argument1'];
		
		// Creature Image
		$filename = 'img/creatures/'. $argument1. '.jpg' ;
		
		if (file_exists($filename)) {
			echo "<img src='". $filename. "' alt='An image of the creature...' class='portrait'>";
		} else {
			echo "<img src='img/creatures/default.jpg' alt='No image could be found!' class='portrait'>";
		}

		// Format the creature name
		$namearr = str_replace("_", " ", $argument1);
		echo "<h2>". makePretty($argument1) . "</h2>"; 

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

		//echo $conn->host_info . "<br>";

		// Example: SELECT * FROM Tarkin_Creatures WHERE Creature_Name='reptilian_flier';
		$sql = "SELECT * FROM Tarkin_Creatures WHERE Creature_Name='" . $argument1. "'";
		$result = $conn->query($sql);

		if ($result->num_rows > 0) {
			$row = $result->fetch_assoc();
			// HAM bar under creature image
			echo "<div class='hambar'><span><b>HAM:</b> ". number_format($row["Base_HAM"]). " / " . number_format($row["Base_HAM_Max"]). "</span>";
			echo "<br /><span><b>Damage:</b> ". number_format($row["Min_Damage"]). " - " . number_format($row["Max_Damage"]). "</span>";
			echo "<br /><span><b>Chance to Hit:</b> ". number_format($row["Chance_to_Hit"]). " </span></div>";
			
			echo "<div class='crgeninfo'>";
			echo "<b>Planet:</b> ". $row["Planet"]. "<br />";
			echo "<b>Level:</b> ". number_format($row["Level"]). "<br />";
			
			if ($row["Missions_Available"] == "Yes"){
				echo "<b>Missions Available:</b> Yes<br />";
			} else {
				echo "<b>Missions Available:</b> No<br />";
			}
			
			echo "<b>XP Amount:</b> " . number_format($row["Base_XP"]). "</div>";
			
			// Combat Information
			echo "<div class='crcombat'><div class='crcombattitle'>Combat Information</div>";
		
		$attack1 = $row["Attack_1"];
		if ($attack1 == ""){
			$attack1 = "None";
		}
		echo "<b>Special Attack 1:</b> ". $attack1. "<br />";
		
		$attack2 = $row["Attack_2"];
		if ($attack2 == ""){
			$attack2 = "None";
		}
		echo "<b>Special Attack 2:</b> ". $attack2. "<br />";
		
		$attackranged = $row["Ranged_Attack"];
		if ($attackranged == ""){
			$attackranged = "No";
		} else {
			$attackranged = "Yes";
		}
		echo "<b>Has Ranged Attack:</b> ". $attackranged. "<br /><br />";
		
		echo "<b>Kinetic Resistance:</b> ". checkVulnerable($row["Kinetic"]). "<br />";
		echo "<b>Energy Resistance:</b> ". checkVulnerable($row["Energy"]). "<br />";
		echo "<b>Blast Resistance:</b> ". checkVulnerable($row["Blast"]). "<br />";
		echo "<b>Heat Resistance:</b> ". checkVulnerable($row["Heat"]). "<br />";
		echo "<b>Cold Resistance:</b> ". checkVulnerable($row["Cold"]). "<br />";
		echo "<b>Electric Resistance:</b> ". checkVulnerable($row["Electric"]). "<br />";
		echo "<b>Acid Resistance:</b> ". checkVulnerable($row["Acid"]). "<br />";
		echo "<b>Stun Resistance:</b> ". checkVulnerable($row["Stun"]). "<br />";
		
		echo "<b>Lightsaber Resistance:</b> " . checkVulnerable($row["Lightsaber"]) . "</div>";
		
		// Biographical Data
		echo "<div class='crbio'><div class='crbiotitle'>Biographical Data</div>";
		echo "<b>Social Group:</b> ". makePretty($row["Social_Group"]). "<br />";
		echo "<b>Diet:</b> ". makePretty($row["Diet"]). "<br />";
		
		if (strpos($row["PVP_Bitmask"], 'AGGRESSIVE') !== false) {
			echo "<b>Aggressive:</b> Yes<br />";
		} else {
			echo "<b>Aggressive:</b> No<br />";
		}

		$deathblow = $row["PVP_Bitmask"];
		if (strpos($row["Creature_Bitmask"], 'KILLER') !== false) {
			echo "<b>Deathblows:</b> Yes<br />";
		} else {
			echo "<b>Deathblows:</b> No<br />";
		}
		
		if (strpos($row["Creature_Bitmask"], 'PACK') !== false) {
			echo "<b>Assists Allies:</b> Yes<br />";
		} else {
			echo "<b>Assists Allies:</b> No<br />";
		}
		
		if (strpos($row["Creature_Bitmask"], 'STALKER') !== false) {
			echo "<b>Stalks Prey:</b> Yes<br /><br />";
		} else {
			echo "<b>Stalks Prey:</b> No<br /><br />";
		}
		
		echo "<b>Bone:</b> ". str_replace("Bone", "", makePretty($row["Bone_Type"])). " ". number_format($row["Bone_Amount"])." <br />";
		echo "<b>Hide:</b> ". str_replace("Hide", "", makePretty($row["Hide_Type"])). " ". number_format($row["Hide_Amount"])." <br />";
		echo "<b>Meat:</b> ". str_replace("Meat", "", makePretty($row["Meat_Type"])). " ". number_format($row["Meat_Amount"])." <br />";
		echo "<b>Milk:</b> ". str_replace("Milk", "", makePretty($row["Milk_Type"])). " ". number_format($row["Milk_Amount"])." <br /><br />";
		
		if ($row["Taming_Chance"] > 0) {
			echo "<b>Tamable:</b> Yes<br />";
		} else {
			echo "<b>Tamable:</b> No<br />";
		}
		
		echo "<b>Ferocity:</b> ". number_format($row["Ferocity"]). "<br />";
		echo "<b>Mountable:</b> ". $row["Mount"]. "<br />";
		echo "<b>Can Sample DNA:</b> ". $row["BE_Can_Sample"]. "<br />";
		echo "<b>Bio-Engineer Craftable:</b> ". $row["BE_Craftable"]. "<br />";
		} else {
			echo "0 results";
		}
		
		$conn->close();
		?>
		<br />
	</div>

<?php include("design-bottom.php"); ?>