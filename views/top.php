  
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
            <a href="">BIT Bank</a>
        </div>
        
        <ul class="user_menu">
            <li><a href="user/create">Sign Up</a></li>    
            <li><a href="#">Log In</a></li>    
        </ul>
    </header>
    <content>