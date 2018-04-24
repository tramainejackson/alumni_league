<!DOCTYPE html>
<html lang="en-US">
<head>
<meta charset="UTF-8"/><meta name="keywords" content="Philly Basketball, Philadelphia Basketball, Rec Centers, Basketball, Philly Hoops"/>
<meta name="description" content="Philadelphia Basketball Players, Leagues and Rec Centers"/>
<meta name="description" content="Where to play basketball in philly"/>
<meta name="handheldfriendly" content="true"/>
<link rel="stylesheet" type="text/css" href="/css/jquery.mobile-1.4.5.min.css"/>
<link rel="stylesheet" type="text/css" href="/css/totherec.mobile.css"/>
</head>
<body>
	<div data-role="page" id="register_player_page">
		<?php include ($_SERVER['DOCUMENT_ROOT']. '/mobile/m.panel.php'); ?> 
		<div data-role="header" data-theme="b" data-position="fixed">
			<h1>Player Account Registration</h1>
			<a href="#menu_panel" class="ui-btn ui-icon-bars ui-btn-icon-notext ui-corner-all"></a>
		</div>	
		<div data-role="main" class="ui-content" id="player_registration_table">			
			<form action="/mobile/m.create_player_profile.php" onsubmit="return validate_player_info();" name="form2" id="form2" method="POST">			
				<label for="username">Username:</label>
				<input type="text" id="username" name="username" autofocus>
				
				<label for="password1">Password:</label>
				<input type="password" id="password1" name="password1">
				
				<label for="password2">Confirm Password:</label>
				<input type="password" id="password2" name="password2">
				
				<label for="firstname">First Name:</label>
				<input type="text" id="firstname" name="firstname">
				
				<label for="lastname">Last Name:</label>
				<input type="text" id="lastname" name="lastname">
				
				<label for="college">College: </label>
				<input type="text" id="college" name="college">
				
				<label for="highschool">High School:</label>
				<input type="text" id="highschool" name="highschool">
				
				<label for="height">Height:</label>
				<input type="text" id="height" name="height">
				
				<label for="weight">Weight:</label>
				<input type="number" id="weight" name="weight">
				
				<label for="nickname">Nickname:</label>
				<input type="text" id="nickname" name="nickname">									
				
				<label for="email">Email:</label>
				<input type="text" id="email" name="email">
					
				<input type="submit" name="submit" id="regProfile_btn" value="Register My Profile!">
			</form>											
		</div>	
		<div data-role="footer" data-theme="b" data-position="fixed">
			<h1>Footer Text</h1>
		</div>	
		<div data-role="popup" data-rel="popup" id="error_popup" data-overlay-theme="b"><p id="mobile_error_message"></p></div>
	</div>	
	<div data-role="page" data-dialog="true" id="contact_info">
		<div data-role="header">
			<h1>Contact Us</h1>
		</div>
		<div data-role="main" class="ui-content">				
			<table>
				<tr>
					<th>Contact</th>
					<th>Email</th>
				</tr>
				
				<tr>
					<td>Tramaine</td>
					<td>totherec.sports@gmail.com</td>	
				</tr>
				
				<tr>
					<td>BC</td>
					<td>bcaldwell86@yahoo.com</td>	
				</tr>		
			</table>
		</div>
	</div>
	<div data-role="page" data-dialog="true" id="new_news">
		<div data-role="header">
			<h1>News</h1>
		</div>
		<div data-role="main" class="ui-content">	
			<h1>Hitting The News Stands In the Near Future</h1>
		</div>
	</div>
	<div data-role="page" data-dialog="true" id="videos">
		<div data-role="header">
			<h1>Videos</h1>
		</div>
		<div data-role="main" class="ui-content">	
			<h1>Coming Soon To A Theater Near You</h1>
		</div>
	</div>	
	<script src="/scripts/jquery-2.1.3.min.js"></script>
	<script src="/scripts/jquery.mobile-1.4.5.min.js"></script>
	<script src="/scripts/totherec-mobile.js"></script>
	<script>console.log(location.href);</script>
</body>
</html>