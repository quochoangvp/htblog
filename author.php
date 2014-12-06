<?php
    include_once('includes/functions.php');
    get_header();
    get_nav();
    get_sidebar('a');
?>
<div id="content">
<?php
	if (isset($_GET['aid']) && validate_int($_GET['aid'])) {
		$aid = (int)$_GET['aid'];
		$page = isset($_GET['page']) ? $_GET['page'] : 1;
		$post_per_page = 5;
		$start = ($page-1)*$post_per_page;

		$posts = select_data("SELECT p.post_id, p.post_name, p.content, date_format(p.time, '%b %d, %y') AS post_time, u.username, u.user_id FROM posts AS p INNER JOIN users AS u USING(user_id) WHERE p.user_id = {$aid} ORDER BY post_time ASC LIMIT {$start},{$post_per_page}");

		$num_posts = num_rows("SELECT post_id FROM posts WHERE user_id = {$aid}");
	    $num_pages = ceil($num_posts/$post_per_page);

		if ($posts) {
			for ($i=0; $i<sizeof($posts); $i++) {
				echo '<div class="post">
						<h2><a href="single.php?pid='.$posts[$i]['post_id'].'">'.$posts[$i]['post_name'].'</a></h2>
						<p>'.the_excerpt($posts[$i]['content'],300).' <a href="single.php?pid='.$posts[$i]['post_id'].'">Read more</a></p>
						<p class="meta"><strong>Posted by:</strong> <a href="author.php?aid='.$posts[$i]['user_id'].'"> '.$posts[$i]['username'].'</a> | <strong>On: </strong> '.$posts[$i]['post_time'].' </p>
	                  </div>';
			}
			pagination('author.php?aid='.$aid);

		} else {
			echo '<p class="warning">Khong co bai viet nao trong muc nay!</p>';
		}
	} else {
		redirect_to();
	}
?>
</div> <!-- end #content -->
<?php
    get_sidebar('b');
    get_footer();
?>