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

        } else $errors[] = 'post_name';

        // Validate cat_id
        if (!empty($clean['cat_id']) && validate_int($clean['cat_id'])) {

            $cat_id = mysqli_real_escape_string($con,$clean['cat_id']);

        } else $errors[] = 'cat_id';

        // Validate content
        if (!empty($trimmed['content'])) {

            $content = strip_tags($trimmed['content'],'<div><p><a><strong><b><s><u><em><sub><sup><pre><code><span><br><hr><blockquote><ul><ol><li><h6><h5><h4><h3><img>');
            $content = mysqli_real_escape_string($con, $trimmed['content']);

        } else $errors[] = 'content';

        // Validate status
        if (!empty($clean['status']) && ($clean['status'] == 'draft' || $clean['status'] == 'publish')) {

            $status = $clean['status'];

        } else $errors[] = 'status';

        // Validate description
        if (!empty($clean['post_des'])) {

            $post_des = mysqli_real_escape_string($con,$clean['post_des']);

        } else $errors[] = 'post_des';

        // Validate post thumbnail
        if (!empty($clean['post_thumbnail'])) {
            $post_thumbnail = mysqli_real_escape_string($con,$clean['post_thumbnail']);
        }

        // Insert to database
        if (empty($errors)) {
            $now = date("Y-m-d H:i:s");
            if (insert_data('posts', '(post_name, user_id, cat_id, content, post_des, status, thumbnail, time)', "('{$post_name}', ".$_SESSION['uid'].", $cat_id, '$content', '$post_des', '$status', '$post_thumbnail', '$now')")) {
                $posts = select_data("SELECT post_id FROM posts WHERE time = '{$now}'");
                // Validate tags
                if (!empty($clean['tag_name'])) {
                    $tag_name = mysqli_real_escape_string($con,$clean['tag_name']);
                    $tag_name = rtrim($tag_name,',');
                    $tags = explode(',', $tag_name);

                    foreach ($tags as $tag) {
                        if(!check_data_exist('tag_name', 'tags', "tag_name='".$tag."'")) {
                            if (insert_data('tags',"(`tag_name`)", "('".$tag."')")) {
                                // Thanh cong
                            } else {
                                // That bai
                            }
                        }
                        $tag_id = select_data("SELECT tag_id FROM tags WHERE tag_name = '".$tag."' LIMIT 1");
                        $tag_id = $tag_id[0]['tag_id'];

                        if(!check_data_exist('id', 'tags_posts', "tag_id = {$tag_id} AND post_id = ".$posts[0]['post_id'])) {

                            if (insert_data('tags_posts',"(`tag_id`, `post_id`)", "($tag_id, ".$posts[0]['post_id'].")")) {
                                // Thanh cong
                            } else {
                                // That bai
                            }
                        } else {
                            // Thanh cong
                        }
                    }
                }
                if (!empty($posts)) redirect_to('admin/edit_post.php?pid='.$posts[0]['post_id']);

                $messages = '<p class="success">Đăng bài thành công!</p>';

            } else $messages = '<p class="warning">Không thể đăng bài!</p>';

        } else $messages = '<p class="warning">Hãy điền đầy đủ dữ liệu!</p>';
    }
