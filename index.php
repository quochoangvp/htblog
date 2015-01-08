<?php
include_once('includes/functions.php');
get_header();
get_nav();
?>
<div class="dashboard-wrapper">
	<div class="left-sidebar">
		<div class="row-fluid">
			<div class="span12">
				<div class="widget">
					<div class="widget-header">
						<div class="title">
							Bài viết mới nhất
						</div>
						<span class="tools">
							<a class="fs1" aria-hidden="true" data-icon="" data-original-title=""></a>
						</span>
					</div>
					<div class="widget-body">
						<div class="post-container">
						<?php
						$posts = select_data("SELECT p.post_id, p.post_name, p.thumbnail, p.content, date_format(p.time, '%b %d, %y') AS post_time, u.username, u.user_id FROM posts AS p INNER JOIN users AS u USING(user_id) WHERE p.status = 'publish' ORDER BY post_time DESC LIMIT 0,3");
                        if ($posts) {
                            foreach ($posts as $post) {
                                $tags = select_data("SELECT t.tag_name FROM tags AS t INNER JOIN tags_posts as tp USING(tag_id) WHERE tp.post_id = {$post['post_id']}");
                                echo '<div class="post">
                                        <div class="img-container"><img src="'.BASE_URL.'public/images/uploads/';
                                        if(empty($post['thumbnail'])) {
                                            echo 'no_thumb.jpg';
                                        } else {
                                            echo 'posts/'.$post['thumbnail'];
                                        }
                                        echo '" alt=""></div>
                                        <article>
                                            <h5 class="no-margin"><a href="single.php?pid='.$post['post_id'].'">'.$post['post_name'].'</a></h5>
                                            <p class="no-margin">'.the_excerpt($post['content'],420).' <a href="single.php?pid='.$post['post_id'].'">Xem thêm</a></p>
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
                                                <li><span class="fs1" aria-hidden="true" data-icon=""></span><a href="author.php?aid='.$post['user_id'].'"> '.$post['username'].'</a></li>
                                                <li><span class="fs1" aria-hidden="true" data-icon=""></span>'.$post['post_time'].' </li>
                                                <li><span class="fs1" aria-hidden="true" data-icon=""></span>'.getPostView($post['post_id']).'</li>
                                            </ul>
                                        </div>
                                    </div>
                                ';
                            }
                        } else {
                            echo '<p class="warning">Không có bài viết nào!</p>';
                        } ?>
                    	</div>
					</div>
				</div>

				<div class="widget">
					<div class="widget-header">
						<div class="title">
							Bài viết được xem nhiều nhất
						</div>
						<span class="tools">
							<a class="fs1" aria-hidden="true" data-icon="" data-original-title=""></a>
						</span>
					</div>
					<div class="widget-body">
						<div class="post-container">
						<?php
						$posts = select_data("SELECT p.post_id, p.post_name, p.thumbnail, p.content, date_format(p.time, '%b %d, %y') AS post_time, u.username, u.user_id, v.value AS post_view FROM posts AS p INNER JOIN users AS u USING(user_id) INNER JOIN visitors AS v USING(post_id) WHERE p.status = 'publish' ORDER BY post_view DESC LIMIT 0,3");
                        if ($posts) {
                            foreach ($posts as $post) {
                            	$tags = select_data("SELECT t.tag_name FROM tags AS t INNER JOIN tags_posts as tp USING(tag_id) WHERE tp.post_id = {$post['post_id']}");
                                echo '<div class="post">
                                        <div class="img-container"><img src="'.BASE_URL.'public/images/uploads/';
                                        if(empty($post['thumbnail'])) {
                                            echo 'no_thumb.jpg';
                                        } else {
                                            echo 'posts/'.$post['thumbnail'];
                                        }
                                        echo '" alt=""></div>
                                        <article>
                                            <h5 class="no-margin"><a href="single.php?pid='.$post['post_id'].'">'.$post['post_name'].'</a></h5>
                                            <p class="no-margin">'.the_excerpt($post['content'],420).' <a href="single.php?pid='.$post['post_id'].'">Xem thêm</a></p>
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
                                                <li><span class="fs1" aria-hidden="true" data-icon=""></span><a href="author.php?aid='.$post['user_id'].'"> '.$post['username'].'</a></li>
                                                <li><span class="fs1" aria-hidden="true" data-icon=""></span>'.$post['post_time'].' </li>
                                                <li><span class="fs1" aria-hidden="true" data-icon=""></span>'.getPostView($post['post_id']).'</li>
                                            </ul>
                                        </div>
                                    </div>';
                            }
                        } else {
                            echo '<p class="warning">Không có bài viết nào!</p>';
                        } ?>
                    	</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<?php
	get_sidebar('b');
	get_footer();
	?>