<h1><?php echo $user->name ?></h1>
<hr>
<p>User ID is: <?php echo $user->id ?></p>
<a href=<?php echo '/'.$user->id.'/edit'; ?>>Edit</a>
<p></p>
<form action='/<?php echo $user->id ?>?method=delete' method='post'>
    <input type="submit" value="Delete">
</form>