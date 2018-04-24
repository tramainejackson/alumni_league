<div class="navi">
	<ul class="menu">
		<li id="index"><a href="../public/index.php">Home</a></li>	
		<li id="player_li"><a href="../public/players.php">Players</a></li>
		<li id="rec_li"><a href="../public/recs.php">Parks N Recs</a></li>
		<li id="league_li"><a href="../public/leagues.php">City Leagues</a></li>			
		<li id="news_li"><a href="../public/news.php">News</a></li>
		<li id="clips_li"><a id="videos_link" href="../public/videos.php">Clips</a></li>
		<li id="contact_li"><a href="../public/contact.php">About TTR</a></li>
		<?php if($session->player || $session->league) { ?>
			<li id="profile_page_li">
				<?php if($session->player != false) { ?>
					<?php $player = Player_Profile::find_by_id($session->player); ?>
					<a class="profile_btn" id="profile_page_link" href="../public/player_page.php"><?php echo $player->full_name(); ?></a>
				<?php } else { ?>
					<?php $league = League_Profile::find_by_id($session->player); ?>
					<a class="profile_btn" id="profile_page_link" href="../public/league_page.php"><?php echo $league->leagues_commish; ?></a>
				<?php } ?>
			</li>
			<li id="logout_li"><a id="logout_btn" class="logoutLink" href="logout.php">Log Out</a></li>
		<?php } else { ?>
			<li id="login_li"><a href="../public/login.php">Login</a></li>
			<li id="register_li"><a href="../public/register.php">Register</a></li>
		<?php } ?>			
	</ul>	
</div>