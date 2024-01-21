<h1>Bit Bank users</h1>
<?php $i = 0;
foreach($users as $user): ?>
    <div class="acc_row">
        <div><?= ++$i ?>.</div>
        <div><?=$user['firstname'] ?></div>
        <div><?=$user['lastname'] ?></div>
        <div><?=$user['email'] ?></div>
        <div><?=$user['ak'] ?></div>
        <div><a href="<?= URL ?>/users/view/<?= $user['id'] ?>">Show details</a></div>
    </div>

<?php endforeach ?>

<h2>More actions</h2>
    <p><a href="<?= URL ?>/users/create">Add new user</a></p>
