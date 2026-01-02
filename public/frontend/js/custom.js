$('#menu_button').click(function(event) {
	$('#navCatContent').toggleClass('sub-menu');
});




$( document ).on('ready', function () {
	$( '.sub-dropdown a' ).on( 'click', function () {
		if ( $( this ).next().hasClass( 'show-sub' ) ) {
			$( this ).parents( '.sub-dropdown' ).first().find( '.show-sub' ).removeClass( "show-sub" );
		}else{
			$( this ).next().addClass( "show-sub" );
		}
	});

	//cart menu
	$('.stickyCart').on('click', function() {
		$('#cart').addClass('shopping_cart_on');
		$('.overlay').addClass('is-visible');
	
	  });
	
	  $('.cart_close_btn').on('click', function() {
		  $('#cart').removeClass('shopping_cart_on');
		  $('.overlay').removeClass('is-visible');
	  });

	  $('.overlay').on('click', function() {
		  $('#cart').removeClass('shopping_cart_on');
		  $('.overlay').removeClass('is-visible');
	  });
});


