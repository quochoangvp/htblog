<?php
	include_once('../includes/functions.php');
    $title = 'Admin CP';
	get_header();
	get_nav();
	admin_access();
?>
<div class="dashboard-wrapper">
	<div class="left-sidebar">
		<div class="row-fluid">
			<div class="span12">
				<div class="widget">
					<div class="widget-header">
						<div class="title">
							Quick Access
							<span class="mini-title">
								Metro UI Navigation
							</span>
						</div>
						<span class="tools">
							<a class="fs1" aria-hidden="true" data-icon="" data-original-title=""></a>
						</span>
					</div>
					<div class="widget-body">
						<div class="row-fluid">
							<div class="metro-nav">
								<div class="metro-nav-block nav-block-yellow current">
									<a href="index.html" data-original-title="">
										<div class="fs1" aria-hidden="true" data-icon=""></div>
										<div class="brand">
											Admin CP
										</div>
									</a>
								</div>
								<div class="metro-nav-block nav-block-orange">
									<a href="<?=BASE_URL?>admin/add_categories.php" data-original-title="">
										<div class="fs1" aria-hidden="true" data-icon=""></div>
										<div class="brand">
											Thêm thể loại
										</div>
									</a>
								</div>
								<div class="metro-nav-block nav-block-blue double">
									<a href="<?=BASE_URL?>admin/view_categories.php" data-original-title="">
										<div class="fs1" aria-hidden="true" data-icon=""></div>
										<div class="brand">
											DS thể loại
										</div>
									</a>
								</div>
								<div class="metro-nav-block nav-block-green">
									<a href="<?=BASE_URL?>admin/add_posts.php" data-original-title="">
										<div class="fs1" aria-hidden="true" data-icon=""></div>
										<div class="brand">
											Thêm bài viết
										</div>
									</a>
								</div>
								<div class="metro-nav-block nav-block-red">
									<a href="<?=BASE_URL?>admin/view_posts.php" data-original-title="">
										<div class="fs1" aria-hidden="true" data-icon=""></div>
										<div class="brand">
											DS bài viết
										</div>
									</a>
								</div>
								<div class="metro-nav-block nav-block-red double">
									<a href="<?=BASE_URL?>admin/manage_users.php" data-original-title="">
										<div class="fs1" aria-hidden="true" data-icon=""></div>
										<div class="brand">
											Quản lý người dùng
										</div>
									</a>
								</div>
								<div class="metro-nav-block nav-block-green">
									<a href="<?=BASE_URL?>admin/trash.php" data-original-title="">
										<div class="fs1" aria-hidden="true" data-icon=""></div>
										<div class="brand">
											Thùng rác
										</div>
									</a>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div> <!-- .left-sidebar -->
<?php
	get_sidebar('b');
	get_footer();
?>