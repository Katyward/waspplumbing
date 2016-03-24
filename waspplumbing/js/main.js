$('.js-show-hide').on('click', '.btn', function(event) {
	$(event.delegateTarget).toggleClass('show-more');
});