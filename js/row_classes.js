window.addEventListener('DOMContentLoaded', function() {
	document.querySelectorAll('td.serv-desc')?.forEach(el => el.closest('tr').classList.add('serv-description') );
	document.querySelectorAll('tr.serv-description')?.forEach(el => el.closest('tr').previousElementSibling.classList.add('has-description') );
});

// jQuery.noConflict();
// (function($) {
// $( document ).ready(function() {

// 	$('td.serv-desc').closest('tr').addClass('serv-description');
// 	$('tr.serv-description').prev('tr').addClass('has-description');

// });
// })(jQuery);