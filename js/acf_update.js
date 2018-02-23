jQuery.noConflict();
(function($) {
$( document ).ready(function() {

	$('.acf-table-body-row').each(function(){
		$leftbody = $(this).find('.acf-table-body-left');
		$count = $(this).find('.acf-table-body-cont').html();
		$( $leftbody ).append( '<div class="is-description"><input type="checkbox" value="description" id="description' + $count + '" name="description" /><label for="description' + $count + '"></label></div>' );
		console.log($count);
	})
	$(document).on( 'click', '.acf-table-add-row', function(){
	    $new_leftbody = $(this).closest('.acf-table-body-row').next('.acf-table-body-row').find('.acf-table-body-left');
	    $new_count = $(this).closest('.acf-table-body-row').next('.acf-table-body-row').find('.acf-table-body-cont').html();
		$( $new_leftbody ).append( '<div class="is-description"><input type="checkbox" value="description" id="description' + $new_count + '" name="description" /><label for="description' + $new_count + '"></label></div>' );
		console.log($new_count);
	});

});
})(jQuery);