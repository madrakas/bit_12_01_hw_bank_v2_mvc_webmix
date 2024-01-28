<h1>User Details</h1>

<div class="acc_row">
<div>ID: <?=  $user->id ?></div>
</div>
<div class="details-head">Personal data</div>
<div class="detail-row">
<div><p><strong>First Name: </strong><?= $user->firstname ?></p>
<p><strong>Last Name: </strong><?= $user->lastname ?></p>
<p><strong>Email: </strong><?= $user->email ?></p>
<p><strong>Personal identificartion code: </strong><?= $user->ak ?></p>
<p><a href="<?= URL ?>/users/edit/<?= $user->id ?>">Edit data</a> <a href="<?= URL ?>/users/editpw/<?= $user->id ?>">Change password</a> 
<?php if($user->id !== 1) : ?>
<a href="<?= URL ?>/users/delete/<?= $user->id ?>">Delete user</a>
<?php endif ?>
</p></div>
</div>
<div class="details-head">Money accounts</div>
<?php
$i = 0;
    foreach ($accounts as $account) {
        echo '<div class="detail-row">';
        echo '<div>' . ++$i . '.</div>';
        echo '<div>' .  $account['iban'] . ' | ' . $account['amount'] . ' ' . $account['currency'] . ' | <a href="' . URL . '/accounts/addfunds/' .$account['id'] . '">Add funds</a> | <a href="' . URL . '/accounts/remfunds/' .$account['id'] . '">Withdraw funds</a> | <a href="' . URL . '/accounts/view/' . $account['id'] . '">View transactions</a> | <a href="' . URL . '/accounts/delete/' .$account['id'] . '">Delete money account</a></div>';
        echo '</div>';
    }
?>
<h2>More actions</h2>
<p><a href="<?= URL ?>/accounts/create/<?= $user->id ?>">Add money account</a> | <a href="/users/logins/<?= $user->id?>">Show logins log</a></p>
