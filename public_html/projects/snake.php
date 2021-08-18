<?php
    $title = 'Snakish Game';
    include_once('../../includes/header.php');
?>
    <section>
    <h1>Snakish Game</h1>
    <canvas width="400" height="400" id="canvas">Your browser does not support the Canvas Element.</canvas>
    <p>Press the arrow keys or WASD to move. Try to collect the orange food to grow bigger, but don't run into your own tail and don't go off the screen!</p>
    <a class="btn" href="snake.php">Restart</a>
    
    <style>
    	.dark
    	{
    	    background: black;
    	}
    	#canvas
    	{
    	    border: 1px solid black;
    	}
    	.btn
    	{
    	    display: -moz-inline-box;
    	    display: inline-block;
    	    padding: 15px;
    	    border: 1px solid #000;
    	    border-radius: 10px;
    	    background: #f0f0f0;
    	    color: #000;
    	}
    	.btn:hover
    	{
    	    background: #fff;
    	    color: #000;
    	}
    </style>
    
    <script>
    	const DrawModeEnum = {HEAD: "green", TAIL: "blue", FOOD: "orange"};
    	var keyCode;
    	var gameInterval = null;
    	var gameOver = false;
    	var canvas = document.getElementById("canvas");
    	var c = canvas.getContext("2d");
    	if(!c) alert("Your browser does not support the Canvas Element");
    	
    	c.textAlign = "left";
		c.font = "20px Arial";
    	
    	var canvasSize = 400;
    	var numCells = 25;
    	var cellSize = canvasSize / numCells;
    	var UP = 0;
    	var RIGHT = 1;
    	var DOWN = 2;
    	var LEFT = 3;
    	var dir = RIGHT;
    	var snake = [[5 * cellSize, 2 * cellSize],
    	            [4 * cellSize, 2 * cellSize],
    	            [3 * cellSize, 2 * cellSize],
    	            [2 * cellSize, 2 * cellSize],
    	            [1 * cellSize, 2 * cellSize]];
    	var food = [[7*cellSize,7*cellSize],[8*cellSize,9*cellSize]];
    	var score = 0;
    	var shouldGrow = false;
    	
    	function fillCanvas(colour)
    	{
    		if(colour === undefined) colour = "white";
    		c.fillStyle = colour;
    		c.fillRect(0, 0, canvas.width, canvas.height);
    		c.fill();
    	}
    	
    	function showScore()
    	{
    		drawText("Score: " + score, 5, 20);
    	}
    	function drawText(text, x, y)
    	{
    		c.fillStyle = "black";
    		c.fillText(text, x, y);
    	}
    	function drawSquare(x, y, drawMode)
    	{
    		c.fillStyle = drawMode;
    		c.beginPath();
    		c.fillRect(x, y, cellSize, cellSize);
    		c.fill();
    	}
    	
    	function startGame()
    	{
    		document.addEventListener("keydown", handleKeydown, false);
    		fillCanvas();
    		gameInterval = setInterval(update, 125);
    		showScore();
    	}
    	
    	function update()
    	{
    	    switch(dir)
    	    {
    	        case UP:
    	            move(0, -1);
    	            break;
    	        case RIGHT:
    	            move(1, 0);
    	            break;
    	        case DOWN:
    	            move(0, 1);
    	            break;
    	        case LEFT:
    	            move(-1, 0);
    	            break;
    	    }
    	    draw();
    	}
    	
    	function handleKeydown(e)
		{
		    e = e || window.event;
		    
			key = event.key;
			if(!gameOver)
			{
				switch(key.toLowerCase())
				{
				    case "w":
				    case "up":
				    case "arrowup":
				        if(dir !== DOWN)
    				        dir = UP;
				        e.preventDefault();
				        shouldGrow = true;
				        break;
				    case "d":
				    case "right":
				    case "arrowright":
				        if(dir !== LEFT)
    				        dir = RIGHT;
    				    shouldGrow = true;
				        break;
				    case "s":
				    case "down":
				    case "arrowdown":
				        if(dir !== UP)
    				        dir = DOWN;
				        e.preventDefault();
    				    shouldGrow = true;
				        break;
				    case "a":
				    case "left":
				    case "arrowleft":
				        if(dir !== RIGHT)
    				        dir = LEFT;
    				    shouldGrow = true;
				        break;
				}
			}
			else if(key === 'Space' || key == "Spacebar")
			{
				// gameOver = false;
				// startGame();
			}
			if(keyCode !== 32)
			    event.preventDefault();
			return false;
		}
		
		function draw()
		{
			fillCanvas();
			showScore();
			if(!gameOver)
			{
				for(var i = 0; i < food.length; ++i)
					drawSquare(food[i][0], food[i][1], DrawModeEnum.FOOD);
				drawSquare(snake[0][0], snake[0][1], DrawModeEnum.HEAD);
				for(var i = 1; i < snake.length; ++i)
					drawSquare(snake[i][0], snake[i][1], DrawModeEnum.TAIL);
			}
			else
			{
			    drawText("You are dead!", 5, 50);
			}
		}
		
// 		function gameOver()
// 		{
// 			gameOver = true;
// 			if(drawInterval !== null) clearInterval(gameInterval);
// 			fillCanvas("red");
// 			c.fillStyle = "white";
// 			c.textAlign = "center";
// 			c.font = "30px Arial";
// 			c.fillText("Press space\nto reset", 200, 200);
// 		}
		
		function move(x, y)
		{
		    var growth = snake[snake.length - 1].slice();
		    
            for(var i = snake.length - 1; i > 0; --i)
                snake[i] = snake[i - 1].slice();
            
            if(shouldGrow)
            {
                snake.push(growth);
                shouldGrow = false;
            }
            
		    snake[0][0] += x * cellSize;
		    snake[0][1] += y * cellSize;
		  //  for(var i = 0; i < snake.length; ++i)
		  //  {
		  //      snake[i][0] += x * cellSize;
		  //      snake[i][1] += y * cellSize;
		  //  }
		    checkFood();
		    checkGameOver();
		}
		
		function checkFood()
		{
		    var head = snake[0];
		    for(var i = 0; i < food.length; ++i)
		    {
                if(food[i][0] == head[0] && food[i][1] == head[1])
                {
                    ++score;
                    food[i] = randomPosition();
                }
            }
		}
		function checkGameOver()
		{
		    var head = snake[0];
		    if(head[0] < 0 || head[0] >= canvasSize
		       || head[1] < 0 || head[1] >= canvasSize)
		    {
		        died();
		    }
		    else
		    {
		        for(var i = 1; i < snake.length; ++i)
		        {
		            if(snake[i][0] === head[0] && snake[i][1] === head[1])
		                died();
		        }
		    }
		}
		
		function randomPosition()
		{
		    var x = Math.floor(Math.random() * numCells) * cellSize;
		    var y = Math.floor(Math.random() * numCells) * cellSize;
		    return [x, y];
		}
		
		function died()
		{
	        gameOver = true;
		    canvas.removeEventListener("keydown", handleKeydown, false);
		    clearInterval(gameInterval);
		    gameInterval = null;
		}
		
		onload = startGame;
    </script>
</section>
<?php include_once('../../includes/footer.php'); ?>
