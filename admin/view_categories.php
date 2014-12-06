<?php
    include_once('../includes/functions.php');
    get_header();
    get_nav();
    admin_access();
?>
<div class="dashboard-wrapper">
<div class="left-sidebar">
<?php

    if (empty($_SESSION['sort'])) {
        $_SESSION['sort']['by'] = 'cat_id';
        $_SESSION['sort']['ad'] = 'ASC';
    }

    $by = $_SESSION['sort']['by'];
    $ad = $_SESSION['sort']['ad'];

    if (view_cat_list($by, $ad)) {
        echo view_cat_list($by, $ad);
    } else {
        echo '<p class="warning">Không có chuyên mục nào!</p>';
    }
?>

</div><!--.left-sidebar-->
<?php
    get_sidebar('b');
    get_footer();
?>