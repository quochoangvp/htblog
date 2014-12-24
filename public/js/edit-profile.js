$(document).ready(function() { 

	$('#photoimg').live('change', function()			{ 
		$("#preview").html('');
		$("#preview").html('<img src="../public/images/loader.gif" alt="Uploading...."/>');
		$("#imageform").ajaxForm({
			target: '#preview'
		}).submit();
		
	});


	//Xeditable form fields
    $.fn.editable.defaults.mode = 'inline';
    $('#username').click(function(event) {
        event.preventDefault();
    });;
    $('#email').editable({
        validate: function(value) {
            if($.trim(value) == '') {
                return 'Mục này không được để trống';
            }
        },
        success: function(response) {
            if (response.status == 'success') {
                $("#message-ajax").empty().append('<p class="success">'+response.msg+'</p>');
                setTimeout(function() {
                  $("#message-ajax p").remove();
                }, 3000);
            } else{
                $("#message-ajax").empty().append('<p class="warning">'+response.msg+'</p>');
                setTimeout(function() {
                  $("#message-ajax p").remove();
                }, 7000);
            };
        }
    });
    $('#password').editable({
        validate: function(value) {
            if($.trim(value) == '') {
                return 'Mục này không được để trống';
            }
        },
        success: function(response) {
            if (response.status == 'success') {
                $("#message-ajax").empty();
            } else{
                $("#message-ajax").empty().append('<p class="warning">'+response.msg+'</p>');
                setTimeout(function() {
                  $("#message-ajax p").remove();
                }, 7000);
            };
        }
    });
    $('#repassword').editable({
        validate: function(value) {
            if($.trim(value) == '') {
                return 'Mục này không được để trống';
            }
        },
        success: function(response) {
            if (response.status == 'success') {
                $("#message-ajax").empty().append('<p class="success">'+response.msg+'</p>');
                setTimeout(function() {
                  $("#message-ajax p").remove();
                }, 3000);
            } else{
                $("#message-ajax").empty().append('<p class="warning">'+response.msg+'</p>');
                setTimeout(function() {
                  $("#message-ajax p").remove();
                }, 7000);
            };
        }
    });
    $('#fullname').editable({
        validate: function(value) {
            if($.trim(value) == '') {
                return 'Mục này không được để trống';
            }
        },
        success: function(response) {
            if (response.status == 'success') {
                $("#message-ajax").empty().append('<p class="success">'+response.msg+'</p>');
                setTimeout(function() {
                  $("#message-ajax p").remove();
                }, 3000);
            } else{
                $("#message-ajax").empty().append('<p class="warning">'+response.msg+'</p>');
                setTimeout(function() {
                  $("#message-ajax p").remove();
                }, 7000);
            };
        }
    });
    $('#address').editable({
        success: function(response) {
            if (response.status == 'success') {
                $("#message-ajax").empty().append('<p class="success">'+response.msg+'</p>');
                setTimeout(function() {
                  $("#message-ajax p").remove();
                }, 3000);
            } else{
                $("#message-ajax").empty().append('<p class="warning">'+response.msg+'</p>');
                setTimeout(function() {
                  $("#message-ajax p").remove();
                }, 7000);
            };
        }
    });
    $('#about').editable({
    	success: function(response) {
            if (response.status == 'success') {
                $("#message-ajax").empty().append('<p class="success">'+response.msg+'</p>');
                setTimeout(function() {
                  $("#message-ajax p").remove();
                }, 3000);
            } else{
                $("#message-ajax").empty().append('<p class="warning">'+response.msg+'</p>');
                setTimeout(function() {
                  $("#message-ajax p").remove();
                }, 7000);
            };
        }
    });
});