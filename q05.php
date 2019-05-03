<div class="question">
	<form action="a05.php" method="post">
		What aggressive creatures can I tame with Taming Vicious Creatures 
		<select name="skill">
		<?php 
			for ($x = 10; $x <= 75; $x++) {
				echo "<option value='$x'>$x</option>";
			} 
		?>
		</select>
		 ?
		<input type="submit" value ="Ask">
	</form>
</div>