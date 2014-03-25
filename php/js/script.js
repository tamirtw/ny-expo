$(window).load(function() {
	
	// Creating the Nivo Slider on window load
	
	$('#slideshow').nivoSlider({
		pauseTime:5000,
		directionNav:false,
		controlNav:false	
	});
});

$(document).ready(function(){

	// Binding event listeners for the form on document ready

	$('#email').defaultText('Your Email');

	// 'working' prevents multiple submissions
	var working = false;
	
	$('#page form').submit(function(){
		
		if(working){
			return false;
		}
		working = true;
		
		$.post(window.location,{email:$('#email').val()},function(r){
			if(r.error){
				$('#email').val(r.error);
			}
			else $('#email').val('Thank you!');
			
			working = false;
		},'json');
		
		return false;
	});
});

// A custom jQuery method for placeholder text:

$.fn.defaultText = function(value){
	
	var element = this.eq(0);
	element.data('defaultText',value);
	
	element.focus(function(){
		if(element.val() == value){
			element.val('').removeClass('defaultText');
		}
	}).blur(function(){
		if(element.val() == '' || element.val() == value){
			element.addClass('defaultText').val(value);
		}
	});
	
	return element.blur();
}