<?php include_once('includes/functions.php'); ?>
<?php
    if (isset($_GET['cid']) && validate_int($_GET['cid'])) {
        $cid = (int)$_GET['cid'];
        $page = isset($_GET['page']) ? $_GET['page'] : 1;
        $post_per_page = 3;
        $start = ($page-1)*$post_per_page;

        $posts = select_data("SELECT p.post_id, p.post_name, p.thumbnail, p.content, date_format(p.time, '%b %d, %y') AS post_time, u.username, u.user_id FROM posts AS p INNER JOIN users AS u USING(user_id) WHERE p.cat_id = {$cid} AND p.status = 'publish' ORDER BY post_time ASC LIMIT {$start},{$post_per_page}");
        $cat = select_data("SELECT cat_name FROM categories WHERE cat_id = $cid LIMIT 1");

        $num_posts = num_rows("SELECT post_id FROM posts WHERE cat_id = {$cid} AND status = 'publish'");
        $num_pages = ceil($num_posts/$post_per_page);
        $title = $cat[0]['cat_name'];
    get_header();
    get_nav();
?>
<div class="dashboard-wrapper">
<div class="left-sidebar">
    <div class="row-fluid">
        <div class="span12">
            <div class="widget">
                <div class="widget-header">
                    <div class="title"><?=$cat[0]['cat_name']?><span class="mini-title"></span></div>
                    <span class="tools">
                        <a class="fs1" aria-hidden="true" data-icon="" data-original-title=""></a>
                    </span>
                </div>
                <div class="widget-body">
                    <div class="post-container">
                    <?php
                        if ($posts) {
                            for ($i=0; $i<sizeof($posts); $i++) {
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
                                        <div class="icons-nav">
                                            <ul>
                                                <li><strong>Người đăng:</strong> <a href="author.php?aid='.$posts[$i]['user_id'].'"> '.$posts[$i]['username'].'</a></li>
                                                <li><strong>Ngày đăng: </strong> '.$posts[$i]['post_time'].' </li>
                                                <li><strong>Lượt xem: </strong> '.getPostView($posts[$i]['post_id']).'</li>
                                            </ul>
                                        </div>
                                    </div>';
                            }
                            pagination('category.php?cid='.$cid);

                        } else {
                            echo '<p class="warning">Không có bài viết nào trong thể loại này!</p>';
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