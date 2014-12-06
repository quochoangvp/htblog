<div class="top-nav">
	<ul>
		<li><a href="<?=BASE_URL?>/index.php" <?php if(current_file() == 'index.php') echo 'class="selected"'; ?>>
			<div class="fs1" aria-hidden="true" data-icon="&#xe000;"></div>Trang chủ</a></li>
		<?php if (isset($_SESSION['uname'])) { ?>
		<li><a href="<?=BASE_URL?>/admin/admin.php" <?php if(dir_name($_SERVER['REQUEST_URI']) == 'admin') echo 'class="selected"'; ?>>
			<div class="fs1" aria-hidden="true" data-icon="&#xe0a0;"></div>Admin CP</a></li>
		<?php } ?>
		<li><a href="<?=BASE_URL?>/contact.php" <?php if(current_file() == 'contact.php') echo 'class="selected"'; ?>>
			<div class="fs1" aria-hidden="true" data-icon="&#xe160;"></div>Liên hệ</a></li>
    </ul>
    <div class="clearfix"></div>
</div><!-- .top-nav -->
<div class="sub-nav">
	<?php if(dir_name($_SERVER['REQUEST_URI']) == 'admin') { ?>
	<ul>
		<li><a href="#" class="heading">Admin CP</a></li>
		<li><a <?php if(current_file() == 'add_categories.php') echo 'class="current"'; ?> href="<?=BASE_URL?>/admin/add_categories.php">Thêm thể loại</a></li>
		<li><a <?php if(current_file() == 'view_categories.php') echo 'class="current"'; ?> href="<?=BASE_URL?>/admin/view_categories.php">Danh sách thể loại</a></li>
		<li><a <?php if(current_file() == 'add_posts.php') echo 'class="current"'; ?> href="<?=BASE_URL?>/admin/add_posts.php">Thêm bài viết</a></li>
		<li><a <?php if(current_file() == 'view_posts.php') echo 'class="current"'; ?> href="<?=BASE_URL?>/admin/view_posts.php">Danh sách bài viết</a></li>
		<li><a <?php if(current_file() == 'manage_users.php') echo 'class="current"'; ?> href="<?=BASE_URL?>/admin/manage_users.php">Quản lý người dùng</a></li>
		<li><a <?php if(current_file() == 'trash.php') echo 'class="current"'; ?> href="<?=BASE_URL?>/admin/trash.php">Thùng rác</a></li>
     </ul>
     <div class="btn-group pull-right">
     	<button class="btn btn-primary">Trình đơn</button>
     	<button data-toggle="dropdown" class="btn btn-primary dropdown-toggle">
     		<span class="caret"></span>
 		</button>
 		<ul class="dropdown-menu pull-right">
			<li><a href="<?=BASE_URL?>/admin/add_categories.php">Thêm thể loại</a></li>
			<li><a href="<?=BASE_URL?>/admin/view_categories.php">Danh sách thể loại</a></li>
			<li><a href="<?=BASE_URL?>/admin/add_posts.php">Thêm bài viết</a></li>
			<li><a href="<?=BASE_URL?>/admin/view_posts.php">Danh sách bài viết</a></li>
			<li><a href="<?=BASE_URL?>/admin/manage_users.php">Quản lý người dùng</a></li>
			<li><a href="<?=BASE_URL?>/admin/trash.php">Thùng rác</a></li>
		</ul>
    </div>
    <?php } ?>
</div><!-- .sub-nav -->
