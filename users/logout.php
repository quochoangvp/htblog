<?php
    include_once('../includes/functions.php');
    get_header();
    get_nav();
?>
<div class="dashboard-wrapper">
<div class="left-sidebar">
<div class="span3">&nbsp;</div>
    <div class="span6">
        <?php
            if (isset($_SESSION['uid'])) {
                $_SESSION = array();
                session_destroy();
                echo '<h3 class="success">Bạn đã đăng xuất thành công!</h3>';
            } else {
                redirect_to('users/login.php');
            }
        ?>
    </div>
<div class="span3">&nbsp;</div>
</div><!--.left-sidebar-->
<?php
    get_sidebar('b');
    get_footer();
?>