$(document).ready(function()
{
    // This is a going to be attached to the
	// test drive pages for a walkthrough tutorial
    // on the home page

	// Create test drive modal
	var modal, header, content, nextBtn;

    modal = $('#test_drive_tutorial');
    header = $(modal).find('.modal-header');
    content = $(modal).find('.modal-body');
    nextBtn = $(modal).find('.nextBtn');

    // Animate modal
    // $(modal).modal('show');

    $('body').on('click', '.step1', function() {
        $(this).toggleClass('step1 step2');

        // Step 1: Highlight the League Name
        $('#leagues_menu li:first-of-type a')
            .attr('data-toggle', 'popover')
            .attr('title', 'League Name')
            .attr('data-placement', 'left')
            .attr('data-content', 'Here is the name of your league. This link will take you to the leagues profile')
            .popover('show');
    });

    $('body').on('click', '.step2', function() {
        $(this).toggleClass('step2 step3');

        // Hide current popover
        $('#leagues_menu li:first-of-type a').popover('hide');

        // Step 2: Highlight the Season Name
        $('.seasonName h1')
            .attr('data-toggle', 'popover')
            .attr('title', 'Season Name')
            .attr('data-placement', 'right')
            .attr('data-content', 'Here is the name of one of the current seasons you\'re running.')
            .popover('show');
    });

    $('body').on('click', '.step3', function() {
        $(this).toggleClass('step3 step4');

        // Hide current popover
        $('.seasonName h1').popover('hide');

        // Step 3: Highlight the Season's Info
        $('.card')
			.addClass('border border-primary')
            .attr('data-toggle', 'popover')
            .attr('title', 'Season Name')
            .attr('data-placement', 'left')
            .attr('data-content', 'Here is the name of one of the current seasons you\'re running.')
            .popover('show');
    });

    $('body').on('click', '.step4', function() {
    	$(this).toggleClass('step4 step5');

        // Hide current popover
        $('.card').popover('hide').removeClass('border border-primary');

        // Focus on the quick question div
        window.scrollTo(0, ($("#season_schedule_snap").parent().offset().top - ($(modal).outerHeight() + 20)));

        // Step 4: Highlight the Quick Snap Shot League Schedule
        $("#season_schedule_snap").parent().addClass('border border-primary')
            .attr('data-toggle', 'popover')
            .attr('title', 'Season Schedule')
            .attr('data-placement', 'left')
            .attr('data-content', 'This is a quick view of the upcoming schedule on the seasons calendar.')
            .popover('show');
    });

    $('body').on('click', '.step5', function() {
        $(this).toggleClass('step5 step6');

        // Hide current popover
        $("#season_schedule_snap").parent().popover('hide').removeClass('border border-primary');

        // Focus on the quick question div
        window.scrollTo(0, ($("#season_teams_snap").parent().offset().top - ($(modal).outerHeight() + 20)));

        // Step 4: Highlight the Quick Snap Shot League Schedule
        $("#season_teams_snap").parent().addClass('border border-primary')
            .attr('data-toggle', 'popover')
            .attr('title', 'Seasons Teams')
            .attr('data-placement', 'left')
            .attr('data-content', 'This is a quick view of the teams participating in the season. Showing a count of total teams, players, and unpaid teams fees')
            .popover('show');
    });

    $('body').on('click', '.step6', function() {
        $(this).toggleClass('step6 step7');

        // Change the next button text to finish
        $('.nextBtn').text('Finish');

        // Hide current popover
        $("#season_teams_snap").parent().popover('hide').removeClass('border border-primary');

        // Focus on the quick question div
        window.scrollTo(0, ($("#season_stats_snap").parent().offset().top - ($(modal).outerHeight() + 20)));

        // Step 4: Highlight the Quick Snap Shot League Schedule
        $("#season_stats_snap").parent().addClass('border border-primary')
            .attr('data-toggle', 'popover')
            .attr('title', 'Seasons Stats')
            .attr('data-placement', 'top')
            .attr('data-content', 'This is a quick view of the season stats leaders in each category')
            .popover('show');
    });

    $('body').on('click', '.step7', function() {
        // Animate and remove the modal
        // $(modal).text('Finish');

        $.ajax({
            url: "/remove_test_drive",
            method: "POST",
            data: { remove_test_drive:'remove_test_drive' },

            success: function (data) {
                $(modal).modal('hide');
            },
        });

        // Go to the leagues schedule page
        $('#leagues_schedule_link')[0].click();
    });

    $('body').on('click', '.removeTestDrive', function() {
        $.ajax({
            url: "/remove_test_drive",
            method: "POST",
            data: { remove_test_drive:'remove_test_drive' },

            success: function (data) {
                $(modal).removeClass('bounceInDown').addClass('bounceOutUp');

                // Remove any borders if available
                $("body *").removeClass('border border-primary');

                // Remove any popovers if available
                $("body *").find('[data-toggle="popover"]').popover('hide');
            },
        });
    });
});