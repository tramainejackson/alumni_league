$(document).ready(function() {	
//Common variables
	var returnedLeagueName = "";
	var registration = $(".registration").detach();
	var login = $(".loginPage").detach();
	var login2 = $(".loginPage2").detach();
	var userNameList, leaguesNameList, checkedUserNameResult, checkedLeagueNameResult;
	var windowHeight = window.innerHeight;
	var windowWidth = window.innerWidth;
	var documentWidth = document.body.clientWidth;
	var documentHeight = document.body.clientHeight;
	var screenHeight = screen.height;
	var screenWidth = screen.width;
	var searchedWinLoc = $(".searches").offset();
	var searchedHight = $(".searches").height();
	var currentY = 0;

//Player filter
	$("body").on("click", ".addFilter", function(e) {
		e.preventDefault();
		var searchCriteria = $(".player_search").val();
		window.open("players.php?filter_search="+searchCriteria, "_self");
	});
	
//Add and remove loading gif when making ajax call
	$(document).ajaxStart(function(){
		$("#loading_image, .maine_overlay").show("fast");
	});
	$(document).ajaxComplete(function(){
		$("#loading_image, .maine_overlay").hide("fast");
	});

//Remove session messages
	if($(".message").length > 0 || $(".errors").length > 0) {
		setTimeout(function() {
			$(".message, .errors").fadeOut();
		}, 7000);
	}	
		
//Make body and container min height same as screen
	$("body, #loginPageContainer, #leaguesProfileContainer, #playerProfileContainer").css({minHeight:windowHeight});
	
//Scroll page to the bottom where selected league is
	if($(".indLeague, .addVideoDiv").length > 0) {
		$("body").animate({scrollTop:screenHeight+"px"}, "slow");
	}	
//Change calendar user is viewing
	var monthlyCalendar = $(".allCalendar_table");
	var currentMonth = new Date().getMonth();
	var counter = currentMonth + 12;
	
	$("body").on("click", ".prevMonth, .nextMonth", function(e)	{		
		if($(this).attr("class") == "prevMonth") {
			if(counter > 0 && counter <= 23) {
				counter--;
				$(monthlyCalendar).each(function(){
					$(this).hide();
				});
				$(monthlyCalendar[counter]).show();
			}
			
			return counter;

		} else {
			if(counter >= 0 && counter < 23) {
				counter++;
				$(monthlyCalendar).each(function() {
					$(this).hide();
				});
				$(monthlyCalendar[counter]).show();
			}
			
			return counter;	
		}
	}); 
	
//Remove rows more than 3 on calendar
	function removeRows() {
		$(".weekDayContent").each(function() { 
			var numRows = $(this).find(".calendarMatchups").length;
			if(numRows >= 4) {
				$(this).find(".calendarMatchups:gt(2)").hide();
				$(this).find(".moreGamesNotifi").show();
			} else {
				$(this).find(".moreGamesNotifi").hide();
			}
		});
	}	
	
//Bring up calendar day with more information
	$("body").on("click", ".weekDayContent", function(e) {
		var dayData = $(this).clone(false);
		var dayNum = $(this).find(".weekDayNum").text();
		var year = $(this).parents("table").find(".showingYear").text();
		var month = $(this).parents("table").find(".showingMonth").text();
		var date = new Date(month + " " + dayNum + " " + year);
				
		if(date.getDay() == 1) {
			$(".calendar_modal #calendarDay").text("Monday");
			$(".calendar_modal .calendarMatchups:gt(2)").show();
			$(".calendar_modal .gameTime").show();
			$(".calendar_modal .moreGamesNotifi").hide();
		} else if(date.getDay() == 2) {
			$(".calendar_modal #calendarDay").text("Tuesday");
			$(".calendar_modal .calendarMatchups:gt(2)").show();
			$(".calendar_modal .moreGamesNotifi").hide();
			$(".calendar_modal .gameTime").show();
		} else if(date.getDay() == 3) {
			$(".calendar_modal #calendarDay").text("Wednesday");
			$(".calendar_modal .calendarMatchups:gt(2)").show();
			$(".calendar_modal .moreGamesNotifi").hide();
			$(".calendar_modal .gameTime").show();
		} else if(date.getDay() == 4) {
			$(".calendar_modal #calendarDay").text("Thursday");
			$(".calendar_modal .calendarMatchups:gt(2)").show();
			$(".calendar_modal .moreGamesNotifi").hide();
			$(".calendar_modal .gameTime").show();
		} else if(date.getDay() == 5) {
			$(".calendar_modal #calendarDay").text("Friday");
			$(".calendar_modal .calendarMatchups:gt(2)").show();
			$(".calendar_modal .moreGamesNotifi").hide();
			$(".calendar_modal .gameTime").show();
		} else if(date.getDay() == 6) {
			$(".calendar_modal #calendarDay").text("Saturday");
			$(".calendar_modal .calendarMatchups:gt(2)").show();
			$(".calendar_modal .moreGamesNotifi").hide();
			$(".calendar_modal .gameTime").show();
		} else if(date.getDay() == 0) {
			$(".calendar_modal #calendarDay").text("Sunday");
			$(".calendar_modal .calendarMatchups:gt(2)").show();
			$(".calendar_modal .moreGamesNotifi").hide();
			$(".calendar_modal .gameTime").show();
		}

		$(".calendar_modal_content").append(dayData);
		$("#calendarDayNum").text(dayNum);
		$(".calendar_modal .weekDayNum").unwrap().remove();
		$(".calendar_modal, .maine_overlay").show();
		if($(this).hasClass("homeGame")) {
			$(".calendar_modal").animate({top:"50px", opacity:"1"}).addClass("homeBox");	
		} else if($(this).hasClass("awayGame")) {
			$(".calendar_modal").animate({top:"50px", opacity:"1"}).addClass("awayBox");
		} else {
			$(".calendar_modal").animate({top:"50px", opacity:"1"});
		}
		
	});	

//Change up and down arrow if league exist or not (age unlimited)
	var comp_age_clicks = 0;
	$("body").on("click", ".comp_age_none", function() {
		$(".unlimited").slideToggle(100);
		comp_age_clicks++;
		if($(".unlimited a").hasClass("unlimited_link")) {						
			if ((comp_age_clicks % 2) == 0) {
				$(".leagues_arrows_none").html("-");
			} else {
				$(".leagues_arrows_none").html("+");
			}
		} else {						
			if ((comp_age_clicks % 2) == 0) {
				$(".leagues_arrows_none").html("+");
			} else {
				$(".leagues_arrows_none").html("-");
			}
		}
	});		
	
//Bring up modal display for with League Information
	$('body').on('click', '.quick_league', function(e) {
		e.preventDefault();
		var leagueInfoDiv = $(this).next().clone();	
		$('.maine_overlay').show();
		$('.leagues_modal .append_div').append(leagueInfoDiv);
		$('.leagues_modal').fadeIn(function(){
			$('.leagues_modal').animate({top:"20px"});
		});
	});
	
//Bring up modal display for with Rec Information
	$('body').on('click', '.quick_rec', function(e) {
		e.preventDefault();
		var recInfoDiv = $(this).next().clone();	
		$('.maine_overlay').show();
		$('.recs_modal .append_div').append(recInfoDiv);
		$('.recs_modal').fadeIn(function(){
			$('.recs_modal').animate({top:"20px"});
		});
	});
	
//Show All Leagues For Age Group
	$("body").on("click", ".comp_age_levels, .comp_level", function(e) {
		var ageLevel = $(this).parent().attr("id");
		$("#"+ageLevel+" .leagues_link").slideToggle(function() {
			if($("#"+ageLevel+" .leagues_link").css("display") == "none") {
				$("#"+ageLevel+" .leagues_arrows").text("-");
			} else {
				$("#"+ageLevel+" .leagues_arrows").text("+");
			}
		});
	});
	
//About TTR Drop Down
	$("body").on("click", "#contact_li", function(e) {
		e.preventDefault();
		$(".maine_overlay, #about_ttr").show();
		var contact1 = $(".contactPageDis").height() + 25;
		var contact2 = $(".contactPage").height() + 25;
		$(".contactPageDis").animate({top:"15px"}, "slow");
		$(".contactPage").animate({top:"15px"}, "medium");
		$(".maine_overlay").on("click", function() {
			$(".contactPageDis").animate({top:"-"+contact1+"px"}, "slow");
			$(".contactPage").animate({top:"-"+contact2+"px"}, "medium", function() {
				$("#about_ttr").fadeOut();
				$(".maine_overlay").fadeOut();
			});
		});
	});
	
//Add more videos to page
	$("body").on("click", ".addMoreVideos", function(e)	{
		var videoCount = $(".videoContent:last-of-type .uploadUser span").attr("class");
		$.post("get_new_videos.php", {videoID:videoCount}, function(data) {			
			var newContent = data;
			$(data).insertBefore(".addMoreVideos");
			if(Number($(".videoContent").length) == Number($(".totalVideos").text())) {
				$(".addMoreVideos").text("All Videos Loaded").attr("class", "noMoreVideos");
			}
		});	
	});	
	
//Play videos on hover & bring up video if clicked on
	$("body").on("click", ".videoContent", function () {
		var video = $(this).children("video")[0];
		var copyVideo = $(this).children("video").clone();
		var videoUploader = $(this).find(".uploadUser").text();
		video.pause();
		copyVideo.attr({"controls": true, "autoplay": true}).appendTo(".video_modal_content");			
		$(".video_modal .video_modal_header").text(videoUploader);	
		$(".maine_overlay, .video_modal").fadeIn();
		$(".video_modal").css({top:"20px"});
	});
	$("body").on("mouseenter", ".videoContent", function() {
		$(this).children("video")[0].play();
	});
	$("body").on("mouseleave", ".videoContent", function() {
			var el = $(this).children("video")[0];
			$(this).find(".pause_overlay").show();
			$(this).find(".pause_overlay p:first-of-type").css({"padding":"23% 0%"}).text("PAUSED!");
			$(this).find(".pause_overlay p:last-of-type").hide();
			el.pause();
	});
	
//Play videos when clicked on public player page
	$("body").on("click", ".playerPageVideo, .editClips_div .myVideo .currentVideo", function () {
		var video = $(this).children("video")[0];
		var copyVideo = $(this).children("video").clone();
		var videoUploader = $(this).find(".uploadUser").text();
		var videoMaxHeight = screenHeight/2;
		copyVideo.attr({"controls": true, "autoplay": true}).appendTo(".video_modal_content");			
		$(".video_modal_header").text(videoUploader);
		$(".maine_overlay").fadeIn();
		$(".video_modal_content video.currentVideo").css({maxHeight:videoMaxHeight+"px"});
		$('.video_modal').show().animate({top:"50px"});
	});
	
//View player profile video
	$("body").on("click", ".viewClip", function(e) {
		var myVideoView = $(this).parent().find(".currentVideo").clone();
		myVideoView.attr({"controls": true, "autoplay": true}).appendTo(".append_div");			
		$(".maine_modal .modal_title").text();
		$(".append_div .currentVideo:gt(0)").remove();	
		$(".maine_overlay").fadeIn();
		$('.maine_modal').fadeIn(function(){
			setTimeout(function() {
				var maineModalHeight = $(".maine_modal").outerHeight();
				var maineWrapperHeight = $(".maine_modal").outerHeight();
				var newWrapperHeight;
				if((maineWrapperHeight != maineModalHeight) || (maineWrapperHeight == maineModalHeight)) {
					newWrapperHeight = maineModalHeight + 50;
					$(".maine_modal").css({"height":newWrapperHeight+"px"});					
					console.log("Modal height = " + maineModalHeight);
					
				}
			}, 100);
		}).css({top:window.pageYOffset+"px"});
	});
	
//Bring up no recent news message
	$('body').on("click", "#news_li", function(e) {
		e.preventDefault();
		$('.maine_modal_header').text("Recent News");
		$(".maine_modal_content").append("<p id='noNewsArticles'>There is no news currently. I am looking for writers that keeps up with Philly HS Basketball, College Basketball and the NBA to write articles for the site. Please contact me with your information. Email: <a href='mailto:administrator@totherec.com?subject=News%20Articles'>administrator@totherec.com</a></p>");
		$('.maine_overlay').fadeIn(function() {
			$('.maine_modal').show().animate({top:"15px"});
		});
	});	
	
//Filter rec centers
	var findRec;
	$("input#rec_search").keyup(function(e) {
		findRec = $("input#rec_search").val();
		if(findRec != "") {
			var filterRecs = $("h3").filter(":not([id*='"+findRec+"'])", function(index){});
			var filterRecs2 = $("h3").filter("[id*='"+findRec+"']", function(index){});
			filterRecs.parent().fadeOut();
			filterRecs2.parent().fadeIn();
		} else {
			$(".recsPage").fadeIn();
		}
	});
	
//Create a scroll across the screen with the rec centers
	var $allRecs = $(".recsPage").toArray();
	var $allRecs2 = $($allRecs).clone();
	var i = 0; var ii = 1; var iii = 2;
	var $showingRecs = [$allRecs[i], $allRecs[ii], $allRecs[iii]];
	$($allRecs).detach();
	$($showingRecs).appendTo("#all_recs").show();
	var timer = setInterval(function() {
		$($showingRecs).animate({margin:"0% 0% 0% -32%"}, function(e) {
			i++; ii++; iii++;
			$showingRecs = [$allRecs[i], $allRecs[ii], $allRecs[iii]];
			$("#all_recs").empty();
			$($showingRecs).appendTo("#all_recs").fadeIn("slow");
		});
	}, 5000);
	
	setTimeout(function() {
		$("#all_recs").empty();
		$("#showAllRecs").fadeOut("slow", function(){ $(this).detach(); });
		$($allRecs2).appendTo("#all_recs").each(function(){ $(this).fadeIn("slow"); });
		clearInterval(timer);
	}, 70000);
	
//Stop scroll on show all recs button on search button click	
	$("body").on("click", "#rec_search, #showAllRecs", function(e)	{
		clearInterval(timer);
		var loginPage2 = $(".loginPage2");
		var test1 = $.contains($(".navi2"), $(".loginPage2"));
		console.log(loginPage2.length);
		$("#showAllRecs").fadeOut("slow", function(){ $(this).detach(); });
		$($showingRecs).animate({margin:"0% 0% 0% -32%"}, function() {
			if(loginPage2.length == 1)
			{
				$(login2).css({"top":'0.4%'}); 
			}
			$("#all_recs").empty();
			$($allRecs2).appendTo("#all_recs").each(function() { 
				$(this).css({margin:"1.55%"}).fadeIn("slow"); 
			});
		});
	});
	
//Add scroll to the top button
	$(window).scroll(function()
	{
		if(window.pageYOffset >= 300){
			$("#scroll_to_top").show("slow");
		}	
		if(window.pageYOffset < 300){
			$("#scroll_to_top").hide("slow");
		}
	});
	
//Scroll to the top of the page
	$("#scroll_to_top").on("click", function() {
		var body = document.body;
		$("body").animate({scrollTop:"0"}, "slow");
	});
	
//Close modals
	$("body").on("click", ".close_x, .maine_overlay", function() {
		$(".maine_overlay").fadeOut("slow");
		if($(".calendar_modal:visible")) {
			var calendarModalHeight = $(".calendar_modal").height() + 20;
			$(".calendar_modal").animate({top:'-'+calendarModalHeight+"px", opacity:"0"}, function() {  
				$(".calendar_modal .calendar_modal_content").empty();
				$(".calendar_modal").removeClass("awayBox homeBox");
			});
		} if($(".maine_modal:visible")) {
			var maineModalHeight = $(".maine_modal").height() + 20;
			$(".maine_modal").animate({top:'-'+maineModalHeight+"px"}, function() { 
				$(".maine_overlay, .maine_modal").fadeOut();
				$(".maine_modal_content p").remove();
			});
		} if($(".recs_modal:visible")) {
			var recsModalHeight = $(".recs_modal").height() + 20;
			$(".recs_modal").animate({top:'-'+recsModalHeight+"px"}, function() { 
				$(".maine_overlay, .recs_modal").fadeOut();
				$(".recs_modal .append_div div").remove();
			});
		} if($(".leagues_modal:visible")) {
			var leaguesModalHeight = $(".leagues_modal").height() + 20;
			$(".leagues_modal").animate({top:'-'+leaguesModalHeight+"px"}, function() { 
				$(".maine_overlay, .leagues_modal").fadeOut();
				$("leagues_modal .append_div div").remove();
			});
		}  if($(".video_modal:visible")) {
			var videoModalHeight = $(".video_modal").height() + 20;
			$(".video_modal").animate({top:'-'+videoModalHeight+"px"}, function() { 
				$(".maine_overlay, .video_modal").fadeOut();
				$(".video_modal .video_modal_content").empty();
			});
		}
	});
});

(function () {
	if($(".container").length > 0) {
		$(".navi").css({position:"fixed"});
	}	
})();
