$(document).ready(function() {
	$.ajax({
		url: '../admin/js-tags.php',
		type: 'POST',
		success: function(response) {
			var tags_data = jQuery.parseJSON(response);
            $( "#tags" ).autocomplete({
            	source: tags_data
            });

            $("#tags").live('keypress', function(event) {
                var p = event.which;
                if (p==13) {
                    var tag = $("#tags").val();
                    var pid = $(".title").attr('id');
                    tag = $.trim(tag);
                    tag = tag.replace(/(<([^>]+)>)/ig,"");
                    $("#results").css('display', 'block');

                    if (tag!=0) {
                        $("#results").append('<a href="#" class="tags_val">'+tag+'</a>');
                        var tags_input = $("#tags_input").val();
                        $("#tags_input").val(tags_input + tag + ',');
                    };
                    $("#tags").val("");
                    // $.ajax({
                    //     url: '../admin/js-add-tags.php',
                    //     type: 'POST',
                    //     data: {tag_name: tag, post_id: pid},
                    //     success: function(response) {
                    //         if (response.status == 'success') {
                    //             $("#message-ajax").empty().append('<p class="success">'+response.msg+'</p>');
                    //             setTimeout(function() {
                    //               $("#message-ajax p").remove();
                    //             }, 3000);
                    //         } else{
                    //             $("#message-ajax").empty().append('<p class="warning">'+response.msg+'</p>');
                    //             setTimeout(function() {
                    //               $("#message-ajax p").remove();
                    //             }, 7000);
                    //         };
                    //     }
                    // });
                    

                    // $(".tags_val").live('click', function(event) {
                    //     event.preventDefault();
                    //     $(this).remove();
                    // });
                };
            });
        }
    });
    
    $(".tags_val").live('click', function(event) {
        var tagName = $(this).text();
        var tags_input = $("#tags_input").val();
        tags_input = tags_input.replace(tagName+',', "");

        $("#tags_input").val(tags_input);
        $.ajax({
            url: '../admin/js-remove-tags.php',
            type: 'POST',
            data: {tag_name: tagName},
        });
        
        event.preventDefault();
        $(this).remove();
    });
});