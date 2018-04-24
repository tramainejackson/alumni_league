<?php require_once("../include/initialize.php"); ?>
<?php require_once("../include/header.php"); ?>
<body>
	<div id="backgroundImageV"></div>
	<?php require_once("../public/modal.php"); ?>
	<?php require_once("../public/about.html"); ?>
	<?php require_once("../public/menu.php"); ?>
	<div class="container-fluid">
		<div class="videoPage">
			<h2 id="video_page_header" class="page_header">The Highlight Reel</h2>
			<?php $getVideos = Video::find_all_videos(); ?>
			<?php if(!empty($getVideos)) { ?>
				<?php if(is_object($getVideos)) { ?>
					<?php $videos1 = $getVideos; ?>
					<div class="videoContent">
						<h2 class="uploadUser">
							<span class="upload<?php echo $videos1->get_upload_id(); ?>">Uploaded By: <?php echo $videos1->nickname ? $videos1->nickname : $videos1->name; ?></span>
						</h2>
						<video class="currentVideo">
							<source src="../videos/<?php echo $videos1->get_filename(); ?>" type="video/mp4">
							<source src="../videos/<?php echo $videos1->get_filename(); ?>" type="video/ogg">
							<source src="../videos/<?php echo $videos1->get_filename(); ?>">
							Your browser does not support the video tag.
						</video>
					</div>
				<?php } elseif(is_array($getVideos)) { ?>
					<?php foreach($getVideos as $videos1) { ?>
						<div class="videoContent">
							<h2 class="uploadUser">
								<span class="upload<?php echo $videos1->get_upload_id(); ?>">Uploaded By: <?php echo $videos1->nickname ? $videos1->nickname : $videos1->name; ?></span>
							</h2>
							<video class="currentVideo">
								<source src="../videos/<?php echo $videos1->get_filename(); ?>" type="video/mp4">
								<source src="../videos/<?php echo $videos1->get_filename(); ?>" type="video/ogg">
								<source src="../videos/<?php echo $videos1->get_filename(); ?>">
								Your browser does not support the video tag.
							</video>
						</div>
					<?php } ?>
					<?php if(count($getVideos) >= 5) { ?>
						<button class="addMoreVideos">Load More Videos</button>
					<?php } ?>
				<?php } ?>
			<?php } else { ?>
				<p class="noVideosMessage">No videos have been added yet. Click <a href="register.php?player_reg=true" class="noVideosMessageLink">here</a> to create a profile to add your videos. Or click <a href="login.php" class="noVideosMessageLink">here</a> to log in if you already have an player profile.</p>
			<?php } ?>
			<?php //mysqli_close($connect); ?>
		</div>
		<div id="loading_image">
			<img src="images/ajax-loader (1).gif" />
		</div>
	</div>
	<?php require_once("../include/footer.php"); ?>
</body>
</html>