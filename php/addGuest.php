<?php
include('functions.php');
?>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<script src="../js/jquery-3.2.1.min.js"></script>
	<script src="../js/functions.js"></script>
</head>
<body>
<a href="menu.php">Return Menu</a><br/>

	<!-- ################### FORM - ADD USER #################### -->
	<form class="pure-form pure-form-aligned" style="background-color:powderblue; width: 50%;" action="../php/doAddGuest.php" method="post">
		<fieldset id="basic">
			<div class="pure-control-group">
				<label for="Name">Name</label>
				<input id="Name" name="Name" type="text" placeholder="Name of the main guest" class="pure-u-1-2">
			</div>
			<div class="pure-control-group">
				<label for="Email">Email</label>
				<input id="Email" name="Email" type="email" placeholder="Email Address" class="pure-u-1-2">
			</div>
			<div class="pure-control-group">
				<label for="Id_Category">Category</label>
				<select id="Id_Category" name="Id_Category" class="pure-u-1-2">
				<?php echo  getHTML_Categories(); ?>
				</select>
			</div>
			<div class="pure-control-group">
				<label for="UniqueKey">Unique Key</label>
				<input id="UniqueKey" name="UniqueKey" type="text" value="<?php echo randomKey(8);?>" readonly class="pure-u-1-2">
			</div>
			<div class="pure-control-group">
				<label for="GuestNo">Number of Guests</label>
				<input id="GuestNo" name="GuestNo" type="text" value="1" readonly class="pure-u-1-2">
			</div>
			<div class="pure-control-group">
				<label for="OptionalText">Comment:</label>
				<textarea id="OptionalText" name="OptionalText" placeholder="Optional comment." class="pure-input-1-2" ></textarea>
			</div>
		</fieldset>
		<hr/>
		<fieldset id="advanced"></fieldset>
		<div class="pure-controls">
			<a class="pure-button pure-button-primary" href="javascript:void(0)" onclick="addGuest();">Add Guest</a>
			<a class="pure-button pure-button-primary" href="javascript:void(0)" onclick="deleteGuest();">Remove Guest</a>
		</div>
		<hr/>
		<div class="pure-controls">
			<button type="submit" class="pure-button pure-button-primary" style="background-color:#73e600;">Register invitation</button>
		</div>
	</form>
	<!-- ################### FORM - ADD USER - END #################### -->
</body>
</html>