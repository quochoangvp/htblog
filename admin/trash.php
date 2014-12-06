<?php
    include_once('../includes/functions.php');
    get_header();
    get_nav();
    admin_access();
?>
<div id="content">
    <h2>Trash</h2>
    <?php
        $sort = isset($_GET['sort']) ? $_GET['sort'] : null;
        switch ($sort) {
            case 'name':   $order_by = 'trash_name'; break;
            case 'time':   $order_by = 'time';       break;
            case 'author': $order_by = 'username';   break;
            case 'status': $order_by = 'status';     break;
            case 'type':   $order_by = 'type';       break;
            default:       $order_by = 'trash_name'; break;
        }
    ?>
    <?php

    $q = "SELECT t.trash_id, t.trash_name, t.content, t.status, t.type, u.username";
        $q .= " FROM trash AS t ";
        $q .= " JOIN users AS u ";
        $q .= " USING(user_id) ";
        $q .= " ORDER BY {$order_by} ASC";
    $posts = select_data($q);
    $size = sizeof($posts);

    if ($posts) { ?>
    <table>
        <thead>
            <tr>
                <th><a href="?sort=name">Pages</a></th>
                <th><a href="?sort=author">Posted by</th>
                <th>Content</th>
                <th><a href="?sort=status">Status</th>
                <th><a href="?sort=type">Type</th>
                <th>Restore/Delete</th>
            </tr>
        </thead>
        <tbody>
        <?php
            for ($i=0; $i < $size; $i++) {
                echo "
                    <tr>
                        <td>{$posts[$i]['trash_name']}</td>
                        <td>{$posts[$i]['username']}</td>
                        <td>{$posts[$i]['content']}</td>
                        <td>{$posts[$i]['status']}</td>
                        <td>{$posts[$i]['type']}</td>
                        <td><a class='restore' href=\"restore.php?id={$posts[$i]['trash_id']}\">Restore</a>/<a class='delete' href=\"delete.php?id={$posts[$i]['trash_id']}\">Delete</a></td>
                    </tr>
                ";
            }
        ?>
        </tbody>
    </table>
    <?php } else {
        echo '<p class="warning">Thùng rác trống!</p>';
    } ?>
</div><!--end content-->
<?php
    get_footer();
?>