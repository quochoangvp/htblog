<?php include_once('includes/functions.php'); ?>
<?php
	if (isset($_GET['pid']) && validate_int($_GET['pid'])) {
		$pid = (int)$_GET['pid'];
//		$q = "SELECT p.post_name, p.content, p.status, date_format(p.time, '%b %d, %y') AS post_time, c.cat_id, c.cat_name, u.user_id, u.username FROM posts AS p JOIN categories AS c USING(cat_id) JOIN users AS u USING(user_id) WHERE post_id = {$pid} LIMIT 1";
		$q = "SELECT p.post_name, p.content, p.status, DATE_FORMAT(p.time, '%b %d, %Y') AS post_time, c.cat_id, c.cat_name, u.user_id, u.username FROM posts AS p JOIN users AS u USING(user_id) JOIN categories AS c USING(cat_id) WHERE post_id = {$pid} LIMIT 1";
		$post = select_data($q);

		setPostView($pid);

	$titles = getParent($post[0]['cat_id']);
	$title = $post[0]['post_name'];
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
                    <div class="title"><?=$post[0]['post_name']?><span class="mini-title"></span></div>
                    <span class="tools">
                        <a class="fs1" aria-hidden="true" data-icon="" data-original-title=""></a>
                    </span>
                </div>
                <div class="widget-body">
                	<ul class="breadcrumb-beauty"><?=breadcrumb($post[0]['cat_id'])?><li><a href=""><?=$post[0]['post_name']?></a></li></ul>
	                <ul class="post_statics">
	                	<li><span class="fs1" aria-hidden="true" data-icon=""></span><a href='author.php?aid=<?=$post[0]['user_id']?>'><?=$post[0]['username']?></a></li>
	                	<li><span class="fs1" aria-hidden="true" data-icon=""></span><?=$post[0]['post_time']?></li>
	                	<li>
	                		<a data-original-title="Có <?=getPostView($pid)?> người đã xem. Bạn xem <?=getUserView($pid)?> lần." data-placement="top">
	                			<span class="fs1" aria-hidden="true" data-icon=""></span>
	                			<?=getPostView($pid)?>
                			</a>
                		</li>
                	</ul>
					<div class="clearfix"></div>
					<div class="post">
					    <?=the_content($post[0]['content'])?>
					</div>
				 </div>
            </div>
        </div>
    </div>
</div><!--.left-sidebar-->
<?php
    get_sidebar('b');
    get_footer();
?>