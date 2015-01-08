<?php
    include_once('../includes/functions.php');
    $title = 'Thùng rác &raquo; Admin CP';
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
                    <div class="title">Thùng rác<span class="mini-title"></span></div>
                    <span class="tools">
                        <a class="fs1" aria-hidden="true" data-icon="" data-original-title=""></a>
                    </span>
                </div>
                <div class="widget-body">
                    <?php
                    $q = "SELECT t.trash_id, t.trash_name, t.content, t.status, t.type, u.username";
                        $q .= " FROM trash AS t ";
                        $q .= " JOIN users AS u ";
                        $q .= " USING(user_id) ";
                        $q .= " ORDER BY trash_id ASC";
                    $posts = select_data($q);

                    if ($posts) { ?>
                    <div id="dt_example" class="example_alt_pagination">
                        <div id="data-table_wrapper" class="dataTables_wrapper" role="grid">
                            <table class="table table-condensed table-striped table-hover table-bordered pull-left dataTable" id="data-table" aria-describedby="data-table_info">
                                <thead>
                                    <tr>
                                        <th style="width:2%"><input type="checkbox" class="no-margin"></th>
                                        <th style="width:16%">Tên</th>
                                        <th style="width:10%">Người đăng</th>
                                        <th style="width:35%" class="center">Nội dung</th>
                                        <th style="width:9%">Trạng thái</th>
                                        <th style="width:10%">Loại</th>
                                        <th style="width:9%">Hành động</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php foreach ($posts as $post) { ?>
                                    <tr class="gradeA odd">
                                        <td><input type="checkbox" class="no-margin"></td>
                                        <td><span class="name"><?=$post['trash_name']?></span></td>
                                        <td class="center"><?=$post['username']?></td>
                                        <td><?=the_excerpt($post['content'])?></td>
                                        <td><?=($post['status'] == 'draft') ? '<span class="label label label-warning">Nháp</span>' : '<span class="label label label-success">Công khai</span>';?></td>
                                        <td><?=($post['type'] == 'posts') ? '<span class="label label label-success">Bài viết</span>' : ''; ?></td>
                                        <td class="hidden-phone">
                                            <div class="btn-group">
                                                <button data-toggle="dropdown" class="btn btn-mini dropdown-toggle">Thao tác
                                                    <span class="caret"></span>
                                                </button>
                                                <ul class="dropdown-menu">
                                                    <li><a href="restore.php?id=<?=$post['trash_id']?>" data-original-title="">Khôi phục</a></li>
                                                    <li><a href="delete.php?id=<?=$post['trash_id']?>" data-original-title="">Xóa vĩnh viễn</a></li>
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
                        echo '<p class="warning">Thùng rác trống!</p>';
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