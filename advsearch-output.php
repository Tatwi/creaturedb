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

<div class="advsearchresult">
	<div class="advsearchtitle"><span>Advanced Search Results</span></div>

	<script type="text/javascript">
		function loadCreaturePage(arg1){
			var pg = "creaturepage.php?argument1=" + arg1;
			window.open(pg);
		}
	</script>

	<?php
	// Helper Functions
	function makePretty($value){
		return ucwords(strtolower(str_replace("_", " ", $value)));
	}
	
	function resistPretty($value){
		$resistvalue = number_format($value);
		if ($resistvalue == -1){
			$resistvalue = "Vulnerable";
		}
		
		return $resistvalue;
	}
	
	function armorRatingIs($value){
		$armorrating = "None";
		if ($value == 1){
			$armorrating = "Light";
		} else if ($value == 2){
			$armorrating = "Medium";
		} else if ($value == 3){
			$armorrating = "Heavy";
		}
		
		return $armorrating;
	}
	
	function specialAttackIs($value){
		if ($value == ""){
			return "None";
		}  else if ($value == "creatureareacombo"){
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
	
	// Input: $conditions, $_POST["oLevel"], $_POST["nLevel"], " Level, "
	function getConditions($con, $op, $num, $str){
		$retvalue = $con;
		$and = "";
		
		if ($con != ""){
			$and = " AND ";
		}
		
		if (empty($op) || empty($num)){
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
	$pMissions = $pTamable = $pMountable = $pDna = $pBe = $pAggressive = $pPassive = false;
	$pDeathblows = $noDb = $pAssists = $noAs = $pStalks = $noSt = $pRanged = false;
	
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
	
	if (isset($_POST["bMissions"])){
		$selections = $selections. " Missions_Available, ";
		$conditions = $conditions. $and. " Missions_Available LIKE 'Yes' ";
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
	
	if (isset($_POST["bAggressiveYes"])){
		$selections = $selections. " PVP_Bitmask, ";
		$conditions = $conditions. $and. " PVP_Bitmask LIKE '%AGGRESSIVE%' ";
		$headings = $headings. "<th>Aggressive</th>";
		$pAggressive = true;
	} else if (isset($_POST["bAggressiveNo"])){
		$selections = $selections. " PVP_Bitmask, ";
		$conditions = $conditions. $and. " PVP_Bitmask NOT LIKE '%AGGRESSIVE%' ";
		$headings = $headings. "<th>Aggressive</th>";
		$pAggressive = true;
		$pPassive = true;
	}
	
	if ($conditions != ""){
		$and = " AND ";
	}
	
	if (isset($_POST["bDeathblowsYes"])){
		$selections = $selections. " Creature_Bitmask, ";
		$conditions = $conditions. $and. " Creature_Bitmask LIKE '%KILLER%' ";
		$headings = $headings. "<th>Deathblows</th>";
		$pDeathblows = true;
	} else if (isset($_POST["bDeathblowsNo"])){
		$selections = $selections. " PVP_Bitmask, ";
		$conditions = $conditions. $and. " Creature_Bitmask NOT LIKE '%KILLER%' ";
		$headings = $headings. "<th>Deathblows</th>";
		$pDeathblows = true;
		$noDb = true;
	}
	
	if ($conditions != ""){
		$and = " AND ";
	}
	
	if (isset($_POST["bAssistsYes"])){
		$selections = $selections. " Creature_Bitmask, ";
		$conditions = $conditions. $and. " Creature_Bitmask LIKE '%PACK%' ";
		$headings = $headings. "<th>Assists</th>";
		$pAssists = true;
	} else if (isset($_POST["bAssistsNo"])){
		$selections = $selections. " Creature_Bitmask, ";
		$conditions = $conditions. $and. " Creature_Bitmask NOT LIKE '%PACK%' ";
		$headings = $headings. "<th>Assists</th>";
		$pAssists = true;
		$noAs = true;
	}
	
	if ($conditions != ""){
		$and = " AND ";
	}
	
	if (isset($_POST["bStalksYes"])){
		$selections = $selections. " Creature_Bitmask, ";
		$conditions = $conditions. $and. " Creature_Bitmask LIKE '%STALKER%' ";
		$headings = $headings. "<th>Stalker</th>";
		$pStalks = true;
	} else if (isset($_POST["bStalksNo"])){
		$selections = $selections. " Creature_Bitmask, ";
		$conditions = $conditions. $and. " Creature_Bitmask NOT LIKE '%STALKER%' ";
		$headings = $headings. "<th>Stalker</th>";
		$pStalks = true;
		$noSt = true;
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

	// Create connection
	$conn = new mysqli($servername, $username, $password, $dbname);

	// Check connection
	if ($conn->connect_error) {
		die("Connection failed: " . $conn->connect_error);
	}
	
	// Add WHERE for conditions
	$where = "";
	if ($conditions != ""){
		$where = "WHERE ";
	}

	//echo $conn->host_info . "<br>";

	// NULL is there to eat the trailing comma left by $selections
	$sql = "SELECT Creature_Name, ". $selections. " NULL FROM Tarkin_Creatures ". $where. $conditions. " ORDER BY Planet, length(Level), Level";
	
	// Debug
	//echo "conditions: ". $conditions. "<br />";
	//echo "lPlanet = ". $_POST["lPlanet"]. "<br />";
	echo "<br />Query: ". $sql. "<br /><br />";
	
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
		echo "<br /><table><tr><th>Creature Name</th>". $headings. "</tr>";
		for ($x = 0; $x < $answersize; $x++) {
			echo "<tr><td><a href='#' onclick='loadCreaturePage(\"". $answer[$x]["Creature_Name"] . "\")'>". makePretty($answer[$x]["Creature_Name"]). "</a></td>";
			
			if ($pPlanet){
				echo "<td>". $answer[$x]["Planet"]. "</td>";
			}
			
			if ($pLevel){
				echo "<td>". number_format($answer[$x]["Level"]). "</td>";
			}
			
			if ($pXp){
				echo "<td>". number_format($answer[$x]["Base_XP"]). "</td>";
			}
			
			if ($pBone){
				echo "<td>". str_replace("Bone", "", makePretty($answer[$x]["Bone_Type"])). "</td><td>". number_format($answer[$x]["Bone_Amount"]). "</td>";
			}
			
			if ($pHide){
				echo "<td>". str_replace("Hide", "", makePretty($answer[$x]["Hide_Type"])). "</td><td>". number_format($answer[$x]["Hide_Amount"]). "</td>";
			}
			
			if ($pMeat){
				echo "<td>". str_replace("Meat", "", makePretty($answer[$x]["Meat_Type"])). "</td><td>". number_format($answer[$x]["Meat_Amount"]). "</td>";
			}
			
			if ($pMilk){
				echo "<td>". str_replace("Milk", "", makePretty($answer[$x]["Milk_Type"])). "</td><td>". number_format($answer[$x]["Milk_Amount"]). "</td>";
			}
			
			if ($pSocialGroup){
				echo "<td>". makePretty($answer[$x]["Social_Group"]). "</td>";
			}
			
			if ($pDiet){
				echo "<td>". makePretty($answer[$x]["Diet"]). "</td>";
			}
			
			if ($pMissions){
				echo "<td>". $answer[$x]["Missions_Available"]. "</td>";
			}
			
			if ($pTamable){
				echo "<td>". number_format($answer[$x]["Taming_Chance"] * 100). "%</td>";
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
				if ($pPassive){
					echo "<td>No</td>";
				} else {
					echo "<td>Yes</td>";
				}
			}
			
			if ($pDeathblows){
				if ($noDb){
					echo "<td>No</td>";
				} else {
					echo "<td>Yes</td>";
				}
			}
			
			if ($pAssists){
				if ($noAs){
					echo "<td>No</td>";
				} else {
					echo "<td>Yes</td>";
				}
			}
			
			if ($pStalks){
				if ($noSt){
					echo "<td>No</td>";
				} else {
					echo "<td>Yes</td>";
				}
			}
			
			if ($pRanged){
				echo "<td>". makePretty(str_replace("creature_spit_small_", "", $answer[$x]["Ranged_Attack"])). "</td>";
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

<?php include("design-bottom.php"); ?>

