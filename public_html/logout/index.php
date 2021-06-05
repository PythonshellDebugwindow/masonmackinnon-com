<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>User - MasonMackinnon.Com</title>
        <link rel="stylesheet" href="/styles/main.css" />
    </head>
    <body>
        <?php
            include_once("../../includes/header.php");
            session_start();
            unset($_SESSION['id']);
            unset($_SESSION['name']);
            session_destroy();
        ?>
        
        <section class="center-items">
            <div>
                <h1 class="center-text">Logged out successfully.</h1>
                <p class="center-text">Some pages might still appear as if you were logged in until your clear your browser's cache.</p>
            </div>
        </section>
        
        <?php include_once("../../includes/footer.php") ?>
    </body>
</html>
