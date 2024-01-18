  
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?= URL ?>/main.css?v=<?= time() ?>">
    <title><?= $title ?? 'BIT bank' ?></title>
</head>
<body>
    <!-- <header class=" ?$headerClass?"> -->
    <header class="">
        <div class="logo">
            <a href="index.php">BIT Bank</a>
        </div>
        
        <ul class="user_menu">
        <?php if (isset($_SESSION['login']) && ($_SESSION['login'] === '1' )){ ?>
            <li><form action="http://localhost/bank/process/session/destroy.php"" method='post'><button type="submit">Log Out</button></form></li>
        <?php } else { ?>
            <li><a href="#">Sign Up</a></li>    
            <li><a href="#">Log In</a></li>    
        <?php } ?>
            
        </ul>
    </header>