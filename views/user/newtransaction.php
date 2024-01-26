<h1>New transaction</h1>

<form action="<?= URL ?>/user/storetransaction" method="post">
    <label for="sender">Sender</label>
    <p id="sender"><?= $sender ?></p>
    <label for="acc">Sender account</label>
    <select name="acc" id="acc">
    
    <?php 
    foreach($accounts as $account) {
        echo '<option value="' . $account['id'] . '">' . $account['iban'] . ' (' . $account['amount'] . ' ' . $account['currency'] . ')';
    }
    ?>    
    
    </select>
    <label>Recipient account</label>
    <input id="riban" name="riban"></input>
    <label for="rname">Recipient name</label>
    <input id="rname" name="rname"></input>
    <label for="amount">Amount</label>
    <input id="amount" name="amount"></input>

    <button type="submit">Transfer money</button>
    <button type="reset">Reset form</button>
</form>