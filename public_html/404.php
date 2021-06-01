<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Error 404: File Not Found</title>
        <link rel="stylesheet" href="/styles/main.css" />
    </head>
    <body>
        <?php include_once("/home/ymyri0wen43m/includes/header.php"); ?>
        
        <section class="center-items full-page">
            <div>
                <h1 class="center-text darkred bigger"><span class="red">Error <span class="spin">4</span><span class="spin">0</span><span class="spin">4</span></span>: File Not Found</h1>
                <p class="center-text big">If you think something should be here, please <a href="/contact/">contact me</a>. Otherwise, you can <a href="/">go home</a>.</p>
            </div>
        </section>
        
        <style>
            .spin
            {
                display: inline-block;
                position: relative;
                animation: spin 2s linear infinite;
            }
            .spin:hover
            {
                animation-play-state: paused;
            }
            @keyframes spin
            {
                0%
                {
                    transform: rotate(0deg);
                }
                100%
                {
                    transform: rotate(360deg);
                }
            }
        </style>
        
        <?php include_once("/home/ymyri0wen43m/includes/footer.php"); ?>
    </body>
</html>
