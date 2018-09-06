jQuery.noConflict();
(function($) {
$( document ).ready(function() {

	$('td.serv-desc').closest('tr').addClass('serv-description');
	$('tr.serv-description').prev('tr').addClass('has-description');

});
})(jQuery);