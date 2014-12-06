<?php
    include_once('../includes/functions.php');
    get_header();
    get_nav();
    admin_access();
?>
<div id="content">
    <h2>Manage Posts</h2>
    <?php
        $sort = isset($_GET['sort']) ? $_GET['sort'] : null;
        switch ($sort) {
            case 'name':
                $order_by = 'post_name';
                break;

            case 'time':
                $order_by = 'time';
                break;

            case 'author':
                $order_by = 'username';
                break;

            case 'cname':
                $order_by = 'cat_name';
                break;

            case 'status':
                $order_by = 'status';
                break;

            default:
                $order_by = 'post_name';
                break;
        }


        $q = "SELECT p.post_id, p.post_name, DATE_FORMAT(p.time, '%b %d, %Y') AS time, p.content, p.status, c.cat_id, c.cat_name, u.username";
            $q .= " FROM posts AS p ";
            $q .= " JOIN users AS u ";
            $q .= " USING(user_id) ";
            $q .= " JOIN categories AS c ";
            $q .= " USING(cat_id) ";
            $q .= " ORDER BY {$order_by} ASC";
        $posts = select_data($q);
        $size = sizeof($posts);

        if ($posts) {
    ?>

    <table>
        <thead>
            <tr>
                <th><a href="?sort=name">Pages</a></th>
                <th><a href="?sort=time">Posted on</th>
                <th><a href="?sort=author">Posted by</th>
                <th>Content</th>
                <th><a href="?sort=cname">Category</th>
                <th><a href="?sort=status">Status</th>
                <th>Edit/Delete</th>
            </tr>
        </thead>
        <tbody>
        <?php
            for ($i=0; $i < $size; $i++) {
                echo "
                    <tr>
                        <td>{$posts[$i]['post_name']}</td>
                        <td>{$posts[$i]['time']}</td>
                        <td>{$posts[$i]['username']}</td>
                        <td>{$posts[$i]['content']}</td>
                        <td><a href=\"".BASE_URL."/category.php?cid={$posts[$i]['cat_id']}\">{$posts[$i]['cat_name']}</a></td>
                        <td>{$posts[$i]['status']}</td>
                        <td><a class='edit' href=\"edit_post.php?pid={$posts[$i]['post_id']}\">Edit</a>/<a class='delete' href=\"trash_post.php?pid={$posts[$i]['post_id']}\">Delete</a></td>
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