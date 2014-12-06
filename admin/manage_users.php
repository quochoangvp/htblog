<?php
    include_once('../includes/functions.php');
    get_header();
    get_nav();
    admin_access();
?>
<div id="content">
    <h2>Manage Users</h2>
    <?php
        $sort = isset($_GET['sort']) ? $_GET['sort'] : null;
        switch ($sort) {
            case 'name':
                $order_by = 'username';
                break;

            case 'email':
                $order_by = 'email';
                break;

            case 'level':
                $order_by = 'level';
                break;

            case 'time':
                $order_by = 'reg_time';
                break;

            default:
                $order_by = 'username';
                break;
        }

        $users = select_data("SELECT user_id, username, email, level, DATE_FORMAT(reg_time, '%b %d %Y') AS time FROM users ORDER BY $order_by ASC");
        $size = sizeof($users);

        if ($users) {
    ?>

    <table>
        <thead>
            <tr>
                <th><a href="?sort=name">Username</a></th>
                <th><a href="?sort=email">Email</th>
                <th><a href="?sort=level">Level</th>
                <th><a href="?sort=time">Registraton Time</th>
                <th>Edit/Delete</th>
            </tr>
        </thead>
        <tbody>
        <?php
            for ($i=0; $i < $size; $i++) {
                echo "
                    <tr>
                        <td>{$users[$i]['username']}</td>
                        <td>{$users[$i]['email']}</td>
                        <td>{$users[$i]['level']}</td>
                        <td>{$users[$i]['time']}</td>
                        <td><a class='edit' href=\"edit_user.php?uid={$users[$i]['user_id']}\">Edit</a>/<a class='delete' href=\"delete_user.php?uid={$users[$i]['user_id']}\">Delete</a></td>
                    </tr>
                ";
            }
        ?>
        </tbody>
    </table>
    <?php } else {
        echo '<p class="warning">Không có bài viết nào!</p>';
    } ?>
</div><!--end content-->
<?php
    get_footer();
?>