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
	
	//Toggle value for checked item
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
	
	//Toggle value for leagues ages and competition for leages edit page
	$("body").on("click", ".compBtnSelect, .ageBtnSelect", function(e) {
		console.log($(this));
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
	
	// Add a new player row on the team edit page
	$('body').on('click', '.addPlayerBtn', function() {
		var newPlayer = $('.newPlayerRow').clone();
		
		$(newPlayer).removeClass('hidden newPlayerRow')
			.insertBefore('#team_players_table .newPlayerRow')
			.removeAttr('hidden')
			.find('input, button').removeClass('hidden').removeAttr('disabled');
	});
	
	// Remove the newly added player row on team edit page
	$('body').on('click', '.removeNewPlayerRow', function() {
		$(this).parents('tr').remove();
	});
	
	
//Variables being used often
	var windowHeight = window.innerHeight;
	var playerID, teamID, gameID;
	var username = $(".loggedInUser").text();
	var loginAttempt = 0;
	var modalField = {
		modalTitle:$("#modal_title"),
		modalContent:$("#modal_content"),
		modalConfirmBtn:$("#confirmBtn"),
		modalCancelBtn:$("#cancelBtn"),
		modalOKBtn:$("#okBtn"),
		modalLoginDiv:$("#loginDiv")
	};
	
	var $statCategories = new Array($("#league_leaders"), 
									$("#player_stats"), 
									$("#team_stats")
	);
	
	var $teamNames = $(".teamName");
	
//Reorder the games to be in order by date
	var gamesOrder = [Number($("#game_week_select option").attr("id"))];
		gamesOrder.sort();
	
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
		var topShelf = window.pageYOffset + 50;
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
			$(this).children(".teamNameTD").text(),
			$(this).children(".jerseyNumTD").text()
		];
		
		$(".playerNamePlayerCard").text(playerStats[0]);
		$(".jerseyNumPlayerCard").text(playerStats[16]);
		$(".teamNameVal").text(playerStats[15]);
		$(".perGamePointsVal").text(playerStats[2]);
		$(".perGameAssistVal").text(playerStats[8]);
		$(".perGameReboundsVal").text(playerStats[10]);
		$(".perGameStealsVal").text(playerStats[12]);
		$(".perGameBlocksVal").text(playerStats[14]);
		$("#player_card").css({"top":topShelf+"px"});
		$("#player_card, #card_overlay").fadeIn();
		$(".closeCard, #card_overlay").on("click", function()
		{
			$("#player_card, #card_overlay").fadeOut();
		});
	});
	
//Add team stats to team card and display	
	$("body").on("click", "#team_stats tr:not(:first)", function(e)
	{	
		var topShelf = window.pageYOffset + 30;
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
		$(".teamCardHeader").css({"backgroundImage":"url('"+teamStats[18]+"')"})
		$("#card_overlay").css({"min-height":windowHeight+"px"});
		$("#team_card").css({top:topShelf+"px"});
		$("#team_card, #card_overlay").fadeIn();
		$(".closeCard, #card_overlay").on("click", function()
		{
			$("#team_card, #card_overlay").fadeOut();
		});				
	});
	
