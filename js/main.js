$('.js-show-hide').on('click', '.btn', function(event) {
	$(event.delegateTarget).toggleClass('show-more');
});

$(function(){

	//catch all click on a tags
	$("a").click(function(){
		//check if has hash
		if(this.hash){
			//get the position of the <a name>
			var toPosition = $(this.hash).position().top;

			//scroll/animate to that element
			$("body,html").animate({
				scrollTop : toPosition
			},2000,"easeOutExpo");

			//don't do the jump
			return false;
		}
	});

	if(location.hash){
		var hash = location.hash;
		window.scroll(0,0);
		$("a[href='"+hash+"']").click();
	}


});
		