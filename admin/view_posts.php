<?php
    include_once('../includes/functions.php');
    $title = 'Danh sách bài viết &raquo; Admin CP';
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
                    <div class="title">Danh sách bài viết<span class="mini-title"></span></div>
                    <span class="tools">
                        <a class="fs1" aria-hidden="true" data-icon="" data-original-title=""></a>
                    </span>
                </div>
                <div class="widget-body">
                    <?php
                        $q = "SELECT p.post_id, p.post_name, DATE_FORMAT(p.time, '%b %d, %Y') AS time, p.content, p.status, c.cat_id, c.cat_name, u.username";
                            $q .= " FROM posts AS p ";
                            $q .= " JOIN users AS u ";
                            $q .= " USING(user_id) ";
                            $q .= " JOIN categories AS c ";
                            $q .= " USING(cat_id) ";
                            $q .= " ORDER BY post_name ASC";
                        $posts = select_data($q);

                        if ($posts) {
                    ?>
                    <div id="dt_example" class="example_alt_pagination">
                        <div id="data-table_wrapper" class="dataTables_wrapper" role="grid">
                            <table class="table table-condensed table-striped table-hover table-bordered pull-left dataTable" id="data-table" aria-describedby="data-table_info">
                                <thead>
                                    <tr>
                                        <th style="width:2%"><input type="checkbox" class="no-margin"></th>
                                        <th style="width:16%">Tên bài</th>
                                        <th style="width:9%">Ngày đăng</th>
                                        <th style="width:10%">Người đăng</th>
                                        <th style="width:35%" class="center">Nội dung</th>
                                        <th style="width:10%">Thể loại</th>
                                        <th style="width:9%">Trạng thái</th>
                                        <th style="width:9%">Hành động</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($posts as $post) { ?>
                                    <tr class="gradeA odd">
                                        <td><input type="checkbox" class="no-margin"></td>
                                        <td><span class="name"><?=$post['post_name']?></span></td>
                                        <td class="center"><?=$post['time']?></td>
                                        <td class="center"><?=$post['username']?></td>
                                        <td><?=the_excerpt($post['content'])?></td>
                                        <td><a href="<?=BASE_URL?>category.php?cid=<?=$post['cat_id']?>"><?=$post['cat_name']?></a></td>
                                        <td class="center"><?php
                                            if($post['status'] == 'publish') echo '<span class="label label label-success">Công khai</span>';
                                            if($post['status'] == 'draft') echo '<span class="label label label-warning">Bản nháp</span>';
                                        ?></td>
                                        <td class="hidden-phone">
                                            <div class="btn-group">
                                                <button data-toggle="dropdown" class="btn btn-mini dropdown-toggle">Thao tác
                                                    <span class="caret"></span>
                                                </button>
                                                <ul class="dropdown-menu">
                                                    <li><a href="edit_post.php?pid=<?=$post['post_id']?>" data-original-title="">Sửa</a></li>
                                                    <li><a href="trash_post.php?pid=<?=$post['post_id']?>" data-original-title="">Xóa</a></li>
                                                </ul>
                                            </div>
                                        </td>
                                    </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <?php } else {
                        echo '<p class="warning">Không có bài viết nào!</p>';
                    } ?>
                </div>
            </div>
        </div>
    </div>
</div><!--.left-sidebar-->
<?php
    get_sidebar('b');
    get_footer();
?>