<h1>Delete BIT bank user?</h1>
<form action="<?= URL ?>/users/destroy" method="post">
    <p>Are you sure you want to delete user <?= $user->firstname ?> <?= $user->lastname ?> (ID: <?= $user->id ?>)</p>
    <input name="userID" type="hidden" value="<?= $user->id ?>"></input>
    <button type="submit">Confirm deletion</button>
</form>