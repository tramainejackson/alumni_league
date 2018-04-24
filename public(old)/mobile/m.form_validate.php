<!DOCTYPE html>
<html lang="en-US">
<head>
<title>ToTheRec</title>
<meta name="viewport" content="width=device-width, initial-scale=1"/>
<meta name="author" content="Guru"/>
<meta name="handheldfriendly" content="true"/>
<link rel="stylesheet" type="text/css" href="/css/jquery.mobile-1.4.5.min.css"/>
<link rel="stylesheet" type="text/css" href="/css/totherec.mobile.css"/>
<script src="/scripts/jquery-2.1.3.min.js"></script>
<script src="/scripts/jquery.mobile-1.4.5.min.js"></script>
</head>
<body>
	<div data-role="page" class="login_page">
		<?php include ($_SERVER['DOCUMENT_ROOT']. '/mobile/m.panel.php'); ?> 
		<div data-role="header" data-theme="b" data-position="fixed">
			<h1>Login</h1>
			<a href="#menu_panel" class="ui-btn ui-icon-bars ui-btn-icon-notext ui-corner-all"></a>
		</div>
		<?php
			include ($_SERVER['DOCUMENT_ROOT'].'/court.php');
			$connect = mysqli_connect($host, $db_username, $db_password, $db) or die("Unable to connect to server");
			$username =  $_POST['username'];
			$password = $_POST['password2'];
			$username2 = mysqli_real_escape_string($connect, strip_tags(trim($username)));
			$password2 = mysqli_real_escape_string($connect,strip_tags(trim($password)));
			$secure_password = hash('md5', $password2);
			$query = "SELECT * FROM `test_user` WHERE username = '$username2'";
			$result = mysqli_query($connect, $query) or die("Unable to run query" .mysqli_errno($connect));
			$row = mysqli_fetch_assoc($result);
			$query2 = "SELECT * FROM `test_user`";
			$result2 = mysqli_query($connect, $query2) or die("Unable to run query" .mysqli_errno($connect));
			$row2 = mysqli_fetch_assoc($result2);


				if($username2 == $row['username'] && $secure_password == $row['password'])
				{
					setcookie('username', $username);
					$query = "SELECT * FROM `player_profile` WHERE username = '$username2'";
					$results = mysqli_query($connect, $query) or die ("Unable to run query2");
					$row = mysqli_fetch_assoc($results);
				
					if(mysqli_num_rows($results) < 1)
					{						
							header('location: /mobile/m.league_page.php');
					}
					
					else
					{
						header('location: /mobile/m.player_page.php');					}
					
				}
				elseif (($password == "") || ($username2 == $row['username'] && $secure_password != $row['password']))
				{
					echo "<div class='ui-content' data-role='main'>";
					echo "<h4 class='error_header error_place_holder'>Incorrect username/password combination. Please try again.</h4>";
					echo "<form action='$_SERVER[PHP_SELF]' method='POST'>";
					echo "<table id='login_page_table'>";
					echo "<tr><th><label for='username'>Username:</label></th>";
					echo "<td><input type='text' name='username' id='username' value = '$username'></td></tr>";
					echo "<tr><th><label for='password2'>Password:</label></th>";
					echo "<td><input type='password' name='password2' id='pass2'></td></tr></table>";
					echo "<input type='submit' name='submit' id='login_page_btn' value='Sign Me In!'>";
					echo "</form></div><body></html>";
					exit;
				}
				elseif (($password == "") || ($username2 != $row['username'] && $secure_password == $row['password']))
				{
					echo "<div class='ui-content' data-role='main'>";
					echo "<h4 class='error_header error_place_holder'>Incorrect username/password combination. Please try again.</h4>";
					echo "<form action='$_SERVER[PHP_SELF]' method='POST'>";
					echo "<table id='login_page_table'>";
					echo "<tr><th><label for='username'>Username:</label></th>";
					echo "<td><input type='text' name='username' id='username' value = '$username'></td></tr>";
					echo "<tr><th><label for='password2'>Password:</label></th>";
					echo "<td><input type='password' name='password2' id='pass2'></td></tr></table>";
					echo "<tr><td><input type='submit' name='submit' id='login_page_btn' value='Sign Me In!'>";
					echo "</form></div></body></html>";
					exit;
				}
				elseif($username2 != $row2['username'])
				{
					echo "<div class='ui-content' data-role='main'>";
					echo "<h4 class='error_header error_place_holder'>Username doesn't exist. Please enter a valid username.</h4>";
					echo "<form action='$_SERVER[PHP_SELF]' method='POST'>";
					echo "<table id='login_page_table'>";
					echo "<tr><th><label for='username'>Username:</label></th>";
					echo "<td><input type='text' name='username' id='username' value = '$username'></td></tr>";
					echo "<tr><th><label for='password2'>Password:</label></th>";
					echo "<td><input type='password' name='password2' id='pass2'></td></tr></table>";
					echo "<input type='submit' name='submit' id='login_page_btn' value='Sign Me In!'>";
					echo "</form></div></body></html>";
					exit;	
				}
		?>
	</div>
	<div data-role="footer" data-theme="b" data-position="fixed">
		<h1>Footer Text</h1>
	</div>
</body>
</html>