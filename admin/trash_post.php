<?php
    include_once('../includes/functions.php');
    get_header();
    get_nav();
    admin_access();
?>
<?php
if (isset($_GET['pid']) && validate_int($_GET['pid'])) {
    $post_id = mysqli_real_escape_string($con,$_GET['pid']);
    $posts = select_data("SELECT post_id, post_name, cat_id, content, status, user_id, time FROM posts WHERE post_id = {$post_id}");
    if ($posts) {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $trash = mysqli_real_escape_string($con,strip_tags($_POST['trash']));
            if ($trash == 'yes') {
                $cols = 'trash_name, parent, content, status, user_id, type, time';
                $val  = "'".$posts[0]['post_name']."', ".$posts[0]['cat_id'].", '".$posts[0]['content']."', '".$posts[0]['status']."', ".$posts[0]['user_id'].", 'posts', '".$posts[0]['time']."'";

                if(insert_data('trash', "($cols)", "($val)")) {
                    if (delete_data('posts', "post_id = {$post_id}")) {
                        $messages = '<p class="success">Đã chuyển vào thùng rác!</p>';
                    } else {
                        $messages = '<p class="warning">Đã xảy ra lỗi trong quá trình xóa!</p>';
                    }
                } else {
                    $messages = '<p class="warning">Xóa không thành công!</p>';
                }
            } else {
                $messages = '<p class="warning">Tôi không muốn đưa nó vào thùng rác nữa!</p>';
            }
        }
    } else {
        redirect_to('admin/view_posts.php');
    }

} else {
    redirect_to('admin/view_posts.php');
}
?>
<div id="content">
    <h2>Move to trash: <?php echo $posts[0]['post_name']; ?></h2>
    <?php if(!empty($messages)) echo $messages; ?>
    <form id="del_post" action="" method="post">
        <fieldset>
            <legend>Move Post to Trash</legend>
                <label for="delete">Are you sure?</label>
                <div>
                    <input type="radio" name="trash" value="no" checked="checked" /> No
                    <input type="radio" name="trash" value="yes" /> Yes
                </div>
                <div><input type="submit" name="submit" value="Delete" onclick="return confirm('Are you sure?');" /></div>
        </fieldset>
    </form>
</div><!--end content-->
<?php
    get_footer();
?>