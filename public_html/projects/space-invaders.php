<?php
    $title = "Web Pong | Projects";
    include_once("../../includes/header.php");
?>
<section>
    <h1>Space Invaders</h1>
    <noscript>Requires JavaScript.</noscript>
    <p id="status">Loading...</p>
    <div id="container">
        <canvas id="canvas" width="824" height="515">Your browser does not support the HTML5 Canvas element.</canvas>
    </div>
    
    <form action="savescore.php" method="POST">
        <input type="hidden" name="game" value="pong">
        <input type="hidden" name="score" value="0" id="score-input">
    </form>
</section>
<script src="space-invaders.js"></script>
<?php include_once("../../includes/footer.php") ?>
