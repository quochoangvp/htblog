<?php include_once('../includes/functions.php'); ?>
<?php
if (isset($_GET['pid']) && validate_int($_GET['pid'])) {

    $post_id = mysqli_real_escape_string($con,$_GET['pid']);
    $posts = select_data("SELECT post_name, cat_id, content, status FROM posts WHERE post_id = {$post_id}");

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $errors  = array();
        $trimmed = array_map('trim', $_POST);
        $clean   = array_map('strip_tags', $trimmed);
        $htmlentities   = array_map('htmlentities', $trimmed);


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
        if (!empty($htmlentities['content'])) {
            $content = mysqli_real_escape_string($con, $htmlentities['content']);
        } else {
            $errors[] = 'content';
        }

        // Validate status
        if (!empty($clean['status']) && ($clean['status'] == 'draft' || $clean['status'] == 'publish')) {
            $status = $clean['status'];
        } else {
            $errors[] = 'status';
        }

        // Cập nhật CSDL
        if (empty($errors)) {
            if(update_data('posts',"post_name = '{$post_name}', cat_id = {$cat_id}, content = '{$content}', status = '{$status}', time = NOW()", "post_id = {$post_id}")) {
                $messages = '<p class="success">Sửa bài viết thành công!</p>';
            } else {
                $messages = '<p class="warning">Sửa thất bại</p>';
            }
        } else {
            $messages = '<p class="warning">Hãy chắc chắn các trường bạn đã nhập đầy đủ!</p>';
        }
    }
} else {
    redirect_to('admin/view_posts.php');
}
    $title = 'Chỉnh sửa: ' . $posts[0]['post_name'] . ' &raquo; Admin CP';
    get_header();
    get_nav();
    admin_access();
?>
<div class="dashboard-wrapper">
    <form id="add_post" class="form-horizontal no-margin" action="" method="post">
    <div class="left-sidebar">
        <div class="row-fluid">
            <div class="span12">
                <div class="widget">
                    <div class="widget-header">
                        <div class="title">Chỉnh sửa: <?=$posts[0]['post_name']; ?><span class="mini-title"><?php if(isset($errors) && in_array('content', $errors)) { echo "<p class='warning'>Vui lòng nhập nội dung</p>"; } ?></span></div>
                        <span class="tools">
                            <a class="fs1" aria-hidden="true" data-icon="" data-original-title=""></a>
                        </span>
                    </div>
                    <div class="widget-body">
                        <div>
                            <textarea name="content" cols="50" rows="20"><?=$posts[0]['content']; ?></textarea>
                        </div>
                        <div class="form-actions no-margin">
                            <div class="next-prev-btn-container pull-left" style="margin-left: -150px;">
                                <a href="view_posts.php" class="button prev" data-original-title="">Trở về</a>
                            </div>
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
            <input type="text" name="post_name" id="post_name" class="input-block-level" value="<?=$posts[0]['post_name']; ?>" maxlength="255" tabindex="1" />
            <?php
                if(isset($errors) && in_array('post_name', $errors)) {
                    echo "<p class='warning'>Vui lòng nhập tên bài viết</p>";
                }
            ?>
        </div>
        <hr class="hr-stylish-1"/>
        <div class="wrapper">
            <label for="cat_id" class="center">Tất cả thể loại</label>
            <select name="cat_id" class="input-block-level" tabindex="2">
                <option value="">Chọn một thể loại</option>
                <?php
                    select_cat_list(0,0,$posts[0]['cat_id']);
                ?>
            </select>
        </div>
        <hr class="hr-stylish-1"/>
        <div class="wrapper">
            <label for="status" class="center">Trạng thái</label>
            <div class="radio">
                <label><input class="radio" type="radio" name="status" value="draft" tabindex="3" <?php
                    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                        if(isset($clean['status']) && $clean['status']=='draft') echo 'checked="checked"';
                    } else {
                        if($posts[0]['status'] == 'draft') echo 'checked="checked"';
                    }
                    ?> />Nháp</label>
                <label><input class="radio" type="radio" name="status" value="publish" tabindex="4" <?php
                    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                        if(isset($clean['status']) && $clean['status']=='publish') echo 'checked="checked"';
                    } else {
                        if($posts[0]['status'] == 'publish') echo 'checked="checked"';
                    }
                    ?> />Công khai</label>
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