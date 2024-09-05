$(document).ready(function() {
    var isMobileOrTablet = /iPhone|iPad|iPod|Android/i.test(navigator.userAgent);

    function showTooltip(event, $this, title) {
        // Save the title into a variable
        var savedTitle = title;

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
                title: savedTitle, // Pass the saved title to the AJAX request
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
                        var tooltipContent = `<div>${response.data.excerpt}</div>`;
                        $this.attr('href', glossaryUrl);
                    }

                    $('#tooltip').html(tooltipContent);

                    if (isMobileOrTablet) {
                        // Center the tooltip on the mobile screen
                        $('#tooltip').css({
                            top: '0',
                            left: '0',
                            height: 'auto',
                            width: '100%',
                         //   transform: 'translate(-50%, -50%)',
                            position: 'fixed'  // was fixed
                        }).fadeIn();

                        // Handle close tooltip click
                        $('#close-tooltip').off('click').on('click', function(e) {
                            e.preventDefault();
                            $('#tooltip').fadeOut();
                        });

                        // Handle tooltip click to navigate to the permalink URL
                        $('#more-link').off('click').on('click', function(e) {
                            e.preventDefault();
                            window.location = glossaryUrl;
                        });
                    } else {
                        // Position the tooltip near the mouse cursor on desktop
                        $('#tooltip').css({
                            top: event.pageY + 10 + 'px',
                            left: event.pageX + 10 + 'px',
                            transform: 'none',
                            position: 'absolute'
                        }).fadeIn();
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
        $('a.story-link').on('mouseenter', function(event) {
            var $this = $(this);
            var title = $this.attr('title'); // Get the title attribute

            // Store the original title in a data attribute and remove it to prevent the default tooltip
            $this.data('original-title', title).removeAttr('title');

            showTooltip(event, $this, title);
        });

        $('a.story-link').on('mouseleave', function() {
            // Hide the glossary tooltip when the mouse leaves the link
            $('#tooltip').fadeOut();

            // Restore the original title attribute
            var $this = $(this);
            var originalTitle = $this.data('original-title');
            if (originalTitle) {
                $this.attr('title', originalTitle);
            }
        });
    }

    // Hide the glossary tooltip when clicking outside of it
    $(document).on('click', function(event) {
        if (!$(event.target).closest('#tooltip, a.story-link').length) {
            $('#tooltip').fadeOut();
        }
    });
});