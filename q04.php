<div class="question">
	<form action="a04.php" method="post">
		What creatures can I tame with Taming Wild Creatures 
		<select name="skill">
		<?php 
			for ($x = 5; $x <= 115; $x++) {
				echo "<option value='$x'>$x</option>";
			} 
		?>
		</select>
		 ?
		<input type="submit" value ="Ask">
	</form>
</div>