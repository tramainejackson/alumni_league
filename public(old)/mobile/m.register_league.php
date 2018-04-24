<!DOCTYPE html>
<html lang="en-US">
<head>
<meta charset="UTF-8"/><meta name="keywords" content="Philly Basketball, Philadelphia Basketball, Rec Centers, Basketball, Philly Hoops"/>
<meta name="description" content="Philadelphia Basketball Players, Leagues and Rec Centers"/>
<meta name="description" content="Where to play basketball in philly"/>
<meta name="handheldfriendly" content="true"/>
<link rel="stylesheet" type="text/css" href="/css/jquery.mobile-1.4.5.min.css"/>
<link rel="stylesheet" type="text/css" href="/css/totherec.mobile.css"/>
<script src="/scripts/jquery-2.1.3.min.js"></script>
<script src="/scripts/jquery.mobile-1.4.5.min.js"></script>
</head>
<body>
	<div data-role="page" id="register_leagues_page">
		<?php include ($_SERVER['DOCUMENT_ROOT']. '/mobile/m.panel.php'); ?> 
		<div data-role="header" data-theme="b" data-position="fixed">
			<h1>League Account Registration</h1>
			<a href="#menu_panel" class="ui-btn ui-icon-bars ui-btn-icon-notext ui-corner-all"></a>
		</div>	
		<div data-role="main" class="ui-content">
			<form action="/mobile/m.create_league_profile.php" onsubmit="return validate_league_info();" id="form1" name="form1" method="POST"> 
				<label for="username">Username:</label>
				<input type="text" id="username" name="username" autofocus>
				
				<label for="password1">Password:</label>
				<input type="password" id="password1" name="password1">
				
				<label for="password2">Confirm Password:</label>
				<input type="password" id="password2" name="password2">
				
				<label for="league_name">League Name:</label>
				<input type="text" id="leagues_name" name="leagues_name">
				
				<label for="commish">League Commissioner:</label>
				<input type="text" id="leagues_commish" name="leagues_commish">
				
				<label for="league_address">League Address:</label>
				<input type="text" id="leagues_address" name="leagues_address">							
				
				<label for="leagues_fee">League Entry Fee:</label>
				<input type="number" id="leagues_fee" name="leagues_fee">
				
				<label for="ref_fee">Referee Fee/Game:</label>
				<input type="number" id="ref_fee" name="ref_fee">
				
				<label for="website">Website:</label>
				<input type="text" id="leagues_website" name="leagues_website">
				
				<label for="phone">Phone Number:</label>
				<input type="text" id="leagues_phone" name="leagues_phone">
				
				<label for="email">Email:</label>
				<input type="text" id="leagues_email" name="leagues_email">
				
				<label for="leagues_comp">Competition Level:</label>
					<select id="leagues_comp" name="leagues_comp[]" data-native-menu="false" multiple>
						<option name="comp_level" value="co_ed">Co-Ed</option>
						<option name="comp_level" value="recreational">Recreational</option>
						<option name="comp_level" value="intermediate">Intermediate</option>							
						<option name="comp_level" value="competitive">Competitive</option>
					</select>
			
				<label for="leagues_age">Competition Age Level:</label>
					<select id="leagues_age" name="leagues_age[]" data-native-menu="false" multiple>
						<option name="comp_age" value="10_and_under">10 and under</option>
						<option name="comp_age" value="12_and_under">12 and under</option>
						<option name="comp_age" value="14_and_under">14 and under</option>							
						<option name="comp_age" value="16_and_under">16 and under</option>
						<option name="comp_age" value="18_and_under">18 and under</option>
						<option name="comp_age" value="unlimited">No Age Limit</option>
						<option name="comp_age" value="30_and_over">30 and over</option>
						<option name="comp_age" value="50_and_over">50 and over</option>
					</select>							
				<input type="submit" name="submit" id="regLeague_btn" value="Register My League">	
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
			<div class="contact">
				<h4>Contact</h4>
				<p>Name: Tramaine</p>
				<p>Email: totherec.sports@gmail.com</p>
			</div>
			<div class="contact">
				<h4>Contact</h4>
				<p>Name: BC</p>
				<p>Email: bcaldwell86@yahoo.com</p>
			</div>	
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
</body>
</html>