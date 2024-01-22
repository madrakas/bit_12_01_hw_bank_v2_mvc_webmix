<h1>Login activity log for all users</h1>
<?php
    foreach($logins as $login){
         
        echo '<div class="detail-row">';
            echo 'ID ' . $login['user'] . ', ' . $login['fname'] . ' ' . $login['lname'] . ':  ' . $login['time'] . ', ' . $login['status'];
        echo '</div>';
    }
?>

