
<h1>Edit your profile</h1>
<form action="<?= URL ?>/user/updateprofile" method='post'>
    
    <label for="firstname">First name</label>
    <input id="firstname" name="firstname" type="text" value="<?= $user->firstname ?>"></input>
    <label for="lastname">Last name</label>
    <input id="lastname" name="lastname" type="text" value="<?= $user->lastname ?>"></input>
    <label for="ak">Personal identification number</label>
    <input id="ak" name="ak" type="text" value="<?= $user->ak ?>"></input>
    <label for="email">Email address</label>
    <input id="email" name="email" type="text" value="<?= $user->email ?>"></input>
        <button type="submit">Save changes</button>
    <button type="reset">Reset Form</button>
</form> </content>
