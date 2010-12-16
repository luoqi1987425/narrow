rocknoon.namespace("rocknoon.widget");

( 
function(){
	
	var default_opt = {
			
		remove : true ,
		speed  : 'slow'
			
	}
	
	
	var slideshow = function( wrapper ,  opts ){
		
		this.wrapper = $( "#" + wrapper );
		this.opts = $.extend({}, default_opt, opts );
		
	}
	
	slideshow.prototype =
    {
	  
	    push:function( html ){
			
			var pusher = $(html).css( {"display":"none"} );
			this.wrapper.prepend(pusher);
			this.wrapper.find(':first').fadeIn(this.opts.speed);
			
			if( this.opts.remove ){
				this.wrapper.find(':last').fadeOut(this.opts.speed , rocknoon.callback( this , '_onFadeout' ));
			}
			
		},
		remove : function( id ){
			$("#" + id).fadeOut(this.opts.speed , function(){
				$(this).remove();
			});
		},
		_onFadeout:function(){
			
				this.wrapper.find(':last').remove();
		}
	    
    }
	
	
	
	
	
	//register name space
	rocknoon.widget.slideshow = slideshow;
}
)();