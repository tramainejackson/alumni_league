$(document).ready(function()
{
	var login3 = $(".loginPage3").detach();
	var registration = $(".registration").detach();
	
	//Add Login Page Drop Down 3
	$("body").on("click", "#login_li3", function(e)
	{
		e.preventDefault();
		var cookieCheck2 = document.cookie;
		console.log(cookieCheck2);
		if(cookieCheck2)
		{	
			$(".maine_modal").html("<p>Already Logged In</p>");
		}
		else
		{
			$(login3).appendTo(".navi3");
			$("#register_li3").fadeOut(100);
			$("#login_li3").fadeOut(100, function(){ $(login3).show().animate({top:'0.1%'}); });
			$("#cancel_login_page_btn3").on("click", function(event)
			{
				event.preventDefault();
				$(login3).animate({top:'-61%'}, 
					function()
					{
						$(login3).detach();
						$("#login_li3").fadeIn("medium"); $("#register_li3").fadeIn("slow");
					}
				);	
			});
		}
	});
	
	//About TTR Drop Down 2
	$("body").on("click", "#contact_li3", function(e)
	{
		e.preventDefault();
		var contactDropSet = window.pageYOffset + 20;
		$("#about_ttr").show(); 
		$(".contactPageDis").animate({top:contactDropSet+"px"}, "slow");
		$(".contactPage").animate({top:contactDropSet+"px"}, "medium");
		$(".maine_overlay").show();
		$(".maine_overlay").on("click", function()
		{
			$(".contactPageDis").animate({top:'-21.6%'}, "slow", function(){$(".contactPageDis").fadeOut()});
			$(".contactPage").animate({top:'-21.6%'}, "medium", function(){$(".contactPage").fadeOut()});
			$(".maine_overlay").fadeOut();
		});
	});
	
	//Add Registration Page Drop Down 3
	$("body").on("click", "#register_li3", function(e)
	{
		e.preventDefault();
		var registrationFormPlayer; var registrationFormLeague; var leagueBtn_clicks = 0;		
		$(".maine_modal .modal_title").after(registration);
		$(registration).show();
		$(".modal_title").text("Register Account");
		$("#player").addClass("active_btn");
		$("#league").removeClass("active_btn");
		$(".maine_modal_wrapper").show("fast").animate({top:window.pageYOffset+"px"});
		$(".maine_overlay").show();
		$(".append_div").load("../register_player.php .registrationPage");
		
		$(".maine_modal").on("click", "#league", function(e)
		{
			leagueBtn_clicks++;
			$("#player").removeClass("active_btn");
			$("#league").addClass("active_btn");
			registrationFormPlayer = $(".registrationPage").detach();
			if(leagueBtn_clicks <= 1)
			{
				$(".append_div").load("../register_league.php .registrationPage");
			}
			else
			{
				$(".append_div").append(registrationFormLeague);
			}
		});
		
		$(".maine_modal").on("click", "#player", function(e)
		{
			$("#league").removeClass("active_btn");
			$("#player").addClass("active_btn");
			registrationFormLeague = $(".registrationPage").detach();
			$(".append_div").append(registrationFormPlayer);
			
		});
		
		$(".maine_modal_wrapper .close_x, .maine_overlay").on("click", function()
		{
			$('.maine_modal_wrapper').animate({top:'-30.5%'}).fadeOut();
			$(".maine_overlay").fadeOut();
			/*$(".maine_modal *:not(.modal_title)").remove();
			$(".alert_modal *:not(.modal_title)").remove();*/
		});
	});
	
	//Bring up no recent news message 2
	$('body').on("click", "#news_li3", function(e)
	{
		e.preventDefault();
		$('.maine_overlay').fadeIn();
		$('p.modal_title').text('Recent News');
		$('.alert_modal_wrapper').show(function(){
			var alertModalHeight = $(".alert_modal").outerHeight();
			var alertWrapperHeight = $(".alert_modal_wrapper").outerHeight();
			var newWrapperHeight;
			if((alertWrapperHeight != alertModalHeight) || (alertWrapperHeight == alertModalHeight))
			{
				newWrapperHeight = alertModalHeight + 50;
				$(".alert_modal_wrapper").css({"height":newWrapperHeight+"px"});
			}
		}).animate({top:'1%'});
		$("p.alert_modal_content").text('There is no news currently. I am looking for writers that keeps up with Philly HS Basketball, College Basketball and the NBA to write articles for the site. Please contact me with your information. Email:totherec.sports@gmail.com');
		
		$(".alert_modal_wrapper .close_x, .maine_overlay").on("click", function()
		{
			$('.alert_modal_wrapper').animate({top:'-35%'}, function(){$('.alert_modal_wrapper').fadeOut();});
			$(".maine_overlay").fadeOut();
		});
	});
	
	//Back to previous page button on player page
	$("body").on("click", "#backBtn", function(e)
	{
		history.back();
	});
	
	//Videos button on player page
	$allVideos = $(".playerVideo");
	$allVideos = $($allVideos).toArray();
	$firstFour = $allVideos.slice(0, 4);
	$("body").on("click", "#vidsBtn", function(e)
	{
		$("#playerDemographics, #playerPagePic").fadeOut(function(){ $($firstFour).fadeIn(); });
		$("#bioBtn").removeClass("active_btn");
		$(this).addClass("active_btn");
	});
	
	//Bio button on player page
	$("body").on("click", "#bioBtn", function(e)
	{
		$(".playerVideos, .playerVideos2").fadeOut(function(){ $("#playerDemographics, #playerPagePic").fadeIn(); });
		$("#vidsBtn").removeClass("active_btn");
		$(this).addClass("active_btn");
	});
	
	//Play video from inividual page
	$("body").on("click", ".playBtn", function(e)
	{
		var getVid = $(this).prev("video")[0];
		var playBtn = $(this);
		var getPauseBtn = $(this).next();
		playBtn.fadeOut();
		getPauseBtn.fadeIn();
		getVid.play();
		
		$(getPauseBtn).on("click", function(e)
		{
			$(this).fadeOut();
			getVid.pause();
			playBtn.fadeIn();
		});
	});
	
	//Navigate through videos on player individual page
	$("body").on("click", ".moreVidBtnRight", function(e)
	{
		var videoIDLast = $(".playerVideo:last-of-type span").text();
	});

	$("body").on("click", ".moreVidBtnLeft", function(e)
	{
		var videoIDFirst = $(".playerVideo:first-of-type span").text();
	});
});