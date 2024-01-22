  
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?= URL ?>/main.css?v=<?= time() ?>">
    <title><?= $title ?? 'BIT bank' ?></title>
</head>
<body>
    <?php 
    $headerClass = '';
    if ($auth === 1  ){
        $headerClass = 'admin';
    } elseif($auth > 1) {
        $headerClass = 'logedin';
    }
    ?>
    <header class="<?= $headerClass ?>">
        <div class="logo">
            <a href="<?= URL ?>">BIT Bank</a>
        </div>
        
        <ul class="user_menu">
            <?php if ($auth){ ?>
                <li><form action="<?= URL ?>/logout" method='post'><button type="submit">Log Out</button></form></li>
            <?php } else { ?>
                <li><a href="<?= URL ?>/users/create">Sign Up</a></li>    
                <li><a href="<?= URL ?>/login">Log In</a></li>    
            <?php } ?>
        </ul>
    </header>
    <?php require ROOT. 'views/message.php' ?>

    <?php 
    if ($auth){
        $contentClass='logedin';

    }else{
        $contentClass='';
    }
    

    if ($auth){
    ?>
    <div class="left-menu">
        <ul>
            <?php if ($auth === 1) { ?>
                <strong>Admin menu</strong>
                <hr/>
                <li><a href="<?= URL ?>/users">Show users</a></li>    
                <li><a href="<?= URL ?>/transactions/all">View transactions</a></li>    
                <li><a href="<?= URL ?>/logins/all">View logins</a></li>    
                <strong>User menu</strong><hr/>
                <?php } ?>
                <li><a href="<?= URL ?>/user/accounts">My money accounts</a></li>
                <li><a href="#">Make a transaction</a></li>
                <li><a href="#">Transactions history</a></li>
                <li><a href="#">User data</a></li>
        </ul>
    </div>
    <?php }?>
   
    <content class="<?= $contentClass ?>">
    

    