<h1>Change your password</h1>



<form action="<?= URL ?>/user/updatepw" method='post'>
    <label for="pw1">Password</label>
    <input id="pw1" name="pw1" type="password"></input>
    <label for="pw2">Repeat Password</label>
    <input id="pw2" name="pw2" type="password"></input>
        <button type="submit">Save password</button>
    <button type="reset">Reset Form</button>
</form>