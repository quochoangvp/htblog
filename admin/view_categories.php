<?php
    include_once('../includes/functions.php');
    $title = 'Quản lý thể loại &raquo; Admin CP';
    get_header();
    get_nav();
    admin_access();
?>
<div class="dashboard-wrapper">
<div class="left-sidebar">
<?php

    if (view_cat_list()) {
        echo view_cat_list();
    } else {
        echo '<p class="warning">Không có chuyên mục nào!</p>';
    }
?>

</div><!--.left-sidebar-->
<?php
    get_sidebar('b');
    get_footer();
?>