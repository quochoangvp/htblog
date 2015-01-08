<?php
include_once('../includes/functions.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	$tags = select_data("SELECT tag_name FROM tags ORDER BY tag_name ASC");
	$tags_r = array();
	for ($i=0; $i < sizeof($tags); $i++) $tags_r[] = $tags[$i]['tag_name'];

	echo json_encode($tags_r);
}