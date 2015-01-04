<?php
date_default_timezone_set('Asia/Ho_Chi_Minh');
define('ROOT_DIR', dirname(dirname(__FILE__)));

define('BASE_URL', 'http://localhost/htblog/');
define('ADMIN_URL', BASE_URL. 'admin/');
define('CSS_URL', BASE_URL. 'public/css/default/');
define('ADMIN_CSS_URL', BASE_URL. 'public/css/admin/');
define('JS_URL', BASE_URL. 'public/js/');

$con = mysqli_connect("localhost","root","","db_htblog");

// Check connection
if (mysqli_connect_errno()) {
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
}
// Change character set to utf8
mysqli_set_charset($con,"utf8");

function chmod_r($path, $fp = '0777') {
    $dir = new DirectoryIterator($path);
    foreach ($dir as $item) {
        chmod($item->getPathname(), $fp);
        if ($item->isDir() && !$item->isDot()) {
            chmod_r($item->getPathname());
        }
    }
}

/**
 * Đưa ra lỗi khi chạy câu lệnh truy vấn CSDL không thành công
 * @param  object $result
 * @param  string $query
 */
function confirm_query($result, $query) {
    global $con;
    if (!$result) {
        die("Could not connect to database!<hr /><br />\nQuery: {$query}<hr /><br />\nMysql Error: " . mysqli_error($con));
    }
}

/**
 * Chuyển hướng người dùng đến trang khác
 * @param  string $page đường dẫn
 */
function redirect_to($page = 'index.php') {
    $page = BASE_URL.$page;
    header("Location: $page");
    exit();
}

/**
 * Kỉêm qua quyền hạn của ngưòi dùng
 */
function admin_access() {
    if (!(isset($_SESSION['ulevel']) && ($_SESSION['ulevel'] == 'owner' || $_SESSION['ulevel'] == 'admin'))) {
        redirect_to();
    }
}

function is_logged() {
    if (empty($_SESSION['uid'])) {
        redirect_to();
    }
}

/**
 * Hiển thị tên thư mục của file đang truy cập
 * @param  string $file Địa chỉ file
 * @return string       Tên thư mục cha
 */
function dir_name($file) {
    $temp = dirname($file);
    return basename($temp, PHP_URL_PATH);
}

/**
 * Get content components
 */
function get_header() {
    include_once('header.php');
}
function get_nav() {
    include_once('nav.php');
}
function get_sidebar($name = 'a') {
    include_once('sidebar-'.$name.'.php');
}
function get_footer() {
    include_once('footer.php');
}

/**
 * Trả về file name của file hiện đang truy cập
 * @return string Tên file
 */
function current_file() {
    $path = basename($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    $filename = explode('?', $path);
    return $filename[0];
}

/**
 * Validate input fields
 */
function validate_username($username) {
    if (preg_match('/[\w]{2,20}/', $username)) {
        return true;
    } else {
        return false;
    }
}
function validate_email($email) {
    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
        return true;
    } else {
        return false;
    }
}
function validate_password($pass) {
    if (preg_match('/[\w!@#$%^&*.\-+]{6,20}/', $pass)) {
        return true;
    } else {
        return false;
    }
}
function validate_int($num) {
    if (filter_var($num, FILTER_VALIDATE_INT, array('min_range' =>1))) {
        return true;
    } else {
        return false;
    }
}

/**
 * Trả về số hàng của một bảng trong DB
 * @param  string $q Câu lệnh truy vấn sql
 * @return int    Số hàng của một hàng
 */
function num_rows($q) {
    global $con;
    $r = mysqli_query($con,$q);
    confirm_query($r,$q);
    return mysqli_num_rows($r);
}

/**
 * Kỉêm tra dữ liệu đã có trong CSDL chưa
 * @param  string $column Cột cần chọn trong bảng
 * @param  string $table  Bảng cần kỉêm tra
 * @param  string || int $where  đìêu kiện kỉêm tra
 * @return boolean   Nếu tồn tại trả về true
 */
function check_data_exist($column, $table, $where) {
    global $con;
    $q = "SELECT $column FROM $table WHERE $where";
    $r = mysqli_query($con,$q);
    confirm_query($r, $q);
    if (mysqli_num_rows($r) > 0) {
        return true;
    } else {
        return false;
    }
}

/**
 * Chèn dữ liệu vào CSDL
 * @param  string $table  Bảng cần chèn
 * @param  string $keys    Cột dữ liệu
 * @param  string $values Dữ liệu cần chèn
 * @return boolean         Trả về đúng hoặc sai
 */
function insert_data($table, $keys, $values) {
    global $con;
    $q = "INSERT INTO $table $keys VALUES $values";
    $r = mysqli_query($con,$q);
    confirm_query($r,$q);
    if (mysqli_affected_rows($con) > 0) {
        return true;
    } else {
        return false;
    }
}

