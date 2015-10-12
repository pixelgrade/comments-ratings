(function($){

	$(document ).ready(function(){

		var $rates = $('#add_comment_rating_wrap'),
			path = $rates.data('assets_path');

		$rates.raty({
			half: true,
			target : '#add_post_rating',
			hints: pixreviews.hints,
			path: path,
			targetKeep : true,
			//targetType : 'score',
			targetType : 'hint',
			precision  : true,
			score: function() {
				return $(this).attr('data-score');
			},
			click: function(score, evt) {
				$('#add_post_rating' ).val( '' + score );
				$('#add_post_rating option[value="' + score + '"]' ).attr( 'selected', 'selected' );
			},
			starType : 'i'
		});

		$('.comment_rate' ).raty({
			readOnly: true,
			//target : this,
			half: true,
			starType : 'i',
			score: function() {
				return $(this).attr('data-score');
			}
		});

	});

})(jQuery);