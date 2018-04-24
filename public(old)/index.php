<?php require_once("../include/initialize.php"); ?>
<?php require_once("../include/header.php"); ?>
<body id="container-fluid">
	<?php include("modal.php"); ?>
	<?php include("menu.php"); ?>
	<?php require_once("../public/about.html"); ?>	
	<div class="content">
		<div class="calendars">
			<?php include("2016_calendar.php"); ?>
			<?php include("2017_calendar.php"); ?>			
		</div>
	</div>
</body>
</html>