/**
 * Chọn dữ liệu từ CSDL
 * @param  string $q Câu lệnh truy vấn CSDL
 * @return boolean   Trả về sai hoặc mảng có chứa dữ liệu
 */
function select_data($q) {
    global $con;
    $r = mysqli_query($con,$q);
    confirm_query($r, $q);
    $fetch_data = array();
    if (mysqli_num_rows($r) > 0) {
        while ($row = mysqli_fetch_array($r, MYSQLI_ASSOC)) {
            $row = array_map('stripslashes', $row);
            $fetch_data[] = $row;
        }
        return $fetch_data;
    } else {
        return false;
    }
}

/**
 * Cập nhật dữ liệu CSDL
 * @param  strign $table Tên bảng cần cập nhật
 * @param  string $set   Nội dung cập nhật
 * @param  string $where Địa chỉ cập nhật
 * @return boolean        Cập nhật thành công hay không
 */
function update_data($table, $set, $where) {
    global $con;
    $q = "UPDATE $table SET $set WHERE $where";
    $r = mysqli_query($con,$q);
    confirm_query($r,$q);
    if (mysqli_affected_rows($con) == 1) {
        return true;
    } else {
        return false;
    }
}

/**
 * Xóa dữ liệu trong CSDL
 * @param  string $table Bảng cần xóa dữ liệu
 * @param  string $where Nơi xóa
 * @return boolean        Xóa thành công hay không
 */
function delete_data($table, $where) {
    global $con;
    $q = "DELETE FROM $table WHERE $where LIMIT 1";
    $r = mysqli_query($con, $q);
    confirm_query($r, $q);
    if (mysqli_affected_rows($con) == 1) {
        return true;
    } else {
        return false;
    }
}


function select_cat_list($category=0,$level=0, $pid = 0) {
    global $con;
    $q = "SELECT cat_id, parent_id, cat_name FROM categories WHERE parent_id = $category";
    $r = mysqli_query($con, $q);
    confirm_query($r,$q);
    $level++;
    while ($row = mysqli_fetch_array($r, MYSQLI_ASSOC)) {
        echo '<option ';
        if ($row['cat_id'] == $pid) {
            echo 'selected="selected"';
        }
        echo ' value="'.$row['cat_id'] . '">' . str_repeat('-- ',$level) . $row['cat_name'].'</option>';
        select_cat_list($row['cat_id'],$level, $pid);
    }
}

function view_cat_list() {
    global $con;
    $q = "SELECT c.cat_id, c.cat_name, c.parent_id, DATE_FORMAT(c.time, '%b %d, %Y') AS time, u.username
        FROM categories AS c
        INNER JOIN users AS u
        USING(user_id)
        ORDER BY cat_id ASC";
    $r = mysqli_query($con, $q);
    confirm_query($r,$q);
    if (mysqli_num_rows($r) > 0) {
        $output = '
            <div class="row-fluid">
                <div class="span12">
                    <div class="widget">
                        <div class="widget-header">
                            <div class="title"><a id="dynamicTable" data-original-title="">Quản lý thể loại</a></div>
                            <span class="tools"><a class="fs1" aria-hidden="true" data-icon="" data-original-title=""></a></span>
                        </div>
                        <div class="widget-body">
                            <div id="dt_example" class="example_alt_pagination">
                                <div id="data-table_wrapper" class="dataTables_wrapper" role="grid">
                                    <table class="table table-condensed table-striped table-hover table-bordered pull-left dataTable" id="data-table" aria-describedby="data-table_info">
                                        <thead>
                                            <tr role="row" id="cats">
                                                <th style="width: 40px;">ID</th>
                                                <th style="width: 200px;">Tên thể loại</th>
                                                <th style="width: 200px;">Thể loại mẹ</th>
                                                <th style="width: 100px;">Số bài viết</th>
                                                <th style="width: 147px;">Người đăng</th>
                                                <th style="width: 147px;">Ngày đăng</th>
                                                <th style="width: 100px;">Tác động</th>
                                            </tr>
                                        </thead>
                                        <tbody role="alert" aria-live="polite" aria-relevant="all">
        ';
        while ($row = mysqli_fetch_array($r, MYSQLI_ASSOC)) {
            $output .= '<tr class="gradeA">';
            $output .= '<td>'.$row['cat_id'].'</td>
                        <td><a href="'.BASE_URL.'category.php?cid='.$row['cat_id'].'">'.$row['cat_name'].'</a></td>
                        <td>';
                            $parent = select_data("SELECT cat_name FROM categories WHERE cat_id = ".$row['parent_id']);
                            if (!empty($parent[0]['cat_name'])) {
                                $output .= $parent[0]['cat_name'];
                            } else {
                                $output .= 'ROOT';
                            }
                            $output .= '</td>
                        <td>';
                            $cpost = select_data("SELECT COUNT(post_id) AS pcount FROM posts WHERE cat_id = ".$row['cat_id']);
                            $output .= $cpost[0]['pcount'];
                        $output .= '</td>
                        <td>'.$row['username'].'</td>
                        <td>'.$row['time'].'</td>
                        <td>
                            <div class="btn-group">
                                <button data-toggle="dropdown" class="btn btn-mini dropdown-toggle">
                                    Tác động<span class="caret"></span>
                                </button>
                                <ul class="dropdown-menu">
                                    <li><a href="'.ADMIN_URL.'edit_category.php?cid='.$row['cat_id'].'" data-original-title="">Sửa</a></li>
                                    <li><a href="'.ADMIN_URL.'delete_category.php?cid='.$row['cat_id'].'" data-original-title="">Xóa</a></li>
                                </ul>
                            </div>
                        </td>
            ';
            $output .= '</tr>';
        }
        $output .= '
                                        </tbody>
                                    </table>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        ';
    } else {
        $output = false;
    }
    return $output;
}



