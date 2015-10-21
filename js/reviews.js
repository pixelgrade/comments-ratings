(function($){
	$(document ).ready(function(){
		var $rates = $('#add_comment_rating_wrap'),
			path = $rates.data('assets_path' ),
			default_score = 4;

		if ( typeof $('#add_post_rating').attr('data-score') !== 'undefined' ) {
			default_score = $('#add_post_rating').attr('data-score');
		}

		$rates.raty({
			half: false,
			target : '#add_post_rating',
			hints: pixreviews.hints,
			path: path,
			targetKeep : true,
			//targetType : 'score',
			targetType : 'hint',
			//precision  : true,
			score: default_score,
			click: function(score, evt) {
				$('#add_post_rating' ).val( '' + score );
				$('#add_post_rating option[value="' + score + '"]' ).attr( 'selected', 'selected' );
			},
			starType : 'i'
		});

		$('.review_rate' ).raty({
			readOnly: true,
			//target : this,
			half: false,
			starType : 'i',
			score: function() {
				return $(this).attr('data-score');
			}
		});
	});
})(jQuery);