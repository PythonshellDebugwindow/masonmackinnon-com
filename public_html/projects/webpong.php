<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Web Pong | Projects | MasonMackinnon.Com</title>
        <link rel="stylesheet" href="/styles/main.css" />
    </head>
    <body>
        <?php include_once("../../includes/header.php") ?>
        
        <section>
            <h1>Web Pong</h1>
            <noscript>Requires JavaScript.</noscript>
            <div id="game-container">
                <div class="button-container">
                    <button id="button-start">Start Game</button>
                </div>
                <div class="game" id="game">
                    <div class="paddles">
                        <div class="paddle"></div>
                        <div class="paddle"></div>
                    </div>
                    <div id="ball"></div>
                </div>
            </div>
            <div class="display">
                <h2 class="left">Score: <span class="score">0</span></h2>
                <h2 class="right">Score: <span class="score">0</span></h2>
            </div>
            <div class="display instructions" style="clear: both">
                <div class="left">
                    <h2>Player 1 Instructions:</h2>
                    <ul>
                        <li><kbd>W</kbd> to go up</li>
                        <li><kbd>S</kbd> to go down</li>
                    </ul>
                </div>
                <div class="right">
                    <h2>Player 2 Instructions:</h2>
                    <ul>
                        <li><kbd>P</kbd> to go up</li>
                        <li><kbd>;</kbd> (beside <kbd>L</kbd>) to go down</li>
                    </ul>
                </div>
            </div>
        </section>
        
        <style>
            section
            {
                margin-bottom: 100px;
            }
            #game-container
            {
                width: 100%;
                height: 600px;
                background: #ccc;
                position: relative;
            }
            .button-container
            {
                width: 100%;
                height: 100%;
                display: flex;
                align-items: center;
                justify-content: center;
            }
            .button-container button
            {
                padding: 10px;
                font-size: 1.8em;
                background: #ddd;
                border: 1px solid #000;
                border-radius: 5px;
            }
            .button-container button:hover
            {
                background: #bbb;
            }
            .game
            {
                display: none;
                width: 100%;
                height: 100%;
                position: absolute;
                top: 0;
                overflow: hidden;
            }
            .game .paddles
            {
                width: 100%;
                height: 100%;
                display: flex;
                justify-content: space-between;
                -webkit-box-sizing: border-box;
                -moz-box-sizing: border-box;
                box-sizing: border-box;
            }
            .game .paddle
            {
                width: 100px;
                height: 200px;
                background: #eee;
            }
            .game #ball
            {
                position: absolute;
                top: 0;
                left: 0;
                width: 70px;
                height: 70px;
                background: #f00;
                border-radius: 35px;
            }
            
            .display h2
            {
                font-size: 1.8em;
            }
            .instructions ul li
            {
                font-size: 1.4em;
                padding: 5px;
            }
            
            .left
            {
                float: left;
            }
            .right
            {
                float: right;
            }
            
            kbd
            {
                font-family: monospace;
                padding: 5px;
                background: #ddd;
                border-radius: 5px;
                border: 1px solid rgba(0,0,0,0.2);
            }
        </style>
        
        <script>
            const gameContainer = document.getElementById("game-container");
            const game = document.getElementById("game");
            const buttonStart = document.getElementById("button-start");
            const GAME_WIDTH = gameContainer.clientWidth;
            const GAME_HEIGHT = gameContainer.clientHeight;
            var gameInterval = -1;
            
            const paddles = document.getElementsByClassName("paddle");
            const PADDLE_MIN_Y = 0;
            const PADDLE_MAX_Y = GAME_HEIGHT - paddles[0].clientHeight;
            const paddleWidth = 100;
            const paddleHeight = 200;
            var paddleYs = [0, 0];
            var paddleSpeeds = [0, 0];
            var paddleSpeed = 15;
            
            const ball = document.getElementById("ball");
            const BALL_SIZE = 70;
            var ballSpeedX = 25;
            var ballSpeedY = 25;
            var ballX = 100;
            var ballY = 0;
            
            const scoreDisplays = document.getElementsByClassName("score");
            var scores = [0, 0];
            
            const TRANSFORM_PROPERTY = (function() {
                var testEl = document.createElement('div');
                if(testEl.style.transform == null)
                    var vendors = ["Webkit", "Moz", "ms", "o", "webkit"];
                    for(var vendor in vendors)
                        if(testEl.style[vendors[vendor] + "Transform"] !== undefined)
                            return vendors[vendor] + "Transform";
                return "transform";
            })();
            
            function moveNthPaddle(n, scale)
            {
                n -= 1;
                paddleYs[n] += paddleSpeed * scale;
                if(paddleYs[n] < PADDLE_MIN_Y)
                    paddleYs[n] = 0;
                //-10 makes it look nicer (doesn't stop short of the bottom)
                else if(paddleYs[n] + paddleHeight -10 > PADDLE_MAX_Y)
                    paddleYs[n] -= paddleSpeed * scale;
                else
                    paddles[n].style.transform = "translateY(" + paddleYs[n] + "px)";
            }
            
            function ballIsTouchingNthPaddle(n)
            {
                let touchingX = n === 1 ?
                                ballX < paddleWidth
                              : (n === 2 ?
                                 ballX + BALL_SIZE > GAME_WIDTH - paddleWidth
                               : false);
                let touchingY = ballY >= paddleYs[n - 1]
                             && ballY <= paddleYs[n - 1] + paddleWidth;
                return touchingX && touchingY;
            }
            
            function incrNthScoreAndUpdateSpeed(n)
            {
                ++scores[n];
                ballSpeedX += 2;
                ballSpeedY += 2;
            }
            
            function moveBall(xScale, yScale)
            {
                //console.log("MOVIGN")
                ballX += ballSpeedX * xScale;
                if(ballX < 0)
                {
                    ballX = 0;
                    ballSpeedX *= -1;
                    if(Math.random() < 0.5) ballSpeedY *= -1;
                }
                else if(ballX > GAME_WIDTH - BALL_SIZE)
                {
                    ballX = GAME_WIDTH - BALL_SIZE;
                    ballSpeedX *= -1;
                    if(Math.random() < 0.5) ballSpeedY *= -1;
                }
                else if(ballIsTouchingNthPaddle(1))
                {
                    incrNthScoreAndUpdateSpeed(0);
                    ballX = paddleWidth;
                    ballSpeedX *= -1;
                    if(Math.random() < 0.5) ballSpeedY *= -1;
                }
                else if(ballIsTouchingNthPaddle(2))
                {
                    incrNthScoreAndUpdateSpeed(1);
                    ballX = GAME_WIDTH - paddleWidth - BALL_SIZE;
                    ballSpeedX *= -1;
                    if(Math.random() < 0.5) ballSpeedY *= -1;
                }
                
                ballY += ballSpeedY * yScale;
                if(ballY < 0)
                {
                    ballY = 0;
                    ballSpeedY *= -1;
                }
                else if(ballY > GAME_HEIGHT - BALL_SIZE)
                {
                    ballY = GAME_HEIGHT - BALL_SIZE;
                    ballSpeedY *= -1;
                }
                
                let newTransform = "translate(" + ballX + "px," + ballY + "px)";
                ball.style[TRANSFORM_PROPERTY] = newTransform;
            }
            
            function displayScores()
            {
                scoreDisplays[0].innerHTML = scores[0];
                scoreDisplays[1].innerHTML = scores[1];
            }
            function addEvent(element, eventName, callback)
            {
                if(element.addEventListener)
                    element.addEventListener(eventName, callback, false);
                else if(element.attachEvent)
                    element.attachEvent("on" + eventName, callback);
                else
                    element["on" + eventName] = callback;
            }
            
            addEvent(document.body, "keydown", function(e) {
                e = e || window.event;
                switch(e.key)
                {
                    case "W":
                    case "w":
                        paddleSpeeds[0] = -1;
                        break;
                    case "S":
                    case "s":
                        paddleSpeeds[0] = 1;
                        break;
                    
                    case "P":
                    case "p":
                        paddleSpeeds[1] = -1;
                        break;
                    case ";":
                    case ":":
                        paddleSpeeds[1] = 1;
                        break;
                }
            });
            addEvent(document.body, "keyup", function(e) {
                e = e || window.event;
                switch(e.key)
                {
                    case "W":
                    case "w":
                        if(paddleSpeeds[0] === -1)
                            paddleSpeeds[0] = 0;
                        break;
                    case "S":
                    case "s":
                        if(paddleSpeeds[0] === 1)
                            paddleSpeeds[0] = 0;
                        break;
                    
                    case "P":
                    case "p":
                        if(paddleSpeeds[1] === -1)
                            paddleSpeeds[1] = 0;
                        break;
                    case ";":
                    case ":":
                        if(paddleSpeeds[1] === 1)
                            paddleSpeeds[1] = 0;
                        break;
                }
            });
            
            function mainLoop()
            {
                //console.log("MAINLOOP")
                if(paddleSpeeds[0] !== 0)
                    moveNthPaddle(1, paddleSpeeds[0]);
                if(paddleSpeed[1] !== 0)
                    moveNthPaddle(2, paddleSpeeds[1]);
                moveBall(1, 1);
                displayScores();
            }
            function startGame()
            {
                buttonStart.style.display = "none";
                game.style.display = "block";
                gameInterval = setInterval(mainLoop, 50);
                mainLoop();
            }
            buttonStart.onclick = startGame;
        </script>
        
        <?php include_once("../../includes/footer.php") ?>
    </body>
</html>
