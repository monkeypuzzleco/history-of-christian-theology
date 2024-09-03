

$(document).ready(function() {
    var isMobileOrTablet = /iPhone|iPad|iPod|Android/i.test(navigator.userAgent);

    function showTooltip(event, $this, title) {
        // Create a tooltip element if it doesn't exist
        if ($('#tooltip').length === 0) {
            $('body').append('<div id="tooltip" style="position: absolute; display: none; background: #fff; border: 1px solid #ccc; padding: 10px; z-index: 1000;"></div>');
        }

        // Fetch the excerpt using AJAX
        $.ajax({
            url: ajax_object.ajax_url, // Use localized AJAX URL
            method: 'POST',
            data: {
                action: 'get_post_excerpt', // Custom action name
                title: title,
                nonce: ajax_object.nonce // Include the nonce
            },
            success: function(response) {
                if (response.success) {
                    var glossaryUrl = response.data.glossary_url; // Assuming the response contains the glossary URL

                    if (isMobileOrTablet) {
                        // Create the tooltip content with "X" and "more" links on mobile
                        var tooltipContent = `
                            <div>
                                <a href="#" id="close-tooltip" style="float: right;">X</a>
                                <div>${response.data.excerpt}</div>
                                <a href="${glossaryUrl}" id="more-link">More</a>
                            </div>
                        `;
                    } else {
                        var tooltipContent = response.data.excerpt;
                        $this.attr('href', glossaryUrl);
                    }

                    $('#tooltip').html(tooltipContent).css({
                        top: event.pageY + 10 + 'px',
                        left: event.pageX + 10 + 'px'
                    }).fadeIn();

                    // Remove the title attribute to prevent the default tooltip
                    $this.removeAttr('title');


                    if (isMobileOrTablet) {
                        // Handle close tooltip click
                        $('#close-tooltip').off('click').on('click', function(e) {
                            e.preventDefault();
                            $('#tooltip').fadeOut();
                        });
                        // Handle tooltip click to navigate to the permalink URL
                        $('#more-link').on('click', function (e) {
                            e.preventDefault();
                            window.location = glossaryUrl;
                        });
                    } 
                } else {
                    console.error(response.data.message);
                }
            },
            error: function(xhr, status, error) {
                console.error('AJAX error:', status, error); // Debug log
            }
        });
    }

    if (isMobileOrTablet) {
        $('a.story-link').on('click', function(event) {
            var $this = $(this);
            var title = $this.attr('title'); // Get the title attribute
            event.preventDefault(); // Prevent default action on mobile
            showTooltip(event, $this, title);
        });
    } else {
        $('a.story-link').hover(
            function(event) {
                var $this = $(this);
                var title = $this.attr('title'); // Get the title attribute
                showTooltip(event, $this, title);
            },
            function() {
                // Hide the glossary tooltip when the mouse leaves the link
                $('#tooltip').fadeOut();
            }
        );
    }
    if (isMobileOrTablet) {
        // Hide the glossary tooltip when clicking outside of it
        $(document).on('click', function (event) {
            if (!$(event.target).closest('#tooltip, a.story-link').length) {
                $('#tooltip').fadeOut();
            }
        });
    } else {
        // Keep tooltip visible when hovering over it
        $(document).on('mouseenter', '#tooltip', function() {
            $(this).stop(true, true).show();
        }).on('mouseleave', '#tooltip', function() {
            $(this).fadeOut();
        }); 
    }
});