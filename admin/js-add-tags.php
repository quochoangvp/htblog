<?php
session_start();
include '../includes/functions.php';
header('Content-Type: application/json');
$response = array();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $tag_name = strip_tags($_POST['tag_name']);
    $post_id = strip_tags($_POST['post_id']);
    if(!check_data_exist('tag_name', 'tags', "tag_name='{$tag_name}'")) {
    	if (insert_data('tags',"(`tag_name`)", "('$tag_name')")) {
    		$response['status'] = 'success';
    		$response['msg1'] = 'Thêm thẻ vào cơ sở dữ liệu thành công!';
    	} else {
    		$response['status'] = 'error';
    		$response['msg1'] = 'Thêm thẻ vào cơ sở dữ liệu thành công!';
    	}
    }
    $tag_id = select_data("SELECT tag_id FROM tags WHERE tag_name = '{$tag_name}' LIMIT 1");
	$tag_id = $tag_id[0]['tag_id'];
	if(!check_data_exist('id', 'tags_posts', "tag_id = {$tag_id} AND post_id = {$post_id}")) {
	    if (insert_data('tags_posts',"(`tag_id`, `post_id`)", "($tag_id, $post_id)")) {
			$response['status'] = 'success';
			$response['msg'] = 'Thêm thẻ vào bài viết thành công!';
		} else {
			$response['status'] = 'error';
			$response['msg'] = 'Thêm thẻ vào bài viết thất bại!';
		}
	} else {
		$response['status'] = 'success';
		$response['msg'] = 'Thêm thẻ vào bài viết thành công!';
	}
	echo json_encode($response);
}