function sidebar_cat_list($category=0,$level=0) {
    global $con;
    $q = "SELECT cat_id, parent_id, cat_name FROM categories WHERE parent_id = $category";
    $r = mysqli_query($con, $q);
    confirm_query($r,$q);
    if (mysqli_num_rows($r) > 0) {
        $level++;
        $output = '<ul>';
        while ($row = mysqli_fetch_array($r, MYSQLI_ASSOC)) {
            $output .= '<li><a href="' . BASE_URL . 'category.php?cid=' . $row['cat_id'] . '"><span class="label-bullet-blue"></span>' . $row['cat_name'] . '</a>';
            if (mysqli_num_rows($r) > 0) {
                $output .= sidebar_cat_list($row['cat_id'],$level);
            }
            $output .= '</li>';
        }
        $output .= '</ul>';
    } else {
        $output = false;
    }
    return $output;
}

function nav_cat_list($category=0,$level=0,$class='nav_cat_list') {
    global $con;
    $q = "SELECT cat_id, parent_id, cat_name FROM categories WHERE parent_id = $category";
    $r = mysqli_query($con, $q);
    confirm_query($r,$q);
    if (mysqli_num_rows($r) > 0) {
        $level++;
        $output = '<ul class="'.$class.'">';
        while ($row = mysqli_fetch_array($r, MYSQLI_ASSOC)) {
            $output .= '<li class="dropdown"><a data-toggle="dropdown" class="dropdown-toggle" href="'.BASE_URL.'category.php?cid='.$row['cat_id'].'"><span class="label-bullet-blue"></span>'.$row['cat_name'].'</a>';
            if (mysqli_num_rows($r) > 0) {
                $output .= nav_cat_list($row['cat_id'],$level, 'dropdown-menu');
            }
            $output .= '</li>';
        }
        $output .= '</ul>';
    } else {
        $output = false;
    }
    return $output;
}

function sidebar_recent_posts() {
    global $con;
    $q = "SELECT post_id, post_name FROM posts ORDER BY time DESC LIMIT 0,20";
    $r = mysqli_query($con, $q);
    confirm_query($r,$q);
    if(mysqli_num_rows($r) > 0) {
        $output = '<ul>';
        while ($row = mysqli_fetch_array($r, MYSQLI_ASSOC)) {
            $output .= '<li><a href="'.BASE_URL.'single.php?pid='.$row['post_id'].'"><span class="label-bullet-blue"></span>'.$row['post_name'].'</a>';
        }
        $output .= '</ul>';
    } else {
        $output = false;
    }
    return $output;
}

/**
 * Get excerpt from string
 *
 * @param String $str String to get an excerpt from
 * @param Integer $startPos Position int string to start excerpt from
 * @param Integer $maxLength Maximum length the excerpt may be
 * @return String excerpt
 */
function the_excerpt($str, $maxLength=400) {
    $str = html_entity_decode($str);
    $str = strip_tags($str);
    if(strlen($str) > $maxLength) {
        $excerpt   = substr($str, 0, $maxLength-3);
        $lastSpace = strrpos($excerpt, ' ');
        $excerpt   = substr($excerpt, 0, $lastSpace);
        $excerpt  .= '...';
    } else {
        $excerpt = $str.'...';
    }
    return $excerpt;
}

