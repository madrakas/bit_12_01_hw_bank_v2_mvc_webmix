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
<p><a href="<?= URL ?>/users/edit/<?= $user->id ?>">Edit data</a> <a href="<?= URL ?>/users/editpw/<?= $user->id ?>">Change password</a> <a href="<?= URL ?>/users/delete/<?= $user->id ?>">Delete user</a></p></div>
</div>
<div class="details-head">Money accounts</div>
<h2>Under construction</h2>
<?php
// $i = 0;
//     foreach ($accounts as $account) {
//         echo '<div class="detail-row">';
//         echo '<div>' . ++$i . '.</div>';
//         echo '<div>' .  $account->iban . ' | ' . $account->amount . ' ' . $account.currency . ' | <a href="' . URL . '/accounts/delete/' .$account->id . '">Delete money account</a></div>';
//         echo '</div>';
//     }
?>
<h2>More actions</h2>
<p><a href="<?= URL ?>/accounts/create/<?= $user->id ?>">Add money account</a> | <a href="/logins/viewuser/<?= $user->id?>">Show logins log</a></p>
