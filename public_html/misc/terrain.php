<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Terrain Generator | Miscellany | MasonMackinnon.Com</title>
        <link rel="stylesheet" href="/styles/main.css" />
    </head>
    <body>
        <?php include_once("../../includes/header.php") ?>
        
        <section>
            <h1>Terrain Generation</h1>
            <p id="gen-msg">Generating...</p>
            <noscript>This page needs JavaScript to work.</noscript>
            <div class="square-container"></div>
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
        </style>
        <script>
            const squareContainer = document.querySelector(".square-container");
            const squareSize = 10;
            var squares = [];
            var numSquaresPerRow = 0;
            var freq = 0.1;
            
            function putSquares()
            {
                let containerWidth = squareContainer.clientWidth;
                let containerHeight = squareContainer.clientHeight;
                
                for(let i = 0; i < containerWidth; i += squareSize)
                {
                    ++numSquaresPerRow;
                    for(let j = 0; j < containerHeight; j += squareSize)
                    {
                        squares.push(0);
                    }
                }
            }
            function genTerrain()
            {
                let numSquaresToIter = squares.length - numSquaresPerRow - 1;
                
                for(let i = 1; i < numSquaresToIter; ++i)
                {
                    if(Math.random() < freq)
                    {
                        for(let j = -1; j <= 1; ++j)
                        {
                            for(let k = -1; k <= 1; ++k)
                            {
                                if(Math.random() < 0.4)
                                {
                                    ++squares[i + j + (k * numSquaresPerRow)];
                                }
                            }
                        }
                    }
                }
                
                for(let i = 1; i < numSquaresToIter; ++i)
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
                                for(let j = -2; j <= 2; ++j)
                                {
                                    for(let k = -2; k <= 2; ++k)
                                    {
                                        let n = i + j + (k * numSquaresPerRow);
                                        if(squares[n] > 0)
                                            break makeDeepOcean;
                                    }
                                }
                                squares[i] = -1;
                            };
                            makeHighMountain:
                            {
                                for(let j = -2; j <= 2; ++j)
                                {
                                    for(let k = -2; k <= 2; ++k)
                                    {
                                        let n = i + j + (k * numSquaresPerRow);
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
                for(let i = 0; i < squares.length; ++i)
                {
                    let square = document.createElement("div");
                    square.classList.add("square");
                    let squareName = squares[i] < 0 ? "deep" : squares[i];
                    square.classList.add("square-" + squareName);
                    squareContainer.appendChild(square);
                }
            }
            
            window.onload = function()
            {
                putSquares();
                genTerrain();
                renderSquares();
            };
        </script>
        
        <?php include_once("../../includes/footer.php") ?>
    </body>
</html>
