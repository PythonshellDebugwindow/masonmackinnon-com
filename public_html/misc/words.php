<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Words | MasonMackinnon.Com</title>
        <link rel="stylesheet" href="/styles/main.css" />
        <link rel="stylesheet" href="/styles/container-grid.css" />
    </head>
    <body>
        <?php include_once("../../includes/header.php") ?>
        
        <section>
            <h1><abbr title="Keywords">Words</abbr></h1>
            <div class="words">
                <?php
                    function nyp()
                    {
                        echo '<h2>This error is Not Your Problem</h2>';
                        echo '<h3>Please <a href="/contact">contact me</a>.';
                    }
                    function fail()
                    {
                        nyp();
                        echo '<p>Error: `' . mysqli_error($dbc) . " " . mysqli_errno() . '`</p>';
                        mysqli_close($dbc);
                        die();
                    }
                    
                    require('../../connect_db.php');
                    $dbc = connect();
                    if(mysqli_connect_errno())
                    {
                        nyp();
                        echo '<p>Failed to connect: ' . mysqli_connect_error() . '</p>';
                        die();
                    }
                    
                    $r = mysqli_query($dbc, 'USE trivia');
                    if(!$r)
                        fail();
                    
                    $r = mysqli_query($dbc, 'SELECT word FROM words');
                    if(!$r)
                        fail();
                    
                    while($word = mysqli_fetch_array($r, MYSQLI_ASSOC))
                    {
                        $w = $word['word'];
                        echo "<div class='word' id='$w'>$w</div>";
                    }
                    
                    mysqli_close($dbc);
                ?>
            </div>
        </section>
        
        <style>
            .words
            {
                display: flex;
                flex-wrap: wrap;
            }
            .words .word
            {
                padding: 10px;
                font-family: monospace;
                background: #ddd;
            }
            .words .word:hover
            {
                background: #ebebeb;
            }
            .words .word.loaded
            {
                transition: background 1s;
            }
            .words .word.loaded:hover
            {
                transition: background 0s;
            }
        </style>
        
        <script>
            window.onload = function()
            {
                var words = document.getElementsByClassName("word");
                
                for(let i = 0; i < words.length; ++i)
                {
                    words[i].classList.add("loaded");
                }
            }
        </script>
        
        <?php include_once("../../includes/footer.php") ?>
    </body>
</html>
