$(document).ready(function() {
	$('.sorting').click(function(event) {
		var cell = $(this).attr('id');
		$.getJSON('../includes/cats_sort.php', {cell : cell}, function(data) {
			if (!data.error) {
				location.reload();
			};
		});
	});

});