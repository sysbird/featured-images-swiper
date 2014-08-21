/*
 Plugin Name: Featured Images Swiper
 featured-images-swiper.js
*/
jQuery(function() {

	// Swiper
	var mySwiper = new Swiper('.swiper-container',{
		slidesPerView: 'auto',
		loop: true
	})

	// Show Thumbnail Title
	jQuery('.featured-images-swiper .swiper-slide a').hover(function(){
		var caption = jQuery(this).find('.caption');
		caption.stop(true, true).animate(
			{opacity: 1,},
			{queue: false,
				duration: '300'.fadeout
			});
	}, function() {
		var caption = jQuery(this).find('.caption');
		caption.stop(true, true).animate(
			{opacity: '0'},
			{queue: false,
				duration: '50'.fadein
			});
	});

	jQuery(window).load(function() {
		// Center Thumbnail Position
		jQuery('.featured-images-swiper .swiper-slide img').each(function(i){
			var wrapperHeight = jQuery(this).closest('.thumbnail').height();
			var wrapperWidth = jQuery(this).closest('.thumbnail').width();
			var imageHeight = jQuery(this).height();
			var imageWidth = jQuery(this).width();
			if(imageWidth > imageHeight){
				// Horizontal Thumbnail
				var h = wrapperHeight;
				var w = (imageWidth/imageHeight) * h;
			}
			else{
				// Vertical Thumbnail
				var w = wrapperWidth;
				var h = (imageHeight/imageWidth) * w;
			}

			// Set Center
			var y = (wrapperHeight - h) / 2;
			var x = (wrapperWidth - w) / 2;

			jQuery(this).css({'height': h + 'px', 'width': w + 'px', 'top': y + 'px', 'left': x + 'px'});
		});
	});
});
