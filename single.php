<?php include_once('includes/functions.php'); ?>
<?php
	if (isset($_GET['pid']) && validate_int($_GET['pid'])) {
		$pid = (int)$_GET['pid'];
		$q = "SELECT p.post_name, p.content, p.status, DATE_FORMAT(p.time, '%b %d, %Y') AS post_time, c.cat_id, c.cat_name, u.user_id, u.username FROM posts AS p JOIN users AS u USING(user_id) JOIN categories AS c USING(cat_id) WHERE post_id = {$pid} LIMIT 1";
		$post = select_data($q);
        $post = $post[0];

		setPostView($pid);

    	$titles = getParent($post['cat_id']);
    	$title = $post['post_name'];
    	foreach ($titles as $tit) {
    		$title = $title . ' &raquo; ' . $tit;
    	}
    	get_header();
        get_nav();

	} else {
		redirect_to();
	}
?>
<div class="dashboard-wrapper">
<div class="left-sidebar">
    <div class="row-fluid">
        <div class="span12">
            <div class="widget">
            	<div class="widget-header">
                    <div class="title"><?=$post['post_name']?><span class="mini-title"></span></div>
                    <span class="tools">
                        <a class="fs1" aria-hidden="true" data-icon="" data-original-title=""></a>
                    </span>
                </div>
                <div class="widget-body">
                	<ul class="breadcrumb-beauty"><?=breadcrumb($post['cat_id'])?><li><a href=""><?=$post['post_name']?></a></li></ul>
                	<div class="post-tags">
                	<?php $tags = select_data("SELECT t.tag_name FROM tags AS t INNER JOIN tags_posts as tp USING(tag_id) WHERE tp.post_id = {$pid}");
                	if (!empty($tags)) {
                        foreach ($tags as $tag) {
                            echo '<span class="fs1" aria-hidden="true" data-icon=""></span><a href="'.BASE_URL.'tag.php?tn='.$tag['tag_name'].'">'.$tag['tag_name'].'<a/>';
                        }
                    }
                	?>
                	</div>
	                <ul class="post_statics">
	                	<li><span class="fs1" aria-hidden="true" data-icon=""></span><a href='author.php?aid=<?=$post[0]['user_id']?>'><?=$post['username']?></a></li>
	                	<li><span class="fs1" aria-hidden="true" data-icon=""></span><?=$post['post_time']?></li>
	                	<li>
	                		<a data-original-title="Có <?=getPostView($pid)?> người đã xem. Bạn xem <?=getUserView($pid)?> lần." data-placement="top">
	                			<span class="fs1" aria-hidden="true" data-icon=""></span>
	                			<?=getPostView($pid)?>
                			</a>
                		</li>
                	</ul>
					<div class="clearfix"></div>
					<div class="post">
					    <?=the_content($post['content'])?>
					</div>
				 </div>
            </div>
        </div>
    </div>
    <div class="row-fluid">
    	<?php
    		same_cat_posts($post['cat_id'], $pid);
    		related_posts($post['cat_id'], $pid);
    		related_posts($post['cat_id'], $pid);
		?>
    </div>
</div><!--.left-sidebar-->
<?php
    get_sidebar('b');
    get_footer();
?>