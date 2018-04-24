	<div id="navi2">
		<div id="bg-one"></div><div id="bg-two"></div><div id="bg-three"></div><div id="bg-four"></div>
		<ul class="menu2">
			<li id="index2"><a class="home2Link" href="/index.php"><button id="first_li">Home</button></a></li>	
			<li id="player_li2"><a class="players2Link" href="/players.php"><button id="players_btn">Players</button></a></li>
			<li id="rec_li2"><a class="recs2Link" href="/recs.php"><button id="pnr_btn">Parks N Recs</button></a></li>
			<li id="league_li2"><a class="leagues2Link" href="/leagues.php"><button id="leagues_btn">Leagues</button></a></li>			
			<li id="news_li2"><a class="news2Link" href="#"><button id="news_btn">News</button></a></li>
			<li id="clips_li2"><a class="videos2Link" href="videos.php"><button id="clips_btn">Clips</button></a></li>
			<li id="contact_li2"><a class="contact2Link" href="/contact.php"><button id="about_ttr_btn">About TTR</button></a></li>

			<?php	
				include("/court.php");
				
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
						
						echo "<li id='logout_li2'><a class='head2 logout2Link' href='/logout.php'><button>Log Out</button></a></li>";
						echo "<li id='league_profile_li2'><a class='head2 leaguePage2Link' href='/league_page.php'><button id='last_li'>".$name_display2."</button></a></li>";
					}
					
					else
					{
					echo "<li id='logout_li2'><a class='head2 logout2Link' href='/logout.php'><button>Log Out</button></a></li>";
					echo "<li id='player_profile_li2'><a class='head2 playerPage2Link' href='/player_page.php'><button id='last_li'>".$name_display."</button></a></li>";
					}	
				}	
				
				else
				{
					echo "<li id='login_li2'><a class='head2 login2Link' href='/login.php'><button>Login</button></a></li>";
					echo "<li id='register_li2'><a class='head2 register2Link' href='/register.php'><button id='last_li'>Register</button></a></li>";
				}
			?>		
		</ul>			
	</div>
	<div class="loginPage2">
		<form name="loginForm2" id="loginForm2" method="POST" onsubmit="return check_login();" action="form_validate(1).php">
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
			<input type="submit" name="submit" id="login_page_btn2" value="Sign Me In">		
			<input type="submit" name="cancel" id="cancel_login_page_btn2" value="Cancel">	
		</form>
	</div>
	<div class="registration">
		<button class="register" id="player">Player Profile</button>
		<button class="register" id="league">League Profile</button>
	</div>
	<div id="about_ttr">
		<div class="contactPageDis">
			<h2 id="about_header">About To The Rec</h2>
			<p>To all the basketball players in the Philly, South Jersey or Deleware area! This site is going to be for you.
			Let me know what you want to see from the site.</p>
				<ul>
					<li>Add your leagues to your page?</li>
				</ul>
			<p>Shoot me some ideas of what else you would like to see. If you know a rec center that has open gym, or where the real players play, shoot me the information
			and well get it added so you know where others are playing. Also send me you pictures and videos so we can add them to the home page.</p>
		</div>	
		<div class="contactPage">
			<h2 id="contact_header">Contact Us</h2>
			<table>
				<tr>
					<td width="100px"><b>Contact</b></td>
					<th colspan"2">Email</th>
				</tr>
				
				<tr>
					<td width="100px">Tramaine</td>
					<td>totherec.sports@gmail.com</td>	
				</tr>
				
				<tr>
					<td width="100px">BC</td>
					<td>bcaldwell86@yahoo.com</td>	
				</tr>		
			</table>
		</div>
	</div>	