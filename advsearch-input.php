<script>
	function clearField() {
		document.getElementById("advsrc").reset();
	}
</script>
<!-- 
	Variable Naming Guide
	
	oName: Math operators used in select menus
	bName: Check boxes
	lPlanet: Selection list values
	nName: For numerical values
	sName: For string values
	obName: Order results by checkboxes
	
	I did this because there are so many variables to track for this form. 
-->

<form id="advsrc" action="advsearch-output.php" method="post">
	<div class="advsrcorderbyleft">
		Sort By<br />
		<input type="checkbox" name="obPlanet"><label> &rarr;</label><br />
		<input type="checkbox" name="obLevel"><label> &rarr;</label><br />
		<input type="checkbox" name="obXp"><label> &rarr;</label><br />
		<input type="checkbox" name="obBone"><label> &rarr;</label><br />
		<input type="checkbox" name="obHide"><label> &rarr;</label><br />
		<input type="checkbox" name="obMeat"><label> &rarr;</label><br />
		<input type="checkbox" name="obMilk"><label> &rarr;</label><br />
		<input type="checkbox" name="obSocialGroup"><label> &rarr;</label><br />
		<input type="checkbox" name="obDiet"><label> &rarr;</label><br />
	</div>
	
	<div class="advsrcgenlabels">
		<br />
		<b>Planet:<br />
		Level:<br />
		XP:<br />
		Bone:<br />
		Hide:<br />
		Meat:<br />
		Milk:<br />
		Social Group:<br />
		Diet:</b><br />
	</div>
	
	<div class="advsrcgen">
		<br />
		&nbsp;
		<select name="lPlanet">
			<option value=""></option>
			<option value="any">Any</option>
			<option value="Corellia">Corellia</option>
			<option value="Dantooine">Dantooine</option>
			<option value="Dathomir">Dathomir</option>
			<option value="Endor">Endor</option>
			<option value="Lok">Lok</option>
			<option value="Naboo">Naboo</option>
			<option value="Rori">Rori</option>
			<option value="Talus">Talus</option>
			<option value="Tatooine">Tatooine</option>
			<option value="Yavin">Yavin</option>
		</select><br />
		
		&nbsp;
		<select name="oLevel">
			<option value=""></option>
			<option value="eq">==</option>
			<option value="gr">&rsaquo;=</option>
			<option value="ls">&lsaquo;=</option>
		</select>
		<input type="number" name="nLevel" min="1" max="500"><br />
		
		&nbsp;
		<select name="oXp">
			<option value=""></option>
			<option value="eq">==</option>
			<option value="gr">&rsaquo;=</option>
			<option value="ls">&lsaquo;=</option>
		</select>
		<input type="number" name="nXp" min="1" max="5000"><br />
		
		&nbsp;
		<select name="lBone" style="">
			<option value="" style="min-width:140px"></option>
			<option value="any">Any</option>
			<option value="bone_avian">Avian Bone</option>
			<option value="bone_mammal">Mammalian Bone</option>
		</select>
		<select name="oBone">
			<option value=""></option>
			<option value="eq">==</option>
			<option value="gr">&rsaquo;=</option>
			<option value="ls">&lsaquo;=</option>
		</select>
		<input type="number" name="nBone" min="1" max="5000"><br />
		
		&nbsp;
		<select name="lHide">
			<option value="" style="min-width:140px"></option>
			<option value="any">Any</option>
			<option value="hide_bristley">Bristley Hide</option>
			<option value="hide_leathery">Leathery Hide</option>
			<option value="hide_scaley">Scaley Hide</option>
			<option value="hide_wooly">Wooly Hide</option>
		</select>
		<select name="oHide">
			<option value=""></option>
			<option value="eq">==</option>
			<option value="gr">&rsaquo;=</option>
			<option value="ls">&lsaquo;=</option>
		</select>
		<input type="number" name="nHide" min="1" max="5000"><br />
		
		&nbsp;
		<select name="lMeat">
			<option value="" style="min-width:140px"></option>
			<option value="any">Any</option>
			<option value="meat_avian">Avian Meat</option>
			<option value="meat_carnivore">Carnivore Meat</option>
			<option value="meat_domesticated">Domesticated Meat</option>
			<option value="meat_herbivore">Herbivore Meat</option>
			<option value="meat_insect">Insect Meat</option>
			<option value="meat_reptilian">Reptilian Meat</option>
			<option value="meat_wild">Wild Meat</option>
		</select>
		<select name="oMeat">
			<option value=""></option>
			<option value="eq">==</option>
			<option value="gr">&rsaquo;=</option>
			<option value="ls">&lsaquo;=</option>
		</select>
		<input type="number" name="nMeat" min="1" max="5000"><br />
		
		&nbsp;
		<select name="lMilk">
			<option value="" style="min-width:140px"></option>
			<option value="any">Any</option>
			<option value="milk_domesticated">Domesticated Milk</option>
			<option value="milk_wild">Wild Milk</option>
		</select>
		<select name="oMilk">
			<option value=""></option>
			<option value="eq">==</option>
			<option value="gr">&rsaquo;=</option>
			<option value="ls">&lsaquo;=</option>
		</select>
		<input type="number" name="nMilk" min="1" max="5000"><br />
		
		&nbsp;
		<select name="lSocialGroup">
			<option value=""></option>
			<option value="any">Any</option>
			<option value="angler">Angler</option>
			<option value="arachne">Arachne</option>
			<option value="bageraset">Bageraset</option>
			<option value="bantha">Bantha</option>
			<option value="baz_nitch">Baz Nitch</option>
			<option value="beetle">Beetle</option>
			<option value="bird">Bird</option>
			<option value="bloodseeker">Bloodseeker</option>
			<option value="blurrg">Blurrg</option>
			<option value="boar">Boar</option>
			<option value="bocatt">Bocatt</option>
			<option value="bol">Bol</option>
			<option value="bolma">Bolma</option>
			<option value="bordok">Bordok</option>
			<option value="borgle">Borgle</option>
			<option value="brackaset">Brackaset</option>
			<option value="butterfly">Butterfly</option>
			<option value="canoid">Canoid</option>
			<option value="carrion_spat">Carrion Spat</option>
			<option value="choku">Choku</option>
			<option value="cu_pa">Cu Pa</option>
			<option value="dalyrake">Dalyrake</option>
			<option value="dewback">Dewback</option>
			<option value="dim_u">Dim U</option>
			<option value="dire_cat">Dire Cat</option>
			<option value="durni">Durni</option>
			<option value="eopie">Eopie</option>
			<option value="falumpaset">Falumpaset</option>
			<option value="fambaa">Fambaa</option>
			<option value="flewt">Flewt</option>
			<option value="flit">Flit</option>
			<option value="fynock">Fynock</option>
			<option value="gacklebat">Gacklebat</option>
			<option value="gnort">Gnort</option>
			<option value="gorg">Gorg</option>
			<option value="graul">Graul</option>
			<option value="gronda">Gronda</option>
			<option value="gualaar">Gualaar</option>
			<option value="gualama">Gualama</option>
			<option value="gubbur">Gubbur</option>
			<option value="guf_drolg">Guf Drolg</option>
			<option value="gulginaw">Gulginaw</option>
			<option value="gungan">Gungan</option>
			<option value="gurk">Gurk</option>
			<option value="gurnaset">Gurnaset</option>
			<option value="gurrcat">Gurrcat</option>
			<option value="gurreck">Gurreck</option>
			<option value="hanadak">Hanadak</option>
			<option value="huf_dun">Huf Dun</option>
			<option value="humbaba">Humbaba</option>
			<option value="huurton">Huurton</option>
			<option value="ikopi">Ikopi</option>
			<option value="imperial">Imperial</option>
			<option value="jax">Jax</option>
			<option value="kaadu">Kaadu</option>
			<option value="kahmurra">Kahmurra</option>
			<option value="kai_tok">Kai Tok</option>
			<option value="kamurith">Kamurith</option>
			<option value="kima">Kima</option>
			<option value="kimogila">Kimogila</option>
			<option value="kliknik">Kliknik</option>
			<option value="krahbu">Krahbu</option>
			<option value="krayt">Krayt</option>
			<option value="kreetle">Kreetle</option>
			<option value="krevol">Krevol</option>
			<option value="kusak">Kusak</option>
			<option value="kwi">Kwi</option>
			<option value="langlatch">Langlatch</option>
			<option value="lantern">Lantern</option>
			<option value="lizard">Lizard</option>
			<option value="malkloc">Malkloc</option>
			<option value="mamien">Mamien</option>
			<option value="mantigrue">Mantigrue</option>
			<option value="mauler">Mauler</option>
			<option value="mawgax">Mawgax</option>
			<option value="merek">Merek</option>
			<option value="mite">Mite</option>
			<option value="mott">Mott</option>
			<option value="mtn_clan">Singing Mountain Clan</option>
			<option value="murra">Murra</option>
			<option value="mynock">Mynock</option>
			<option value="naboo">Naboo</option>
			<option value="narglatch">Narglatch</option>
			<option value="nightsister">Nightsister</option>
			<option value="spider_nightsister">Nightsister Spider</option>
			<option value="nudfuh">Nudfuh</option>
			<option value="nuna">Nuna</option>
			<option value="panther">Panther</option>
			<option value="paralope">Paralope</option>
			<option value="peko">Peko</option>
			<option value="perlek">Perlek</option>
			<option value="pharple">Pharple</option>
			<option value="piket">Piket</option>
			<option value="prong">Prong</option>
			<option value="pugoriss">Pugoriss</option>
			<option value="purbole">Purbole</option>
			<option value="quenker">Quenker</option>
			<option value="rancor">Rancor</option>
			<option value="rasp">Rasp</option>
			<option value="rat">Rat</option>
			<option value="rawl">Rawl</option>
			<option value="remmer">Remmer</option>
			<option value="reptilian_flier">Reptilian Flier</option>
			<option value="rill">Rill</option>
			<option value="roba">Roba</option>
			<option value="ronto">Ronto</option>
			<option value="scyk">Scyk</option>
			<option value="self">Self</option>
			<option value="sevorrt">Sevorrt</option>
			<option value="sharnaff">Sharnaff</option>
			<option value="shaupaut">Shaupaut</option>
			<option value="shear_mite">Shear Mite</option>
			<option value="skreeg">Skreeg</option>
			<option value="slice_hound">Slice Hound</option>
			<option value="snake">Snake</option>
			<option value="snorbal">Snorbal</option>
			<option value="spider">Spider</option>
			<option value="spine_snake">Spined Snake</option>
			<option value="spined_puc">Spined Puc</option>
			<option value="spineflap">Spineflap</option>
			<option value="squall">Squall</option>
			<option value="squill">Squill</option>
			<option value="stinaril">Stinaril</option>
			<option value="tabage">Tabage</option>
			<option value="thune">Thune</option>
			<option value="torton">Torton</option>
			<option value="tortur">Tortur</option>
			<option value="tusk_cat">Tusk Cat</option>
			<option value="tusken_raider">Tusken Raider</option>
			<option value="tybis">Tybis</option>
			<option value="varactyl">Varactyl</option>
			<option value="veermok">Veermok</option>
			<option value="verne">Verne</option>
			<option value="vesp">Vesp</option>
			<option value="vir_vur">Vir Vir</option>
			<option value="voritor">Voritor</option>
			<option value="vrelt">Vrelt</option>
			<option value="vrobal">Vrobal</option>
			<option value="walluga">Walluga</option>
			<option value="whisperbird">Whisperbird</option>
			<option value="woolamander">Woolamander</option>
			<option value="worrt">Worrt</option>
			<option value="wrix">Wrix</option>
		</select><br />
		
		&nbsp;
		<select name="lDiet">
			<option value=""></option>
			<option value="any">Any</option>
			<option value="CARNIVORE">Carnivore</option>
			<option value="HERBIVORE">Herbavore</option>
		</select><br />
	</div>	
		
	<div class="advsrcbtnsleft">
		<input type="checkbox" name="bMissions"><label>Missions Available</label><br />
		<input type="checkbox" name="bTamable"><label>Tamable</label><br />
		<input type="checkbox" name="bMountable"><label>Mountable</label><br />
		<input type="checkbox" name="bDna"><label>Can Sample DNA</label><br />
		<input type="checkbox" name="bBe"><label>Bio-Engineer Craftable</label><br />
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		<input type="checkbox" name="obAsc"><label> Sort Ascending Instead</label>
	</div>
	
	<div class="advsrcbtnsright">
		Aggressive:&nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox" name="bAggressiveYes"><label>Yes</label> <input type="checkbox" name="bAggressiveNo"><label>No</label><br />
		Deathblows:&nbsp;&nbsp;<input type="checkbox" name="bDeathblowsYes"><label>Yes</label> <input type="checkbox" name="bDeathblowsNo"><label>No</label><br />
		Assists Allies:&nbsp;<input type="checkbox" name="bAssistsYes"><label>Yes</label> <input type="checkbox" name="bAssistsNo"><label>No</label><br />
		Stalks Prey:&nbsp;&nbsp;&nbsp;<input type="checkbox" name="bStalksYes"><label>Yes</label> <input type="checkbox" name="bStalksNo"><label>No</label><br />
		<input type="checkbox" name="bRanged"><label>Has Ranged Attack</label><br />
	</div>

	<div class="advsrcorderbyright">
		Sort By<br />
		<input type="checkbox" name="obHam"><label> &rarr;</label><br />
		<input type="checkbox" name="obDamage"><label> &rarr;</label><br />
		<input type="checkbox" name="obToHit"><label> &rarr;</label><br />
		<input type="checkbox" name="obFerocity"><label> &rarr;</label><br />
		<input type="checkbox" name="obAttack1"><label> &rarr;</label><br />
		<input type="checkbox" name="obAttack2"><label> &rarr;</label><br />
		<input type="checkbox" name="obArmor"><label> &rarr;</label><br />
		<input type="checkbox" name="obKinetic"><label> &rarr;</label><br />
		<input type="checkbox" name="obEnergy"><label> &rarr;</label><br />
		<input type="checkbox" name="obBlast"><label> &rarr;</label><br />
		<input type="checkbox" name="obHeat"><label> &rarr;</label><br />
		<input type="checkbox" name="obCold"><label> &rarr;</label><br />
		<input type="checkbox" name="obElectric"><label> &rarr;</label><br />
		<input type="checkbox" name="obAcid"><label> &rarr;</label><br />
		<input type="checkbox" name="obStun"><label> &rarr;</label><br />
		<input type="checkbox" name="obLightsaber"><label> &rarr;</label><br />
	</div>

	<div class="advsrccombatlabels">
		<br />
		<b>HAM:<br />
		Damage:<br />
		Chance to Hit:<br />
		Ferocity:<br />
		Special Attack 1:<br />
		Special Attack 2:<br />
		Armor Rating:<br />
		Kinetic Resistance:<br />
		Energy Resistance:<br />
		Blast Resistance:<br />
		Heat Resistance:<br />
		Cold Resistance:<br />
		Electric Resistance:<br />
		Acid Resistance:<br />
		Stun Resistance:<br />
		Lightsaber Resistance:</b><br />
	</div>

	<div class="advsrccombat">
		<br />
		&nbsp;
		<select name="oHam">
			<option value=""></option>
			<option value="eq">==</option>
			<option value="gr">&rsaquo;=</option>
			<option value="ls">&lsaquo;=</option>
		</select>
		<input type="number" name="nHam" min="1" max="650000"><br />


		&nbsp;
		<select name="oDamage">
			<option value=""></option>
			<option value="eq">==</option>
			<option value="gr">&rsaquo;=</option>
			<option value="ls">&lsaquo;=</option>
		</select>
		<input type="number" name="nDamage" min="1" max="5000"><input type="checkbox" name="bDamage"><label>By Min Value</label><br />
		
		&nbsp;
		<select name="oToHit">
			<option value=""></option>
			<option value="eq">==</option>
			<option value="gr">&rsaquo;=</option>
			<option value="ls">&lsaquo;=</option>
		</select>
		<input type="number" name="nToHit" min="0.01" max="100" step="0.01"><br />
		
		&nbsp;
		<select name="oFerocity">
			<option value=""></option>
			<option value="eq">==</option>
			<option value="gr">&rsaquo;=</option>
			<option value="ls">&lsaquo;=</option>
		</select>
		<input type="number" name="nFerocity" min="0" max="50"><br />

		&nbsp;
		<select name="lAttack1">
			<option value=""></option>
			<option value="any">Any</option>
			<option value="blindattack">Blinding Strike</option>
			<option value="creatureareaattack">Creature Area Attack</option>
			<option value="posturedownattack">Crippling Strike</option>
			<option value="dizzyattack">Dizzy Strike</option>
			<option value="intimidationattack">Intimidation</option>
			<option value="knockdownattack">Knockdown</option>
			<option value="mediumdisease">Medium Disease</option>
			<option value="mediumpoison">Medium Poison</option>
			<option value="milddisease">Mild Disease</option>
			<option value="mildpoison">Mild Poison</option>
			<option value="creatureareableeding">Open Wounds</option>
			<option value="creatureareadisease">Plague Strike</option>
			<option value="creatureareapoison">Poison Spray</option>
			<option value="strongdisease">Strong Disease</option>
			<option value="strongpoison">Strong Poison</option>
			<option value="stunattack">Stunning Strike</option>
			<!-- option value="creatureareacombo">Area Combo</option> None found in DB -->
			<!-- option value="creatureareaknockdown">Force Strike</option> None found in DB -->
		</select><br />
		
		&nbsp;
		<select name="lAttack2">
			<option value=""></option>
			<option value="any">Any</option>
			<option value="blindattack">Blinding Strike</option>
			<option value="creatureareaattack">Creature Area Attack</option>
			<option value="posturedownattack">Crippling Strike</option>
			<option value="dizzyattack">Dizzy Strike</option>
			<option value="intimidationattack">Intimidation</option>
			<option value="knockdownattack">Knockdown</option>
			<option value="mediumdisease">Medium Disease</option>
			<option value="mediumpoison">Medium Poison</option>
			<option value="milddisease">Mild Disease</option>
			<option value="mildpoison">Mild Poison</option>
			<option value="creatureareableeding">Open Wounds</option>
			<option value="creatureareadisease">Plague Strike</option>
			<option value="creatureareapoison">Poison Spray</option>
			<option value="strongdisease">Strong Disease</option>
			<option value="strongpoison">Strong Poison</option>
			<option value="stunattack">Stunning Strike</option>
			<!-- option value="creatureareacombo">Area Combo</option> None found in DB -->
			<!-- option value="creatureareaknockdown">Force Strike</option> None found in DB -->
		</select><br />
		
		&nbsp;
		<select name="lArmor">
			<option value=""></option>
			<option value="any">Any</option>
			<option value="0">None</option>
			<option value="1">Light</option>
			<option value="2">Medium</option>
			<option value="3">Heavy</option>
		</select><br />

		&nbsp;
		<select name="oKinetic">
			<option value=""></option>
			<option value="eq">==</option>
			<option value="gr">&rsaquo;=</option>
			<option value="ls">&lsaquo;=</option>
		</select>
		<input type="number" name="nKinetic" min="-1" max="500"><br />
		
		&nbsp;
		<select name="oEnergy">
			<option value=""></option>
			<option value="eq">==</option>
			<option value="gr">&rsaquo;=</option>
			<option value="ls">&lsaquo;=</option>
		</select>
		<input type="number" name="nEnergy" min="-1" max="500"><br />
		
		&nbsp;
		<select name="oBlast">
			<option value=""></option>
			<option value="eq">==</option>
			<option value="gr">&rsaquo;=</option>
			<option value="ls">&lsaquo;=</option>
		</select>
		<input type="number" name="nBlast" min="-1" max="500"><br />
		
		&nbsp;
		<select name="oHeat">
			<option value=""></option>
			<option value="eq">==</option>
			<option value="gr">&rsaquo;=</option>
			<option value="ls">&lsaquo;=</option>
		</select>
		<input type="number" name="nHeat" min="-1" max="500"><br />
		
		&nbsp;
		<select name="oCold">
			<option value=""></option>
			<option value="eq">==</option>
			<option value="gr">&rsaquo;=</option>
			<option value="ls">&lsaquo;=</option>
		</select>
		<input type="number" name="nCold" min="-1" max="500"><br />
		
		&nbsp;
		<select name="oElectric">
			<option value=""></option>
			<option value="eq">==</option>
			<option value="gr">&rsaquo;=</option>
			<option value="ls">&lsaquo;=</option>
		</select>
		<input type="number" name="nElectric" min="-1" max="500"><br />
		
		&nbsp;
		<select name="oAcid">
			<option value=""></option>
			<option value="eq">==</option>
			<option value="gr">&rsaquo;=</option>
			<option value="ls">&lsaquo;=</option>
		</select>
		<input type="number" name="nAcid" min="-1" max="500"><br />
		
		&nbsp;
		<select name="oStun">
			<option value=""></option>
			<option value="eq">==</option>
			<option value="gr">&rsaquo;=</option>
			<option value="ls">&lsaquo;=</option>
		</select>
		<input type="number" name="nStun" min="-1" max="500"><br />
		
		&nbsp;
		<select name="oLightsaber">
			<option value=""></option>
			<option value="eq">==</option>
			<option value="gr">&rsaquo;=</option>
			<option value="ls">&lsaquo;=</option>
		</select>
		<input type="number" name="nLightsaber" min="-1" max="500"><br />
	</div>
	
	<div class="spacer" style="height:546px;">&nbsp;</div>
	<pre>
		To include an item on the results page use the Any drop down option or use &rsaquo;= [valid number] for number fields. 
		For resistance vulnerabilities use a value of -1. Use a value of 0 for no resistance.</pre>
	<div class="question">
		<a href="" onclick="clearField(this.form)">Reset Form</a> <input type="submit" value ="Submit">
	</div>
</form>