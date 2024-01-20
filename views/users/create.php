<h1>Create new Bit Bank account</h1>

<p>All fields are required.</p>
<form action="<?= URL ?>/users/store" method='post'>
    <label for="firstname">First name</label>
    <input id="firstname" name="firstname" type="text" value="<?= $firstname ?? '' ?>"></input>
    <label for="lastname">Last name</label>
    <input id="lastname" name="lastname" type="text" value="<?= $lastname ?? '' ?>"></input>
    <label for="ak">Personal identification number</label>
    <input id="ak" name="ak" type="text" value="<?= $ak ?? '' ?>"></input>
    <label for="email">Email address</label>
    <input id="email" name="email" type="text" value="<?= $email ?? '' ?>"></input>
    <label for="pw1">Password</label>
    <input id="pw1" name="pw1" type="password"></input>
    <label for="pw2">Repeat Password</label>
    <input id="pw2" name="pw2" type="password"></input>
    <button type="submit">Create account</button>
    <button type="reset">Reset Form</button>
</form> 