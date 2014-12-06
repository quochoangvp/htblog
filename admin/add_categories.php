<?php
    include_once('../includes/functions.php');
    $title = 'Thêm thể loại &raquo; Admin CP';
    get_header();
    get_nav();
    admin_access();
?>
<?php
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $errors  = array();
        $trimmed = array_map('trim', $_POST);
        $clean   = array_map('strip_tags', $trimmed);

        // Validate category name
        if (!empty($clean['category'])) {
            $cat_name = mysqli_real_escape_string($con, $clean['category']);
            if(check_data_exist('cat_name', 'categories', "cat_name = '$cat_name'")) {
                $errors[] = 'cat_name';
            }
        } else {
            $errors[] = 'category';
        }

        // Validate parent_id
        if (!empty($clean['parent_id'])) {
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

        // Insert to database
        if (empty($errors)) {
            if (insert_data('categories', '(cat_name, user_id, parent_id, time)', "('{$cat_name}', ".$_SESSION['uid'].", $parent_id, NOW())")) {
                $messages = '<p class="success">Thêm thể loại thành công!</p>';
            } else {
                $messages = '<p class="warning">Không thể thêm thể loại!</p>';
            }
        } else {
            $messages = '<p class="warning">Hãy điền đầy đủ thông tin!</p>';
        }
    }
?>
<div class="dashboard-wrapper">
<div class="left-sidebar">
    <div class="row-fluid">
        <div class="span12">
            <div class="widget">
                <div class="widget-header">
                    <div class="title">Thêm thể loại<span class="mini-title"></span></div>
                    <span class="tools">
                        <a class="fs1" aria-hidden="true" data-icon="" data-original-title=""></a>
                    </span>
                </div>
                <div class="widget-body">
                    <?php if(!empty($messages)) echo $messages; ?>
                    <form id="add_cat" class="form-horizontal no-margin" action="" method="post">
                        <div class="control-group">
                            <label for="category" class="control-label">Tên thể loại</label>
                            <div class="controls">
                                <input type="text" name="category" id="category" class="span4" value="<?php if(isset($clean['category'])) echo $clean['category']; ?>" maxlength="255" tabindex="1" />
                                <span class="help-inline ">
                                    <?php
                                        if(isset($errors) && in_array('category', $errors)) {
                                            echo "<span class='warning'>Hãy nhập tên thể loại</span>";
                                        }
                                        if(isset($errors) && in_array('cat_name', $errors)) {
                                            echo "<span class='warning'>Thể loại này đã tồn tại</span>";
                                        }
                                    ?>
                                </span>
                            </div>
                        </div>
                        <div class="control-group">
                            <label for="parent" class="control-label">Thể loại mẹ</label>
                            <div class="controls">
                                <select name="parent_id" class="span4" tabindex='2'>
                                    <option value="">Chọn một thể loại</option>
                                    <option value="0" <?php if(isset($clean['parent_id']) && $clean['parent_id'] == 0) echo 'selected="selected"' ?>>Thể loại gốc</option>
                                    <?php
                                        select_cat_list(0,0,isset($clean['parent_id']) ? $clean['parent_id'] : '');
                                    ?>
                                </select>
                                <span class="help-inline ">
                                    <?php
                                        if(isset($errors) && in_array('parent_id', $errors)) {
                                            echo "<span class='warning'>Hãy chọn một thể loại</span>";
                                        }
                                    ?>
                                </span>
                            </div>
                        </div>
                        <div class="form-actions no-margin">
                            <input class="btn btn-info pull-right" type="submit" name="submit" value="Thêm thể loại" tabindex="3" />
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