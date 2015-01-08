<?php
    include_once('../includes/functions.php');
?>
<?php
if (isset($_GET['cid']) && validate_int($_GET['cid'])) {

    $cat_id = mysqli_real_escape_string($con,$_GET['cid']);
    $cats = select_data("SELECT cat_name, parent_id FROM categories WHERE cat_id = {$cat_id} LIMIT 1");
    $cat = $cats[0];

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $errors  = array();
        $trimmed = array_map('trim', $_POST);
        $clean   = array_map('strip_tags', $trimmed);

        // Validate category name
        if (!empty($clean['category'])) {
            $cat_name = mysqli_real_escape_string($con, $clean['category']);
        } else {
            $errors[] = 'category';
        }

        // Validate parent_id
        if (isset($clean['parent_id'])) {
            if ($clean['parent_id'] == 0) {
                $parent_id = $clean['parent_id'];
            } elseif (validate_int($clean['parent_id'])) {
                $parent_id = mysqli_real_escape_string($con,$clean['parent_id']);
            } else {
                $errors[] = 'parent_id';
            }
        } else {
            $errors[] = 'parent_id';
        }

        // Cập nhật CSDL
        if (empty($errors)) {
            if(update_data('categories',"cat_name = '$cat_name', parent_id = $parent_id, time = NOW()", "cat_id = $cat_id")) {
                $messages = '<p class="success">Sửa thành công!</p>';
            } else {
                $messages = '<p class="warning">Sửa thất bại</p>';
            }
        } else {
            $messages = '<p class="warning">Hãy chắc chắn các trường bạn đã nhập đầy đủ!</p>';
        }
    }
} else {
    redirect_to('admin/view_categories.php');
}
?>
<?php
    $title = 'Sửa thể loại: ' . $cat['cat_name'] . ' &raquo; Admin CP';
    get_header();
    get_nav();
    admin_access();
?>
<div class="dashboard-wrapper">
<div class="left-sidebar">
    <div class="row-fluid">
        <div class="span12">
            <div class="widget">
                <div class="widget-header">
                    <div class="title">Sửa thể loại: <?php echo $cat['cat_name']; ?><span class="mini-title"></span></div>
                    <span class="tools">
                        <a class="fs1" aria-hidden="true" data-icon="" data-original-title=""></a>
                    </span>
                </div>
                <div class="widget-body">
                    <?php if(!empty($messages)) echo $messages; ?>
                    <form id="edit_cat" class="form-horizontal no-margin" action="" method="post">
                        <div class="control-group">
                            <label for="category" class="control-label">Tên thể loại</label>
                            <div class="controls">
                                <input type="text" name="category" id="category" class="span4" value="<?php echo $cat['cat_name']; ?>" maxlength="255" tabindex="1" />
                                <span class="help-inline ">
                                    <?php
                                        if(isset($errors) && in_array('category', $errors)) {
                                            echo "<span class='warning'>Vui lòng nhập tên thể loại</span>";
                                        }
                                    ?>
                                </span>
                            </div>
                        </div>
                        <div class="control-group">
                            <label for="parent" class="control-label">Thể loại mẹ</label>
                            <div class="controls">
                                <select name="parent_id" class="span4" tabindex="2">
                                    <option value="">Chọn một thể loại</option>
                                    <option value="0" <?php if($cat['parent_id'] == 0) echo 'selected="selected"' ?>>Root</option>
                                    <?php
                                        select_cat_list(0,0,$cat['parent_id']);
                                    ?>
                                </select>
                                <span class="help-inline ">
                                    <?php
                                        if(isset($errors) && in_array('parent_id', $errors)) {
                                            echo "<span class='warning'>Vui lòng chọn một thư mục mẹ</span>";
                                        }
                                    ?>
                                </span>
                            </div>
                        </div>
                        <div class="form-actions no-margin">
                            <div class="next-prev-btn-container pull-left" style="margin-left: -150px;">
                                <a href="view_categories.php" class="button prev" data-original-title="">Trở về</a>
                            </div>
                            <input class="btn btn-info pull-right" type="submit" name="submit" value="Sửa" tabindex="3" />
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