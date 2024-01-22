<h1>All transactions Log</h1>

<?php

echo '<div class="detail-headings">
<div class="time">When</div>
<div class="toIBAN">Sender IBAN</div>
<div class="toName">Sender name</div>
<div class="toIBAN">Recipient IBAN</div>
<div class="toName">Recipient name</div>
<div class="amount">Amount</div>
<div class="currency">Currency</div>
</div>';

foreach ($transactions as $transaction){

echo '<div class="detail-row">';
    echo '<div class="time">' . $transaction['time'] . '</div>';
    echo '<div class="toIBAN">' . $transaction['fromIBAN'] . '</div>';
    echo '<div class="toName">' . $transaction['fromName'] . '</div>';
    echo '<div class="toIBAN">' . $transaction['toIBAN'] . '</div>';
    echo '<div class="toName">' . $transaction['toName'] . '</div>';
    echo '<div class="amount">' . $transaction['amount'] . '</div>';
    echo '<div class="currency">' . $transaction['curr'] . '</div>';
echo '</div>';
}

?>

