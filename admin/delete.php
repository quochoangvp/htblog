<?php
    include_once('../includes/functions.php');
    get_header();
    get_nav();
    admin_access();
?>
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
?>
<div id="content">
    <h2>Delete: <?php echo $trash[0]['trash_name']; ?></h2>
    <?php if(!empty($messages)) echo $messages; ?>
    <form id="del_trash" action="" method="post">
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