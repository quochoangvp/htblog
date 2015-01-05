<?php
session_start();
include '../includes/functions.php';
header('Content-Type: application/json');
$response = array();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $tag_name = strip_tags($_POST['tag_name']);
    $tag_id = select_data("SELECT tag_id FROM tags WHERE tag_name='{$tag_name}'");
    if(sizeof($tag_id) != 0) {
    	$tag_id = $tag_id[0]['tag_id'];
    	if (delete_data('tags_posts',"tag_id={$tag_id}")) {
    		$response['status'] = 'success';
    		$response['msg']  = 'Xóa thẻ khỏi bài viết thành công!';
    	} else {
    		$response['status'] = 'error';
    		$response['msg']  = 'Xóa thẻ khỏi bài viết thất bại!';
    	}
    } else {
    	$response['status'] = 'success';
		$response['msg']  = 'Xóa thẻ khỏi bài viết thành công!';
    }
    
	echo json_encode($response);
}