<?php
    include_once('../includes/functions.php');
    $title = 'Thêm bài viết &raquo; Admin CP';
    get_header();
    get_nav();
    admin_access();
?>
<?php
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $errors  = array();
        $trimmed = array_map('trim', $_POST);
        $clean   = array_map('strip_tags', $trimmed);


        // Validate post_name
        if (!empty($clean['post_name'])) {
            $post_name = mysqli_real_escape_string($con, $clean['post_name']);
        } else {
            $errors[] = 'post_name';
        }

        // Validate cat_id
        if (!empty($clean['cat_id']) && validate_int($clean['cat_id'])) {
            $cat_id = mysqli_real_escape_string($con,$clean['cat_id']);
        } else {
            $errors[] = 'cat_id';
        }

        // Validate content
        if (!empty($trimmed['content'])) {
            $content = strip_tags($trimmed['content'],'<div><p><a><strong><b><s><u><em><sub><sup><pre><code><span><br><hr><blockquote><ul><ol><li><h6><h5><h4><h3><img>');
            $content = mysqli_real_escape_string($con, $trimmed['content']);
        } else {
            $errors[] = 'content';
        }

        // Validate status
        if (!empty($clean['status']) && ($clean['status'] == 'draft' || $clean['status'] == 'publish')) {
            $status = $clean['status'];
        } else {
            $errors[] = 'status';
        }

        // Insert to database
        if (empty($errors)) {
            if (insert_data('posts', '(post_name, user_id, cat_id, content, status, time)', "('{$post_name}', ".$_SESSION['uid'].", $cat_id, '$content', '$status', NOW())")) {
                $messages = '<p class="success">Đăng bài thành công!</p>';
            } else {
                $messages = '<p class="warning">Không thể đăng bài!</p>';
            }
        } else {
            $messages = '<p class="warning">Hãy điền đầy đủ dữ liệu!</p>';
        }
    }
?>
<div class="dashboard-wrapper">
<form id="add_post" action="" class="form-horizontal no-margin" method="post">
    <div class="left-sidebar">
        <div class="row-fluid">
            <div class="span12">
                <div class="widget">
                    <div class="widget-header">
                        <div class="title">Viết bài mới<span class="mini-title"><?php if(isset($errors) && in_array('content', $errors)) { echo "<span class='warning'>Vui lòng nhập nội dung</span"; } ?></span></div>
                        <span class="tools">
                            <a class="fs1" aria-hidden="true" data-icon="" data-original-title=""></a>
                        </span>
                    </div>
                    <div class="widget-body">
                        <div>
                            <textarea name="content" cols="50" rows="20"><?php
                                if(isset($_POST['content'])) echo htmlentities($_POST['content'], ENT_COMPAT, 'UTF-8');
                            ?></textarea>
                        </div>
                        <div class="form-actions no-margin">
                            <input class="btn btn-info pull-right" type="submit" name="submit" value="Lưu" tabindex="5" />
                            <div class="clearfix"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div><!--.left-sidebar-->
    <div class="right-sidebar">
        <?php if(!empty($messages)) echo '<div class="wrapper">'.$messages.'</div><hr class="hr-stylish-1"/>'; ?>
        <div class="wrapper">
            <label for="post" class="center">Tên bài viết</label>
            <input type="text" name="post_name" id="post_name" class="input-block-level" value="<?php if(isset($clean['post_name'])) echo $clean['post_name']; ?>" maxlength="255" tabindex="1" />
            <?php
                if(isset($errors) && in_array('post_name', $errors)) {
                    echo "<p class='warning'>Vui lòng nhập tên bài viết</p>";
                }
            ?>
        </div>
        <hr class="hr-stylish-1"/>
        <div class="wrapper">
            <label for="cat_id" class="center">Chọn thể loại</label>
            <select name="cat_id" class="input-block-level" tabindex="2">
                <option value="">Chọn một thể loại</option>
                <?php
                    select_cat_list(0,0,isset($clean['cat_id']) ? $clean['cat_id'] : '');
                ?>
            </select>
            <?php
                if(isset($errors) && in_array('cat_id', $errors)) {
                    echo "<p class='warning'>Vui lòng chọn một thể loại</p>";
                }
            ?>
        </div>
        <hr class="hr-stylish-1"/>
        <div class="wrapper">
            <label for="post" class="center">Chọn trạng thái</label>
            <div class="radio">
                <label><input class="radio" type="radio" name="status" value="draft" tabindex="4" <?php if(isset($clean['status']) && $clean['status']=='draft') echo 'checked="checked"'; ?> />Nháp</label>
                <label><input class="radio" type="radio" name="status" value="publish" <?php if(isset($clean['status']) && $clean['status']=='publish') echo 'checked="checked"'; ?> />Công khai</label>
            </div>
            <?php
                if(isset($errors) && in_array('status', $errors)) {
                    echo "<p class='warning'>Hãy chọn trạng thái của bài viết</p>";
                }
            ?>
        </div>
    </div>
</form>
<div class="clearfix"></div>
</div><!-- .dashboard-wrapper -->
<?php
    get_footer();
?>