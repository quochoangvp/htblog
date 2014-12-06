	<div id="section-navigation">
		<ul class="navi">
			<li><a <?php if(current_file() == 'add_categories.php') echo 'class="current"'; ?> href="add_categories.php">Add Categories</a></li>
			<li><a <?php if(current_file() == 'view_categories.php') echo 'class="current"'; ?> href="view_categories.php"> View Categories</a></li>
			<li><a <?php if(current_file() == 'add_posts.php') echo 'class="current"'; ?> href="add_posts.php">Add Post</a></li>
			<li><a <?php if(current_file() == 'view_posts.php') echo 'class="current"'; ?> href="view_posts.php">View Posts</a></li>
			<li><a <?php if(current_file() == 'manage_users.php') echo 'class="current"'; ?> href="manage_users.php">Manage Users</a></li>
			<li><a <?php if(current_file() == 'trash.php') echo 'class="current"'; ?> href="trash.php">Trash</a></li>
		</ul>
</div><!--end section-navigation-->