?>
<div class="dashboard-wrapper">
<form id="add_post" action="" class="form-horizontal no-margin" method="post"></form>
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
                        <?php if(!empty($messages)) echo '<div class="wrapper">'.$messages.'</div>'; ?>
                        <div class="wrapper">
                            <label for="post" class="text">Nhập tên bài viết ở đây</label>
                            <input form="add_post" type="text" name="post_name" id="post_name" class="input-block-level" value="<?php if(isset($clean['post_name'])) echo $clean['post_name']; ?>" maxlength="255" tabindex="1" />
                            <?php
                                if(isset($errors) && in_array('post_name', $errors)) {
                                    echo "<p class='warning'>Vui lòng nhập tên bài viết</p>";
                                }
                            ?>
                        </div>
                        <div>
                            <textarea form="add_post" class="mceEditor" name="content" cols="50" rows="20"><?php
                                if(isset($_POST['content'])) echo htmlentities($_POST['content'], ENT_COMPAT, 'UTF-8');
                            ?></textarea>
                        </div>
                        <div class="form-actions no-margin">
                            <input form="add_post" class="btn btn-info pull-right" type="submit" name="submit" value="Lưu" tabindex="5" />
                            <div class="clearfix"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div><!--.left-sidebar-->
    <div class="right-sidebar">
        <div class="wrapper">
            <label for="cat_id" class="center">Chọn thể loại</label>
            <select form="add_post" name="cat_id" class="input-block-level" tabindex="2">
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
        <div class="wrapper">
            <label for="post_des" class="center">Mô tả (&lt;170 kí tự)</label>
            <textarea form="add_post" name="post_des" id="post_des" class="input-block-level" rows="5" tabindex="3"><?=isset($clean['post_des']) ? $clean['post_des'] : '';?></textarea>
            <?php
                if(isset($errors) && in_array('post_des', $errors)) {
                    echo "<p class='warning'>Vui lòng nhập mô tả cho bài viết</p>";
                }
            ?>
        </div>
        <div class="wrapper">
            <label for="post_tags" class="center">Gắn thẻ</label>
            <div class="ui-widget">
                <input type="text" name="tag_name" id="tags" class="input-block-level" value="" maxlength="255"/>
            </div>
            <div id="results" style="display:none;">
                <input form="add_post" type="hidden" id="tags_input" name="tag_name" value="" />
            </div>
        </div>
        <div class="wrapper">
            <label for="post" class="center">Chọn trạng thái</label>
            <div class="radio">
                <label><input form="add_post" class="radio" type="radio" name="status" value="draft" tabindex="3" <?php if(isset($clean['status']) && $clean['status']=='draft') echo 'checked="checked"'; ?> />Nháp</label>
                <label><input form="add_post" class="radio" type="radio" name="status" value="publish" tabindex="4" <?php if(isset($clean['status']) && $clean['status']=='publish') echo 'checked="checked"'; ?> />Công khai</label>
            </div>
            <?php
                if(isset($errors) && in_array('status', $errors)) {
                    echo "<p class='warning'>Hãy chọn trạng thái của bài viết</p>";
                }
            ?>
        </div>
        <div id="message-ajax"></div>

        <div class="wrapper">
            <label for="status" class="center">Hình ảnh bài viết</label>
            <div class="post-thumbnail">
                <div id="preview">
                    <?php
                        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                            echo '<img src="'.BASE_URL.'public/images/uploads/';
                            if(empty($clean['post_thumbnail'])) echo 'no_thumb.jpg';
                            else echo 'posts/'.$clean['post_thumbnail'];
                            echo '" alt="user photo" />';

                            echo '<label id="lbl_post_thumb" for="';
                            if(!empty($clean['post_thumbnail'])) echo $clean['post_thumbnail'];
                            echo '">';
                            echo '<input form="add_post" type="hidden" id="input_post_thumbnail" name="post_thumbnail" value="';
                            if(!empty($clean['post_thumbnail'])) echo $clean['post_thumbnail'];
                            echo '" />';
                            echo '</label>';
                        } else {
                            echo '<img src="'.BASE_URL.'public/images/uploads/no_thumb.jpg" alt="user photo" />';
                            
                            echo '<label id="lbl_post_thumb" for="">';
                            echo '<input form="add_post" type="hidden" id="input_post_thumbnail" name="post_thumbnail" value="" />';
                            echo '</label>';
                        }
                    ?>
                </div>
                <div title="Nhấn vào ảnh để thay ảnh" class="photoimg">
                    <form id="imageform" method="post" enctype="multipart/form-data" action="ajaxthumb.php">
                        <input type="file" name="photoimg" id="photoimg" />
                    </form>
                </div>
                <div class="next-prev-btn-container center">
                    <div id="post_thumbnail"></div>
                    <div id="thumb_link">
                        <?php
                            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                                if(!empty($clean['post_thumbnail'])) echo '<a id="del" href="#" class="button">Xóa</a>';
                            } else {
                                if(!empty($posts[0]['thumbnail'])) echo '<a id="del" href="#" class="button">Xóa</a>';
                            }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
<div class="clearfix"></div>
</div><!-- .dashboard-wrapper -->
<?php
    get_footer();
?>