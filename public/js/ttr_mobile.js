function validate_player_info()
{
	var username_check = $('#username').val();
	var password1_check = $('#password1').val();
	var password2_check = $('#password2').val();
	var firstname_check = $('#firstname').val();
	var lastname_check = $('#lastname').val();
	var college_check = $('#college').val();
	var highschool_check = $('#highschool').val();
	var height_check = $('#height').val();
	var weight_check = $('#weight').val();
	var nickname_check = $('#nickname').val();
	var email_check = $('#email').val();
	var username_regrex = /^([\w\d\.]{6,25})$/g;
	var password_regrex = /^([\w\d_!@#$%]{6,20})$/g;
	var college_regrex = /^[a-zA-Z'\- ]{1,50}$/g;	
	var highschool_regrex = /^[a-zA-Z'\- ]{1,50}$/g;	
	var height_regrex = /^([2-7])\'([0-9]{0,2})$/g;
	var email_regrex = /^[\w]{1,}(\.\w{1,})?@([\w]{1,}\.)?([\w]{1,}\.)([a-zA-Z]{1,})$/g;
	var fname_regrex = /^[a-zA-Z'\- ]{1,25}$/g;		
	var lname_regrex = /^[a-zA-Z'\- ]{1,50}$/g;		
	var nname_regrex = /^[0-9a-zA-Z'\- ]{1,25}$/g;	
	$('input').removeClass('error_border');
									
	if(username_check == "")
	{
		$("#mobile_error_message").html("Username cannot be empty.");
		$("#error_popup").popup("open");
		$('input#username').focus();
		return false;
	}
	
	$('input#username').keyup(function()
	{
		$.ajax({
			url: 'user_names_list.php',
			success: function(data)			
			{		
				var username = $('input#username').val();
				var username_dupe = username.toLowerCase();
				var data_to_array = data.split(" ");
				var ii = 0;
				var data_length = data_to_array.length;
				for(ii; ii < data_length; ii++)
				{
					if((username_dupe != "") && (username_dupe == data_to_array[ii]))
					{
						$('h3.place_holder_header').html('\'' + username_dupe + '\' username already exist, please select a different username.');
						$('h3.place_holder_header').addClass('error_header');
						$('input#username').focus();
					}
				}	
			}
		});	
	});
	
	if(!username_regrex.test(username_check))
	{
		$('#mobile_error_message').html('Username should be between 6 - 25 characters and contain only numbers, letters, periods and underscores.');			
		$("#error_popup").popup("open");
		$('input#username').focus();
		return false;
	}
	
	if(password2_check != password1_check)
	{
		$('#mobile_error_message').html('Passwords do not match.');
		$("#error_popup").popup("open");
		$('input#password2').focus();
		return false;
	}
	
	if(password2_check == "" || password1_check == "")
	{
		$('#mobile_error_message').html('Password cannot be empty.');
		$("#error_popup").popup("open");
		if(password1_check == "")
		{
			$('input#password1').focus();
		}
		else
		{
			$('input#password2').focus();
		}			
		return false;
	}	

	if(!password_regrex.test(password1_check))
	{
		$('#mobile_error_message').html('Password should be between 5 - 20 characters and contain only numbers, letters and the following symbols (_!@#$%).');
		$("#error_popup").popup("open");
		$('input#password1').focus();
		return false;
	}
	
	if(firstname_check == "")
	{
		$('#mobile_error_message').html('First Name cannot be empty.');
		$("#error_popup").popup("open");
		$('input#firstname').focus();
		return false;
	}
	
	if(!fname_regrex.test(firstname_check))
	{
		$('#mobile_error_message').html('First Name can only contain letters and the following special characters (- and \').');
		$("#error_popup").popup("open");
		$('input#firstname').focus();
		return false;
	}
	
	if(lastname_check == "")
	{
		$('#mobile_error_message').html('Last Name cannot be empty.');
		$("#error_popup").popup("open");
		$('input#lastname').focus();
		return false;
	}
	
	if(!lname_regrex.test(lastname_check))
	{
		$('#mobile_error_message').html('Last Name can only contain letters and the following special characters (- and \').');
		$("#error_popup").popup("open");
		$('input#lastname').focus();
		return false;
	}
	
	if((college_check != "") && (!college_regrex.test(college_check)))
	{
		$('#mobile_error_message').html('College cannot contain numbers or special characters.');
		$("#error_popup").popup("open");
		$('input#college').focus();
		return false;
	}
	
	if((highschool_check != "") && (!highschool_regrex.test(highschool_check)))
	{
		$('#mobile_error_message').html('Highschool cannot contain numbers or special characters.');
		$("#error_popup").popup("open");
		$('input#highschool').focus();
		return false;
	}
	
	if(height_check != "")
	{
		if(!height_regrex.test(height_check))
		{
			$('#mobile_error_message').html('Height should be in the format of X\'XX.');
			$("#error_popup").popup("open");
			$('input#height').focus();
			return false;
		}		
	}	
	
	if(weight_check < 0)
	{
		$('#mobile_error_message').html('Weight cannot be less than zero.');
		$("#error_popup").popup("open");
		$('input#weight').focus();
		return false;
	}
	
	if(weight_check > 799)
	{
		$('#mobile_error_message').html('Weight max is 799.');
		$("#error_popup").popup("open");
		$('input#weight').focus();
		return false;
	}
	
	if((nickname_check != "") && (!nname_regrex.test(nickname_check)))
	{
		$('#mobile_error_message').html('Nickname can only contain letters and the following special characters (- and \').');
		$("#error_popup").popup("open");
		$('input#nickname').focus();
		return false;
	}
	
	if((email_check != "") && (!email_regrex.test(email_check)))
	{
		$('#mobile_error_message').html('Incorrect format for an email. Ex: john.doe@gmail.com or johndoe@school.college.edu');
		$("#error_popup").popup("open");
		$('input#email').focus();
		return false;
	}
return true;	
}

function validate_league_info()
{
	var username_check = $('#username').val();
	var password1_check = $('#password1').val();
	var password2_check = $('#password2').val();
	var leagues_name_check = $('#leagues_name').val();
	var leagues_commish_check = $('#leagues_commish').val();
	var leagues_email_check = $('#leagues_email').val();
	var leagues_phone_check = $('#leagues_phone').val();
	var leagues_website_check = $('#leagues_website').val();
	var leagues_address_check = $('#leagues_address').val();
	var leagues_fee_check = $('#leagues_fee').val();
	var ref_fee_check = $('#ref_fee').val();
	var username_regrex = /^([\w\d\.]{6,25})$/g;
	var password_regrex = /^([\w\d_!@#$%]{6,20})$/g;
	var phone_regrex = /^[0-9]{3}\-[0-9]{3}\-[0-9]{4}$/g;
	var address_regrex = /^[a-zA-Z0-9]{1,100}$/g;
	var commish_regrex = /^[a-zA-Z'\- ]{1,50}$/g;
	$('input').removeClass('error_border');
	
	if(username_check == "")
	{
		$('#mobile_error_message').html('Username cannot be empty.');
		$("#error_popup").popup("open");		
		$('input#username').focus();
		return false;
	}
	
	$('#username').keyup(function()
	{		
		$.ajax({
			url: 'user_names_list.php',
			success: function(data)			
			{		
				var username = $('input#username').val();
				var username_dupe = username.toLowerCase();
				var data_to_array = data.split(" ");
				var ii = 0;
				var data_length = data_to_array.length;
				for(ii; ii < data_length; ii++)
				{
					if((username_dupe != "") && (username_dupe == data_to_array[ii]))
					{
						$('#mobile_error_message').html(username_dupe + ' already exist, please select a different username.');
						$("#error_popup").popup("open");
						$('input#username').focus();
					}
				}	
			}
		});	
	});		
	
	if(!username_regrex.test(username_check))
	{
		$('#mobile_error_message').html('Username should be between 6 - 25 characters and contain only numbers, letters, periods and underscores.');
		$("#error_popup").popup("open");
		$('input#username').focus();
		return false;
	}
	
	if(password2_check != password1_check)
	{
		$('#mobile_error_message').html('Passwords do not match.');
		$("#error_popup").popup("open");
		$('input#password2').focus();
		return false;
	}
	
	if(password2_check == "" || password1_check == "")
	{
		$('#mobile_error_message').html('Password cannot be empty.');
		$("#error_popup").popup("open");
		if(password1_check == "")
		{
			$('input#password1').focus();
		}
		else
		{
			$('input#password2').focus();
		}			
		return false;
	}	

	if(!password_regrex.test(password1_check))
	{
		$('#mobile_error_message').html('Password should be between 5 - 20 characters and contain only numbers, letters and the following symbols (_!@#$%).');
		$("#error_popup").popup("open");
		$('input#password1').focus();
		return false;
	}
	
	if(leagues_name_check == "")
	{
		$('#mobile_error_message').html('League Name cannot be empty.');
		$("#error_popup").popup("open");
		$('input#leagues_name').focus();
		return false;
	}
	
	$('#leagues_name').keyup(function()
	{		
		$.ajax({
			url: 'leagues_names_list.php',
			success: function(data)			
			{		
				var leaguename_dupe = $('input#leagues_name').val();
				var leagues_array = data.split(" ");
				var ii = 0;
				var data_length = leagues_array.length;
				for(ii; ii < data_length; ii++)
				{
					if((leaguename_dupe != "") && (leaguename_dupe == leagues_array[ii]))
					{
						$('#mobile_error_message').html('\'' + leaguename_dupe + '\' already exist as a League Name, please select a different name for your league.');
						$("#error_popup").popup("open");
						$('input#leagues_name').focus();
					}
				}	
			}
		});			
	});
	
	if(leagues_commish_check == "")
	{
		$('#mobile_error_message').html('League Commissioner cannot be empty.');
		$("#error_popup").popup("open");
		$('input#leagues_commish').focus();
		return false;
	}
	
	if(!commish_regrex.test(leagues_commish_check))
	{
		$('#mobile_error_message').html('League Commissioner cannot include special characters or numbers.');
		$("#error_popup").popup("open");
		$('input#leagues_commish').focus();
		return false;
	}
	if(leagues_address_check == "")
	{
		$('#mobile_error_message').html('League Address cannot be empty.');
		$("#error_popup").popup("open");
		$('input#leagues_address').focus();
		return false;
	}
	if(leagues_fee_check < 0)
	{
		$('#mobile_error_message').html('League Fee cannot be less than zero.');
		$("#error_popup").popup("open");
		$('input#leagues_fee').focus();
		return false;
	}
	if(ref_fee_check < 0)
	{
		$('#mobile_error_message').html('Ref Fee cannot be less than zero.');
		$("#error_popup").popup("open");
		$('input#ref_fee').focus();
		return false;
	}
	if(!phone_regrex.test(leagues_phone_check))
	{
		$('#mobile_error_message').html('Phone number should be in the format of XXX-XXX-XXXX.');
		$("#error_popup").popup("open");
		$('input#leagues_phone').focus();
		return false;
	}
return true;	
}

function check_login()
{
	var password2 = $('input#pass2').val();
	var username1 = $('input#username').val();
	var username2 = username1.toLowerCase();
		
	if(username2 == "")
	{
		$('#mobile_error_message').html('Username is Empty');
		$("#error_popup").popup("open");
		$("input#username").focus();
		return false;
	}
	
	if(password2 == "")
	{
		$('#mobile_error_message').html('Password is Empty');
		$("#error_popup").popup("open");
		$("input#pass2").focus();
		return false;
	}		
return true;	
}

//Reload login page
$(document).on("pagecreate", "#login_page", function()
{
	var a = location.href;
	var b = "http://localhost/mobile/m.login.php";
	console.log(a);
	console.log(b);
	if(a !== b)
	{
		location.reload();
	}
});

//Reload home page
$(document).on("pagecreate", "#home_page", function()
{
	var a = location.href;
	var b = "http://localhost/mobile/m.totherec.php";
	console.log(a);
	console.log(b);
	if(a !== b)
	{
		location.reload();
	}
});

//Reload players page
$(document).on("pagecreate", "#player_page", function()
{
	var a = location.href;
	var b = "http://localhost/mobile/m.players.php";
	console.log(a);
	console.log(b);
	if(a !== b)
	{
		location.reload();
	}
});

//Reload leagues page
$(document).on("pagecreate", "#leagues_page", function()
{
	var a = location.href;
	var b = "http://localhost/mobile/m.leagues.php";
	console.log(a);
	console.log(b);
	if(a !== b)
	{
		location.reload();
	}
});

//Reload twitter page
$(document).on("pagecreate", "#twitter_page", function()
{
	var a = location.href;
	var b = "http://localhost/mobile/m.twitterfeed.php";
	console.log(a);
	console.log(b);
	if(a !== b)
	{
		location.reload();
	}
});

//Reload registration page
$(document).on("pagecreate", "#register_page", function()
{
	var a = location.href;
	var b = "http://localhost/mobile/m.register.php";
	console.log(a);
	console.log(b);
	if(a !== b)
	{
		location.reload();
	}
});

//Reload recs page
$(document).on("pagecreate", "#recs_page", function()
{
	var a = location.href;
	var b = "http://localhost/mobile/m.recs.php";
	console.log(a);
	console.log(b);
	if(a !== b)
	{
		location.reload();
	}
});

//Reload my player page
$(document).on("pagecreate", "#my_player_page", function()
{
	var a = location.href;
	var b = "http://localhost/mobile/m.player_page.php";
	console.log(a);
	console.log(b);
	if(a !== b)
	{
		location.reload();
	}
});

//Reload my league page page
$(document).on("pagecreate", "#my_leagues_page", function()
{
	var a = location.href;
	var b = "http://localhost/mobile/m.league_page.php";
	console.log(a);
	console.log(b);
	if(a !== b)
	{
		location.reload();
	}
});

//Reload my league page page
$(document).on("pagecreate", "#logout_page", function()
{
	var a = location.href;
	var b = "http://localhost/mobile/m.logout.php";
	console.log(a);
	console.log(b);
	if(a !== b)
	{
		location.reload();
	}
});