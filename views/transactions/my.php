<h1>Transaction history</h1>

<?php 
$i = 0;
foreach($accounts as $acc):?>
    <div class="acc_row"><div><?= ++$i ?></div><div><?= $acc['iban'] ?></div></div>
    
    <?php
        $accTransRcv = array_filter($transactions, fn($tr) => $tr['to'] === $acc['id']);
        $accTransSnt = array_filter($transactions, fn($tr) => $tr['from'] === $acc['id']);

        if (count($accTransRcv)>0):
    ?>
        <div class="details-head">Received:</div>
        <div class="detail-headings">
            <div class="time">When</div>
            <div class="toIBAN">Sender IBAN</div>
            <div class="toName">Sender name</div>
            <div class="amount">Amount</div>
            <div class="currency">Currency</div>
        </div>
    
    <?php 
            foreach ($accTransRcv as $tr): ?>
                <div class="detail-row">
                    <div class="time"><?= $tr['time'] ?></div>
                    <div class="toIBAN"><?= $tr['fromIBAN'] ?></div>
                    <div class="toName"><?= $tr['fromName'] ?></div>
                    <div class="amount"><?= $tr['amount'] ?></div>
                    <div class="currency">Eur</div>
                </div>
        <?php endforeach;
        endif;
        
        if (count($accTransSnt)>0):
            ?>
            <div class="details-head">Sent:</div>
            <div class="detail-headings">
                <div class="time">When</div>
                <div class="toIBAN">Recipient IBAN</div>
                <div class="toName">Recipient name</div>
                <div class="amount">Amount</div>
                <div class="currency">Currency</div>
            </div>
            
            <?php 
            foreach ($accTransSnt as $tr): ?>
                <div class="detail-row">
                    <div class="time"><?= $tr['time'] ?></div>
                    <div class="toIBAN"><?= $tr['toIBAN'] ?></div>
                    <div class="toName"><?= $tr['toName'] ?></div>
                    <div class="amount"><?= $tr['amount'] ?></div>
                    <div class="currency">Eur</div>
                </div>
            <?php endforeach;
        endif; 
endforeach; ?>


