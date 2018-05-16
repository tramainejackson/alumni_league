$(document).ready(function() {	
	
	//Common variables
	var windowHeight = window.innerHeight;
	var windowWidth = window.innerWidth;
	var documentWidth = document.body.clientWidth;
	var documentHeight = document.body.clientHeight;
	var screenHeight = screen.height;
	var screenWidth = screen.width;

	// Animations initialization
	new WOW().init();
	
	// Initialize MDB select
	$('.mdb-select').material_select();
	
	// Initialize datetimepicker
	$('.datetimepicker').pickadate({
		// Escape any “rule” characters with an exclamation mark (!).
		format: 'mm/dd/yyyy',
		formatSubmit: 'yyyy/mm/dd',
	});
	
	// Initialize timepicker
	$('.timepicker').pickatime({
		// 12 or 24 hour 
		twelvehour: true,
		autoclose: true,
		default: '18:00',
	});
	
	// Dropdown Init
	$('.dropdown-toggle').dropdown();
	
	// SideNav Scrollbar Initialization
	var sideNavScrollbar = document.querySelector('.custom-scrollbar');
	Ps.initialize(sideNavScrollbar);
	// SideNav Button Initialization
	$(".button-collapse").sideNav({
		edge: 'left', // Choose the horizontal origin
		closeOnClick: true // Closes side-nav on <a> clicks, useful for Angular/Meteor
	});

	// Remove flash message if there is one after 8 seconds
	if($('.flashMessage').length == 1) {
		$('.flashMessage').animate({top:'+=' + ($('nav').height() + 150) + 'px'});
		setTimeout(function(){
			$('.flashMessage').animate({top:'-150px'}, function(){
				$('.flashMessage').remove();
			});
		}, 8000);
	}
	
	// Toggle value for checked item 
	// (allows one of 2 options to be selected but required at least one to be selected)
	$("body").on("click", ".registrationFormCard .profileSelection button, .inputSwitchToggle", function(e) {
		$(this).add($(this).siblings()).toggleClass('green grey active');
		
		if($(this).children().attr('checked') == 'checked') {
			$(this).children().removeAttr('checked');
			$(this).siblings().children().attr('checked', 'checked');
		} else {
			$(this).children().attr('checked', 'checked');
			$(this).siblings().children().removeAttr('checked');
		}
	});
	
	// Toggle team captain checkbox
	$('body').on('click', '#team_players_table input[name="team_captain"]', function(e) {
		var checkInputs = $('#team_players_table input[name="team_captain"]');
		var checkedInput = $(this);

		// Remove checkbox from all other checkboxes
		checkInputs.each(function() {
			if($(this).prop('checked') && $(this).val() != checkedInput.val()) {
				$(this).prop('checked', false);
			}
		});
	});
	
	// Toggle value for leagues ages and competition for leages edit page .
	// (Will toggle on and off. Not related to sibling option. Does not require a selection)
	$("body").on("click", ".compBtnSelect, .ageBtnSelect", function(e) {
		if($(this).hasClass('compBtnSelect')) {
			$(this).toggleClass('orange gray active');
			
			if($(this).children().attr('checked') == 'checked') {
				$(this).children().removeAttr('checked');
			} else {
				$(this).children().attr('checked', 'checked');
			}
		} else {
			$(this).toggleClass('blue gray active');
			
			if($(this).children().attr('checked') == 'checked') {
				$(this).children().removeAttr('checked');
			} else {
				$(this).children().attr('checked', 'checked');
			}
		}
	});
	
	// Toggle value for game forfeit.
	// (Will toggle on and off. Allows only 1 of 2 sibling 
	// options to be selected. Does not require a selection)
	$("body").on("click", ".homeForfeitBtn, .awayForfeitBtn", function(e) {
		if($(this).hasClass('red')) {
			$(this).children().removeAttr('checked');
		} else {
			$(this).children().attr('checked', 'checked');
			
			// If sibling has red class then remove it
			if($(this).siblings().hasClass('red')) {
				$(this).siblings().toggleClass('red stylish-color-dark active');
				$(this).siblings().children().removeAttr('checked')
			}
		}

		$(this).toggleClass('red stylish-color-dark active');
	});
	
	// Bring up quick game edit on league schedule index
	// page
	$('body').on('click', '.editGameBtn', function(e) {
		var gameInfo = $(this).parents('tr');
		console.log(gameInfo.children(".awayTeamData").text());
		console.log(gameInfo.children(".homeTeamData").text());
		console.log(gameInfo.children(".awayTeamScoreData").text().trim());
		console.log(gameInfo.children(".homeTeamScoreData").text().trim());
	});
	
	// Add a new player row on the team edit page
	$('body').on('click', '.addPlayerBtn', function() {
		var newPlayer = $('.newPlayerRow').clone();
		
		$(newPlayer).removeClass('hidden newPlayerRow')
			.insertBefore('#team_players_table .newPlayerRow')
			.removeAttr('hidden')
			.find('input, button').removeClass('hidden').removeAttr('disabled').focus();
	});
	
	// Remove the newly added player row on team edit page
	$('body').on('click', '.removeNewPlayerRow', function() {
		$(this).parents('tr').remove();
	});
	
	// Add new game card on the schedule week edit page
	$('body').on('click', '#edit_page_add_game', function() {
		var newGame = $('.newGameRow').clone();
		
		$(newGame).removeClass('hidden newGameRow')
			.prependTo('.updateWeekForm')
			.removeAttr('hidden')
			.find('input, button, select').removeAttr('disabled');
		
		// Initialize timepicker
		$(newGame).find('.timepicker').pickatime({
			// 12 or 24 hour 
			twelvehour: true,
			autoclose: true,
			default: '18:00',
		});
		
		// Initialize datetimepicker
		$(newGame).find('.datetimepicker').pickadate({
			format: 'mm/dd/yyyy',
			formatSubmit: 'yyyy/mm/dd',
		});
		
		// Initialize datetimepicker
		$(newGame).find('select').addClass('.mdb-select').material_select();
	});
	
	//Add active class to current stat category button
	$("body").on("click", ".statCategoryBtn", function(e)
	{
		e.preventDefault();
		$(".statCategoryBtn").removeClass("activeBtn");
		$(this).addClass("activeBtn");
		statsToggle();
	});
	
	//Add player stats to player card and display
	$("body").on("click", ".leagueLeadersCategory tr:not(.leagueLeadersCategoryFR), #player_stats tr:not(:first)", function(e)
	{
		var playerStats = [
			$(this).children(".playerNameTD").text(),
			$(this).children(".totalPointsTD").text(),
			$(this).children(".pointsPGTD").text(),
			$(this).children(".totalThreesTD").text(),
			$(this).children(".threesPGTD").text(),
			$(this).children(".totalFTTD").text(),
			$(this).children(".freeThrowsPGTD").text(),
			$(this).children(".totalAssTD").text(),
			$(this).children(".assistPGTD").text(),
			$(this).children(".totalRebTD").text(),
			$(this).children(".rebPGTD").text(),
			$(this).children(".totalStealsTD").text(),
			$(this).children(".stealsPGTD").text(),
			$(this).children(".totalBlocksTD").text(),
			$(this).children(".blocksPGTD").text(),
			$(this).children(".teamNameTD").text()
		];
		
		$(".playerNamePlayerCard").text(playerStats[0]);
		$(".teamNameVal").text(playerStats[15]);
		$(".perGamePointsVal").text(playerStats[2]);
		$(".perGameAssistVal").text(playerStats[8]);
		$(".perGameReboundsVal").text(playerStats[10]);
		$(".perGameStealsVal").text(playerStats[12]);
		$(".perGameBlocksVal").text(playerStats[14]);
	});
	
//Add team stats to team card and display	
	$("body").on("click", "#team_stats tr:not(:first)", function(e)
	{	
		var teamStats = [
			$(this).children(".teamNameTD").text(),
			$(this).children(".totalPointsTD").text(),
			$(this).children(".pointsPGTD").text(),
			$(this).children(".totalThreesTD").text(),
			$(this).children(".threesPGTD").text(),
			$(this).children(".totalFTTD").text(),
			$(this).children(".freeThrowsPGTD").text(),
			$(this).children(".totalAssTD").text(),
			$(this).children(".assistPGTD").text(),
			$(this).children(".totalRebTD").text(),
			$(this).children(".rebPGTD").text(),
			$(this).children(".totalStealsTD").text(),
			$(this).children(".stealsPGTD").text(),
			$(this).children(".totalBlocksTD").text(),
			$(this).children(".blocksPGTD").text(),
			$(this).children(".totalWinsTD").text(),
			$(this).children(".totalLossesTD").text(),
			$(this).children(".totalGamesTD").text(),
			$(this).children(".teamPicture").text()
		];
		
		$(".teamNameTeamCard").text(teamStats[0]);
		$(".teamWinsVal").text(teamStats[15]);
		$(".teamLossesVal").text(teamStats[16]);
		$(".perGameTeamPointsVal").text(teamStats[2]);
		$(".totalTeamPointsVal").text(teamStats[1]);
		$(".perGameTeamAssistVal").text(teamStats[7]);
		$(".totalTeamAssistVal").text(teamStats[8]);
		$(".perGameTeamReboundsVal").text(teamStats[9]);
		$(".totalTeamReboundsVal").text(teamStats[10]);
		$(".perGameTeamStealsVal").text(teamStats[11]);
		$(".totalTeamStealsVal").text(teamStats[12]);
		$(".perGameTeamBlocksVal").text(teamStats[13]);
		$(".totalTeamBlocksVal").text(teamStats[14]);
		$(".teamCardHeader img").attr('src',teamStats[18]);
	});
	
	$("body").on("change", ".awayTeamScore, .homeTeamScore", function(e){
		if($(this).attr("class") == "awayTeamScore teamScore")
		{
			var away_score = $(this);
			var away_name = $(this).parent().parent().find(".away_team_select");
			var home_score = $(this).parent().next().children(".homeTeamScore");
			var home_name = $(this).parent().parent().find(".home_team_select");
			if($(away_score).val() > $(home_score).val())
			{
				$(away_score).css({backgroundColor:"green", color:"white"});
				$(away_name).css({backgroundColor:"green", color:"white"});
				$(home_score).css({backgroundColor:"red", color:"white"});
				$(home_name).css({backgroundColor:"red", color:"white"});
			}
			else if($(away_score).val() < $(home_score).val())
			{
				$(away_score).css({backgroundColor:"red", color:"white"});
				$(away_name).css({backgroundColor:"red", color:"white"});
				$(home_score).css({backgroundColor:"green", color:"white"});
				$(home_name).css({backgroundColor:"green", color:"white"});
			}
			else
			{
				$(away_score).css({backgroundColor:"yellow", color:"initial"});
				$(away_name).css({backgroundColor:"yellow", color:"initial"});
				$(home_score).css({backgroundColor:"yellow", color:"initial"});
				$(home_name).css({backgroundColor:"yellow", color:"initial"});
			}
		}
		else
		{
			var home_score = $(this);
			var away_score = $(this).parent().prev().children(".awayTeamScore");
			var away_name = $(this).parent().parent().find(".away_team_select");
			var home_name = $(this).parent().parent().find(".home_team_select");
			if($(away_score).val() > $(home_score).val())
			{
				$(away_score).css({backgroundColor:"green", color:"white"});
				$(away_name).css({backgroundColor:"green", color:"white"});
				$(home_score).css({backgroundColor:"red", color:"white"});
				$(home_name).css({backgroundColor:"red", color:"white"});
			}
			else if($(away_score).val() < $(home_score).val())
			{
				$(away_score).css({backgroundColor:"red", color:"white"});
				$(away_name).css({backgroundColor:"red", color:"white"});
				$(home_score).css({backgroundColor:"green", color:"white"});
				$(home_name).css({backgroundColor:"green", color:"white"});
			}
			else
			{
				$(away_score).css({backgroundColor:"yellow", color:"initial"});
				$(away_name).css({backgroundColor:"yellow", color:"initial"});
				$(home_score).css({backgroundColor:"yellow", color:"initial"});
				$(home_name).css({backgroundColor:"yellow", color:"initial"});
			}
		}
		
	});

//Remove players added with the add player button
	$("body").on("click", "button.removeNewEditPlayer", function(e){
		e.preventDefault();
		$(this).prevUntil("button").remove();
		$(this).remove();
	});
	
//Check schedule for errors before bringing up modal
	$("body").on("click", "#submit_edit_schedule, #submit_new_schedule, #editAllGames", function(e){
		e.preventDefault();
		var weekNum = $(".weekNumSchedule:visible").text();
		$(modalField.modalTitle).text("Confirm");
		$(modalField.modalCancelBtn).text("Cancel Edit");
		$(modalField.modalConfirmBtn).text("Send Schedule");
		
		if($(this).attr("id") == "submit_new_schedule")	{
			$(modalField.modalContent).text("Games without a date will not be added. Are you sure that you want to add week(s) to the schedule?");
			$(modalField.modalConfirmBtn).addClass("confirmNewSchedule");
			$("#admin_overlay, #admin_modal").fadeIn("slow", function(){});
		}
		else if($(this).attr("id") == "submit_edit_schedule") {
			$(modalField.modalContent).text("Games without a date will not be added. Are you sure that you want to edit week "+weekNum+"'s schedule?");
			$(modalField.modalConfirmBtn).addClass("confirmEditSchedule");
			$("#admin_overlay, #admin_modal").fadeIn("slow", function(){});
		}
		else {
			$(".weekScheduleTable:visible input, .weekScheduleTable:visible select").removeClass("disabledBtn").removeAttr("disabled");
			$(".weekScheduleTable:visible button").addClass("disabledBtn").attr("disabled", true);
			$("#submit_edit_schedule").fadeIn();
		}
	});
});

//Toggle between the stat categories
function statsToggle()
{
	var $statCategories = new Array(
		$("#league_leaders"), 
		$("#player_stats"), 
		$("#team_stats")
	);
	
	if($("#league_leaders_btn").hasClass("activeBtn")) {
		$statCategories[0].show(); $statCategories[1].hide(); $statCategories[2].hide();
	} else if($("#player_stats_btn").hasClass("activeBtn")) {
		$statCategories[0].hide(); $statCategories[1].show(); $statCategories[2].hide();
	} else {
		$statCategories[0].hide(); $statCategories[1].hide(); $statCategories[2].show();
	}
}

// Tooltips Initialization
$(function () {
  $('[data-toggle="tooltip"]').tooltip();
});

// MDB Lightbox Init
$(function () {
	$("#mdb-lightbox-ui").load("/addons/mdb-lightbox-ui.html");
});