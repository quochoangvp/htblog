<?php
    include_once('../includes/functions.php');
    get_header();
    get_nav();
    admin_access();
?>
<?php
if (isset($_GET['cid']) && validate_int($_GET['cid'])) {
    $messages = array();
    $cat_id = mysqli_real_escape_string($con,$_GET['cid']);
    $cats = select_data("SELECT cat_name FROM categories WHERE cat_id = {$cat_id}");
    $posts = select_data("SELECT post_name, cat_id, content, status, user_id, time FROM posts WHERE cat_id = {$cat_id}");
    if($cats) {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $delete = mysqli_real_escape_string($con,strip_tags($_POST['delete']));
            if ($delete == 'yes') {

                do {
                    $post_delete = mysqli_real_escape_string($con,strip_tags($_POST['post_delete']));
                    if ($post_delete == 'trash') {
                        $post_name = mysqli_real_escape_string($con, strip_tags($posts[0]['post_name']));
                        $content = mysqli_real_escape_string($con, $posts[0]['content']);
                        $status = mysqli_real_escape_string($con, $posts[0]['status']);
                        $user_id = (int)$posts[0]['user_id'];
                        $time = mysqli_real_escape_string($con, $posts[0]['time']);

                        $cols = 'trash_name, parent, content, status, user_id, type, time';
                        $val  = "'".$post_name."', ".$cat_id.", '".$content."', '".$status."', ".$user_id.", 'posts', '".$time."'";

                        if(insert_data('trash', "($cols)", "($val)")) {
                            if (delete_data('posts', "cat_id = {$cat_id}")) {
                                $messages[] = '<p class="success">Đã chuyển vào thùng rác!</p>';
                            } else {
                                $messages[] = '<p class="warning">Đã xảy ra lỗi trong quá trình xóa!</p>';
                            }
                        } else {
                            $messages[] = '<p class="warning">Xóa không thành công!</p>';
                        }
                    } elseif ($post_delete == 'del') {
                        if (delete_data('posts', "cat_id = {$cat_id}")) {
                            $messages[] = '<p class="success">Đã chuyển vào thùng rác!</p>';
                        } else {
                            $messages[] = '<p class="warning">Đã xảy ra lỗi trong quá trình xóa!</p>';
                        }
                    }
                }while (sizeof($posts)==0);

                if(delete_data('categories', "cat_id = $cat_id")) {
                    $messages[] = '<p class="success">Xóa thành công!</p>';
                } else {
                    $messages[] = '<p class="warning">Xóa thất bại!</p>';
                }

            } else {
                $messages[] = '<p class="warning">Tôi không muốn xóa nữa!</p>';
            }
        }
    } else {
        redirect_to('admin/view_categories.php');
    }
} else {
    redirect_to('admin/view_categories.php');
}
?>
<div class="dashboard-wrapper">
<div class="left-sidebar">
    <div class="row-fluid">
        <div class="span12">
            <div class="widget">
                <div class="widget-header">
                    <div class="title">Xóa thể loại: <?=$cats[0]['cat_name']?><span class="mini-title"></span></div>
                    <span class="tools">
                        <a class="fs1" aria-hidden="true" data-icon="" data-original-title=""></a>
                    </span>
                </div>
                <div class="widget-body">
                    <?php if(!empty($messages)) echo $messages; ?>
                    <form id="del_user" class="form-inline no-margin" action="" method="post">
                        <div class="control-group">
                            <label for="delete">Bạn chắc chắn muốn xóa thể loại này?</label>
                            <div class="radio">
                                <label><input class="radio" type="radio" name="delete" value="no" checked="checked" /> Không</label>
                                <label><input class="radio" type="radio" name="delete" value="yes" /> Có</label>
                            </div>
                        </div>
                        <?php if ($posts) { ?>
                        <hr/>
                        <div class="control-group">
                            <label for="do_posts_action">Thể loại có chứa <strong><?=sizeof($posts)?></strong> bài viết. Bạn muốn làm gì với những bài này?</label>
                            <div class="radio">
                                <label><input class="radio" type="radio" name="post_delete" value="trash" checked="checked" /> Chuyển vào thùng rác</label>
                                <label><input class="radio" type="radio" name="post_delete" value="del" /> Xóa luôn</label>
                            </div>
                        </div>
                        <?php } ?>
                        <div class="form-actions no-margin">
                            <input class="btn btn-info pull-right" type="submit" name="submit" value="Xóa" onclick="return confirm('Are you sure?');" />
                            <div class="clearfix"></div>
                        </div>
                    </form>
                 </div>
            </div>
        </div>
    </div>
</div><!--.left-sidebar-->
<?php
    get_sidebar('b');
    get_footer();
?>