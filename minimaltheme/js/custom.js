/***********************************************************************************************/
/* CUSTOM JS */
/***********************************************************************************************/
jQuery(document).ready(function() {
	jQuery("#portfolio-sorting li:first-child a").addClass('active');
	
	jQuery('#portfolio-sorting li a').click(function() {
		// Remove the current active class
		// Add the active class to the clicked button
		jQuery('#portfolio-sorting li a.active').removeClass('active');
		jQuery(this).addClass('active');
		
		// Get the button text (filter value)
		var filterValue = 'cat-' + jQuery(this).text().toLowerCase().replace(' ', '-');
				
		// If we clicked "All", we show all hidden items
		if (filterValue === 'cat-all') {
			jQuery('.portfolio-entry').removeClass('hidden');
		} else {
			// Else, we find the portfolio entries that match 
			// and add the class of .hidden
			jQuery('.portfolio-entry').each(function() {
				if (!jQuery(this).hasClass(filterValue)) {
					jQuery(this).addClass('hidden');
				} else {
					jQuery(this).removeClass('hidden');
				}
			});
		}
	
		return false;
	});
});