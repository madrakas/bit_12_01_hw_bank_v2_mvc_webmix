<h1>Withdraw funds</h1>


<form action="<?= URL ?>/accounts/updateamount" method='post'>

<p>Withdraw money from account <?= $account->iban ?>?</p>
<p>Current acount balance: <?= $account->amount ?> <?= $account->currency ?></p>

    <input id="accountID" name="accountID" type="hidden" value="<?= $accountID ?>"></input>
    <label for="remAmount">Amount</label>
    <input id="remAmuount" name="remAmount" type="number"></input>
    <button type="submit">Withdraw amount</button>
    <button type="reset">Reset Form</button>
</form> 