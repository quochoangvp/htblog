<?php include_once('../includes/functions.php'); ?>
<?php
if (isset($_GET['pid']) && validate_int($_GET['pid'])) {

    $post_id = mysqli_real_escape_string($con,$_GET['pid']);
    $posts = select_data("SELECT post_name, post_des, cat_id, thumbnail, content, status FROM posts WHERE post_id = {$post_id}");
    if (!$posts[0]['post_name']) redirect_to('admin/view_posts.php');
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
        // Validate description
        if (!empty($clean['post_des'])) {
            $post_des = mysqli_real_escape_string($con,$clean['post_des']);
        } else {
            $errors[] = 'post_des';
        }
        // Validate post thumbnail
        if (!empty($clean['post_thumbnail'])) {
            $post_thumbnail = mysqli_real_escape_string($con,$clean['post_thumbnail']);
        } else {
            $post_thumbnail = '';
        }

        // Cập nhật CSDL
        if (empty($errors)) {
            if(update_data('posts',"post_name = '{$post_name}', post_des = '{$post_des}', cat_id = {$cat_id}, content = '{$content}', status = '{$status}', thumbnail = '{$post_thumbnail}', time = NOW()", "post_id = {$post_id}")) {
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
<div class="dashboard-wrapper clearfix">
    <form id="add_post" class="form-horizontal no-margin" action="" method="post"></form>
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
                            <textarea form="add_post" class="mceEditor" name="content" cols="50" rows="20"><?=$posts[0]['content']; ?></textarea>
                        </div>
                        <div class="form-actions no-margin">
                            <div class="next-prev-btn-container pull-left" style="margin-left: 12px;">
                                <a href="view_posts.php" class="button prev" data-original-title="">Trở về</a>
                            </div>
                            <input form="add_post" class="btn btn-info pull-right" type="submit" name="submit" value="Lưu" tabindex="5" />
                            <!-- <div class="clearfix"></div> -->
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
            <input form="add_post" type="text" name="post_name" id="post_name" class="input-block-level" value="<?=$posts[0]['post_name']; ?>" maxlength="255" tabindex="1" />
            <?php
                if(isset($errors) && in_array('post_name', $errors)) {
                    echo "<p class='warning'>Vui lòng nhập tên bài viết</p>";
                }
            ?>
        </div>
        <div class="wrapper">
            <label for="cat_id" class="center">Tất cả thể loại</label>
            <select form="add_post" name="cat_id" class="input-block-level" tabindex="2">
                <option value="">Chọn một thể loại</option>
                <?php
                    select_cat_list(0,0,$posts[0]['cat_id']);
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
            <textarea form="add_post" name="post_des" id="post_des" class="input-block-level" rows="5" tabindex="3"><?php
                if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                    echo $clean['post_des'];
                } else {
                    if (!empty($posts[0]['post_des'])) {
                        echo $posts[0]['post_des'];
                    } else {
                        echo the_excerpt(strip_tags($posts[0]['content']),170);
                    }
                }
            ?></textarea>
            <?php
                if(isset($errors) && in_array('post_des', $errors)) {
                    echo "<p class='warning'>Vui lòng nhập mô tả cho bài viết</p>";
                }
            ?>
        </div>
        <div class="wrapper">
            <label for="status" class="center">Trạng thái</label>
            <div class="radio">
                <label><input form="add_post" class="radio" type="radio" name="status" value="draft" tabindex="4" <?php
                    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                        if(isset($clean['status']) && $clean['status']=='draft') echo 'checked="checked"';
                    } else {
                        if($posts[0]['status'] == 'draft') echo 'checked="checked"';
                    }
                    ?> />Nháp</label>
                <label><input form="add_post" class="radio" type="radio" name="status" value="publish" tabindex="5" <?php
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
        <div id="message-ajax"></div>

        <div class="wrapper">
            <label for="status" class="center">Hình ảnh bài viết</label>
            <div class="post-thumbnail">
                <div id="preview">
                    <img src="<?php
                        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                            ?><?=BASE_URL?>public/images/uploads/<?=empty($clean['post_thumbnail']) ? 'no_thumb.jpg' : 'posts/'.$clean['post_thumbnail'];?>" alt="user photo" /><?php
                        } else {
                            ?><?=BASE_URL?>public/images/uploads/<?=empty($posts[0]['thumbnail']) ? 'no_thumb.jpg' : 'posts/'.$posts[0]['thumbnail'];?>" alt="user photo" /><?php } ?>
                    <label id="lbl_post_thumb" for="<?=empty($posts[0]['thumbnail']) ? '' : $posts[0]['thumbnail'];?>">
                        <input form="add_post" type="hidden" id="input_post_thumbnail" name="post_thumbnail" value="<?=empty($posts[0]['thumbnail']) ? '' : 'posts/'.$posts[0]['thumbnail'];?>" />
                    </label>
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
<!-- <div class="clearfix"></div> -->
</div><!-- .dashboard-wrapper -->
<?php
    get_footer();
?>