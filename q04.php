<div class="question">
	<form action="a04.php" method="post">
		What creatures can I tame between level 
		<select name="levelmin">
		<?php 
			for ($x = 1; $x <= 95; $x++) {
				echo "<option value='$x'>$x</option>";
			} 
		?>
		</select>
		  and 
		<select name="levelmax">
		<?php 
			for ($x = 1; $x <= 95; $x++) {
				echo "<option value='$x'>$x</option>";
			} 
		?>
		</select>
		  ?
		<input type="submit" value ="Ask">
	</form>
</div>