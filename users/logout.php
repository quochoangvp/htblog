<?php
    include_once('../includes/functions.php');
    get_header();
    get_nav();
?>
<div class="dashboard-wrapper">
<div class="left-sidebar">
<?php
    if (isset($_SESSION['uid'])) {
        $_SESSION = array();
        session_destroy();
        echo '<h3 class="success">Bạn đã đăng xuất thành công!</h3>';
    } else {
        redirect_to('users/login.php');
    }
?>
</div><!--.left-sidebar-->
<?php
    get_sidebar('b');
    get_footer();
?>