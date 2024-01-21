<h1>View <?= $user->firstname ?> <?= $user->lastname?> (ID: <?= $user->id?>) login logs</h1>

<?php 
     foreach($logins as $login){
        echo '<div class="detail-row">';
        echo 'ID ' . $user ->id . ', ' . $user->firstname . ' ' . $user->lastname . ':  ' . $login['time'] . ', ' . $login['status'];
        echo '</div>';
    }
?>