function pagination($url) {
    global $page, $num_pages;
    if($num_pages > 1) {
        echo '<div class="pagination no-margin"><ul>';
        if ($page != 1) {
            echo '<li><a href="&amp;page='.($page-1).'">Prev</a></li>';
        }
        for ($i=1; $i<=$num_pages; $i++) {
            if ($page == $i) {
                echo '<li class="active"><a class="disabled" href="">'.$i.'</a></li>';
            } else {
                echo '<li><a href="'.$url.'&amp;page='.$i.'">'.$i.'</a></li>';
            }
        }
        if ($page != $num_pages) {
            echo '<li><a href="'.$url.'&amp;page='.($page+1).'">Next</a></li>';
        }
        echo '</ul></div>';
    }
}

function the_content($content) {
    $content = html_entity_decode($content);
    //$content = str_replace('div','p',$content);

    $bdiv = substr_count($content, '<div');
    $ediv = substr_count($content, '</div>');
    $sub = abs($bdiv-$ediv);
    if ($sub==0) {
        echo $content;
    } else {
        echo $content = str_replace('div','p',$content);
    }
}

function getParent($cid) {
    do {
        $q = "SELECT cat_id, cat_name, parent_id FROM categories WHERE cat_id = {$cid} LIMIT 1";
        $cats = select_data($q);
        $cname = $cats[0]['cat_name'];

        $r[$cid] = $cname;
        $cid = $cats[0]['parent_id'];
    } while ($cid!=0);
    asort($r);
    return $r;
}

function breadcrumb($cid) {
    $parents = getParent($cid);
    echo "<li itemscope itemtype=\"http://data-vocabulary.org/Breadcrumb\">
                <span itemprop=\"title\">
                    <a href=\"".BASE_URL."\" itemprop=\"url\">Trang chủ</a>
                </span>
            </li>";
    foreach ($parents as $id => $name) {
        echo "
            <li itemscope itemtype=\"http://data-vocabulary.org/Breadcrumb\">
                <span itemprop=\"title\">
                    <a href=\"".BASE_URL."category.php?cid=".$id."\" itemprop=\"url\">".$name."</a>
                </span>
            </li>
        ";
    }
}

function setPostView($post_id) {
    $ip       = $_SERVER["REMOTE_ADDR"];
    $agent    = $_SERVER["HTTP_USER_AGENT"];
    $datetime = date("Y-m-d") . ' ' . date('H:i:s');
    if(!select_data("SELECT ip_address FROM visitors WHERE post_id = {$post_id}")) {
        insert_data('visitors', '(value, post_id, ip_address, user_agent, datetime)', "(1, $post_id, '$ip', '$agent', '$datetime')");
    } else {
        update_data('visitors', "value = (value+1), user_agent = '$agent', datetime = '$datetime'", "post_id = $post_id");
    }
}
function getPostView($post_id) {
    $postview = select_data("SELECT COUNT(ip_address) AS pv FROM visitors WHERE post_id = {$post_id}");
    return $postview[0]['pv'];
}
function getUserView($post_id) {
    $ip       = $_SERVER["REMOTE_ADDR"];
    $postview = select_data("SELECT value FROM visitors WHERE ip_address = '{$ip}' AND post_id = {$post_id}");
    return $postview[0]['value'];
}
function same_cat_posts($cid, $pid) {
    $posts = select_data("SELECT post_id, post_name FROM posts WHERE cat_id = {$cid} AND post_id != {$pid} ORDER BY rand() LIMIT 5");
    echo '
        <div class="span4">
            <div class="widget">
                <div class="widget-header">
                    <div class="title">Bài viết cùng thể loại<a id="lists" data-original-title=""></a></div>
                    <span class="tools"><a class="fs1" aria-hidden="true" data-icon="" data-original-title=""></a></span>
                </div>
                <div class="widget-body">
                    <div class="stylish-lists">
                        <ul>';
    for ($i=0; $i < sizeof($posts); $i++) {
        echo '<li><a href="'.BASE_URL.'single.php?pid='.$posts[$i]['post_id'].'">'.$posts[$i]['post_name'].'</a></li>';
    }
    echo '
                        </ul>
                    </div>
                </div>
            </div>
        </div>';
}
function related_posts($cid, $pid) {
    $posts = select_data("SELECT post_id, post_name FROM posts WHERE cat_id = {$cid} AND post_id != {$pid} ORDER BY rand() LIMIT 5");
    echo '
        <div class="span4">
            <div class="widget">
                <div class="widget-header">
                    <div class="title">Bài viết liên quan<a id="lists" data-original-title=""></a></div>
                    <span class="tools"><a class="fs1" aria-hidden="true" data-icon="" data-original-title=""></a></span>
                </div>
                <div class="widget-body">
                    <div class="stylish-lists">
                        <ul>';
    for ($i=0; $i < sizeof($posts); $i++) {
        echo '<li><a href="'.BASE_URL.'single.php?pid='.$posts[$i]['post_id'].'">'.$posts[$i]['post_name'].'</a></li>';
    }
    echo '
                        </ul>
                    </div>
                </div>
            </div>
        </div>';
}