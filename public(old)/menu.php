<div class="navi navbar navbar-inverse">
	<div class="container-fluid">
		<ul class="menu nav navbar-nav">
			<li id="index"><a href="index.php">Home</a></li>	
			<li id="player_li"><a href="players.php">Players</a></li>
			<li id="rec_li"><a href="recs.php">Parks N Recs</a></li>
			<li id="league_li"><a href="leagues.php">City Leagues</a></li>			
			<li id="news_li"><a href="news.php">News</a></li>
			<li id="clips_li"><a id="videos_link" href="videos.php">Clips</a></li>
			<li id="contact_li"><a href="contact.php">About TTR</a></li>
		</ul>
		<ul class="menu nav navbar-nav navbar-right">
			<?php if($session->player || $session->league) { ?>
				<li id="profile_page_li">
					<?php if($session->player) { ?>
						<?php $player = Player_Profile::find_by_sql("SELECT firstname, lastname FROM player_profile WHERE user_account_id = '$session->user_id';"); ?>
						<a class="profile_btn" id="profile_page_link" href="../public/player_page.php"><span class="glyphicon glyphicon-user"><span class="menuLiSpan"><?php echo $player->full_name(); ?></span></a>
					<?php } else { ?>
						<?php $league = League_Profile::find_by_sql("SELECT * FROM leagues_profile WHERE user_account_id = '$session->user_id';"); ?>
						<a class="profile_btn" id="profile_page_link" href="../public/league_page.php"><span class="glyphicon glyphicon-user"><span class="menuLiSpan"><?php echo $league->leagues_commish; ?></span></a>
					<?php } ?>
				</li>
				<li id="logout_li"><a id="logout_btn" class="logoutLink" href="logout.php"><span class="glyphicon glyphicon-log-out"><span class="menuLiSpan">Log Out</span></a></li>
			<?php } else { ?>
				<li id="login_li"><a href="../public/login.php"><span class="glyphicon glyphicon-log-in"><span class="menuLiSpan">Login</span></a></li>
				<li id="register_li"><a href="../public/register.php"><span class="glyphicon glyphicon-user"><span class="menuLiSpan">Register</span></a></li>
			<?php } ?>				
		</ul>	
	</div>
</div>