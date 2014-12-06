<?php include_once('includes/functions.php'); ?>
<?php
	if (isset($_GET['pid']) && validate_int($_GET['pid'])) {
		$pid = (int)$_GET['pid'];
//		$q = "SELECT p.post_name, p.content, p.status, date_format(p.time, '%b %d, %y') AS post_time, c.cat_id, c.cat_name, u.user_id, u.username FROM posts AS p JOIN categories AS c USING(cat_id) JOIN users AS u USING(user_id) WHERE post_id = {$pid} LIMIT 1";
		$q = "SELECT p.post_name, p.content, p.status, DATE_FORMAT(p.time, '%b %d, %Y') AS post_time, c.cat_id, c.cat_name, u.user_id, u.username FROM posts AS p JOIN users AS u USING(user_id) JOIN categories AS c USING(cat_id) WHERE post_id = {$pid} LIMIT 1";
		$post = select_data($q);

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
                    <div class="title">
                    	<ul class="breadcrumb"><?=breadcrumb($post[0]['cat_id'])?>
                    		<li> &raquo; <?=$post[0]['post_name']?><span class="mini-title"></span></li>
                		</ul>
            		</div>
                    <span class="tools">
                        <a class="fs1" aria-hidden="true" data-icon="" data-original-title=""></a>
                    </span>
                </div>
                <div class="widget-body">
	                <div class="post_statics">
	                	Đăng bởi: quochoangvp \ Ngày đăng: Nov 21, 2014 \ Lượt xem: 12
                	</div>
					<div class='post'>
					    <p><?=the_content($post[0]['content'])?></p>
					    <p class='meta'>
					        <strong>Posted by:</strong><a href='author.php?aid=<?=$post[0]['user_id']?>'> <?=$post[0]['username']?></a> | 
					        <strong>On: </strong> <?=$post[0]['post_time']?>
					        <strong>Page views: </strong> <?=$page_views?>
					        </p>
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