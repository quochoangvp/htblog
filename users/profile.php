<?php include_once('../includes/functions.php');
    $title = 'Hồ sơ';
    get_header();
    get_nav();

    is_logged();
    $user_id = $_SESSION['uid'];
    $users = select_data("SELECT username, email, fullname, avatar, address, level, about, reg_time FROM users WHERE user_id = {$user_id} LIMIT 1");
?>
<div class="dashboard-wrapper">
<div class="left-sidebar">
    <div class="row-fluid">
        <div class="span12">
            <div class="widget">
                <div class="widget-header">
                    <div class="title">Hồ sơ<span class="mini-title"></span></div>
                    <span class="tools">
                        <a class="fs1" aria-hidden="true" data-icon="" data-original-title=""></a>
                    </span>
                </div>
                <div id="message-ajax"></div>
                <div class="widget-body">
                    <div class="container-fluid">
                        <div class="row-fluid">
                            <div class="span3">
                                <div class="thumbnail">
                                    <div id="preview">
                                        <img src="<?=BASE_URL?>public/images/uploads/<?=empty($users[0]['avatar']) ? 'profile.png' : $users[0]['avatar'];?>" alt="user photo" />
                                    </div>
                                    <div title="Nhấn vào ảnh để thay ảnh đại diện" class="photoimg">
                                        <form id="imageform" method="post" enctype="multipart/form-data" action="ajaximage.php">
                                            <input type="file" name="photoimg" id="photoimg" />
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <div class="span9">
                                <form class="form-horizontal" id="enable">
                                    <h5>Thông tin đăng nhập</h5>
                                    <hr>
                                    <div class="control-group">
                                        <label class="control-label">Tên truy cập</label>
                                        <div class="controls">
                                            <a id="username" href="" data-original-title="Bạn không được phép sửa tên truy cập" class="inputText editable editable-click">
                                                <?=$users[0]['username']?>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <label class="control-label">Địa chỉ Email</label>
                                        <div class="controls">
                                            <a id="email" href="" data-type="email" data-pk="1" data-url="<?=BASE_URL?>users/user_edit_data.php" data-original-title="Nhấn vào đây để sửa email" class="inputText editable editable-click">
                                                <?=$users[0]['email']?>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <label class="control-label">Mật khẩu</label>
                                        <div class="controls">
                                            <a id="password" href="" data-type="password" data-pk="1" data-url="<?=BASE_URL?>users/user_edit_data.php" data-original-title="Nhấn vào đây để sửa mật khẩu" class="inputText editable editable-click">
                                                ******
                                            </a>
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <label class="control-label">Xác nhận mật khẩu</label>
                                        <div class="controls">
                                            <a id="repassword" href="" data-type="password" data-pk="1" data-url="<?=BASE_URL?>users/user_edit_data.php" data-original-title="Nhấn vào đây nhập lại mật khẩu" class="inputText editable editable-click">
                                                ******
                                            </a>
                                        </div>
                                    </div>
                                    <br>
                                    <h5>Thông tin cá nhân</h5>
                                    <hr>
                                    <div class="control-group">
                                        <label class="control-label">Họ tên đầy đủ</label>
                                        <div class="controls">
                                            <a id="fullname" href="" data-type="text" data-pk="1" data-url="<?=BASE_URL?>users/user_edit_data.php" data-original-title="Nhấn vào đây để sửa họ tên" class="inputText editable editable-click">
                                                <?=$users[0]['fullname']?>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <label class="control-label">Địa chỉ</label>
                                        <div class="controls">
                                            <a id="address" href="" data-type="text" data-pk="1" data-url="<?=BASE_URL?>users/user_edit_data.php" data-original-title="Nhấn vào đây để sửa địa chỉ" class="inputText editable editable-click">
                                                <?=$users[0]['address']?>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <label class="control-label">Ghi chú</label>
                                        <div class="controls">
                                            <a id="about" href="" data-type="textarea" data-pk="1" data-url="<?=BASE_URL?>users/user_edit_data.php" data-original-title="Nhấn vào đây để viết đôi lời về bản thân" class="inputText editable editable-click">
                                                <?=$users[0]['about']?>
                                            </a>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                 </div>
            </div>
        </div>
    </div>
</div><!--.left-sidebar-->
<?php
    get_sidebar('b');
    get_footer();
?>