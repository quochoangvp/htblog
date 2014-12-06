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
            $content = strip_tags($content,'<div><p><a><strong><b><s><u><em><sub><sup><pre><code><span><br><hr><blockquote><ul><ol><li><h6><h5><h4><h3><img>');
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
            if (insert_data('posts', '(post_name, user_id, cat_id, content, time)', "('{$post_name}', ".$_SESSION['uid'].", $cat_id, '$content', NOW())")) {
                $messages = '<p class="success">Đăng bài thành công!</p>';
            } else {
                $messages = '<p class="warning">Không thể đăng bài!</p>';
            }
        } else {
            $messages = '<p class="warning">Hãy điền đầy đủ dữ liệu!</p>';
        }
    }
?>
<div id="content">
    <h2>Create a post</h2>
    <?php if(!empty($messages)) echo $messages; ?>
        <form id="add_post" action="" method="post">
            <fieldset>
                <legend>Add a Post</legend>
                    <div>
                        <label for="post">Post Name: <span class="required">*</span>
                            <?php
                                if(isset($errors) && in_array('post_name', $errors)) {
                                    echo "<p class='warning'>Please fill in the post name</p>";
                                }
                            ?>
                        </label>
                        <input type="text" name="post_name" id="post_name" value="<?php if(isset($clean['post_name'])) echo $clean['post_name']; ?>" maxlength="255" tabindex="1" />
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
                                select_cat_list(0,0,isset($clean['cat_id']) ? $clean['cat_id'] : '');
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
                        <textarea name="content" cols="50" rows="20"><?php if(isset($_POST['content'])) echo htmlentities($_POST['content'], ENT_COMPAT, 'UTF-8'); ?></textarea>
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
                            <option value="draft">Nháp</option>
                            <option value="publish">Công khai</option>
                        </select>
                    </div>
            </fieldset>
            <p><input type="submit" name="submit" value="Add Post" tabindex="5" /></p>
        </form>
</div><!--end content-->
<?php
    get_footer();
?>