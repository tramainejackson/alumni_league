<div data-role="panel" id="menu_panel" data-theme="b"> 
	<div data-role="controlgroup" data-type="vertical">
		<h2>Take me to...</h2>
		<a id="home_page_panel_li" href="/mobile/m.totherec.php" data-transition="flip" class="panel_link ui-btn">TTR</a>
		
			<?php include ($_SERVER['DOCUMENT_ROOT']. '/court.php'); 
			$connect = mysqli_connect($host, $db_username, $db_password, $db) or die("Unable to connect to server");
			$query3 = "SELECT * FROM `rec_profile` ORDER BY `recs_name`";
			$results3 = mysqli_query($connect, $query3) or die ("Unable to run query1");
			$row_cnt = mysqli_num_rows($results3);

			if(!empty($_COOKIE['username']))
			{

			$user = $_COOKIE['username'];
			$query = "SELECT * FROM `player_profile` WHERE username = '$user'";
			$results = mysqli_query($connect, $query) or die ("Unable to run query2");
			$row = mysqli_fetch_assoc($results);
			$name_display = $row['firstname'];
				
				if(mysqli_num_rows($results) < 1)
				{
					$query2 = "SELECT * FROM `leagues_profile` WHERE username = '$user'";
					$results2 = mysqli_query($connect, $query2);
					$row2 = mysqli_fetch_assoc($results2);
					$name_display2 = $row2['leagues_commish'];
					
					echo "<a id='logout_panel_li' class='head panel_link ui-btn' href=/mobile/m.logout.php>Log Out</a>";
					echo "<a id='profile_panel_li' class='head panel_link ui-btn' href=/mobile/m.league_page.php>My Profile</a>";
				}
				
				else
				{
				echo "<a id='logout_panel_li' class='head panel_link ui-btn' href='/mobile/m.logout.php'>Log Out</a>";
				echo "<a id='profile_panel_li' class='head panel_link ui-btn' href='/mobile/m.player_page.php'>My Profile</a>";
				}	
			}	
			
			else
			{
				echo "<a id='register_page_panel_li' href='/mobile/m.register.php' data-transition='flip' class='panel_link ui-btn'>Register an Account</a>";
				echo "<a id='login_panel_li' href='/mobile/m.login.php' data-transition='flip' class='panel_link ui-btn'>Login</a>";
			}
		?>			
		
		<a href="/mobile/m.players.php" id="player_page_panel_li" data-transition="turn" class="panel_link ui-btn">Player Pages</a>
		<a href="/mobile/m.leagues.php" id="league_page_panel_li" data-transition="turn" class="panel_link ui-btn">Leagues</a>
		<a href="/mobile/m.recs.php" id="rec_page_panel_li" data-transition="fade" class="panel_link ui-btn">Rec Centers</a>
		<a href="/mobile/m.twitterfeed.php" id="twitter_page_panel_li" data-transition="fade" class="panel_link ui-btn">#phillyhoops</a>
		<a href="#videos" id="videos_page_panel_li" data-transition="pop" class="panel_link ui-btn">Clips</a>
		<a href="#new_news" id="news_page_panel_li" data-transition="pop" class="panel_link ui-btn">News</a>
		<a href="#contact_info" id="about_page_panel_li" data-transition="pop" class="panel_link ui-btn">About</a>
	</div>
</div> 	