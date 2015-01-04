<?php
    include_once('../includes/functions.php');
    $title = 'Đăng nhập';
    get_header();
    get_nav();
?>
<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $errors  = array();
    $trimmed = array_map('trim', $_POST);
    $clean   = array_map('strip_tags', $trimmed);

    // Validate username
    if (!empty($clean['username']) && validate_username($clean['username'])) {
        $username = mysqli_real_escape_string($con,$clean['username']);
    } else {
        $errors[] = 'username';
    }

    // Validate password
    if (!empty($trimmed['password']) && validate_password($trimmed['password'])) {
        $password = sha1(mysqli_real_escape_string($con, $trimmed['password']));
    } else {
        $errors[] = 'password';
    }

    // Truy vấn CSDL
    if (empty($errors)) {
        if ($users = select_data("SELECT user_id, username, level FROM users WHERE username = '{$username}' AND password = '{$password}'")) {

            $_SESSION['uid'] = $users[0]['user_id'];
            $_SESSION['uname'] = $users[0]['username'];
            $_SESSION['ulevel'] = $users[0]['level'];

            $levels = array('owner', 'admin', 'mod');
            if (in_array($users[0]['level'], $levels)) {
                redirect_to('admin/admin.php');
            } else {
                redirect_to();
            }
        } else {
            $message = '<p class="warning">Không đúng username hoặc mật khẩu</p>';
        }
    } else {
        $message = '<p class="warning">Hãy điền đủ thông tin để đăng nhập</p>';
    }

}
?>
<div class="dashboard-wrapper">
<div class="left-sidebar">
    <div class="row-fluid">
        <div class="span12">
            <div class="widget">
                <div class="widget-header">
                    <div class="title">Đăng nhập<span class="mini-title"></span></div>
                    <span class="tools">
                        <a class="fs1" aria-hidden="true" data-icon="" data-original-title=""></a>
                    </span>
                </div>
                <div class="widget-body">
                <?php if(!empty($message)) echo $message; ?>
                    <div class="span3">&nbsp;</div>
                    <div class="span6">
                        <div class="sign-in-container">
                            <form action="" class="login-wrapper" method="post">
                                <div class="header">
                                    <div class="row-fluid">
                                        <div class="span12">
                                            <h3>Đăng nhập<img src="<?=ADMIN_CSS_URL?>img/logo1.png" alt="Logo" class="pull-right"></h3>
                                            <p>Nhập đầy đủ và thông tin một cách chính xác để đăng nhập.</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="content">
                                    <div class="row-fluid">
                                        <div class="span12">
                                            <input type="text" name="username" id="username" value="<?php if(isset($clean['username'])) {echo $clean['username'];} ?>" placeholder="Username" maxlength="20" tabindex="1" />
                                            <span class="help-inline">
                                                <?php if(isset($errors) && in_array('username',$errors)) echo "<span class='warning'>Vui lòng nhập username.</span>";?>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="row-fluid">
                                        <div class="span12">
                                            <input type="password" name="password" id="password" value="" placeholder="Password" maxlength="20" tabindex="2" />
                                            <span class="help-inline">
                                                <?php if(isset($errors) && in_array('password',$errors)) echo "<span class='warning'>Vui lòng nhập mật khẩu.</span>";?>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="actions">
                                    <input class="btn btn-danger" name="Đăng nhập" type="submit" value="Login">
                                    <a class="link" href="retrieve_password.php" data-original-title="">Quên mật khẩu?</a>
                                    <div class="clearfix"></div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="span3">&nbsp;</div>
                    <div class="clearfix"></div>
                </div>
            </div>
        </div>
    </div>
</div> <!-- .left-sidebar -->
<?php
    get_sidebar('b');
    get_footer();
?>