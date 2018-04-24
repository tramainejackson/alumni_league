<?php require_once("../include/initialize.php"); ?>
<?php $startRange = str_ireplace("upload", "", $_POST["videoID"]); ?>
<?php $getVideos = Video::find_videos_range($startRange); ?>
<?php $totalVids = count($getVideos); ?>
<?php $returnData = "" ?>
<?php foreach($getVideos as $videos1) { ?>
	<div class="videoContent">
		<h2 class="uploadUser">
			<span class="upload<?php echo $videos1->get_upload_id(); ?>">Uploaded By: <?php echo $videos1->nickname ? $videos1->nickname : $videos1->name; ?></span>
		</h2>
		<video class="currentVideo">
			<source src="<?php echo $videos1->get_filename(); ?>" type="video/mp4">
			<source src="<?php echo $videos1->get_filename(); ?>" type="video/ogg">
		</video>
	</div>
<?php } ?>
<?php echo "<span class='totalVideos' style='display:none;'>".$totalVids."</span>"; ?>