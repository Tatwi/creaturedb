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

	// Build-A-Query
	$selections = "";
	$conditions = "";
	$orderby = "";
	$headings = "";
	$fields = "";

	// Create connection
	$conn = new mysqli($servername, $username, $password, $dbname);

	// Check connection
	if ($conn->connect_error) {
		die("Connection failed: " . $conn->connect_error);
	}

	//echo $conn->host_info . "<br>";

	$sql = "SELECT ". $selections. " NULL FROM Tarkin_Creatures WHERE ". $conditions. $orderby;
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
		echo "<table><tr>". $headings. "</tr>";
		for ($x = 0; $x < $answersize; $x++) {
			echo "<tr>". $fields. "</tr>";
		}
		echo "</table><br />";
	} else{
		echo "<p>Sorry, no results were found for the following query:<br /><br />". $sql. "<br /><br />Have a look over the conditions and values, make your changes, and try again.</p>";
	}

	$conn->close();
	?>
	<br />
	<pre><a href="index.php">Back to main page ...</a></pre>
</div>

<?php include("design-bottom.php"); ?>

