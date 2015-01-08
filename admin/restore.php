<?php include_once('../includes/functions.php'); ?>
<?php
if (isset($_GET['id']) && validate_int($_GET['id'])) {
    $id = mysqli_real_escape_string($con,$_GET['id']);
    $trashs = select_data("SELECT trash_name, parent, content, status, user_id, type, time FROM trash WHERE trash_id = {$id} LIMIT 1");
    $trash = $trashs[0];
    if($trash) {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $restore = mysqli_real_escape_string($con,strip_tags($_POST['restore']));
            if ($restore == 'yes') {
                $trash_name = mysqli_real_escape_string($con, strip_tags($trash['trash_name']));
                $user_id = (int)$trash['user_id'];
                $parent = (int)$trash['parent'];
                $content = mysqli_real_escape_string($con, $trash['content']);
                $time = mysqli_real_escape_string($con, $trash['time']);

                if (insert_data('posts', '(post_name, user_id, cat_id, content, time)', "('".$trash_name."', ".$user_id.", ".$parent.", '".$content."', '".$time."')")) {
                    if (delete_data('trash', "trash_id = {$id}")) {
                        $messages = '<p class="success">Khôi phục thành công!</p>';
                    } else {
                        $messages = '<p class="warning">Lỗi trong quá trình khôi phục!</p>';
                    }
                } else {
                    $messages = '<p class="warning">Khôi phục thất bại!</p>';
                }
            } else {
                $messages = '<p class="warning">Tôi không muốn khôi phục!</p>';
            }
        }
    } else {
        redirect_to('admin/trash.php');
    }
} else {

    redirect_to('admin/trash.php');
}
    $title = 'Khôi phục: ' . $trash['trash_name'];
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
                    <div class="title">Khôi phục: <?php echo $trash['trash_name']; ?><span class="mini-title"></span></div>
                    <span class="tools">
                        <a class="fs1" aria-hidden="true" data-icon="" data-original-title=""></a>
                    </span>
                </div>
                <div class="widget-body">
                    <?php if(!empty($messages)) echo $messages; ?>
                    <form id="restore" class="form-inline no-margin" action="" method="post">
                        <div class="control-group">
                            <label for="delete">Bạn chắc chắn muốn xóa thể loại này?</label>
                            <div class="radio">
                                <label><input class="radio" type="radio" name="restore" value="no" checked="checked" /> Không</label>
                                <label><input class="radio" type="radio" name="restore" value="yes" /> Có</label>
                            </div>
                        </div>
                        <div class="form-actions no-margin">
                            <div class="next-prev-btn-container pull-left" style="margin-left: 10px;">
                                <a href="trash.php" class="button prev" data-original-title="">Trở về</a>
                            </div>
                            <input class="btn btn-info pull-right" type="submit" name="submit" value="Khôi phục" onclick="return confirm('Bạn chắc chắn?');" />
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