<h1>Change user password</h1>


<form action="<?= URL ?>/users/updatepw/<?= $userID ?>" method='post'>
<label for="pw1">Password</label>
    <input name="userID" type="hidden" value="<?= $userID?>"></input>
    <input id="pw1" name="pw1" type="password"></input>
    <label for="pw2">Repeat Password</label>
    <input id="pw2" name="pw2" type="password"></input>
    <button type="submit">Save changes</button>
    <button type="reset">Reset Form</button>
</form> 