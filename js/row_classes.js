window.addEventListener('DOMContentLoaded', function() {
	document.querySelector('td.serv-desc')?.closest('tr').classList.add('serv-description');
	document.querySelector('tr.serv-description')?.closest('tr').previousElementSibling.classList.add('has-description');
});

// jQuery.noConflict();
// (function($) {
// $( document ).ready(function() {

// 	$('td.serv-desc').closest('tr').addClass('serv-description');
// 	$('tr.serv-description').prev('tr').addClass('has-description');

// });
// })(jQuery);