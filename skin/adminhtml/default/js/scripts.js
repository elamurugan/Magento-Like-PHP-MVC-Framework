var jQ = $.noConflict();
jQ(document).ready(function(){
	
	/** Alert Message Boxes **/
    jQ('.alertMsg .alert-close').each(function() {
        jQ(this).click(function(event) {
            event.preventDefault();
            jQ(this).parent().fadeOut("slow", function() {
                jQ(this).css('diplay', 'none');
            });
        });
    });
    
});