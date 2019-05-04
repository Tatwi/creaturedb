<?php include("design-top.php"); ?>
<?php include("dbinfo.php"); ?>
	
	<div class="contentbox">
		<div class="contentboxtitle"><span>Creature Information</span></div>
		
		<?php
		// Helper functions
		function resistPretty($value){
			$resistvalue = number_format($value);
			if ($resistvalue == -1){
				$resistvalue = "Vulnerable";
			}
			
			return $resistvalue;
		}
		
		function makePretty($value){
			return ucwords(strtolower(str_replace("_", " ", $value)));
		}
		
		function specialAttackIs($value){
			if ($value == ""){
				return "None";
			} else if ($value == ""){
			
			} else if ($value == "creatureareacombo"){
				return "Area Combo";
			} else if ($value == "blindattack"){
				return "Blinding Strike";
			} else if ($value == "creatureareaattack"){
				return "Creature Area Attack";
			} else if ($value == "posturedownattack"){
				return "Crippling Strike";
			} else if ($value == "dizzyattack"){
				return "Dizzy Strike";
			} else if ($value == "creatureareaknockdown"){
				return "Force Strike";
			} else if ($value == "intimidationattack"){
				return "Intimidation";
			} else if ($value == "knockdownattack"){
				return "Knockdown";
			} else if ($value == "mediumdisease"){
				return "Medium Disease";
			} else if ($value == "mediumpoison"){
				return "Medium Poison";
			} else if ($value == "milddisease"){
				return "Mild Disease";
			} else if ($value == "mildpoison"){
				return "Mild Poison";
			} else if ($value == "creatureareableeding"){
				return "Open Wounds";
			} else if ($value == "creatureareadisease"){
				return "Plague Strike";
			} else if ($value == "creatureareapoison"){
				return "Poison Spray";
			} else if ($value == "strongdisease"){
				return "Strong Disease";
			} else if ($value == "strongpoison"){
				return "Strong Poison";
			} else if ($value == "stunattack"){
				return "Stunning Strike";
			} 
			
			// There are a few cases the value will be NA
			return $value;
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
			echo "<h2>". makePretty($argument1) . "</h2>";
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

			echo "<b>Special Attack 1:</b> ". specialAttackIs($row["Attack_1"]). "<br />";
			echo "<b>Special Attack 2:</b> ". specialAttackIs($row["Attack_2"]). "<br />";
			
			$attackranged = $row["Ranged_Attack"];
			if ($attackranged == ""){
				$attackranged = "No";
			} else {
				$attackranged = "Yes";
			}
			echo "<b>Has Ranged Attack:</b> ". $attackranged. "<br />";
			
			$armorrating = "None";
			if ($row["Armor"] == 1){
				$armorrating = "Light";
			} else if ($row["Armor"] == 2){
				$armorrating = "Medium";
			} else if ($row["Armor"] == 3){
				$armorrating = "Heavy";
			} 
			echo "<b>Armor Rating:</b> ". $armorrating. "<br />";
			
			echo "<b>Kinetic Resistance:</b> ". resistPretty($row["Kinetic"]). "<br />";
			echo "<b>Energy Resistance:</b> ". resistPretty($row["Energy"]). "<br />";
			echo "<b>Blast Resistance:</b> ". resistPretty($row["Blast"]). "<br />";
			echo "<b>Heat Resistance:</b> ". resistPretty($row["Heat"]). "<br />";
			echo "<b>Cold Resistance:</b> ". resistPretty($row["Cold"]). "<br />";
			echo "<b>Electric Resistance:</b> ". resistPretty($row["Electric"]). "<br />";
			echo "<b>Acid Resistance:</b> ". resistPretty($row["Acid"]). "<br />";
			echo "<b>Stun Resistance:</b> ". resistPretty($row["Stun"]). "<br />";
			echo "<b>Lightsaber Resistance:</b> " . resistPretty($row["Lightsaber"]) . "</div>";
			
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
			
			// Galaxy Harvester links
			$ghurl = "http://galaxyharvester.net/resourceList.py?planet=";
			
			if ($row["Planet"] == "Corellia"){
				$ghurl = $ghurl. "1";
			} else if ($row["Planet"] == "Dantooine"){
				$ghurl = $ghurl. "2";
			} else if ($row["Planet"] == "Dathomir"){
				$ghurl = $ghurl. "3";
			} else if ($row["Planet"] == "Endor"){
				$ghurl = $ghurl. "4";
			} else if ($row["Planet"] == "Lok"){
				$ghurl = $ghurl. "5";
			} else if ($row["Planet"] == "Naboo"){
				$ghurl = $ghurl. "6";
			} else if ($row["Planet"] == "Rori"){
				$ghurl = $ghurl. "7";
			} else if ($row["Planet"] == "Talus"){
				$ghurl = $ghurl. "8";
			} else if ($row["Planet"] == "Tatooine"){
				$ghurl = $ghurl. "9";
			} else if ($row["Planet"] == "Yavin"){
				$ghurl = $ghurl. "10";
			} 
			
			$boneurl = $ghurl. "&rgroup=creature_resources&rtype=". $row["Bone_Type"]. "_". strtolower($row["Planet"]);
			$hideurl = $ghurl. "&rgroup=creature_resources&rtype=". $row["Hide_Type"]. "_". strtolower($row["Planet"]);
			$meaturl = $ghurl. "&rgroup=creature_resources&rtype=". $row["Meat_Type"]. "_". strtolower($row["Planet"]);
			$milkurl = $ghurl. "&rgroup=creature_resources&rtype=". $row["Milk_Type"]. "_". strtolower($row["Planet"]);
			
			if ($row["Bone_Amount"] > 0){
				echo "<b>Bone:</b> <a href='$boneurl' target='_blank'>". str_replace("Bone", "", makePretty($row["Bone_Type"])). "</a> ". number_format($row["Bone_Amount"])." <br />";
			} else {
				echo "<b>Bone:</b> None<br />";
			}
			
			if ($row["Hide_Amount"] > 0){
				echo "<b>Hide:</b>  <a href='$hideurl' target='_blank'>". str_replace("Hide", "", makePretty($row["Hide_Type"])). "</a> ". number_format($row["Hide_Amount"])." <br />";
			} else {
				echo "<b>Hide:</b> None<br />";
			}
			
			if ($row["Meat_Amount"] > 0){
				echo "<b>Meat:</b>  <a href='$meaturl' target='_blank'>". str_replace("Meat", "", makePretty($row["Meat_Type"])). "</a> ". number_format($row["Meat_Amount"])." <br />";
			} else {
				echo "<b>Meat:</b> None<br />";
			}
			
			if ($row["Milk_Amount"] > 0){
				echo "<b>Milk:</b>  <a href='$milkurl' target='_blank'>". str_replace("Milk", "", makePretty($row["Milk_Type"])). "</a> ". number_format($row["Milk_Amount"])." <br /><br />";
			} else {
				echo "<b>Milk:</b> None<br /><br />";
			}
			
			if ($row["Taming_Chance"] > 0) {
				echo "<b>Tamable:</b> Yes<br />";
			} else {
				echo "<b>Tamable:</b> No<br />";
			}
			
			echo "<b>Ferocity:</b> ". number_format($row["Ferocity"]). "<br />";
			echo "<b>Mountable:</b> ". $row["Mount"]. "<br />";
			echo "<b>Can Sample DNA:</b> ". $row["BE_Can_Sample"]. "<br />";
			echo "<b>Bio-Engineer Craftable:</b> ". $row["BE_Craftable"]. "</div>";
		} else {
			echo "Unable to load creature data at this time.";
		}
		
		$conn->close();
		?>
		
	</div>

<?php include("design-bottom.php"); ?>