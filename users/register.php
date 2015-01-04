<?php
    include_once('../includes/functions.php');
    get_header();
    get_nav();
?>
<?php
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $errors  = array();
        $trimmed = array_map('trim', $_POST);
        $clean   = array_map('strip_tags', $trimmed);

        // Validate username
        if (!empty($clean['username']) && validate_username($trimmed['username'])) {
            $username = mysqli_real_escape_string($con, $trimmed['username']);
        } else {
            $errors[] = 'username';
        }

        // Validate email
        if (!empty($clean['email']) && validate_email($clean['email'])) {
            $email = mysqli_real_escape_string($con, $clean['email']);
        } else {
            $errors[] = 'email';
        }

        // Validate password
        if (!empty($trimmed['password']) && validate_password($trimmed['password'])) {

            if (!empty($trimmed['repassword'])) {

                if ($trimmed['repassword'] == $trimmed['password']) {

                    $password = sha1(mysqli_real_escape_string($con, $trimmed['password']));

                } else {
                    $errors[] = 'notmatch';
                }
            } else {
                $errors[] = 'repassword';
            }
        } else {
            $errors[] = 'password';
        }

        // Insert database
        if (empty($errors)) {
            if (!check_data_exist('user_id', 'users', "username = '".$username."'")) {
                if (!check_data_exist('user_id', 'users', "email = '".$email."'")) {
                    // Username và email chưa tồn tại trong hệ thống, có thể đăng ký
                    if(insert_data('users', '(username, password, email, level, reg_time)',
                                            '("'.$username.'", "'.$password.'", "'.$email.'", "normal", NOW())')) {
                        $message = '<p class="success">Đăng ký thành công!</p>';
                        $_POST = $clean = $trimmed = array();
                    } else {
                        $message = '<p class="warning">Đăng ký thất bại!</p>';
                    }
                } else {
                    $message = '<p class="warning">Email đã tồn tại trong hệ thống</p>';
                }
            } else {
                $message = '<p class="warning">Người dùng đã tồn tại trong hệ thống</p>';
            }
        } else {
            $message = '<p class="warning">Hãy điền đầy đủ các trường bên dưới</p>';
        }
    }
?>
<div class="dashboard-wrapper">
<div class="left-sidebar">
    <div class="row-fluid">
        <div class="span12">
            <div class="widget">
                <div class="widget-header">
                    <div class="title">Đăng ký<span class="mini-title"></span></div>
                    <span class="tools">
                        <a class="fs1" aria-hidden="true" data-icon="" data-original-title=""></a>
                    </span>
                </div>
                <div class="widget-body">
                    <div class="span3">&nbsp;</div>
                    <div class="span6">
                        <div class="sign-in-container">
                            <?php if(!empty($message)) echo $message; ?>
                            <form action="register.php" class="login-wrapper" method="post">
                                <div class="header">
                                    <div class="row-fluid">
                                        <div class="span12">
                                            <h3>Đăng ký<img src="<?=ADMIN_CSS_URL?>img/logo1.png" alt="Logo" class="pull-right"></h3>
                                            <p>Nhập đầy đủ và thông tin một cách chính xác để đăng ký.</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="content">
                                    <div class="row-fluid">
                                        <div class="span12">
                                            <label for="username" class="">Username</label>
                                            <input type="text" name="username" maxlength="20" value="<?php if(isset($clean['username'])) echo $clean['username']; ?>" tabindex='1' />
                                            <span class="help-inline">
                                                <?php
                                                    if(isset($errors) && in_array('username', $errors)) {
                                                        echo '<span class="warning">Vui lòng nhập username</span>';
                                                    }
                                                ?>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="row-fluid">
                                        <div class="span12">
                                            <label for="email" class="control-label">Email</label>
                                            <input type="text" name="email" maxlength="100" value="<?php if(isset($clean['email'])) echo $clean['email']; ?>" tabindex='2' />
                                            <span class="help-inline">
                                                <?php
                                                    if(isset($errors) && in_array('email', $errors)) {
                                                        echo '<span class="warning">Vui lòng nhập email</span>';
                                                    }
                                                ?>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="row-fluid">
                                        <div class="span12">
                                            <label for="password" class="control-label">Mật khẩu</label>
                                            <input type="password" name="password" maxlength="20" value="<?php if(isset($trimmed['password'])) echo $trimmed['password']; ?>" tabindex='3' />
                                            <span class="help-inline">
                                                <?php
                                                    if(isset($errors) && in_array('password', $errors)) {
                                                        echo '<span class="warning">Vui lòng nhập mật khẩu</span>';
                                                    }
                                                ?>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="row-fluid">
                                        <div class="span12">
                                            <div class="control-group">
                                                <label for="repassword" class="control-label">Nhập lại mật khẩu</label>
                                                <input type="password" name="repassword" maxlength="20" value="<?php if(isset($trimmed['repassword'])) echo $trimmed['repassword']; ?>" tabindex='4' />
                                                <span class="help-inline">
                                                    <?php
                                                        if(isset($errors) && in_array('repassword', $errors)) {
                                                            echo '<span class="warning">Please enter your password again.</span>';
                                                        }
                                                        if(isset($errors) && in_array('notmatch', $errors)) {
                                                            echo '<span class="warning">Your confirmed password does not match.</span>';
                                                        }
                                                    ?>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="actions">
                                    <input class="btn btn-info pull-right" type="submit" name="submit" value="Đăng ký" tabindex="5" />
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