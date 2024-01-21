<h1>Account transactions</h1>

<div class="acc_row">
<div><?= $accountID ?></div>
<div><?= $iban ?></div>
</div>

<?php

if (count($sent) > 0){
            echo '<div class="details-head">Sent:</div>';
            echo '<div class="detail-headings">
            <div class="time">When</div>
            <div class="toIBAN">Recipient IBAN</div>
            <div class="toName">Recipient name</div>
            <div class="amount">Amount</div>
            <div class="currency">Currency</div>
        </div>';
        }
        foreach ($sent as $tout){

            echo '<div class="detail-row">';
                echo '<div class="time">' . $tout['time'] . '</div>';
                echo '<div class="toIBAN">' . $tout['toIBAN'] . '</div>';
                echo '<div class="toName">' . $tout['toName'] . '</div>';
                echo '<div class="amount">' . $tout['amount'] . '</div>';
                echo '<div class="currency">' . $tout['curr'] . '</div>';
            echo '</div>';
        }
        if (count($received) > 0){
            echo '<div class="details-head">Received:</div>';
            echo '<div class="detail-headings">
            <div class="time">When</div>
            <div class="toIBAN">Sender IBAN</div>
            <div class="toName">Sender name</div>
            <div class="amount">Amount</div>
            <div class="currency">Currency</div>
            </div>';
        }
        foreach ($received as $tin){

            echo '<div class="detail-row">';
                echo '<div class="time">' . $tin['time'] . '</div>';
                echo '<div class="toIBAN">' . $tin['fromIBAN'] . '</div>';
                echo '<div class="toName">' . $tin['fromName'] . '</div>';
                echo '<div class="amount">' . $tin['amount'] . '</div>';
                echo '<div class="currency">' . $tin['curr'] . '</div>';
            echo '</div>';
        }
        ?>