<h1>User profile</h1>

<p><strong>First name: </strong><?= $user->firstname ?>.</p>
<p><strong>Last name: </strong><?= $user->lastname ?>.</p>
<p><strong>Personal identification number: </strong> <?= $user->ak ?>.</p>
<p><strong>Email address: </strong> <?= $user->email ?>.</p>

<h2>Change your data</h2>
    <p><a href="<?= URL ?>/user/editprofile">Edit personal information</a></p>
    <p><a href="<?= URL ?>/user/changepw">Change password</a></p>
    <p><a href="<?= URL ?>/user/delprofile">Close acount</a></p>