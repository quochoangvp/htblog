<?php
    include_once('../includes/functions.php');
    get_header();
    get_nav();
    admin_access();
?>
<?php
if (isset($_GET['cid']) && validate_int($_GET['cid'])) {
    $cat_id = mysqli_real_escape_string($con,$_GET['cid']);

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $delete = mysqli_real_escape_string($con,strip_tags($_POST['delete']));
        if ($delete == 'yes') {
            if(delete_data('categories', "cat_id = $cat_id")) {
                $messages = '<p class="success">Xóa thành công!</p>';
            } else {
                $messages = '<p class="warning">Xóa thất bại!</p>';
            }
        } else {
            $messages = '<p class="warning">Tôi không muốn xóa nữa!</p>';
        }
    }

} else {

    redirect_to('admin/view_categories.php');
}
?>
<?php
    $cats = select_data("SELECT cat_name FROM categories WHERE cat_id = {$cat_id}");
?>
<div id="content">
    <h2>Delete category: <?php echo $cats[0]['cat_name']; ?></h2>
    <?php if(!empty($messages)) echo $messages; ?>
    <form id="del_cat" action="" method="post">
        <fieldset>
            <legend>Delete Category</legend>
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