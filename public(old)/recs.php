<?php require_once("../include/initialize.php"); ?>
<?php require_once("../include/header.php"); ?>
<body>
	<div id="backgroundImageR"></div>
	<?php require_once("../public/modal.php"); ?>
	<?php require_once("../public/menu.php"); ?>
	<?php require_once("../public/about.html"); ?>
	<div class="container-fluid ">
		<div class="recsPageContainer">
			<div class="">
				<h2 id="rec_page_header" class="page_header">Philly Rec Centers</h2>
			</div>
			<div class="search_box">
				<input id="rec_search" name="search" type="search" placeholder="Search Center"/>
			</div>
			<div id="all_recs_frame">
				<div id="all_recs">
					<?php $getRecs = Rec_Center::get_rec_centers(); ?>
					<?php $fireRecs = Player_Profile::get_fire_recs(); ?>
					<?php foreach ($getRecs as $showRec) { ?>
						<div class="recsPage">
							<?php if($showRec->recs_name != "") { ?>
								<?php if($showRec->recs_nickname != "") { ?>
									<h3 id="<?php echo strtolower(str_ireplace(" ", "", $showRec->recs_name)); ?>" class="recs_header" title="<?php echo $showRec->recs_name; ?>"><b>"<?php echo $showRec->recs_nickname; ?>"</b>&nbsp;<?php echo $showRec->recs_name; ?></h3>
								<?php } else { ?>
									<h3 id="<?php echo strtolower(str_ireplace(" ", "", $showRec->recs_name)); ?>" class="recs_header" title="<?php echo $showRec->recs_name; ?>"><?php echo $showRec->recs_name; ?></h3>
								<?php } ?>
							<?php } ?>
							<ul class="recsPageList">
								<li><span class="listLabel">Rec Advisor:</span><span class="listContent" title="<?php echo $showRec->recs_owner; ?>"><?php echo $showRec->recs_owner != "" ? $showRec->recs_owner : "None Available"; ?></span></li>
								<li><span class="listLabel">Address:</span><span class="listContent" title="<?php echo $showRec->recs_address; ?>"><?php echo $showRec->recs_address != "" ? $showRec->recs_address : "None Available"; ?></span></li>
								<li><span class="listLabel">Website:</span><span class="listContent" title="<?php echo $showRec->recs_website; ?>"><?php echo $showRec->recs_website != "" ? $showRec->recs_website : "None Available"; ?></span></li>
								<li><span class="listLabel">Indoor Gym:</span><span class="listContent" title=""><?php echo $showRec->indoor == 1 ? "Yes" : "No"; ?></span></li>
								<li><span class="listLabel">Blacktop:</span><span class="listContent" title=""><?php echo $showRec->outdoor == 1 ? "Yes" : "No"; ?></span></li>
								<li><span class="listLabel">Cost:</span><span class="listContent" title=""><?php echo $showRec->fee != "" ? "Yes" : "No"; ?></span></li>
								<li><span class="listLabel">More Info:</span><span class="listContent" title="<?php echo $showRec->recs_phone; ?>"><?php echo $showRec->recs_phone; ?></span></li>
							</ul>
							<?php if(in_array(str_ireplace(" ", "_", $showRec->recs_name), $fireRecs)) { ?>
								<span><img src="images/fire.png" class="fireIcon2" /></span>
							<?php } ?>
						</div>
					<?php } ?>
				</div>
			</div>
			<button id="showAllRecs">Show All Rec Centers</button>
			<button id="scroll_to_top"></button>
		</div>
	</div>
	<?php require_once("../include/footer.php"); ?>
</body>
</html>