<?php
    include_once('../includes/functions.php');
    get_header();
    get_nav();
    admin_access();
?>
<?php
if (isset($_GET['id']) && validate_int($_GET['id'])) {
    $id = mysqli_real_escape_string($con,$_GET['id']);
    $trash = select_data("SELECT trash_name, parent, content, status, user_id, type, time FROM trash WHERE trash_id = {$id}");
    if($trash) {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $restore = mysqli_real_escape_string($con,strip_tags($_POST['restore']));
            if ($restore == 'yes') {
                if (insert_data('posts', '(post_name, user_id, cat_id, content, time)', "('".$trash[0]['trash_name']."', ".$trash[0]['user_id'].", ".$trash[0]['parent'].", '".$trash[0]['content']."', '".$trash[0]['time']."')")) {
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
?>
<div id="content">
    <h2>Restore: <?php echo $trash[0]['trash_name']; ?></h2>
    <?php if(!empty($messages)) echo $messages; ?>
    <form id="restore" action="" method="post">
        <fieldset>
            <legend>Restore</legend>
                <label for="trash">Are you sure?</label>
                <div>
                    <input type="radio" name="restore" value="no" checked="checked" /> No
                    <input type="radio" name="restore" value="yes" /> Yes
                </div>
                <div><input type="submit" name="submit" value="Restore" onclick="return confirm('Are you sure?');" /></div>
        </fieldset>
    </form>
</div><!--end content-->
<?php
    get_footer();
?>