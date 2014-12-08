<?php include_once('../includes/functions.php'); ?>
<?php
if (isset($_GET['pid']) && validate_int($_GET['pid'])) {
    $post_id = mysqli_real_escape_string($con,$_GET['pid']);
    $posts = select_data("SELECT post_id, post_name, cat_id, content, status, user_id, time FROM posts WHERE post_id = {$post_id}");
    if ($posts) {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $trash = mysqli_real_escape_string($con,strip_tags($_POST['trash']));
            if ($trash == 'yes') {
                $post_name = mysqli_real_escape_string($con, strip_tags($posts[0]['post_name']));
                $cat_id = mysqli_real_escape_string($con, $posts[0]['cat_id']);
                $content = mysqli_real_escape_string($con, $posts[0]['content']);
                $status = mysqli_real_escape_string($con, $posts[0]['status']);
                $user_id = (int)$posts[0]['user_id'];
                $time = mysqli_real_escape_string($con, $posts[0]['time']);

                $cols = 'trash_name, parent, content, status, user_id, type, time';
                $val  = "'".$post_name."', ".$cat_id.", '".$content."', '".$status."', ".$user_id.", 'posts', '".$time."'";

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
    $title = 'Chuyển vào thùng rác: ' . $posts[0]['post_name'] . ' &raquo; Admin CP';
    get_header();
    get_nav();
    admin_access();
?>
<div class="dashboard-wrapper">
<div class="left-sidebar">
    <div class="row-fluid">
        <div class="span1"></div>
        <div class="span10">
            <div class="widget">
                <div class="widget-header">
                    <div class="title">Chuyển vào thùng rác: <?php echo $posts[0]['post_name']; ?><span class="mini-title"></span></div>
                    <span class="tools">
                        <a class="fs1" aria-hidden="true" data-icon="" data-original-title=""></a>
                    </span>
                </div>
                <div class="widget-body">
                    <?php if(!empty($messages)) echo $messages; ?>
                    <form id="del_post" class="form-inline no-margin" action="" method="post">
                        <div class="control-group">
                            <label for="delete">Bạn chắc chắn muốn xóa thể loại này?</label>
                            <div class="radio">
                                <label><input class="radio" type="radio" name="trash" value="no" checked="checked" /> Không</label>
                                <label><input class="radio" type="radio" name="trash" value="yes" /> Có</label>
                            </div>
                        </div>
                        <div class="form-actions no-margin">
                            <div class="next-prev-btn-container pull-left" style="margin-left: 10px;">
                                <a href="view_posts.php" class="button prev" data-original-title="">Trở về</a>
                            </div>
                            <input class="btn btn-info pull-right" type="submit" name="submit" value="Xóa" onclick="return confirm('Bạn chắc chắn?');" />
                            <div class="clearfix"></div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="span1"></div>
    </div>
</div><!--.left-sidebar-->
<?php
    get_sidebar('b');
    get_footer();
?>