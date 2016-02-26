<h3>User Index</h3>
<hr>
<table>
    <tr>
        <th>ID</th>
        <th>NAME</th>
    </tr>
    <?php foreach($users as $user): ?>
            <tr>
                <td><a href=<?php echo "/$user->id" ?>><?php echo $user->id ?></a></td>
                <td><?php echo $user->name ?></td>
            </tr>
    <?php endforeach; ?>
</table>
<br>
<a href=<?php echo "/new" ?>>Add User</a>
