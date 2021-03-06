<?php
ini_set('session.use_only_cookies', true);
ob_start();
session_start();
?>
<!DOCTYPE html>
<!--[if lt IE 7]>
<html class="lt-ie9 lt-ie8 lt-ie7" lang="en">
<![endif]-->
<!--[if IE 7]>
<html class="lt-ie9 lt-ie8" lang="en">
<![endif]-->
<!--[if IE 8]>
<html class="lt-ie9" lang="en">
<![endif]-->
<!--[if gt IE 8]>
<!-->
<html lang="en">
<!--
<![endif]-->
<head>
    <meta charset="utf-8">
    <title><?php echo (isset($GLOBALS['title'])) ? $GLOBALS['title'] : "Trang chủ"; ?> &raquo; HTBlog</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link href="<?=ADMIN_CSS_URL?>icomoon/style.css" rel="stylesheet">
    <link href="<?=ADMIN_CSS_URL?>css/jquery-ui.css" rel="stylesheet">
    <!--[if lte IE 7]>
    <script src="<?=ADMIN_CSS_URL?>css/icomoon-font/lte-ie7.js">
    </script>
    <![endif]-->

    <link href="<?=ADMIN_CSS_URL?>css/main.css" rel="stylesheet"> <!-- Important. For Theming change primary-color variable in main.css  -->
    <?php if (current_file() == 'profile.php'): ?>
        <link href="<?=ADMIN_CSS_URL?>css/bootstrap-editable.css" rel="stylesheet"/>
    <?php endif ?>

    <script type="text/javascript" src="<?=JS_URL?>jquery.min.js"></script>
    <script type="text/javascript" src="<?=JS_URL?>jquery-ui.min.js"></script>
    <script src="<?=ADMIN_CSS_URL?>js/bootstrap.js"></script>
    <script type="text/javascript" src="<?=JS_URL?>tinymce/tinymce.min.js"></script>
    <script src="<?=ADMIN_CSS_URL?>js/tiny-scrollbar.js"></script>
    <?php if (current_file() == 'profile.php' || current_file() == 'edit_post.php' || current_file() == 'add_posts.php'): ?>
        <script type="text/javascript" src="<?=JS_URL?>jquery.form.js"></script>
        <script type="text/javascript" src="<?=JS_URL?>js-tags.js"></script>
    <?php endif ?>
    <?php if (current_file() == 'profile.php'): ?>
    <script type="text/javascript" src="<?=JS_URL?>edit-profile.js"></script>
    <?php endif ?>
    <?php if (current_file() == 'edit_post.php' || current_file() == 'add_posts.php'): ?>
    <script type="text/javascript" src="<?=JS_URL?>post_thumbnail.js"></script>
    <?php endif ?>

    <?php $arr = array('view_categories.php', 'view_posts.php', 'manage_users.php', 'trash.php');
    if(in_array(current_file(), $arr)) { ?>
    <script src="<?=ADMIN_CSS_URL?>js/jquery.dataTables.js"></script>
    <?php } ?>

    <?php if (current_file() == 'profile.php'): ?>
    <script src="<?=ADMIN_CSS_URL?>js/bootstrap-editable.min.js"></script>
    <?php endif ?>

    <?php $arr = array('view_categories.php', 'view_posts.php', 'manage_users.php', 'trash.php');
    if(in_array(current_file(), $arr)) { ?>
    <script type="text/javascript">
        $(document).ready(function() {
            $('#data-table').dataTable({
                "order": [[ 0, "asc" ]],
                "sPaginationType": "full_numbers"
            });
        } );
    </script>
    <?php } ?>

    <script type="text/javascript">
    $(document).ready(function() {
        //TinyMCE
        tinymce.init({
            theme : 'modern',
            skin : 'lightgray',
            mode : "specific_textareas",
            editor_selector : "mceEditor"
        });

        //Tooltip
        $('a').tooltip('hide');
        $('i').tooltip('hide');

        //Tiny Scrollbar
        $('#scrollbar').tinyscrollbar();
        $('#scrollbar-one').tinyscrollbar();
        $('#scrollbar-two').tinyscrollbar();
        $('#scrollbar-three').tinyscrollbar();
    });
</script>
</head>
<body>
    <header>
        <a href="<?=BASE_URL?>index.php" class="logo"><img src="<?=ADMIN_CSS_URL?>img/logo.png" alt="logo" /></a>
        <div class="btn-group">
            <?php if (isset($_SESSION['uname'])) { ?>
            <button class="btn btn-primary"><?php echo $_SESSION['uname']; ?></button>
            <button data-toggle="dropdown" class="btn btn-primary dropdown-toggle">
                <span class="caret"></span>
            </button>
            <ul class="dropdown-menu pull-right">
                <li><a href="<?=BASE_URL?>users/profile.php">Hồ sơ</a></li>
                <li><a href="<?=BASE_URL?>users/account_settings.php">Cài đặt tài khoản</a></li>
                <li><a href="<?=BASE_URL?>users/logout.php">Đăng xuất</a></li>
            </ul>
            <?php } else { ?>
            <a class="btn btn-primary" data-original-title="" href="<?=BASE_URL?>users/login.php">Đăng nhập</a>
            <a class="btn" data-original-title="" href="<?=BASE_URL?>users/register.php">Đăng ký</a>
            <?php } ?>
        </div>
    </header>
    <div class="container-fluid">
        <div class="dashboard-container">