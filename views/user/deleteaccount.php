<h1>Delete bank account?</h1>
<form action="<?= URL ?>/user/destroyaccount" method="post">
    <p>Are you sure you want to delete account <?= $account->iban ?> (ID: <?= $account->id ?>)</p>
    <input name="accountID" type="hidden" value="<?= $account->id ?>"></input>
    <button type="submit">Confirm deletion</button>
</form>