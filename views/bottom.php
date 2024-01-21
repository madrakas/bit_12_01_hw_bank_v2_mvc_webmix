</content>
<?php 
    $footerClass = '';
    if ($auth === 1 ){
        $footerClass = 'admin';
    } elseif($auth > 1) {
        $footerClass = 'logedin';
    }
?>

    <footer class="<?= $footerClass ?>">
        <div class="logo">
            <a href="">BIT Bank</a>
        </div>
    </footer>
</body>
</html>