<h1>Create new money account</h1>



<form action="<?= URL ?>/accounts/store" method='post'>
<p>Create new money account?</p>
    <input id="uid" name="uid" type="hidden" value="<?= $uid ?>"></input>
    <button type="submit">Create account</button>
</form> 