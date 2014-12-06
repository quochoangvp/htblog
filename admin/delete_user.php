<?php
    include_once('../includes/functions.php');
    get_header();
    get_nav();
    admin_access();
?>
<?php
if (isset($_GET['uid']) && validate_int($_GET['uid'])) {
    $user_id = mysqli_real_escape_string($con,$_GET['uid']);
    $users = select_data("SELECT username, level FROM users WHERE user_id = {$user_id}");
    if($users) {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $delete = mysqli_real_escape_string($con,strip_tags($_POST['delete']));
            if ($delete == 'yes') {
                if($users[0]['level'] == 'owner') {
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
?>
<div id="content">
    <h2>Delete user: <?php echo $users[0]['username']; ?></h2>
    <?php if(!empty($messages)) echo $messages; ?>
    <form id="del_user" action="" method="post">
        <fieldset>
            <legend>Delete</legend>
                <label for="delete">Are you sure?</label>
                <div>
                    <input type="radio" name="delete" value="no" checked="checked" /> No
                    <input type="radio" name="delete" value="yes" /> Yes
                </div>
                <div><input type="submit" name="submit" value="Delete" onclick="return confirm('Are you sure?');" /></div>
        </fieldset>
    </form>
</div><!--end content-->
<?php
    get_footer();
?>