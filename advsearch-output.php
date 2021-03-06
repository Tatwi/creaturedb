<html>
<head>
	<meta charset="UFT-8">
	<title>Tarkin's Revenge Creature Database</title>
	<link href="style.css" rel="stylesheet" type="text/css" id="style"/>
	<link href='https://fonts.googleapis.com/css?family=Encode Sans Semi Condensed' rel='stylesheet'>
</head>
<body>
<div class="advsearchmaincontainer">
	<div class="title">
		 <a href="https://tarkinswg.com"><img src="img/title.png" alt="Tarkin's Revenge" style="margin-top:4px;width:454px;height:174px;left:10px;position:relative;float:left;"></a>
		<strong><a href="index.php">Creature Database</a></strong>
		<br />
	</div>
<?php include("dbinfo.php"); ?>
<?php include("functions_before.php"); ?>

<div class="advsearchresult">
	<div class="advsearchtitle"><span>Advanced Search Results</span></div>

	<script type="text/javascript">
		function loadCreaturePage(arg1){
			var pg = "creaturepage.php?argument1=" + arg1;
			window.open(pg);
		}
	</script>

	<?php
	// Input: $conditions, $_POST["oLevel"], $_POST["nLevel"], " Level "
	function getConditions($con, $op, $num, $str){
		$retvalue = $con;
		$and = "";
		
		if ($con != ""){
			$and = " AND ";
		}
		
		if (empty($op)){
			// Any/Failsafe
			$retvalue = $retvalue. $and. $str. " >= 1";
		} else if ($op == "gr"){
			$retvalue = $retvalue. $and. $str. " >= ". $num;
		} else if ($op == "ls"){
			$retvalue = $retvalue. $and. $str. " <= ". $num;
		} else if ($op == "eq"){
			$retvalue = $retvalue. $and. $str. " = ". $num;
		}
		
		return $retvalue;
	}

	// Build-A-Query
	$selections = "";
	$conditions = "";
	$headings = "";
	$and  = "";
	$tmp = "";
	$pPlanet = $pLevel = $pXp = $pBone = $pHide = $pMeat = $pMilk = $pSocialGroup = $pDiet = false;
	$pMissions = $pTamable = $pMountable = $pDna = $pBe = $pAggressive = false;
	$pDeathblows = $pAssists = $pStalks = $pRanged = false;
	$pHam = $pDamage = $pToHit = $pFerocity = $pAttack1 = $pAttack2 = $pArmor = false;
	$resists = array("Kinetic", "Energy", "Blast", "Heat", "Cold", "Electric", "Acid", "Stun", "Lightsaber");
	$pResists = array(false, false, false, false, false, false, false, false, false);
	
	if ($_POST["lPlanet"] == "any"){
		$selections = " Planet, ";
		$headings = "<th>Planet</th>";
		$pPlanet = true;
	} else if ($_POST["lPlanet"] != ""){
		$selections = " Planet, ";
		$conditions = " Planet LIKE '". $_POST["lPlanet"]. "'";
		$headings = "<th>Planet</th>";
		$pPlanet = true;
	}
	
	if ($_POST["oLevel"] != "" && $_POST["nLevel"] > 0){
		$selections = $selections. " Level, ";
		$conditions = getConditions($conditions, $_POST["oLevel"], $_POST["nLevel"], " Level ");
		$headings = $headings. "<th>Level</th>";
		$pLevel = true;
	}
	
	if ($_POST["oXp"] != "" && $_POST["nXp"] > 0){
		$selections = $selections. " Base_XP, ";
		$conditions = getConditions($conditions, $_POST["oXp"], $_POST["nXp"], " Base_XP ");
		$headings = $headings. "<th>XP</th>";
		$pXp = true;
	}
	
	if ($_POST["lBone"] == "any"){
		$selections = $selections. " Bone_Type, Bone_Amount, ";
		$conditions = getConditions($conditions, $_POST["oBone"], $_POST["nBone"], " Bone_Amount ");
		$headings = $headings. "<th>Bone Type</th><th>Bone Amount</th>";
		$pBone = true;
	} else if ($_POST["lBone"] != "" && $_POST["oBone"] != "" && $_POST["nBone"] > 0){
		$selections = $selections. " Bone_Type, Bone_Amount, ";
		$conditions = getConditions($conditions, $_POST["oBone"], $_POST["nBone"], " Bone_Amount "). " AND Bone_Type LIKE '". $_POST["lBone"]. "' ";
		$headings = $headings. "<th>Bone Type</th><th>Bone Amount</th>";
		$pBone = true;
	}
	
	if ($_POST["lHide"] == "any"){
		$selections = $selections. " Hide_Type, Hide_Amount, ";
		$conditions = getConditions($conditions, $_POST["oHide"], $_POST["nHide"], " Hide_Amount ");
		$headings = $headings. "<th>Hide Type</th><th>Hide Amount</th>";
		$pHide = true;
	} else if ($_POST["lHide"] != "" && $_POST["oHide"] != "" && $_POST["nHide"] > 0){
		$selections = $selections. " Hide_Type, Hide_Amount, ";
		$conditions = getConditions($conditions, $_POST["oHide"], $_POST["nHide"], " Hide_Amount "). " AND Hide_Type LIKE '". $_POST["lHide"]. "' ";
		$headings = $headings. "<th>Hide Type</th><th>Hide Amount</th>";
		$pHide = true;
	}
	
	if ($_POST["lMeat"] == "any"){
		$selections = $selections. " Meat_Type, Meat_Amount, ";
		$conditions = getConditions($conditions, $_POST["oMeat"], $_POST["nMeat"], " Meat_Amount ");
		$headings = $headings. "<th>Meat Type</th><th>Meat Amount</th>";
		$pMeat = true;
	} else if ($_POST["lMeat"] != "" && $_POST["oMeat"] != "" && $_POST["nMeat"] > 0){
		$selections = $selections. " Meat_Type, Meat_Amount, ";
		$conditions = getConditions($conditions, $_POST["oMeat"], $_POST["nMeat"], " Meat_Amount "). " AND Meat_Type LIKE '". $_POST["lMeat"]. "' ";
		$headings = $headings. "<th>Meat Type</th><th>Meat Amount</th>";
		$pMeat = true;
	}
	
	if ($_POST["lMilk"] == "any"){
		$selections = $selections. " Milk_Type, Milk_Amount, ";
		$conditions = getConditions($conditions, $_POST["oMilk"], $_POST["nMilk"], " Milk_Amount ");
		$headings = $headings. "<th>Milk Type</th><th>Milk Amount</th>";
		$pMilk = true;
	} else if ($_POST["lMilk"] != "" && $_POST["oMilk"] != "" && $_POST["nMilk"] > 0){
		$selections = $selections. " Milk_Type, Milk_Amount, ";
		$conditions = getConditions($conditions, $_POST["oMilk"], $_POST["nMilk"], " Milk_Amount "). " AND Milk_Type LIKE '". $_POST["lMilk"]. "' ";
		$headings = $headings. "<th>Milk Type</th><th>Milk Amount</th>";
		$pMilk = true;
	}
	
	if ($conditions != ""){
		$and = " AND ";
	}
	
	if ($_POST["lSocialGroup"] == "any"){
		$selections = $selections. " Social_Group, ";
		$headings = $headings. "<th>Social Group</th>";
		$pSocialGroup = true;
	} else if ($_POST["lSocialGroup"] != ""){
		$selections = $selections. " Social_Group, ";
		$conditions = $conditions. $and. " Social_Group LIKE '". $_POST["lSocialGroup"]. "' ";
		$headings = $headings. "<th>Social Group</th>";
		$pSocialGroup = true;
	}
	
	if ($conditions != ""){
		$and = " AND ";
	}
	
	if ($_POST["lDiet"] == "any"){
		$selections = $selections. " Diet, ";
		$headings = $headings. "<th>Diet</th>";
		$pDiet = true;
	} else if ($_POST["lDiet"] != ""){
		$selections = $selections. " Diet, ";
		$conditions = $conditions. $and. " Diet LIKE '". $_POST["lDiet"]. "' ";
		$headings = $headings. "<th>Diet</th>";
		$pDiet = true;
	}
	
	if ($conditions != ""){
		$and = " AND ";
	}
	
	if ($_POST["lMissions"] == "Yes"){
		$selections = $selections. " Missions_Available, ";
		$conditions = $conditions. $and. " Missions_Available LIKE 'Yes' ";
		$headings = $headings. "<th>Missions</th>";
		$pMissions = true;
	} else if ($_POST["lMissions"] == "No"){
		$selections = $selections. " Missions_Available, ";
		$conditions = $conditions. $and. " Missions_Available LIKE 'No' ";
		$headings = $headings. "<th>Missions</th>";
		$pMissions = true;
	} else if ($_POST["lMissions"] == "any"){
		$selections = $selections. " Missions_Available, ";
		$headings = $headings. "<th>Missions</th>";
		$pMissions = true;
	}
	
	if ($conditions != ""){
		$and = " AND ";
	}
	
	if (isset($_POST["bTamable"])){
		$selections = $selections. " Taming_Chance, ";
		$conditions = $conditions. $and. " Taming_Chance > 0 ";
		$headings = $headings. "<th>Tamable</th>";
		$pTamable = true;
	}
	
	if ($conditions != ""){
		$and = " AND ";
	}
	
	if (isset($_POST["bMountable"])){
		$selections = $selections. " Mount, ";
		$conditions = $conditions. $and. " Mount LIKE 'Yes' ";
		$headings = $headings. "<th>Mountable</th>";
		$pMountable = true;
	}
	
	if ($conditions != ""){
		$and = " AND ";
	}
	
	if (isset($_POST["bDna"])){
		$selections = $selections. " BE_Can_Sample, ";
		$conditions = $conditions. $and. " BE_Can_Sample LIKE 'Yes' ";
		$headings = $headings. "<th>DNA</th>";
		$pDna = true;
	}
	
	if ($conditions != ""){
		$and = " AND ";
	}
	
	if (isset($_POST["bBe"])){
		$selections = $selections. " BE_Craftable, ";
		$conditions = $conditions. $and. " BE_Craftable LIKE 'Yes' ";
		$headings = $headings. "<th>BE Craftable</th>";
		$pBe = true;
	}
	
	if ($conditions != ""){
		$and = " AND ";
	}
	
	if ($_POST["lAggressive"] == "Yes"){
		$selections = $selections. " PVP_Bitmask, ";
		$conditions = $conditions. $and. " PVP_Bitmask LIKE '%AGGRESSIVE%' ";
		$headings = $headings. "<th>Aggressive</th>";
		$pAggressive = true;
	} else if ($_POST["lAggressive"] == "No"){
		$selections = $selections. " PVP_Bitmask, ";
		$conditions = $conditions. $and. " PVP_Bitmask NOT LIKE '%AGGRESSIVE%' ";
		$headings = $headings. "<th>Aggressive</th>";
		$pAggressive = true;
	} else if ($_POST["lAggressive"] == "any"){
		$selections = $selections. " PVP_Bitmask, ";
		$headings = $headings. "<th>Aggressive</th>";
		$pAggressive = true;
	}
	
	if ($conditions != ""){
		$and = " AND ";
	}
	
	if ($_POST["lDeathblows"] == "Yes"){
		$selections = $selections. " Creature_Bitmask, ";
		$conditions = $conditions. $and. " Creature_Bitmask LIKE '%KILLER%' ";
		$headings = $headings. "<th>Deathblows</th>";
		$pDeathblows = true;
	} else if ($_POST["lDeathblows"] == "No"){
		$selections = $selections. " Creature_Bitmask, ";
		$conditions = $conditions. $and. " Creature_Bitmask NOT LIKE '%KILLER%' ";
		$headings = $headings. "<th>Deathblows</th>";
		$pDeathblows = true;
	} else if ($_POST["lDeathblows"] == "any"){
		$selections = $selections. " Creature_Bitmask, ";
		$headings = $headings. "<th>Deathblows</th>";
		$pDeathblows = true;
	}
	
	if ($conditions != ""){
		$and = " AND ";
	}
	
	if ($_POST["lAssists"] == "Yes"){
		$selections = $selections. " Creature_Bitmask, ";
		$conditions = $conditions. $and. " Creature_Bitmask LIKE '%PACK%' ";
		$headings = $headings. "<th>Assists</th>";
		$pAssists = true;
	} else if ($_POST["lAssists"] == "No"){
		$selections = $selections. " Creature_Bitmask, ";
		$conditions = $conditions. $and. " Creature_Bitmask NOT LIKE '%PACK%' ";
		$headings = $headings. "<th>Assists</th>";
		$pAssists = true;
	} else if ($_POST["lAssists"] == "any"){
		$selections = $selections. " Creature_Bitmask, ";
		$headings = $headings. "<th>Assists</th>";
		$pAssists = true;
	} 
	
	if ($conditions != ""){
		$and = " AND ";
	}
	
	if ($_POST["lStalks"] == "Yes"){
		$selections = $selections. " Creature_Bitmask, ";
		$conditions = $conditions. $and. " Creature_Bitmask LIKE '%STALKER%' ";
		$headings = $headings. "<th>Stalker</th>";
		$pStalks = true;
	} else if ($_POST["lStalks"] == "No"){
		$selections = $selections. " Creature_Bitmask, ";
		$conditions = $conditions. $and. " Creature_Bitmask NOT LIKE '%STALKER%' ";
		$headings = $headings. "<th>Stalker</th>";
		$pStalks = true;
	} else if ($_POST["lStalks"] == "any"){
		$selections = $selections. " Creature_Bitmask, ";
		$headings = $headings. "<th>Stalker</th>";
		$pStalks = true;
	}
	
	if ($conditions != ""){
		$and = " AND ";
	}
	
	if (isset($_POST["bRanged"])){
		$selections = $selections. " Ranged_Attack, ";
		$conditions = $conditions. $and. " Ranged_Attack IS NOT NULL ";
		$headings = $headings. "<th>Ranged Attack</th>";
		$pRanged = true;
	}
	
	if ($_POST["oHam"] != "" && $_POST["nHam"] > 0){
		$selections = $selections. " Base_HAM, ";
		$conditions = getConditions($conditions, $_POST["oHam"], $_POST["nHam"], " Base_HAM ");
		$headings = $headings. "<th>HAM</th>";
		$pHam = true;
	}
	
	if ($_POST["oDamage"] != "" && $_POST["nDamage"] > 0 && !isset($_POST["bDamage"])){
		$selections = $selections. " Min_Damage, Max_Damage, ";
		$conditions = getConditions($conditions, $_POST["oDamage"], $_POST["nDamage"], " Max_Damage ");
		$headings = $headings. "<th>Min Damage</th><th>Max Damage</th>";
		$pDamage = true;
	} else if ($_POST["oDamage"] != "" && $_POST["nDamage"] > 0 && isset($_POST["bDamage"])){
		$selections = $selections. " Min_Damage, Max_Damage, ";
		$conditions = getConditions($conditions, $_POST["oDamage"], $_POST["nDamage"], " Min_Damage ");
		$headings = $headings. "<th>Min Damage</th><th>Max Damage</th>";
		$pDamage = true;
	}
	
	if ($_POST["oToHit"] != "" && $_POST["nToHit"] > 0){
		$selections = $selections. " Chance_to_Hit, ";
		$conditions = getConditions($conditions, $_POST["oToHit"], $_POST["nToHit"], " Chance_to_Hit ");
		$headings = $headings. "<th>Hit Chance</th>";
		$pToHit = true;
	}
	
	if ($_POST["oFerocity"] != "" && $_POST["nFerocity"] > 0){
		$selections = $selections. " Ferocity, ";
		$conditions = getConditions($conditions, $_POST["oFerocity"], $_POST["nFerocity"], " Ferocity ");
		$headings = $headings. "<th>Ferocity</th>";
		$pFerocity = true;
	}
	
	if ($conditions != ""){
		$and = " AND ";
	}
	
	if ($_POST["lAttack1"] == "any"){
		$selections = $selections. " Attack_1, ";
		$conditions = $conditions. $and. " Attack_1 IS NOT NULL ";
		$headings = $headings. "<th>Attack 1</th>";
		$pAttack1 = true;
	} else if ($_POST["lAttack1"] != ""){
		$selections = $selections. " Attack_1, ";
		$conditions = $conditions. $and. " Attack_1 LIKE '". $_POST["lAttack1"]. "' ";
		$headings = $headings. "<th>Attack 1</th>";
		$pAttack1 = true;
	}
	
	if ($conditions != ""){
		$and = " AND ";
	}
	
	if ($_POST["lAttack2"] == "any"){
		$selections = $selections. " Attack_2, ";
		$conditions = $conditions. $and. " Attack_2 IS NOT NULL ";
		$headings = $headings. "<th>Attack 2</th>";
		$pAttack2 = true;
	} else if ($_POST["lAttack2"] != ""){
		$selections = $selections. " Attack_2, ";
		$conditions = $conditions. $and. " Attack_2 LIKE '". $_POST["lAttack2"]. "' ";
		$headings = $headings. "<th>Attack 2</th>";
		$pAttack2 = true;
	}
	
	if ($conditions != ""){
		$and = " AND ";
	}
	
	if ($_POST["lArmor"] == "any"){
		$selections = $selections. " Armor, ";
		$headings = $headings. "<th>Armor Rating</th>";
		$pArmor = true;
	} else if ($_POST["lArmor"] != ""){
		$selections = $selections. " Armor, ";
		$conditions = $conditions. $and. " Armor = ". $_POST["lArmor"]. " ";
		$headings = $headings. "<th>Armor Rating</th>";
		$pArmor = true;
	}
	
	for ($x = 0; $x < 11; $x++){
		if ($_POST["o". $resists[$x]] != "" && (int)$_POST["n". $resists[$x]] >= -1){
			$selections = $selections. " $resists[$x], ";
			$conditions = getConditions($conditions, $_POST["o". $resists[$x]], $_POST["n". $resists[$x]], " $resists[$x] ");
			$headings = $headings. "<th>$resists[$x]</th>";
			$pResists[$x] = true;
		}
	}
	
	// Add WHERE for conditions
	$where = "";
	if ($conditions != ""){
		$where = "WHERE ";
	}
	
	// Order By
	$dir = "DESC";
	if (isset($_POST["obAsc"])){
		$dir = "ASC";
	}
	
	// NULL prevents empty ORDER BY
	$orderby = " ORDER BY NULL";
	
	if (isset($_POST["obPlanet"])){
		$orderby = $orderby. ", Planet";
	}
	
	if (isset($_POST["obLevel"])){
		$orderby = $orderby. ", length(Level) $dir, Level $dir";
	}
	
	if (isset($_POST["obXp"])){
		$orderby = $orderby. ", length(Base_XP) $dir, Base_XP $dir";
	}
	
	if (isset($_POST["obBone"])){
		$orderby = $orderby. ", length(Bone_Amount) $dir, Bone_Amount $dir";
	}
	
	if (isset($_POST["obHide"])){
		$orderby = $orderby. ", length(Hide_Amount) $dir, Hide_Amount $dir";
	}
	
	if (isset($_POST["obMeat"])){
		$orderby = $orderby. ", length(Meat_Amount) $dir, Meat_Amount $dir";
	}
	
	if (isset($_POST["obMilk"])){
		$orderby = $orderby. ", length(Milk_Amount) $dir, Milk_Amount $dir";
	}
	
	if (isset($_POST["obSocialGroup"])){
		$orderby = $orderby. ", Social_Group";
	}
	
	if (isset($_POST["obDiet"])){
		$orderby = $orderby. ", Diet";
	}
	
	if (isset($_POST["obHam"])){
		$orderby = $orderby. ", length(Base_HAM) $dir, Base_HAM $dir";
	}
	
	if (isset($_POST["obDamage"])){
		$orderby = $orderby. ", length(Damage) $dir, Damage $dir";
	}
	
	if (isset($_POST["obToHit"])){
		$orderby = $orderby. ", length(Chance_to_Hit) $dir, Chance_to_Hit $dir";
	}
	
	if (isset($_POST["obFerocity"])){
		$orderby = $orderby. ", length(Ferocity) $dir, Ferocity $dir";
	}
	
	if (isset($_POST["obAttack1"])){
		$orderby = $orderby. ", Attack_1";
	}
	
	if (isset($_POST["obAttack2"])){
		$orderby = $orderby. ", Attack_2";
	}
	
	if (isset($_POST["obArmor"])){
		$orderby = $orderby. ", Armor";
	}
	
	for ($x = 0; $x < 11; $x++){
		if (isset($_POST["ob". $resists[$x]])){
			$orderby = $orderby. ", length(". $resists[$x]. ") $dir, ". $resists[$x]. " $dir";
		}
	}

	// Create connection
	$conn = new mysqli($servername, $username, $password, $dbname);

	// Check connection
	if ($conn->connect_error) {
		die("Connection failed: " . $conn->connect_error);
	}

	//echo $conn->host_info . "<br>";

	// NULL is there to eat the trailing comma left by $selections
	$sql = "SELECT Creature_Name, ". $selections. " NULL FROM Tarkin_Creatures ". $where. $conditions. $orderby;
	
	$result = $conn->query($sql);
	$answer = array();
	$answercntr = 0;
	$results = true;
	
	if ($result->num_rows > 0) {
		while($row = $result->fetch_assoc()) {
			$answer[$answercntr] = $row;
			$answercntr++;
		}
	} else {
		$results = false;
	}
	
	$answersize = count($answer);
	
	if ($results){
		echo "<br /><table id='theTable'><tr><th>Creature Name</th>". $headings. "</tr>";
		for ($x = 0; $x < $answersize; $x++) {
			echo "<tr><td><a href='#' onclick='loadCreaturePage(\"". $answer[$x]["Creature_Name"] . "\")'>". makePretty($answer[$x]["Creature_Name"]). "</a></td>";
			
			if ($pPlanet){
				echo "<td>". $answer[$x]["Planet"]. "</td>";
			}
			
			if ($pLevel){
				echo "<td>". number_format($answer[$x]["Level"]). "</td>";
			}
			
			if ($pXp){
				echo "<td>". formatInt($answer[$x]["Base_XP"]). "</td>";
			}
			
			if ($pBone){
				echo "<td>". str_replace("Bone", "", makePretty($answer[$x]["Bone_Type"])). "</td><td>". formatInt($answer[$x]["Bone_Amount"]). "</td>";
			}
			
			if ($pHide){
				echo "<td>". str_replace("Hide", "", makePretty($answer[$x]["Hide_Type"])). "</td><td>". formatInt($answer[$x]["Hide_Amount"]). "</td>";
			}
			
			if ($pMeat){
				echo "<td>". str_replace("Meat", "", makePretty($answer[$x]["Meat_Type"])). "</td><td>". formatInt($answer[$x]["Meat_Amount"]). "</td>";
			}
			
			if ($pMilk){
				echo "<td>". str_replace("Milk", "", makePretty($answer[$x]["Milk_Type"])). "</td><td>". formatInt($answer[$x]["Milk_Amount"]). "</td>";
			}
			
			if ($pSocialGroup){
				echo "<td>". makePretty($answer[$x]["Social_Group"]). "</td>";
			}
			
			if ($pDiet){
				echo "<td>". makePretty($answer[$x]["Diet"]). "</td>";
			}
			
			if ($pMissions){
				if (strpos($answer[$x]["Missions_Available"], 'Yes') !== false){
					echo "<td>Yes</td>";
				} else {
					echo "<td>No</td>";
				}
			}
			
			if ($pTamable){
				echo "<td>". formatInt($answer[$x]["Taming_Chance"] * 100). "%</td>";
			}
			
			if ($pMountable){
				echo "<td>". $answer[$x]["Mount"]. "</td>";
			}
			
			if ($pDna){
				echo "<td>". $answer[$x]["BE_Can_Sample"]. "</td>";
			}
			
			if ($pBe){
				echo "<td>". $answer[$x]["BE_Craftable"]. "</td>";
			}
			
			if ($pAggressive){
				if (strpos($answer[$x]["PVP_Bitmask"], 'AGGRESSIVE') !== false){
					echo "<td>Yes</td>";
				} else {
					echo "<td>No</td>";
				}
			}
			
			if ($pDeathblows){
				if (strpos($answer[$x]["Creature_Bitmask"], 'KILLER') !== false){
					echo "<td>Yes</td>";
				} else {
					echo "<td>No</td>";
				}
			}
			
			if ($pAssists){
				if (strpos($answer[$x]["Creature_Bitmask"], 'PACK') !== false){
					echo "<td>Yes</td>";
				} else {
					echo "<td>No</td>";
				}
			}
			
			if ($pStalks){
				if (strpos($answer[$x]["Creature_Bitmask"], 'STALKER') !== false){
					echo "<td>Yes</td>";
				} else {
					echo "<td>No</td>";
				}
			}
			
			if ($pRanged){
				echo "<td>". makePretty(str_replace("creature_spit_small_", "", $answer[$x]["Ranged_Attack"])). "</td>";
			}
			
			if ($pHam){
				echo "<td>". formatInt($answer[$x]["Base_HAM"]). "</td>";
			}
			
			if ($pDamage){
				echo "<td>". formatInt($answer[$x]["Min_Damage"]). "</td><td>". formatInt($answer[$x]["Max_Damage"]). "</td>";
			}
			
			if ($pToHit){
				echo "<td>". $answer[$x]["Chance_to_Hit"]. "</td>";
			}
			
			if ($pFerocity){
				echo "<td>". formatInt($answer[$x]["Ferocity"]). "</td>";
			}
			
			if ($pAttack1){
				echo "<td>". specialAttackIs($answer[$x]["Attack_1"]). "</td>";
			}
			
			if ($pAttack2){
				echo "<td>". specialAttackIs($answer[$x]["Attack_2"]). "</td>";
			}
			
			if ($pArmor){
				echo "<td>". armorRatingIs($answer[$x]["Armor"]). "</td>";
			}
			
			for ($y = 0; $y < 11; $y++){
				if ($pResists[$y]){
					echo "<td>". formatInt($answer[$x][$resists[$y]]). "</td>";
				}
			}
			
			echo"</tr>";
		}
		echo "</table><p>". $answersize. " Reults Found</p>";
	} else{
		echo "<p>Sorry, no results were found. Have a look over the conditions and values, make your changes, and try again.
		</p>
		<p>
		Use the Back button in your browser rather than the <em>Back to main page ...</em> link below to avoid resetting the form.
		</p>";
	}

	$conn->close();
	?>
	<br />
	<pre><a href="index.php">Back to main page ...</a></pre>
</div>

<?php include("functions_after.php"); ?>
<?php include("design-bottom.php"); ?>