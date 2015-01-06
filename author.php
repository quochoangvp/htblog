<?php include_once('includes/functions.php'); ?>
<?php
	if (isset($_GET['aid']) && validate_int($_GET['aid'])) {
		$aid = (int)$_GET['aid'];
		$page = isset($_GET['page']) ? $_GET['page'] : 1;
		$post_per_page = 5;
		$start = ($page-1)*$post_per_page;

		$posts = select_data("SELECT p.post_id, p.post_name, p.thumbnail, p.content, date_format(p.time, '%b %d, %y') AS post_time, u.username, u.user_id FROM posts AS p INNER JOIN users AS u USING(user_id) WHERE p.user_id = {$aid} AND p.status = 'publish' ORDER BY post_time ASC LIMIT {$start},{$post_per_page}");

		$num_posts = num_rows("SELECT post_id FROM posts WHERE user_id = {$aid} AND status = 'publish'");
	    $num_pages = ceil($num_posts/$post_per_page);

	    $title = 'Tất cả bài viết của "' . $posts[0]['username'] . '"';
	    get_header();
	    get_nav();
?>
<div class="dashboard-wrapper">
<div class="left-sidebar">
    <div class="row-fluid">
        <div class="span12">
            <div class="widget">
                <div class="widget-header">
                    <div class="title">Tất cả bài viết của "<?=$posts[0]['username']?>"<span class="mini-title"></span></div>
                    <span class="tools">
                        <a class="fs1" aria-hidden="true" data-icon="" data-original-title=""></a>
                    </span>
                </div>
                <div class="widget-body">
                    <div class="post-container">
						<?php
						if ($posts) {
							for ($i=0; $i<sizeof($posts); $i++) {
                                $tags = select_data("SELECT t.tag_name FROM tags AS t INNER JOIN tags_posts as tp USING(tag_id) WHERE tp.post_id = {$posts[$i]['post_id']}");
								echo '<div class="post">
                                        <div class="img-container"><img src="'.BASE_URL.'public/images/uploads/';
                                        if(empty($posts[$i]['thumbnail'])) {
                                            echo 'no_thumb.jpg';
                                        } else {
                                            echo 'posts/'.$posts[$i]['thumbnail'];
                                        }
                                        echo '" alt=""></div>
                                        <article>
                                            <h5 class="no-margin"><a href="single.php?pid='.$posts[$i]['post_id'].'">'.$posts[$i]['post_name'].'</a></h5>
                                            <p class="no-margin">'.the_excerpt($posts[$i]['content'],420).' <a href="single.php?pid='.$posts[$i]['post_id'].'">Xem thêm</a></p>
                                        </article>
                                        <div class="post-tags">';

                                        if (!empty($tags)) {
                                            foreach ($tags as $tag) {
                                                echo '<span class="fs1" aria-hidden="true" data-icon=""></span><a href="'.BASE_URL.'tag.php?tn='.$tag['tag_name'].'">'.$tag['tag_name'].'<a/>';
                                            }
                                        }

                                        echo '</div>
                                        <div class="icons-nav">
                                            <ul>
                                                <ul>
                                                <li><span class="fs1" aria-hidden="true" data-icon=""></span>'.$posts[$i]['post_time'].' </li>
                                                <li><span class="fs1" aria-hidden="true" data-icon=""></span>'.getPostView($posts[$i]['post_id']).'</li>
                                            </ul>
                                        </div>
                                    </div>';
							}
							pagination('author.php?aid='.$aid);

						} else {
							echo '<p class="warning">Không có bài viết nào trong mục này!</p>';
						}
					echo '</div>';
	} else {
		redirect_to();
	}
?>
				</div>
            </div>
        </div>
    </div>
</div><!--.left-sidebar-->
<?php
    get_sidebar('b');
    get_footer();
?>