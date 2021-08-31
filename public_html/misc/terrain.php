<?php
    $title = 'Terrain Generator | Miscellany';
    include_once("../../includes/header.php")
?>
<section style="position: relative">
    <h1>Terrain Generator</h1>
    <p id="gen-msg">Generating...</p>
    <noscript>This page needs JavaScript to work.</noscript>
    <div class="square-container"></div>
    <div class="range-holder">
        <span>North Pacific</span>
        <input type="range" min="0" max="1" value="0.1" step="0.001" onchange="slider(this.value)">
        <span>Coastal Himalayas</span>
    </div>
</section>

<style>
    #gen-msg
    {
        position: absolute;
    }
    .square-container
    {
        box-sizing: border-box;
        width: 100%;
        height: 400px;
        display: flex;
        flex-wrap: wrap;
    }
    .square
    {
        position: relative;
        width: 10px;
        height: 10px;
    }
    .square-deep
    {
        background: #00f;
    }
    .square-0
    {
        background: #35d;
    }
    .square-1
    {
        background: #3d3;
    }
    .square-2
    {
        background: #c74;
    }
    .square-3
    {
        background: #841;
    }
    .square-4
    {
        background: #ddd;
    }
    .square-5
    {
        background: #fff;
    }
    .range-holder
    {
        position: absolute;
        bottom: 0;
        width: 100%;
        margin-top: 25px;
        box-sizing: border-box;
        display: flex;
        justify-content: center;
        align-items: center;
    }
    input[type="range"]
    {
        width: 50%;
        margin: 0 20px;
    }
</style>
<script>
    const squareContainer = document.querySelector(".square-container");
    const squareSize = 10;
    var squares = [];
    var numSquaresPerRow = 0;
    var freq = 0.1;
    
    function putSquares()
    {
        squares = [];
        
        var containerWidth = squareContainer.clientWidth;
        var containerHeight = squareContainer.clientHeight;
        
        for(var i = 0; i < containerWidth; i += squareSize)
        {
            ++numSquaresPerRow;
            for(var j = 0; j < containerHeight; j += squareSize)
            {
                squares.push(0);
            }
        }
    }
    function genTerrain()
    {
        var numSquaresToIter = squares.length - numSquaresPerRow - 1;
        
        for(var i = 1; i < numSquaresToIter; ++i)
        {
            if(Math.random() < freq)
            {
                for(var j = -1; j <= 1; ++j)
                {
                    for(var k = -1; k <= 1; ++k)
                    {
                        if(Math.random() < 0.4)
                        {
                            ++squares[i + j + (k * numSquaresPerRow)];
                        }
                    }
                }
            }
        }
        
        for(var i = 1; i < numSquaresToIter; ++i)
        {
            if(squares[i] === 0)
            {
                if(squares[i - 1] > 0 && squares[i + 1] > 0
                && squares[i - numSquaresPerRow] > 0
                && squares[i + numSquaresPerRow] > 0)
                {
                    squares[i] = 2;
                }
                else
                {        
                    makeDeepOcean: {
                        for(var j = -2; j <= 2; ++j)
                        {
                            for(var k = -2; k <= 2; ++k)
                            {
                                var n = i + j + (k * numSquaresPerRow);
                                if(squares[n] > 0)
                                    break makeDeepOcean;
                            }
                        }
                        squares[i] = -1;
                    };
                    makeHighMountain: {
                        for(var j = -2; j <= 2; ++j)
                        {
                            for(var k = -2; k <= 2; ++k)
                            {
                                var n = i + j + (k * numSquaresPerRow);
                                if(squares[n] < 3)
                                    break makeHighMountain;
                            }
                        }
                        squares[i] = 4;
                    }
                }
            }
        }
    }
    function renderSquares()
    {
        while(squareContainer.children.length > 0)
            squareContainer.children[0].remove();
        squareContainer.innerHTML = "";
        
        for(var i = 0; i < squares.length; ++i)
        {
            var square = document.createElement("div");
            square.classList.add("square");
            var squareName = squares[i] < 0 ? "deep" : squares[i];
            if(squares[i] > 5)
                squareName = "5";
            square.classList.add("square-" + squareName);
            squareContainer.appendChild(square);
        }
    }
    
    function slider(v)
    {
        freq = v;
        putSquares();
        genTerrain();
        renderSquares();
    }
    
    window.onload = function()
    {
        slider(freq);
    };
</script>
<?php include_once("../../includes/footer.php") ?>
