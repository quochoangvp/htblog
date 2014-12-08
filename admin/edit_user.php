<?php include_once('../includes/functions.php'); ?>
<?php
if (isset($_GET['uid']) && validate_int($_GET['uid'])) {

    $user_id = mysqli_real_escape_string($con,$_GET['uid']);
    $users = select_data("SELECT username, email, level FROM users WHERE user_id = {$user_id}");
    if($users) {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $errors  = array();
            $trimmed = array_map('trim', $_POST);
            $clean   = array_map('strip_tags', $trimmed);

            // Validate email
            if (!empty($clean['email']) && validate_email($clean['email'])) {
                $email = mysqli_real_escape_string($con,$clean['email']);
            } else {
                $errors[] = 'email';
            }

            // Validate level
            $ulevel = array('owner', 'admin', 'mod', 'normal');
            if (!empty($clean['level']) && in_array($clean['level'], $ulevel)) {
                $level = $clean['level'];
            } else {
                $errors[] = 'level';
            }

            // Cập nhật CSDL
            if (empty($errors)) {
                if(update_data('users',"email = '{$email}', level = '{$level}'", "user_id = {$user_id}")) {
                    $messages = '<p class="success">Sửa bài chi tiết người dùng thành công!</p>';
                    if($_SESSION['uid'] == $user_id) $_SESSION['ulevel'] = $level;
                } else {
                    $messages = '<p class="warning">Sửa thất bại</p>';
                }
            } else {
                $messages = '<p class="warning">Hãy chắc chắn các trường bạn đã nhập đầy đủ!</p>';
            }
        }
    } else {
        redirect_to('admin/manage_users.php');
    }
} else {
    redirect_to('admin/manage_users.php');
}
    $title = 'Chỉnh sửa người dùng : ' . $users[0]['username'] . ' &raquo; Admin CP';
    get_header();
    get_nav();
    admin_access();
?>
<div class="dashboard-wrapper">
<div class="left-sidebar">
    <div class="row-fluid">
        <div class="span2"></div>
        <div class="span8">
            <div class="widget">
                <div class="widget-header">
                    <div class="title">Chỉnh sửa người dùng : <?=$users[0]['username']; ?><span class="mini-title"></span></div>
                    <span class="tools">
                        <a class="fs1" aria-hidden="true" data-icon="" data-original-title=""></a>
                    </span>
                </div>
                <div class="widget-body">
                    <?php if(!empty($messages)) echo $messages; ?>
                    <form id="add_post" class="form-horizontal no-margin" action="" method="post">
                       <div class="control-group">
                            <label for="email" class="control-label">Email</label>
                            <div class="controls">
                                <input type="text" name="email" id="email" class="span4" value="<?=$users[0]['email']; ?>" maxlength="100" tabindex="1" />
                                <span class="help-inline ">
                                    <?php
                                        if(isset($errors) && in_array('email', $errors)) {
                                            echo "<p class='warning'>Hãy nhập email của người dùng</p>";
                                        }
                                    ?>
                                </span>
                            </div>
                        </div>
                        <div class="control-group">
                            <label for="level" class="control-label">Chức vụ</label>
                            <div class="controls">
                                <select name="level" class="span4" tabindex="2">
                                    <option <?php if($users[0]['level'] == 'normal') echo 'selected="selected"';?> value="normal">Thành viên</option>
                                    <option <?php if($users[0]['level'] == 'mod') echo 'selected="selected"';?> value="mod">Moderator</option>
                                    <option <?php if($users[0]['level'] == 'admin') echo 'selected="selected"';?> value="admin">Quản trị viên</option>
                                    <option <?php if($users[0]['level'] == 'owner') echo 'selected="selected"';?> value="owner">Chủ nhân</option>
                                </select>
                                <span class="help-inline ">
                                    <?php
                                        if(isset($errors) && in_array('level', $errors)) {
                                            echo '<p class="warning">Chọn một chức vụ cho người dùng</p>';
                                        }
                                    ?>
                                </span>
                            </div>
                        </div>
                        <div class="form-actions no-margin">
                            <div class="next-prev-btn-container pull-left" style="margin-left: -150px;">
                                <a href="manage_users.php" class="button prev" data-original-title="">Trở về</a>
                            </div>
                            <input class="btn btn-info pull-right" type="submit" name="submit" value="Sửa" tabindex="3" />
                            <div class="clearfix"></div>
                        </div>
                    </form>
                 </div>
            </div>
        </div>
        <div class="span2"></div>
    </div>
</div><!--.left-sidebar-->
<?php
    get_sidebar('b');
    get_footer();
?>