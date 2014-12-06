<?php
    include_once('../includes/functions.php');
    get_header();
    get_nav();
    admin_access();
?>
<?php
if (isset($_GET['pid']) && validate_int($_GET['pid'])) {

    $post_id = mysqli_real_escape_string($con,$_GET['pid']);

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
?>
<?php
    $posts = select_data("SELECT post_name, cat_id, content, status FROM posts WHERE post_id = {$post_id}");
?>
<div id="content">
    <h2>Edit post: <?=$posts[0]['post_name']; ?></h2>
    <?php if(!empty($messages)) echo $messages; ?>
        <form id="add_post" action="" method="post">
            <fieldset>
                <legend>Edit a Post</legend>
                    <div>
                        <label for="post">Post Name: <span class="required">*</span>
                            <?php
                                if(isset($errors) && in_array('post_name', $errors)) {
                                    echo "<p class='warning'>Please fill in the post name</p>";
                                }
                            ?>
                        </label>
                        <input type="text" name="post_name" id="post_name" value="<?=$posts[0]['post_name']; ?>" maxlength="255" tabindex="1" />
                    </div>

                    <div>
                        <label for="cat_id">All categories: <span class="required">*</span>
                            <?php
                                if(isset($errors) && in_array('cat_id', $errors)) {
                                    echo "<p class='warning'>Please pick a category</p>";
                                }
                            ?>
                        </label>

                        <select name="cat_id" tabindex='2'>
                            <option value="">Choose a Category</option>
                            <?php
                                select_cat_list(0,0,$posts[0]['cat_id']);
                            ?>
                        </select>
                    </div>

                    <div>
                        <label for="post-content">Post Content: <span class="required">*</span>
                            <?php
                                if(isset($errors) && in_array('content', $errors)) {
                                    echo "<p class='warning'>Please fill in the content</p>";
                                }
                            ?>
                        </label>
                        <textarea name="content" cols="50" rows="20"><?=$posts[0]['content']; ?></textarea>
                    </div>

                    <div>
                        <label for="status">Trạng thái: <span class="required">*</span>
                            <?php
                                if(isset($errors) && in_array('status', $errors)) {
                                    echo "<p class='warning'>Hãy chọn trạng thái của bài viết</p>";
                                }
                            ?>
                        </label>

                        <select name="status" tabindex='4'>
                            <option <?php if($posts[0]['status'] == 'draft') echo 'selected="selected"'; ?> value="draft">Nháp</option>
                            <option <?php if($posts[0]['status'] == 'publish') echo 'selected="selected"'; ?> value="publish">Công khai</option>
                        </select>
                    </div>
            </fieldset>
            <p><input type="submit" name="submit" value="Edit Post" tabindex="5" /></p>
        </form>
</div><!--end content-->
<?php
    get_footer();
?>