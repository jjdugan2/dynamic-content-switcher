document.addEventListener('DOMContentLoaded', function () {
	// Gets a URL paramter
    function getUrlParameter(name) {
        name = name.replace(/[\[]/, '\\[').replace(/[\]]/, '\\]');
        var regex = new RegExp('[\\?&]' + name + '=([^&#]*)');
        var results = regex.exec(location.search);
        return results === null ? '' : decodeURIComponent(results[1].replace(/\+/g, ' '));
    }

    // Assign appropriate index value to param value
	var headlineParam = getUrlParameter('headline');
	var headlineIndex = parseInt(headlineParam, 10) - 1;
	var imageParam = getUrlParameter('image');
	var imageIndex = parseInt(imageParam, 10) - 1;
	var ctaParam = getUrlParameter('cta');
	var ctaIndex = parseInt(ctaParam, 10) - 1;

    // Handle Headline replacements
	if (DCS_Variations.headlines[headlineIndex]) {
        // Get elements with 'wp-block-post-title' class and update them
        var wpBlockPostTitleElements = document.getElementsByClassName('wp-block-post-title');
        for (var i = 0; i < wpBlockPostTitleElements.length; i++) {
            wpBlockPostTitleElements[i].innerText = DCS_Variations.headlines[headlineIndex];
        }

		// Get elements with 'dcs_headline' class and update them
        var headlineElements = document.getElementsByClassName('dcs_headline');
        for (var i = 0; i < headlineElements.length; i++) {
            headlineElements[i].innerText = DCS_Variations.headlines[headlineIndex];
        }
    }

    // Handle Image replacements
	if (DCS_Variations.images[imageIndex]) {
		// Get elements with 'dcs_image' class and update them
        var imageElements = document.getElementsByClassName('dcs_image');
        for (var i = 0; i < imageElements.length; i++) {
            // Find <img> elements within the current <figure>
            var imgElements = imageElements[i].getElementsByTagName('img');

            // Check if there's at least one <img> element to update
            if (imgElements.length > 0) {
                // Update the src of the first <img> found
                imgElements[0].src = DCS_Variations.images[imageIndex];

                // Update the srcset of the first <img> found
                imgElements[0].srcset = DCS_Variations.images[imageIndex];
            }
        }
    }

    // Handle CTA replacements
    if (DCS_Variations.ctas[ctaIndex]) {
        var ctaElements = document.getElementsByClassName('dcs_cta');
        for (var i = 0; i < ctaElements.length; i++) {
            // Find <a> elements within the current ctaElement
            var aElements = ctaElements[i].getElementsByTagName('a');

            // Check if there's at least one <a> element to update
            if (aElements.length > 0) {
                // Update the inner text of the first <a> found
                aElements[0].innerText = DCS_Variations.ctas[ctaIndex];
            }
        }
    }

});
