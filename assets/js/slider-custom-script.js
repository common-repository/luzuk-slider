jQuery(document).ready(function(){
	jQuery('.slider-admin-tab li:nth-child(1)').addClass('active');
	jQuery('#slider-tab1').addClass('active');

	jQuery('.slider-admin-tab li').click(function(){
		jQuery('.slider-admin-tab li').removeClass('active');
		jQuery('#slider-tab1').removeClass('active');
		jQuery('.slider-tab-content-wrap').removeClass('active');

		jQuery(this).addClass('active');
		let current_tab = jQuery(this).attr('slider-id');
		jQuery('#' + current_tab).addClass('active');
		
	});
});


/* tab dashboard content */
// main tabs
jQuery(document).ready(function(){
    
    jQuery('.team-block-tab li:nth-child(1)').addClass('active');
    jQuery('#teamblock1').addClass('active');

    jQuery('.team-block-tab li').click(function(){

    });

    jQuery('.team-block-tab li').click(function(){
        jQuery('.team-block-tab li').removeClass('active');
        jQuery('#teamblock1').removeClass('active');
        jQuery('.teamblock-content-wrap').removeClass('active');

        jQuery(this).addClass('active');
        let current_tab = jQuery(this).attr('tblock-id');
        jQuery('#' + current_tab).addClass('active');

    });

});



