currentValue = window.location.hash.substr(1);
(function($) {

if( (typeof currentValue != "undefined") && (currentValue != '') && (currentValue != null) ){
 console.log(currentValue);
 $( "input" ).triggerHandler( "focus" );
$(this.$el).attr('data-key', currentValue)
	$.fn.mydata=function(key, variable){
	    if ($(".acf-tab-button").data(key)!=variable){ // check if it's changed
	        $(".acf-tab-button").data(key, variable).trigger('click', key);
	    }else{
	        console.log('data wasn\'t changed');
	    }
	}

	$(".acf-tab-button").mydata('id', currentValue);
}
})(jQuery);
