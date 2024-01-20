<h1>Add funds</h1>


<form action="<?= URL ?>/accounts/updateamount" method='post'>

<p>Add money to account <?= $account->iban ?>?</p>
<p>Current acount balance: <?= $account->amount ?> <?= $account->currency ?></p>

    <input id="accountID" name="accountID" type="hidden" value="<?= $accountID ?>"></input>
    <label for="addAmount">Amount</label>
    <input id="addAmuount" name="addAmount" type="number"></input>
    <button type="submit">Add amount</button>
    <button type="reset">Reset Form</button>
</form> 