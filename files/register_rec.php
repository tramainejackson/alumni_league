<!DOCTYPE html>
<html lang="en-US">
<head>
<title>ToTheRec</title>
<meta charset="UTF-8"/><meta name="keywords" content="Philly Basketball, Philadelphia Basketball, Rec Centers, Basketball, Philly Hoops"/>
<meta name="description" content="Philadelphia Basketball Players, Leagues and Rec Centers"/>
<meta name="description" content="Where to play basketball in philly"/>
<meta name"viewport" content"width=device-width, intial-scale=1"/>
<meta name="author" content="Guru"/>
<link rel="stylesheet" type="text/css" href="/css/style.css"/>
<style> 
</style>
</head>

<body>
<?php include "menu.php"; ?>

<?php 

	if(!empty($_COOKIE['username']))
	{
		echo "<div id=logged_in>";
		echo "A user is currently logged in.</br>";
		echo "Take me <a href=index.php>index</a></br>";
		echo "I'll just <a href=form_logout.php>Log Out</a></br>";
		echo "</div>";
		exit;
	}
?>

<div class="registrationPage">
	<div class="profileSetup">
		<h3>Create a username and password</h3>
			<form id="form1" method="POST" action="form_validate_account.php">
				<table>
					<tr>
						<td><label for="username">Username:</label></td>
						<td><input type="text" id="username" name="username" autofocus><br></td>
					</tr>
				
					<tr>
						<td><label for="password1">Password:</label></td>
						<td><input type="password" id="password1" name="password1"><br></td>
					</tr>
				
					<tr>
						<td><label for="password2">Confirm Password:</label></td>
						<td><input type="password" id="password2" name="password2"><br></td>
					</tr>
				</table>	
	</div>
	
	<div class="league_setup">
		<h3>Create My League</h3>
				<table>
					<tr>
						<td><label for="league_name">League Name:</label></td>
						<td><input type="text" id="league_name" name="league_name"><br></td>
					</tr>
				
				 	<tr>
						<td><label for="commish">Commissioner:</label></td>
						<td><input type="text" id="commish" name="commish"><br></td>
					</tr>	
				
					<tr>
						<td><label for="league_address">League Address:</label></td>
						<td><input type="text" id="league_address" name="league_address"><br></td>
					</tr>
				
					<tr>
						<td><label for="website">Website:</label></td>
						<td><input type="text" id="website" name="website"><br></td>
					</tr>
				
					<tr>
						<td><label for="phone">Phone Number:</label></td>
						<td><input type="text" id="phone" name="phone"><br></td>
					</tr>
				
					<tr>
						<td width="43%"><label for="email">Email:</label></td>
						<td><input type="text" id="email" name="email"><br></td>
					</tr>	
				
					<tr>
						<td><input type="checkbox" id="outdoor" name="outdoor" value="1">Outdoors<br></td>
						<td><input type="checkbox" id="indoor" name="indoor" value="1">Indoors<br></td>
					</tr>	
						
					<tr>
						<td><input type="submit" name="submit" value="Submit"></td>
					</tr>	
				</table>
			</form>
	</div>
</div>
</div>

<footer>
	<p>Share With:</p>
</footer>

</body>
</html>