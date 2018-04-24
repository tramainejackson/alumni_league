<?php require_once("../include/sessions.php"); ?>
<?php require_once("../include/court.php"); ?>
<?php require_once("../include/functions.php"); ?>
<?php require_once("../include/header.php"); ?>
	<body>
		<div class="container">
		<?php $getPlayerProfile = find_player_by_username("yahoo"); ?>
		$row_cnt = mysqli_num_rows($results3);
		<?php while($showProfile = mysqli_fetch_assoc($results3)) { ?>
			<div class="playerDisplay">
				<div class="playerInfo" id="playerDemographics">
					<?php if($showProfile['nickname'] != "") { ?>
						<h2 id="about_header"><?php echo $showProfile['firstname']. " \"".$showProfile['nickname']."\" " .$showProfile['lastname']; ?></h2>
					<?php } else { ?>
						<h2 id="about_header"><?php echo $showProfile['firstname']. " \"".$showProfile['nickname']."\" " .$showProfile['lastname']; ?></h2>
					<?php } ?>	
					<table>
						<?php if($showProfile['college'] != "") { ?>
							<tr>
								<td><b>College:</b></td>
								<td><?php echo $showProfile['college']; ?></td>
							</tr>
						<?php } ?>
						<?php if($showProfile['highschool'] != "") { ?>
							<tr>
								<td><b>High School:</b></td>
								<td><?php echo $showProfile['highschool']; ?></td>
							</tr>
						<?php } ?>
						<?php if($showProfile['height'] != "") { ?>
							<tr>
								<td><b>Height:</b></td>
								<td><?php echo $showProfile['height']; ?></td>
							</tr>
						<?php } ?>
						<?php if($showProfile['height'] != 0) { ?>
							<tr>
								<td><b>Weight:</b></td>
								<td><?php echo $showProfile['weight']." lbs"; ?></td>
							</tr>
						<?php } ?>
						<?php if($showProfile['age'] != 0) { ?>
							<tr>
								<td><b>Age:</b></td>
								<td><?php echo $showProfile['age']; ?></td>
							</tr>
						<?php } ?>
						<?php if($showProfile['email'] != "") { ?>
							<tr>
								<td><b>Email:</b></td>
								<td><?php echo $showProfile['email']; ?></td>
							</tr>
						<?php } ?>
					</table>
			
			if(($showProfile['picture'] != "") && ($showProfile['college'] == "") && ($showProfile['highschool'] == "") && ($showProfile['nickname'] == "") 
				&& ($showProfile['height'] == "") && ($showProfile['weight'] == 0) && ($showProfile['age'] == 0))
			{
				echo "<div class=profilePic>";
				echo "<img id=playerPic src=/images/".$showProfile['picture'].">";
				echo "</div>";
			}
			else
			{
				echo "<div class=profilePic>";
				echo "<button tye='button' class='playerPic_class playerPic_btn'><a href='javascript:history.back()'>&#8666 Back</a></button>";
				echo "<img id=playerPic class='playerPic_class' src=/images/".$showProfile['picture'].">";
				echo "<button tye='button' class='playerPic_class playerPic_btn'><a href='javascript:history.back()'>&#8666 Back</a></button>";
				echo "</div>";
			}
				
			</div>
		<?php } ?>
			<script src="/scripts/jquery-2.1.1.js"></script>
			<script src="/scripts/totherec_2.js"></script>
		</div>
	</body>
</html>

		