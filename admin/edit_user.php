<?php
    include_once('../includes/functions.php');
    get_header();
    get_nav();
    admin_access();
?>
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
?>
<div id="content">
    <h2>Edit: <?=$users[0]['username']; ?></h2>
    <?php if(!empty($messages)) echo $messages; ?>
        <form id="add_post" action="" method="post">
            <fieldset>
                <legend>User info</legend>
                <div>
                    <label for="email">Email: <span class="required">*</span>
                        <?php
                            if(isset($errors) && in_array('email', $errors)) {
                                echo "<p class='warning'>Hãy nhập email của người dùng</p>";
                            }
                        ?>
                    </label>
                    <input type="text" name="email" id="email" value="<?=$users[0]['email']; ?>" maxlength="100" tabindex="1" />
                </div>

                <div>
                    <label for="level">Level: <span class="required">*</span>
                        <?php
                            if(isset($errors) && in_array('level', $errors)) {
                                echo '<p class="warning">Chọn một level cho người dùng</p>';
                            }
                        ?>
                    </label>

                    <select name="level" tabindex='2'>
                        <option <?php if($users[0]['level'] == 'normal') echo 'selected="selected"';?> value="normal">Thành viên</option>
                        <option <?php if($users[0]['level'] == 'mod') echo 'selected="selected"';?> value="mod">Moderator</option>
                        <option <?php if($users[0]['level'] == 'admin') echo 'selected="selected"';?> value="admin">Quản trị viên</option>
                        <option <?php if($users[0]['level'] == 'owner') echo 'selected="selected"';?> value="owner">Chủ nhân</option>
                    </select>
                </div>
            </fieldset>
            <p><input type="submit" name="submit" value="Edit Post" tabindex="5" /></p>
        </form>
</div><!--end content-->
<?php
    get_footer();
?>