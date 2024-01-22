<h1>Your money accounts</h1>

    
<?php 
        $i = 0;
        foreach($accounts as $account){

            ?>
            <div class="acc_row">
                <div class="acc_ln"><?= ++$i?>.</div>
                <div class="acc_iban"><?= $account['iban']?></div>
                <div class="acc_amouont"><?= $account['amount']?></div>
                <div class="acc_curr"><?= $account['currency']?></div>
                <div class="acc_del"><a href="<?= URL ?>/user/deleteaccount/<?= $account['id']?>">Delete</a></div>
            </div>
            <?php
        }
    ?>

<h2>More actions</h2>
    <p><a href="<?= URL ?>/user/addaccount">Add new money account</a></p>