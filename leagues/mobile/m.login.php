<?php
if(!empty($_COOKIE['username']))
{
	header ("location: /totherec.php");
}
?>
<!DOCTYPE html>
<html lang="en-US">
<head>
<title>ToTheRec</title>
<meta charset="UTF-8"/><meta name="keywords" content="Philly Basketball, Philadelphia Basketball, Rec Centers, Basketball, Philly Hoops"/>
<meta name="description" content="Philadelphia Basketball Players, Leagues and Rec Centers"/>
<meta name="description" content="Where to play basketball in philly"/>
<meta name="handheldfriendly" content="true"/>
<link rel="stylesheet" type="text/css" href="/css/jquery.mobile-1.4.5.min.css"/>
<link rel="stylesheet" type="text/css" href="/css/totherec.mobile.css"/>
<script src="/scripts/jquery-2.1.3.min.js"></script>
<script src="/scripts/jquery.mobile-1.4.5.min.js"></script>
<script src="/scripts/totherec-mobile.js"></script>
<style>	a#login_panel_li {background-color: green;} </style>
<style> 
</style>
</head>
<body>
	<div data-role="page" id="login_page">
		<?php include ($_SERVER['DOCUMENT_ROOT']. '/mobile/m.panel.php'); ?> 
		<div data-role="header" data-theme="b" data-position="fixed">
			<h1>Login</h1>
			<a href="#menu_panel" class="ui-btn ui-icon-bars ui-btn-icon-notext ui-corner-all"></a>
		</div>		
		<div data-role="main" class="ui-content">	
			<form action="/mobile/m.form_validate.php" onsubmit="return check_login();" name="form1" id="form1" method="POST"> 
				<table id="login_page_table">
					<tr>
						<th><label for="username">Username:</label></th> 
						<th><input type="text" name="username" id="username"></th>
					</tr>
					
					<tr>
						<th><label for="password">Password:</label></th> 
						<th><input type="password" id="pass2" name="password2"></th>
					</tr>								
				</table>				
				<input type="submit" name="submit" id="login_page_btn" value="Sign me in!">			
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
</body>
</html>