//Add new player field to current fieldset
	$("body").on("click", ".addAnotherPlayer", function(e)
	{
		e.preventDefault();
		var parentDiv = $(e.target).parent().parent().attr("id");
		if(parentDiv == "add_team_form") {
			var newPlayerRow = "<label for='team_player_name'>Player Info</label><input type='text' name='team_player_name[]' class='formInput formNameInput' id='form_team_player_nam' placeholder='Full Name' /><input type='number' name='team_player_num[]'  class='formInput formNumInput' placeholder='Jersey #' /><br/>";
			$(newPlayerRow).appendTo(".newTeamInfo");
		}
		else if(parentDiv == "edit_team_form") {
			var newPlayerRow = "<label for='player_name' class='editTeamLabel' style='color:green'>Player Info</label><input type='text' name='newTeamsPlayers[]' id='' class='edit_team_form_PN' value='' placeholder='Player Name' /><input type='number' name='newTeamsPlayersJersey[]' class='edit_team_form_JN' placeholder='#' /><button class='removeNewEditPlayer'>-</button>";
			$(newPlayerRow).appendTo(".editTeamInfo");
		}
		else {
			console.log("Something random happened here!");
		}	
	});
	
	//Get select week schedule to edit
	//Add new week or new game to schedule
	//Add team id to hidden value when team name changed
	//Change background colors of winner/loser when score is changed
	$("body").on("change", "#game_week_select2", function(e) {
		$(".addToSchedule, .weekScheduleTable:visible button").removeAttr("disabled").removeClass("disabledBtn");
		getWeekSchedule();
	});
	
	$("body").on("click", "#addNewWeek, #addNewGame", function(e) {
		var gameRow = getLastGameRow();
		
		if($(this).attr("id") == "addNewGame") {
			$(gameRow).appendTo(".weekScheduleTable:visible");
			if($("#submit_edit_schedule:visible").length > 0) {
				$(gameRow).find("input, select").removeAttr("disabled")
					.removeClass("disabledBtn");
				$(gameRow).find("button").attr("disabled", true)
					.addClass("disabledBtn");
			}
			else {
				$(gameRow).find("input, select").attr("disabled", true)
					.addClass("disabledBtn");
				$(gameRow).find("button").removeAttr("disabled")
					.removeClass("disabledBtn");
			}
		}
		else {
			if($(".newWeekTable").length > 0)
			{
				$("#game_week_select2 #blank").prop("selected", true);
				$("#game_week_select2").change();
				$(".weekScheduleTable").hide();
				$(".newWeekTable").show();
				$(".newWeekTable input, .newWeekTable select").removeAttr("disabled")
					.removeClass("disabledBtn");
				$(".newWeekTable button").attr("disabled", true)
					.addClass("disabledBtn");
			}
			else {
				var getNewWeekNum = Number($(".weekNumSchedule").last().text()) + 1;
				var newWeekTable = createNewWeek();
					gameRow = $(gameRow).wrap("<tr></tr>");
					$(gameRow).find(".seasonWeekInput")
						.attr({"value":getNewWeekNum})
						.val(getNewWeekNum);
				$(newWeekTable).appendTo("#current_week_schedule_form");
				$(".weekScheduleTable").hide();
				$("#game_week_select2 #blank").prop("selected", true);
				$("#game_week_select2").change();
				
				for(i=0; i <= 5; i++) {
					var addGameRow = $(gameRow).clone();
					$(addGameRow).appendTo(".newWeekTable");	
				}
				
				$(".newWeekTable, #submit_edit_schedule").show();
				$(".newWeekTable input, .newWeekTable select").removeAttr("disabled")
					.removeClass("disabledBtn");
				$(".newWeekTable button").attr("disabled", true)
					.addClass("disabledBtn");
			}
			$("#submit_edit_schedule").fadeIn();
			$("#removeWeek, #editAllGames").attr("disabled", true)
				.addClass("disabledBtn");
		}
	});
	
	$("body").on("change", ".away_team_select.teamSelect, .home_team_select.teamSelect", function(e){
		var teamIDs = $(this).find("option:selected").attr("id").slice(4);
		if($(this).attr("class") == "away_team_select teamSelect")
		{
			$(this).parent().parent().find(".awayTeamIdInput").val(teamIDs);
		}
		else
		{
			$(this).parent().parent().find(".homeTeamIdInput").val(teamIDs);
		}
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
	
//Remove player from team or whole team
	$("body").on("click", ".removePlayer, .removeTeam, .modalElement.modalElementConfirmBtn.confirmRemovePlayer, .modalElement.modalElementConfirmBtn.confirmRemoveTeam", function(e)
	{
		e.preventDefault();
		if($(e.target).attr("class") == "removePlayer") {
			playerID = $(this).prev().val();
			$(modalField.modalTitle).text("Confirm");
			$(modalField.modalContent).text("Are you sure you want to remove this player?");
			$(modalField.modalConfirmBtn).text("Remove Player").addClass("confirmRemovePlayer").removeAttr("id");
			$(modalField.modalCancelBtn).text("Cancel");
			$("#admin_overlay, #admin_modal").fadeIn("slow");
			return playerID;
		}
		
		else if($(this).attr("class") == "modalElement modalElementConfirmBtn confirmRemovePlayer")
		{
			$(this).attr("disabled", true);
			var teamID = $("#team_select3 option:selected").attr("class");
			$.post("admin2.php", {playerID:playerID, removePlayer:"yes", username:username}, function(data){
				$.ajax({url:"admin.php",
					cache: false})
					.done(function(data) {
						var teamsInfo = $(data).find("#team"+teamID+" #team_info_load");
						var teamsStats = $(data).find("#edit_stats_load_div");
						var teamsSchedule = $(data).find("#edit_schedule_content");
						$("#team"+teamID).html(teamsInfo);
						$("#edit_stats").html(teamsStats);
						$("#edit_schedule").html(teamsSchedule);
					});
				$(modalField.modalContent).text(data);
				$(modalField.modalConfirmBtn).hide("");
				$(modalField.modalCancelBtn).hide("");
				$(modalField.modalTitle).text("Completed");
				$("#admin_overlay, #admin_modal").fadeOut("slow", function(){
					$("#admin_modal").css({minWidth:"initial", minHeight:"25%", top:"4%", left:"80%"}).fadeIn("slow");
				});
				setTimeout(function(){
					$("#admin_modal").fadeOut("slow", function(){ $("#admin_modal").css({minWidth:"50%", minHeight:"30%", top:"10%", left:"25%"}); });
					$(modalField.modalConfirmBtn).show("").removeAttr("disabled").removeClass("confirmRemovePlayer").attr("id", "confirmBtn");
					$(modalField.modalCancelBtn).show("");
				}, 5000);
			});
		}
			
		else if($(this).attr("class") == "modalElement modalElementConfirmBtn confirmRemoveTeam")
		{
			$(this).attr("disabled", true);
			teamID = $("#team_select3 option:selected").attr("class");
			$.post("admin2.php", {teamID:teamID, removeTeam:"yes", username:username}, function(data)
			{
				$("#edit_team").load("admin.php #edit_team_load_div");
				$("#edit_stats").load("admin.php #edit_stats_load_div");
				$("#edit_schedule").load("admin.php #edit_schedule_content");
				$(modalField.modalContent).text(data);
				$(modalField.modalConfirmBtn).hide("");
				$(modalField.modalCancelBtn).hide("");
				$(modalField.modalTitle).text("Completed");
				$("#admin_overlay, #admin_modal").fadeOut("slow", function(){
					$("#admin_modal").css({minWidth:"initial", minHeight:"25%", top:"4%", left:"80%"}).fadeIn("slow");
				});
				setTimeout(function(){
					$("#admin_modal").fadeOut("slow", function(){ $("#admin_modal").css({minWidth:"50%", minHeight:"30%", top:"10%", left:"25%"}); });
					$(modalField.modalConfirmBtn).show("").removeAttr("disabled").removeClass("confirmRemoveTeam").attr("id", "confirmBtn");
					$(modalField.modalCancelBtn).show("");
				}, 5000);
			});
		}
		
		else 
		{
			e.preventDefault();
			teamID = $(this).prev().val();
			$(modalField.modalTitle).text("Confirm");
			$(modalField.modalContent).text("Are you sure you want to remove this team?");
			$(modalField.modalConfirmBtn).text("Remove Team").addClass("confirmRemoveTeam").removeAttr("id");
			$(modalField.modalCancelBtn).text("Cancel");
			$("#admin_overlay, #admin_modal").fadeIn("slow");
			return teamID;
		}	
	});
	
//Remove whole week or game from a week
	$("body").on("click", "#removeWeek, #removeGame", function(e){
		if($(this).attr("id") == "removeGame")
		{
			e.preventDefault();
			$(".removeTD").show("slow");
		}
		else
		{
			$(modalField.modalTitle).text("Confirm");
			$(modalField.modalContent).text("Are your sure you want to delete this whole week?");
			$(modalField.modalConfirmBtn).text("Remove Week").addClass("removeAllGames");
			$(modalField.modalCancelBtn).text("Cancel");
			$("#admin_modal, #admin_overlay").fadeIn();
		}
	});	
	
//Remove players added with the add player button
	$("body").on("click", "button.removeNewEditPlayer", function(e){
		e.preventDefault();
		$(this).prevUntil("button").remove();
		$(this).remove();
	});
	
//Get player and player stats from individual week to add to table
//Allow editing of all players stats
//Change update button to a button that will send data
//Change background color of edited field
	$("body").on("change", "#team_name_select2", function(e){
		getTeamGames();	
	});
	$("body").on("change", "#game_week_select", function(e){
		var getGameInfo = $("#game_week_select option:selected").attr("id");
		getPlayerStats(getGameInfo);
	});
	
	$("body").on("click", "#update_all_btn", function(e){
		e.preventDefault();
		$(".editPlayerNamesTable").each(function(){
			var getGameInfo = $("#game_week_select option:selected").attr("id");
			if($(this).hasClass(getGameInfo)){
				$(this).find("input").removeAttr("disabled");
			}
			else {
				$(this).find("input").attr("disabled", true);
			}
		});
		$("#submit_edit_stats").fadeIn().removeAttr("disabled");
		$("td.editPlayerStatTD button").attr("disabled", true).removeClass("submitIndPlayerStat").css({backgroundColor:"buttonface", color:"initial", border:"outset 2px buttonface", margin:"0.75% 0%", minWidth:"75%", borderRadius:"5px"}).text("Update");
		$("#submit_edit_stats").css({backgroundColor:"cornflowerblue"}).fadeIn(function(){ $("html, body").animate({scrollTop:'+200'}); });
		$(this).css({backgroundColor:"darkgray", color:"white"}).text("Update Individual").attr("id", "update_ind_btn");
	});
	
	$("body").on("click", "#update_ind_btn", function(e){
		e.preventDefault();
		$("td.editPlayerStatTD input").attr("disabled", true);
		$("td.editPlayerStatTD button").removeAttr("disabled").removeClass("submitIndPlayerStat").css({backgroundColor:"yellow", color:"initial", border:"outset 2px darkkhaki"}).text("Update");
		$("#submit_edit_stats").fadeOut().attr("disabled", true).css({backgroundColor:"darkgray"});
		$(this).css({backgroundColor:"buttonface", color:"black"}).text("Update All").attr("id", "update_all_btn");
	});
	
	$("body").on("click", ".updateIndBtn", function(e){
		e.preventDefault();
		$("td.editPlayerStatTD input").attr("disabled", true);
		$("td.editPlayerStatTD button").addClass("updateIndBtn").removeClass("submitIndPlayerStat").css({backgroundColor:"yellow", color:"initial", border:"outset 2px darkkhaki"}).text("Update");
		$(this).addClass("submitIndPlayerStat").removeClass("updateIndBtn").css({backgroundColor:"cornflowerblue", border:"outset 2px dodgerblue", color:"white"}).text("Send");
		$(this).parent().parent().find("input").removeAttr("disabled");
		$("#update_all_btn").css({backgroundColor:"buttonface", color:"initial", border:"outset 2px buttonface"});
	});
	
	$("body").on("change", "td.editPlayerStatTD input", function(e){
		$(this).parent().css({backgroundColor:"yellow"});
	});
	
//Get Team and Players to edit 
	$("body").on("change", "#team_select3", function(e)
	{
		showEditLeague();
	});
	
//Get team id and add it to the input value
	$("body").on("change", "#team_name_select", function(e)
	{
		var getTeamIDValue = $("#team_name_select option:selected").attr("id").slice(7);
		var getTeamIDInput = $(this).parent().parent().find("#form_team_id");
		getTeamIDInput.val(getTeamIDValue);
		console.log(getTeamIDInput.val(getTeamIDValue));
	});
	
//Send new team information
	$("body").on("click", "#submit_new_team", function(e)
	{
		e.preventDefault();
		var teamNameVal = $("form#add_team_form #form_team_name").val();
		var playerNameVal = $("form#add_team_form .formNameInput");
		var jerseyNumVal = $("form#add_team_form .formNumInput");
		var errors = 0;
		$(modalField.modalConfirmBtn).text("Send New Team").addClass("confirmNewTeam");
		$(modalField.modalCancelBtn).text("Edit New Team");
		$(modalField.modalTitle).text("Confirm");
		$(modalField.modalContent).text("Are you sure that you want to add this new team to your league?");
		$(playerNameVal).each(function(){ $(this).css({borderColor:"initial"}); });
		$("form#add_team_form #form_team_name").css({borderColor:"initial"});
		for(var ii=0; ii < $(playerNameVal).length; ii++)
		{
			if($(playerNameVal[ii]).val() == "" && $(jerseyNumVal[ii]).val() != "") {
				var playerRow = $(playerNameVal[ii]);
				playerRow.css({borderColor:"red"});
				errors++;
			}
			else {
				console.log("Everything seems ok.")
			}
		}
		if(teamNameVal == "") {
			e.preventDefault();
			$("form#add_team_form #form_team_name").css({borderColor:"red"});
			console.log("Team Name Cannot Be Empty!");
		}
		else if(errors > 0) {
			e.preventDefault();
			$(modalField.modalTitle).text("Error").css({backgroundColor:"red"});
			$(modalField.modalContent).text("Add player name or remove jersey number.");
			$(modalField.modalConfirmBtn).hide("");
			$(modalField.modalCancelBtn).hide("");
			$(modalField.modalOKBtn).show().text("Ok");
			$("#admin_overlay, #admin_modal").fadeIn("slow", function(){});
		}
		else {
			e.preventDefault();
			$("#admin_overlay, #admin_modal").fadeIn("slow", function(){});
		}
	});
	
//Send edited player(s) and team information 	
	$("body").on("click", "#submit_edit_team", function(e)
	{
		e.preventDefault();
		var teamName = $("form#edit_team_form #edit_team_form_TN").val();
		var playerName = $("form#edit_team_form .edit_team_form_PN");
		var jerseyNum = $("form#edit_team_form .edit_team_form_JN");
		var errors = 0;
		$(modalField.modalConfirmBtn).text("Edit Team").addClass("confirmEditTeam");
		$(modalField.modalCancelBtn).text("Cancel Edit");
		$(modalField.modalTitle).text("Confirm");
		$(modalField.modalContent).text("Are you sure that you want to edit this team's information?");
		$(playerName).each(function(){ $(this).css({borderColor:"initial"}); });
		$("form#edit_team_form #edit_team_form_TN").css({borderColor:"initial"});
		for(var ii=0; ii < $(playerName).length; ii++)
		{
			if($(playerName[ii]).val() == "" && $(jerseyNum[ii]).val() != "") {
				var playerRow = $(playerName[ii]);
				playerRow.css({borderColor:"red"});
				errors++;
			}
			else {
				console.log("Everything seems ok.")
			}
		}
		if(teamName == "") {
			e.preventDefault();
			$(modalField.modalTitle).text("Error");
			$(modalField.modalContent).text("The team name cannot be empty.");
			$(modalField.modalConfirmBtn).hide("");
			$(modalField.modalCancelBtn).hide("");
			$(modalField.modalOKBtn).text("Ok");
			$("form#edit_team_form #edit_team_form_TN").css({borderColor:"red"});
			$("#admin_overlay, #admin_modal").fadeIn("slow", function(){
				$(modalField.modalOKBtn).on("click", function(event) {
					$("#admin_overlay, #admin_modal").fadeOut("slow");
				});
			});	
		}
		else if(errors > 0) 
		{
			e.preventDefault();
			$(modalField.modalTitle).text("Error").css({backgroundColor:"red"});
			$(modalField.modalContent).text("Add player name or remove jersey number.");
			$(modalField.modalConfirmBtn).hide("");
			$(modalField.modalCancelBtn).hide("");
			$(modalField.modalOKBtn).show().text("Ok");
			$("#admin_overlay, #admin_modal").fadeIn("slow", function(){});
		}
		else 
		{
			e.preventDefault();
			$("#admin_overlay, #admin_modal").fadeIn("slow", function(){});
		}
	});
	
//Send edited individual stats and team stats
	$("body").on("click", "#submit_edit_stats, .submitIndPlayerStat", function(e)
	{
		e.preventDefault();
		var teamID = $("#team_name_select2 option:selected").attr("class");
		var gameID = $("#game_week_select option:selected").attr("class");
		if($(e.target).attr("class") == "submitIndPlayerStat") {
			var indStatValues = $(this).parent().parent().find("input");
			$(this).attr("disabled", true);
			$(modalField.modalConfirmBtn).hide("");
			$(modalField.modalCancelBtn).hide("");
			$(modalField.modalOKBtn).hide("");
			$.post("admin2.php", 
					{points:$(indStatValues[0]).val(), 
					threes:$(indStatValues[1]).val(), 
					fts:$(indStatValues[2]).val(), 
					assist:$(indStatValues[3]).val(), 
					rebounds:$(indStatValues[4]).val(), 
					steals:$(indStatValues[5]).val(), 
					blocks:$(indStatValues[6]).val(),
					playerID:$(indStatValues[7]).val(),
					teamID:teamID, 
					gameID:gameID,
					editPlayerStats: "yes",
					username:username},
					function(data){
						$(modalField.modalTitle).text("Completed");
						$(modalField.modalContent).text(data);
						$("#admin_modal").css({minWidth:"initial", minHeight:"25%", top:"4%", left:"80%"}).fadeIn("slow");	
						$("td.editPlayerStatTD input").attr("disabled", true);
						$("td.editPlayerStatTD button").addClass("updateIndBtn").removeClass("submitIndPlayerStat").css({backgroundColor:"yellow", border:"outset 2px darkkhaki", color:"initial"}).text("Update");
						$("td.editPlayerStatTD").css({backgroundColor:"initial"});
						$(".updateIndBtn").removeAttr("disabled");
						setTimeout(function(){
							$("#admin_modal").fadeOut("slow", function(){ $("#admin_modal").css({minWidth:"50%", minHeight:"50%", top:"10%", left:"25%"}); });
							$(modalField.modalConfirmBtn).show("");
							$(modalField.modalCancelBtn).show("");
						}, 3000);
			});
		}
		else {
			$(modalField.modalConfirmBtn).hide("");
			$(modalField.modalCancelBtn).hide("");
			$(modalField.modalOKBtn).hide("");
			$(this).attr("disabled", true);
			$.post("admin2.php", ($("form#edit_player_stats_form").serialize()+'&'+$.param({teamID:teamID, gameID:gameID, editTeamStats:"yes", username:username})), function(data)
			{
				$(modalField.modalContent).text(data);
				$(modalField.modalTitle).text("Completed");
				$("#submit_edit_stats").removeAttr("disabled");
				$("#admin_modal").css({minWidth:"initial", minHeight:"25%", top:"4%", left:"80%"}).fadeIn("slow");
				$("td.editPlayerStatTD button").removeClass("submitIndPlayerStat").css({backgroundColor:"buttonface", color:"initial"}).text("Update");
				$("td.editPlayerStatTD").css({backgroundColor:"initial"});
				setTimeout(function(){
					$("#admin_modal").fadeOut("slow", function(){ $("#admin_modal").css({minWidth:"50%", minHeight:"50%", top:"10%", left:"25%"}); });
					$(modalField.modalConfirmBtn).show("");
					$(modalField.modalCancelBtn).show("");
				}, 3000);
			});
			
		}
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
//Send actual data
	$("body").on("click", "#confirmBtn, #cancelBtn", function(event) {
		var weekNum = $(".weekNumSchedule:visible").text();
		if($(this).attr("class") == "modalElement modalElementConfirmBtn confirmEditSchedule")
		{
			//alert($("#current_week_schedule_form").serialize());
			$(this).attr("disabled", true);
			$(".weekScheduleTable input, .weekScheduleTable select").attr("disabled", true);
			$(".weekScheduleTable:visible input, .weekScheduleTable:visible select").removeAttr("disabled");
			$.post("admin2.php", ($("#current_week_schedule_form").serialize()+'&'+$.param({editSchedule:'yes', username:username})), function(data)
			{
				$("#edit_schedule").load("admin.php #edit_schedule_content", function()
				{
					$("#edit_team").load("admin.php #edit_team_load_div");
					$("#edit_stats").load("admin.php #edit_stats_load_div");
				});
				$(modalField.modalTitle).text("Completed");
				$(modalField.modalContent).text(data);
				$(modalField.modalConfirmBtn).hide("");
				$(modalField.modalCancelBtn).hide("");
				$("#admin_overlay, #admin_modal").fadeOut("slow", function(){
					$("#admin_modal").css({minWidth:"initial", minHeight:"25%", top:"4%", left:"80%"}).fadeIn("slow");
				});
				setTimeout(function(){
					$("#admin_modal").fadeOut("slow", function(){ $("#admin_modal").css({minWidth:"50%", minHeight:"30%", top:"10%", left:"25%"}); });
					$(modalField.modalConfirmBtn).show("").removeAttr("disabled").removeClass("confirmEditSchedule");
					$(modalField.modalCancelBtn).show("");
				}, 5000);
			});
		}
		
		else if($(this).attr("class") == "modalElement modalElementConfirmBtn confirmNewSchedule")
		{
			$(this).attr("disabled", true);
			$.post("admin2.php", ($("#new_week_schedule_form").serialize()+'&'+$.param({newSchedule:"yes", username:username})), function(data){					
				$("#edit_schedule").load("admin.php #edit_schedule_content", function(){
					$("#edit_team").load("admin.php #edit_team_load_div");
					$("#edit_stats").load("admin.php #edit_stats_load_div");
				});
				$(modalField.modalTitle).text("Completed");
				$(modalField.modalContent).text(data);
				$(modalField.modalConfirmBtn).hide("");
				$(modalField.modalCancelBtn).hide("");
				$("#admin_overlay, #admin_modal").fadeOut("slow", function(){
					$("#admin_modal").css({minWidth:"initial", minHeight:"25%", top:"4%", left:"80%"}).fadeIn("slow");
				});
				setTimeout(function(){
					$("#admin_modal").fadeOut("slow", function(){ $("#admin_modal").css({minWidth:"50%", minHeight:"30%", top:"10%", left:"25%"}); });
					$(modalField.modalConfirmBtn).show("").removeAttr("disabled").removeClass("confirmNewSchedule");
					$(modalField.modalCancelBtn).show("");
				}, 5000);
			});
		}
		else if($(this).attr("class") == "modalElement modalElementConfirmBtn confirmNewTeam")
		{
			$(this).attr("disabled", true);
			$.post("admin2.php", ($("form#add_team_form").serialize()+'&'+$.param({newTeam:"yes", username:username})), function(data)
			{
				$("#add_team").load("admin.php #add_team_content", function(){
					$("#edit_team").load("admin.php #edit_team_load_div");
					$("#edit_stats").load("admin.php #edit_stats_load_div");				
					$("#edit_schedule").load("admin.php #edit_schedule_content");
				});
				$(modalField.modalContent).text(data);
				$(modalField.modalConfirmBtn).hide("");
				$(modalField.modalCancelBtn).hide("");
				$(modalField.modalTitle).text("Completed");
				$("#admin_overlay, #admin_modal").fadeOut("slow", function(){
					$("#admin_modal").css({minWidth:"initial", minHeight:"25%", top:"4%", left:"80%"}).fadeIn("slow");
					$("#submit_new_team").fadeIn();
				});
				setTimeout(function(){
					$("#admin_modal").fadeOut("slow", function(){ $("#admin_modal").css({minWidth:"50%", minHeight:"30%", top:"10%", left:"25%"}); });
					$(modalField.modalConfirmBtn).show("").removeAttr("disabled").removeClass("confirmNewTeam");
					$(modalField.modalCancelBtn).show("");
				}, 5000);
			});
		}
		
		else if($(this).attr("class") == "modalElement modalElementConfirmBtn confirmEditTeam")
		{
			$(this).attr("disabled", true);
			var teamID = $("#team_select3 option:selected").attr("class");
			$.post("admin2.php", ($("form#edit_team_form").serialize()+'&'+$.param({editTeam:"yes", username:username})), function(data)
			{
				$.ajax({url:"admin.php",
					cache: false})
					.done(function(data) {
						var teamsInfo = $(data).find("#edit_team_load_div");
						var teamsStats = $(data).find("#edit_stats_load_div");
						var teamsSchedule = $(data).find("#edit_schedule_content");
						$("#edit_team").html(teamsInfo);
						$("#edit_stats").html(teamsStats);
						$("#edit_schedule").html(teamsSchedule);
					});
					
				$(modalField.modalContent).text(data);
				$(modalField.modalConfirmBtn).hide("");
				$(modalField.modalCancelBtn).hide("");
				$(modalField.modalTitle).text("Completed");
				$("#admin_overlay, #admin_modal").fadeOut("slow", function(){
					$("#admin_modal").css({minWidth:"initial", minHeight:"25%", top:"4%", left:"80%"}).fadeIn("slow");
				});
				setTimeout(function(){
					$("#admin_modal").fadeOut("slow", function(){ $("#admin_modal").css({minWidth:"50%", minHeight:"30%", top:"10%", left:"25%"}); });
					$(modalField.modalConfirmBtn).show("").removeAttr("disabled").removeClass("confirmEditTeam");
					$(modalField.modalCancelBtn).show("");
				}, 5000);
			});
		}
		
		else if($(this).attr("class") == "modalElement modalElementConfirmBtn updateWeekGame")
		{
			$(this).attr("disabled", true);
			var getRowToUpdate = $(".activeRow");
			var awayScore = getRowToUpdate.find(".awayTeamScore.teamScore").val();
			var homeScore = getRowToUpdate.find(".homeTeamScore.teamScore").val();
			var homeTeamID = getRowToUpdate.find(".home_team_select option:selected").attr("id");
			var awayTeamID = getRowToUpdate.find(".away_team_select option:selected").attr("id");
			var awayTeamName = getRowToUpdate.find(".away_team_select option:selected").val();
			var homeTeamName = getRowToUpdate.find(".home_team_select option:selected").val();
			var gameTime = getRowToUpdate.find(".game_time_select option:selected").val();
			var gameDate = getRowToUpdate.find(".game_date").val();
			var gameID = getRowToUpdate.find(".gameIdInput").val();
			var seasonWeek2 = getRowToUpdate.find(".seasonWeekInput").val();
			
			$.post("admin2.php", $.param({editSchedule:"yes",  
				username:username,
				game_id3:gameID,
				away_team_select3:awayTeamName,
				home_team_select3:homeTeamName,
				game_time_select3:gameTime,
				game_date3:gameDate,
				season_week3:seasonWeek2,
				home_team_id3:homeTeamID.slice(4),
				away_team_id3:awayTeamID.slice(4),
				awayTeamScore3:awayScore,
				homeTeamScore3:homeScore
			 }), 
			function(data)
			{
				$("#edit_team").load("admin.php #edit_team_load_div", {team_ID2:teamID, get_team:"yes"}, function(){
					$("#edit_stats").load("admin.php #edit_stats_load_div");
					$("#edit_schedule").load("admin.php #edit_schedule_content");
				});
				$(modalField.modalContent).text(data);
				$(modalField.modalConfirmBtn).hide("");
				$(modalField.modalCancelBtn).hide("");
				$(modalField.modalTitle).text("Completed");
				$("#admin_overlay, #admin_modal").fadeOut("slow", function(){
					$("#admin_modal").css({minWidth:"initial", minHeight:"25%", top:"4%", left:"80%"}).fadeIn("slow");
				});
				setTimeout(function(){
					$("#admin_modal").fadeOut("slow", function(){ $("#admin_modal").css({minWidth:"50%", minHeight:"30%", top:"10%", left:"25%"}); });
					$(modalField.modalConfirmBtn).show("").removeAttr("disabled").removeClass("updateWeekGame");
					$(modalField.modalCancelBtn).show("");
				}, 5000);
			});
		}
		else if($(this).attr("class") == "modalElement modalElementConfirmBtn removeAllGames")
		{
			var seasonWeek = $(".weekScheduleTable:visible .seasonWeekInput").val();
			$.post("admin2.php", {seasonWeek:seasonWeek, removeWeek:"yes", username:username}, function(data){
				$("#edit_team").load("admin.php #edit_team_load_div");
				$("#edit_stats").load("admin.php #edit_stats_load_div");
				$("#edit_schedule").load("admin.php #edit_schedule_content");
				$(modalField.modalContent).text(data);
				$(modalField.modalConfirmBtn).hide("");
				$(modalField.modalCancelBtn).hide("");
				$(modalField.modalTitle).text("Completed");
				$("#admin_overlay, #admin_modal").fadeOut("slow", function(){
					$("#admin_modal").css({minWidth:"initial", minHeight:"25%", top:"4%", left:"80%"}).fadeIn("slow");
				});
				setTimeout(function(){
					$("#admin_modal").fadeOut("slow", function(){ $("#admin_modal").css({minWidth:"50%", minHeight:"30%", top:"10%", left:"25%"}); });
					$(modalField.modalConfirmBtn).show("").removeAttr("disabled").removeClass("removeAllGames").attr("id", "confirmBtn");
					$(modalField.modalCancelBtn).show("");
				}, 5000);
			});
		}
		
		else if($(this).attr("class") == "modalElement modalElementConfirmBtn removeWeekGame")
		{
			var teamID1 = $(".activeRow .awayTeamIdInput").val();
			var teamID2 = $(".activeRow .homeTeamIdInput").val();
			var gameID = $(".activeRow .gameIdInput").val();
			$.post("admin2.php", {gameID:gameID, 
								 removeGame:"yes",
								 awayTeamID:teamID1,
								 homeTeamID:teamID2,  
								 username:username}, 
				function(data){
				$("#edit_team").load("admin.php #edit_team_load_div");
				$("#edit_stats").load("admin.php #edit_stats_load_div");
				$("#edit_schedule").load("admin.php #edit_schedule_content");
				$(modalField.modalContent).text(data);
				$(modalField.modalConfirmBtn).hide("");
				$(modalField.modalCancelBtn).hide("");
				$(modalField.modalTitle).text("Completed");
				$("#admin_overlay, #admin_modal").fadeOut("slow", function(){
					$("#admin_modal").css({minWidth:"initial", minHeight:"25%", top:"4%", left:"80%"}).fadeIn("slow");
				});	
				setTimeout(function(){
					$("#admin_modal").fadeOut("slow", function(){ $("#admin_modal").css({minWidth:"50%", minHeight:"30%", top:"10%", left:"25%"}); });
					$(modalField.modalConfirmBtn).show("").removeAttr("disabled").removeClass("removeWeekGame").attr("id", "confirmBtn");
					$(modalField.modalCancelBtn).show("");
				}, 5000);
			});
		}
		else if($(this).attr("class") == "modalElement modalElementCancelBtn")
		{
			$("#admin_overlay, #admin_modal").fadeOut("slow");
			$(modalField.modalCancelBtn).attr("id", "cancelBtn");
			$(modalField.modalConfirmBtn).attr("id", "confirmBtn").removeAttr("disabled").removeClass("confirmEditTeam confirmNewTeam confirmNewSchedule confirmEditSchedule confirmRemovePlayer confirmRemoveTeam updateWeekGame removeAllGames removeWeekGame");
		}
	});	
	
//Toggle between showing and hiding rules
	$("body").on("click", "#league_rules_btn", function(e)
	{
		$("#leagues_rules").slideToggle();
		$("#league_rules_btn").toggleClass("activeBtn");
	});
	
//Toggle between the stat categories
	function statsToggle()
	{
		if($("#league_leaders_btn").hasClass("activeBtn"))
		{
			$statCategories[0].show(); $statCategories[1].hide(); $statCategories[2].hide();
		}
		else if($("#player_stats_btn").hasClass("activeBtn"))
		{
			$statCategories[0].hide(); $statCategories[1].show(); $statCategories[2].hide();
		}
		else
		{
			$statCategories[0].hide(); $statCategories[1].hide(); $statCategories[2].show();
		}
	}	
//Admin Page bring up add stats or add team or add player
	$("body").on("click", ".addNewBtn", function(e)
	{
		var bbbutton = $(this);
		var firstClick = 0;
		var $allBBBtn = $(".addNewBtn");
		var $add_div = $(".adminPageDiv");
		$($allBBBtn).each(function(event){
			$(this).removeClass("activeBtnAdmin").animate({fontSize:"135%", padding:"2%"});
		});
		
		if(bbbutton.attr("id") == "add_new_team") {
			$($add_div).each(function(event){ 
				$(this).hide();
			});
			$($add_div[0]).slideDown();
			$(this).addClass("activeBtnAdmin");
			$("#submit_new_team").fadeIn();
		}
		else if(bbbutton.attr("id") == "add_edit_team"){
			$($add_div).each(function(event){ 
				$(this).hide();
			});
			$($add_div[1]).slideDown();
			$(this).addClass("activeBtnAdmin");
		}
		else if(bbbutton.attr("id") == "add_edit_schedule") {
			$($add_div).each(function(event){ 
				$(this).hide();
			});
			$($add_div[3]).slideDown();
			$(this).addClass("activeBtnAdmin");
		}
		else {
			$($add_div).each(function(event){ 
				$(this).hide();
			});
			$($add_div[2]).slideDown();
			$(this).addClass("activeBtnAdmin");
		}
	});
//Allow editing of team score and schedule
	$("body").on("click", ".editScoreBtn, .editGameBtn, .removeGameBtn, .updateGameBtn.updateBkgdColor, .cancelGameBtn", function(e){
		e.preventDefault();
		var getUpdateBtn = $(this).parent().parent().find(".updateGameBtn");
		var getTeamsFields = $(this).parent().parent().find(".teamSelect");
		var getTeamScoreFields = $(this).parent().parent().find(".teamScore");
		var getGameTimeField = $(this).parent().parent().find(".game_time_select");
		var getGameDateField = $(this).parent().parent().find(".game_date");
		$(".weekScheduleTable tr").removeClass("activeRow");
		$(this).parent().parent().addClass("activeRow");
		if($(this).attr("class") == "editScoreBtn")
		{
			e.preventDefault();
			$(".updateGameBtn").removeClass("updateBkgdColor")
				.attr("disabled", true);
			$(".teamSelect, .teamScore, .game_date, .game_time_select").addClass("disabledBtn")
				.attr("disabled", true);
			$(getGameTimeField).attr("disabled", true)
				.addClass("disabledBtn");
			$(getGameDateField).attr("disabled", true)
				.addClass("disabledBtn");
			$(getUpdateBtn).addClass("updateBkgdColor").removeAttr("disabled");
			$(getTeamScoreFields).each(function(event){
				$(this).removeClass("disabledBtn").removeAttr("disabled");
			});
			$(getTeamsFields).each(function(){
				$(this).attr("disabled", true).addClass("disabledBtn");
			});
		}
		else if($(this).attr("class") == "editGameBtn")
		{
			e.preventDefault();
			$(".updateGameBtn").removeClass("updateBkgdColor")
				.attr("disabled", true);
			$(".teamSelect, .teamScore, .game_date, .game_time_select").addClass("disabledBtn")
				.attr("disabled", true);
			$(getTeamsFields).each(function(event){
				$(this).removeClass("disabledBtn").removeAttr("disabled");
			});
			$(getGameDateField).add(getGameTimeField).add(getTeamScoreFields).removeClass("disabledBtn").removeAttr("disabled");
			$(getUpdateBtn).addClass("updateBkgdColor").removeAttr("disabled");
		}
		else if($(this).attr("class") == "removeGameBtn")
		{
			e.preventDefault();
			$(modalField.modalTitle).text("Confirm");
			$(modalField.modalContent).text("Are your sure you want to delete this already scheduled game?");
			$(modalField.modalConfirmBtn).text("Remove Game").addClass("removeWeekGame");
			$(modalField.modalCancelBtn).text("Cancel");
			$("#admin_modal, #admin_overlay").fadeIn();
		}
		else if($(this).attr("class") == "updateGameBtn updateBkgdColor")
		{
			e.preventDefault();
			gameID = $(this).parent().next().next().find(".gameIdInput").val();
			$(modalField.modalTitle).text("Confirm");
			$(modalField.modalContent).text("This will update this game only. Are you sure you want to update this game?");
			$(modalField.modalConfirmBtn).text("Update Game").addClass("updateWeekGame");
			$(modalField.modalCancelBtn).text("Cancel");
			$("#admin_modal, #admin_overlay").fadeIn();
			return gameID;
		}
		else
		{
			e.preventDefault();
			$([getTeamScoreFields, getTeamsFields, getGameTimeField, getGameDateField]).each(function(event){
				$(this).addClass("disabledBtn")
					.attr("disabled", true);
			}); 
			$(getUpdateBtn).removeClass("updateBkgdColor").attr("disabled", true);
		}
	});
});

function showEditLeague(){
	var getLeagueID = $("#team_select3 option:selected").attr("class");
	$("#team_select3 #blank").attr("disabled", true);
	$(".editTeamInfo").each(function(){
		$(this).hide()
		$(".editTeamInfo input").attr("disabled", true);
	});
	$("#team"+getLeagueID+", #edit_teams_info").show();
	$("#team"+getLeagueID+" input").removeAttr("disabled");
}

function getWeekSchedule() {
	var weekID = $("#game_week_select2 option:selected").attr("class");
	$("#submit_edit_schedule, #submit_new_schedule").attr("id", "submit_edit_schedule");
	$(".weekScheduleTable, #submit_edit_schedule").hide();
	$("#current_week_schedule, .addToSchedule").show();
	$("#week"+weekID+" input, #week"+weekID+" select").attr("disabled", true)
		.addClass("disabledBtn");
	$("#week"+weekID+" button").removeClass("updateBkgdColor");
	$("#week"+weekID).show();
}

function getTeamGames() {
	var team_ID = $("#team_name_select2 option:selected").attr("class");
	$("#team_name_select2 #blank").attr("disabled", true);
	$("#update_ind_btn").css({backgroundColor:"buttonface", color:"black"}).text("Update All").attr("id", "update_all_btn");
	$("div#game_select h2").css({color:"black"});
	$("#game_week_select").removeAttr("disabled");
	$("#edit_player_stats_content").hide();
	$("#game_week_select option:not(#blank)").each(function(){
		if($(this).attr("id").search("team"+team_ID) == -1) {
			$(this).hide();	
		}
		else {
			$(this).show();
		}
	});
	$("#game_week_select #blank").prop("selected", true);
	$("#game_week_select").change();
}

function getPlayerStats(gameInfo) {
	var game_ID = $("#game_week_select option:selected").attr("class");
	$(".editPlayerNamesTable").each(function(){
		if($(this).hasClass(gameInfo)){
			$("#edit_player_stats_content").fadeIn("slow");
			$("#game_week_select #blank").attr("disabled", true);
			$(this).show();
		}
		else {
			$(this).hide();
		}	
	});
	$("#update_ind_btn").css({backgroundColor:"buttonface", color:"black"})
		.text("Update All")
		.attr("id", "update_all_btn");
	$("td.editPlayerStatTD input").attr("disabled", true);
	$("html, body").animate({scrollTop:'+200'});
	$("#submit_edit_stats").hide("slow")
		.attr("disabled", true);
	$("#update_all_btn").css({backgroundColor:"buttonface", color:"initial", border:"outset 2px buttonface"})
		.show();
	gameInfo = "";
}

function getLastGameRow() {
	var gameRow = $(".weekScheduleTable tr").last().clone();
	var getTeamID = Number($(".teamSelectOption").first().attr("id").slice(4));
	var getWeekNum = Number($(".weekNumSchedule:visible").text());
	$(gameRow).find(".away_team_select")
		.attr("name", "away_team_select2[]");
	$(gameRow).find(".away_team_select option:selected")
		.removeAttr("selected");
	$(gameRow).find(".home_team_select")
		.attr("name", "home_team_select2[]");
	$(gameRow).find(".home_team_select option:selected")
		.removeAttr("selected");
	$(gameRow).find(".game_time_select")
		.attr("name", "game_time_select2[]");
	$(gameRow).find(".game_time_select option:selected")
		.removeAttr("selected");
	$(gameRow).find(".game_date")
		.attr({"name":"game_date2[]", "value":""})
		.val("");
	$(gameRow).find(".gameIdInput")
		.attr({"name":"game_id2[]", "value":""})
		.val("");
	$(gameRow).find(".awayTeamScore")
		.attr({"name":"awayTeamScore2[]", "value":""})
		.val("");
	$(gameRow).find(".homeTeamScore")
		.attr({"name":"homeTeamScore2[]", "value":""})
		.val("");
	$(gameRow).find(".seasonWeekInput")
		.attr({"name":"season_week2[]", "value":getWeekNum})
		.val(getWeekNum);
	$(gameRow).find("input.awayTeamIdInput")
		.attr({"name":"away_team_id2[]", "value":getTeamID})
		.val(getTeamID);
	$(gameRow).find("input.homeTeamIdInput")
		.attr({"name":"home_team_id2[]", "value":getTeamID})
		.val(getTeamID);
	$(gameRow).find(".removeGameBtn")
		.attr("class", "removeGameBtn2");
	return gameRow;
}

function createNewWeek() {
	var newWeekTable = "";
	var getLastWeek = $(".weekNumSchedule").last().text();
	var newWeekNum = Number(getLastWeek) + 1;
		newWeekTable += "<table class='weekScheduleTable newWeekTable' id='week"+newWeekNum+"' style='display: none;'>";
		newWeekTable += "<caption>Week <span class='weekNumSchedule'>"+newWeekNum+"</span> Schedule</caption>";
		newWeekTable += "<tbody><tr><th colspan='3' class='scheduleTH'>Match-Up</th>";
		newWeekTable += "<th colspan='2' class='scheduleTH'>Score</th>";
		newWeekTable += "<th colspan='1' class='scheduleTH'>Time</th>";
		newWeekTable += "<th colspan='1' class='scheduleTH'>Date</th>";
		newWeekTable += "</tr></tbody></table>";
	return newWeekTable;
}

// Tooltips Initialization
$(function () {
  $('[data-toggle="tooltip"]').tooltip();
});

// MDB Lightbox Init
$(function () {
	$("#mdb-lightbox-ui").load("/addons/mdb-lightbox-ui.html");
});