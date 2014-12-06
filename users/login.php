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
                    <form id="login" class="form-horizontal no-margin" action="" method="post">
                        <div class="control-group">
                            <label for="username" class="control-label">Username</label>
                            <div class="controls">
                                <input type="text" name="username" id="username" value="<?php if(isset($clean['username'])) {echo $clean['username'];} ?>" placeholder="Username" maxlength="20" tabindex="1" />
                                <span class="help-inline">
                                    <?php if(isset($errors) && in_array('username',$errors)) echo "<span class='warning'>Vui lòng nhập username.</span>";?>
                                </span>
                            </div>
                        </div>
                        <div class="control-group">
                            <label for="pass" class="control-label">Mật khẩu</label>
                            <div class="controls">
                                <input type="password" name="password" id="password" value="" placeholder="Password" maxlength="20" tabindex="2" />
                                <span class="help-inline">
                                    <?php if(isset($errors) && in_array('password',$errors)) echo "<span class='warning'>Vui lòng nhập mật khẩu.</span>";?>
                                </span>
                            </div>
                        </div>
                        <div class="controls"><a href="retrieve_password.php">Quên mật khẩu?</a></div>
                        <div class="form-actions no-margin">
                            <input class="btn btn-info pull-right" type="submit" name="submit" value="Đăng nhập" tabindex="3" />
                            <div class="clearfix"></div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div> <!-- .left-sidebar -->
<?php
    get_sidebar('b');
    get_footer();
?>