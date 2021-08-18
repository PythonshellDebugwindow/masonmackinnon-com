<?php
    $title = 'Log Out';
    include_once("../../includes/header.php");
    @session_start();
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
