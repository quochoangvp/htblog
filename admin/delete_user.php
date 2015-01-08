<?php include_once('../includes/functions.php'); ?>
<?php
if (isset($_GET['uid']) && validate_int($_GET['uid'])) {
    $user_id = mysqli_real_escape_string($con,$_GET['uid']);
    $users = select_data("SELECT username, level FROM users WHERE user_id = {$user_id} LIMIT 1");
    $user = $users[0];
    if($user) {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $delete = mysqli_real_escape_string($con,strip_tags($_POST['delete']));
            if ($delete == 'yes') {
                if($user['level'] == 'owner') {
                    $messages = '<p class="warning">Không thể xóa Owner!</p>';
                } else {
                    if(delete_data('users', "user_id = $user_id")) {
                        $messages = '<p class="success">Xóa thành công!</p>';
                    } else {
                        $messages = '<p class="warning">Xóa thất bại!</p>';
                    }
                }
            } else {
                $messages = '<p class="warning">Tôi không muốn xóa nữa!</p>';
            }
        }
    } else {
        redirect_to('admin/manage_users.php');
    }
} else {
    redirect_to('admin/manage_users.php');
}
    $title = 'Xóa người dùng: ' . $user['username'] . ' &raquo; Admin CP';
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
                    <div class="title">Xóa người dùng: <?php echo $user['username']; ?><span class="mini-title"></span></div>
                    <span class="tools">
                        <a class="fs1" aria-hidden="true" data-icon="" data-original-title=""></a>
                    </span>
                </div>
                <div class="widget-body">
                    <?php if(!empty($messages)) echo $messages; ?>
                    <form id="del_user" class="form-inline no-margin" action="" method="post">
                        <div class="control-group">
                            <label for="delete">Bạn chắc chắn muốn xóa người dùng này?</label>
                            <div class="radio">
                                <label><input class="radio" type="radio" name="delete" value="no" checked="checked" /> Không</label>
                                <label><input class="radio" type="radio" name="delete" value="yes" /> Có</label>
                            </div>
                        </div>
                        <div class="form-actions no-margin">
                            <div class="next-prev-btn-container pull-left" style="margin-left: 10px;">
                                <a href="manage_users.php" class="button prev" data-original-title="">Trở về</a>
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