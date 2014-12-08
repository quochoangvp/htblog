<?php include_once('../includes/functions.php'); ?>
<?php
if (isset($_GET['id']) && validate_int($_GET['id'])) {
    $id = mysqli_real_escape_string($con,$_GET['id']);
    $trash = select_data("SELECT trash_name FROM trash WHERE trash_id = {$id}");
    if($trash) {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $delete = mysqli_real_escape_string($con,strip_tags($_POST['delete']));
            if ($delete == 'yes') {
                if(delete_data('trash', "trash_id = $id")) {
                    $messages = '<p class="success">Xóa thành công!</p>';
                } else {
                    $messages = '<p class="warning">Xóa thất bại!</p>';
                }
            } else {
                $messages = '<p class="warning">Tôi không muốn xóa nữa!</p>';
            }
        }
    } else {
        redirect_to('admin/trash.php');
    }
} else {
    redirect_to('admin/trash.php');
}
    $title = 'Xóa vĩnh viễn: ' . $trash[0]['trash_name'] . ' &raquo; Admin CP';
    get_header();
    get_nav();
    admin_access();
?>
<div class="dashboard-wrapper">
<div class="left-sidebar">
    <div class="row-fluid">
        <div class="span3"></div>
        <div class="span6">
            <div class="widget">
                <div class="widget-header">
                    <div class="title">Xóa vĩnh viễn: : <?php echo $trash[0]['trash_name']; ?><span class="mini-title"></span></div>
                    <span class="tools">
                        <a class="fs1" aria-hidden="true" data-icon="" data-original-title=""></a>
                    </span>
                </div>
                <div class="widget-body">
                    <?php if(!empty($messages)) echo $messages; ?>
                    <form id="del_trash" class="form-inline no-margin" action="" method="post">
                        <div class="control-group">
                            <label for="delete">Bạn chắc chắn muốn xóa? Bài viết sẽ không thể khôi phục lại!</label>
                            <div class="radio">
                                <label><input type="radio" name="delete" value="no" checked="checked" /> Không</label>
                                <label><input type="radio" name="delete" value="yes" /> Có</label>
                            </div>
                        </div>
                        <div class="form-actions no-margin">
                            <div class="next-prev-btn-container pull-left" style="margin-left: 10px;">
                                <a href="view_categories.php" class="button prev" data-original-title="">Trở về</a>
                            </div>
                            <input class="btn btn-info pull-right" type="submit" name="submit" value="Xóa" onclick="return confirm('Bạn chắc chắn?');" />
                            <div class="clearfix"></div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="span3"></div>
    </div>
</div><!--.left-sidebar-->
<?php
    get_sidebar('b');
    get_footer();
?>