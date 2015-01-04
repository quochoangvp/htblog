$(document).ready(function() {
	$('#photoimg').live('change', function() { 
		$("#preview").html('');
		$("#preview").html('<img src="../public/images/loader.gif" alt="Uploading...."/>');
		$("#imageform").ajaxForm({
			target: '#preview'
		}).submit();
	});

	$('#thumb_link a').live('click', function(event) {
		var thumb = $('#lbl_post_thumb').attr('for');
		var id = $('#thumb_link a').attr('id');
		if (id=='add') {
			$('#input_post_thumbnail').val(thumb);
			$('#preview img').attr('src', '../public/images/uploads/posts/'+thumb);
			$('#preview img').addClass('thumb_added');
			$("#message-ajax").empty().append('<p id="photo-message" class="success">Đã thêm ảnh!</p>');
			setTimeout(function() {
				$("#message-ajax p").remove();
			}, 3000);
			$("#thumb_link").empty().append('<a id="del" href="#" class="button">Xóa</a>');;
		} else if(id=='del') {
			$('#input_post_thumbnail').val('');
			$('#preview img').attr('src', '../public/images/uploads/no_thumb.jpg');
			$('#input_post_thumbnail').val('');
			$("#message-ajax").empty().append('<p id="photo-message" class="warning">Đã xóa ảnh!</p>');
			setTimeout(function() {
				$("#message-ajax p").remove();
			}, 3000);
			$("#thumb_link").empty();
		};
		event.preventDefault();
	});
});