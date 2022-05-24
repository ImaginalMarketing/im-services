window.addEventListener('DOMContentLoaded', function() {
	document.querySelector('.acf-table-root')?.querySelector('.acf-table-wrap')?.prepend('<div>To indicate a service description, prepend the text with "++".<br />For example: ++This is a service description.<br /><br /></div>');	


	document.querySelectorAll('.acf-table-body-row')?.each(function(){
		$leftbody = document.querySelector(this).querySelector('.acf-table-body-left');
		$count = document.querySelector(this).querySelector('.acf-table-body-cont').html();
		document.querySelector( $leftbody ).insertAdjacentHTML("beforeend", '<div class="is-description"><input type="checkbox" value="description" id="description' + $count + '" name="description" /><label for="description' + $count + '"></label></div>' );
		console.log($count);
	})
	
document.querySelector('.acf-table-add-row')?.addEventListener( 'click', function(){
		$new_leftbody = document.querySelector(this).closest('.acf-table-body-row').next('.acf-table-body-row').querySelector('.acf-table-body-left');
		$new_count = document.querySelector(this).closest('.acf-table-body-row').next('.acf-table-body-row').querySelector('.acf-table-body-cont').html();
	document.querySelector( $new_leftbody ).insertAdjacentHTML("beforeend", '<div class="is-description"><input type="checkbox" value="description" id="description' + $new_count + '" name="description" /><label for="description' + $new_count + '"></label></div>' );
	console.log($new_count);
});
})

// jQuery.noConflict();
// (function($) {
// $( document ).ready(function() {

// 	$('.acf-table-root').find('.acf-table-wrap').prepend('<div>To indicate a service description, prepend the text with "++".<br />For example: ++This is a service description.<br /><br /></div>')

// 	$('.acf-table-body-row').each(function(){
// 		$leftbody = $(this).find('.acf-table-body-left');
// 		$count = $(this).find('.acf-table-body-cont').html();
// 		$( $leftbody ).append( '<div class="is-description"><input type="checkbox" value="description" id="description' + $count + '" name="description" /><label for="description' + $count + '"></label></div>' );
// 		console.log($count);
// 	})
// 	$(document).on( 'click', '.acf-table-add-row', function(){
// 	    $new_leftbody = $(this).closest('.acf-table-body-row').next('.acf-table-body-row').find('.acf-table-body-left');
// 	    $new_count = $(this).closest('.acf-table-body-row').next('.acf-table-body-row').find('.acf-table-body-cont').html();
// 		$( $new_leftbody ).append( '<div class="is-description"><input type="checkbox" value="description" id="description' + $new_count + '" name="description" /><label for="description' + $new_count + '"></label></div>' );
// 		console.log($new_count);
// 	});

// });
// })(jQuery);