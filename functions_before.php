<!-- Common functions that must come before the document content -->

<script>
function loadCreaturePage(arg1){
	var pg = "creaturepage.php?argument1=" + arg1;
	window.open(pg);
}
</script>

<?php 
	function makePretty($value){
		return ucwords(strtolower(str_replace("_", " ", $value)));
	}
	
	function formatInt($value){
		$value = number_format($value);
		$value = str_replace(",", "", $value);
		console.log($value);
		return $value;
	}
	
	function resistPretty($value){
		$resistvalue = formatInt($value);
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
?>