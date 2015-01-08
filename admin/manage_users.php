<?php
    include_once('../includes/functions.php');
    $title = 'Quản lý người dùng &raquo; Admin CP';
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
                        $users = select_data("SELECT user_id, username, email, level, DATE_FORMAT(reg_time, '%b %d %Y') AS time FROM users ORDER BY user_id ASC");
                        if ($users) {
                    ?>
                    <div id="dt_example" class="example_alt_pagination">
                        <div id="data-table_wrapper" class="dataTables_wrapper" role="grid">
                            <table class="table table-condensed table-striped table-hover table-bordered pull-left dataTable" id="data-table" aria-describedby="data-table_info">
                                <thead>
                                    <tr>
                                        <th style="width:2%"><input type="checkbox" class="no-margin"></th>
                                        <th style="width:8%">ID</th>
                                        <th style="width:25%">Tên</th>
                                        <th style="width:25%">Email</th>
                                        <th style="width:10%">Chức vụ</th>
                                        <th style="width:20%">Ngày đăng ký</th>
                                        <th style="width:10%">Hành động</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($users as $user) { ?>
                                    <tr>
                                        <td><input type="checkbox" class="no-margin"></td>
                                        <td><?=$user['user_id']?></td>
                                        <td><span class="name"><?=$user['username']?></span></td>
                                        <td><?=$user['email']?></td>
                                        <td><span class="label label label-info"><?=$user['level']?></span></td>
                                        <td><?=$user['time']?></td>
                                        <td>
                                            <div class="btn-group">
                                                <button data-toggle="dropdown" class="btn btn-mini dropdown-toggle">Tác động<span class="caret"></span>
                                                </button>
                                                <ul class="dropdown-menu">
                                                    <li><a href="edit_user.php?uid=<?=$user['user_id']?>" data-original-title="">Sửa</a></li>
                                                    <li><a href="delete_user.php?uid=<?=$user['user_id']?>" data-original-title="">Xóa</a></li>
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