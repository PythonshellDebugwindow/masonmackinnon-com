var statusP = document.getElementById("status");
var canvas = document.getElementById("canvas");
var c = canvas.getContext("2d");
var cAspectRatio = 1.6; //W / H
var cWidth = canvas.clientWidth;
canvas.width = cWidth;
var cHeight = canvas.clientWidth / cAspectRatio;
canvas.height = cHeight;

var mouseX = 0;
var mouseY = 0;
var mouseIsDown = false;

var backgroundImg, heartImg;
var playerBulletImg, bulletMSImg, enemyImg, mothershipImg, playerImg;

var gameInterval = null;
var gameIntervalSpeed = 60;
var enemyMoveInterval = null;
var enemyMoveIntervalSpeed = 480;

var playerX = 50;
var maxPlayerX = null;
var playerY = null;
var playerSpeed = 25;
var score = 0;
var lives = 4;
var gameIsStarted = true; //false;

var enemies = [];
var enemySpeed = null;
var playerBullets = [];
var bulletOffsetX = null;
var enemyBullets = [];
var bulletHeight = null;
var bulletSpeed = 5;
var mothership = [-50, 25];
var hasMothership = false;

function loadImages()
{
    backgroundImg = new Image();
    backgroundImg.src = "images/background.jpg";
    backgroundImg.onerror = perrorNoImage;
    backgroundImg.onload = function()
    {
        heartImg = new Image();
        heartImg.src = "images/heart.png";
        heartImg.onerror = perrorNoImage;
        heartImg.onload = function()
        {
            playerBulletImg = new Image();
            playerBulletImg.src = "images/player-bullet.png";
            playerBulletImg.onerror = perrorNoImage;
            playerBulletImg.onload = function()
            {
                bulletHeight = playerBulletImg.height;
                enemyBulletImg = new Image();
                enemyBulletImg.src = "images/enemy-bullet.png";
                enemyBulletImg.onerror = perrorNoImage;
                enemyBulletImg.onload = function()
                {
                    bulletMSImg = new Image();
                    bulletMSImg.src = "images/bullet-ms.png";
                    bulletMSImg.onerror = perrorNoImage;
                    bulletMSImg.onload = function()
                    {
                        enemyImg = new Image();
                        enemyImg.src = "images/enemy.png";
                        enemyImg.onerror = perrorNoImage;
                        enemyImg.onload = function()
                        {
                            enemySpeed = Math.floor(enemyImg.width / 2);
                            mothershipImg = new Image();
                            mothershipImg.src = "images/mothership.png";
                            mothershipImg.onerror = perrorNoImage;
                            mothershipImg.onload = function()
                            {
                                playerImg = new Image();
                                playerImg.src = "images/player.png";
                                playerImg.onerror = perrorNoImage;
                                playerImg.onload = function()
                                {
                                    maxPlayerX = cWidth - playerImg.width - playerSpeed - 50;
                                    playerY = cHeight - playerImg.height - 50;
                                    bulletOffsetX = playerImg.width / 2 - playerBulletImg.width / 2;
                                    startGame();
                                };
                            };
                        };
                    };
                };
            };
        };
    };
}

function loadGame()
{
    statusP.innerHTML = "Loading images...";
    loadImages();
}
function perrorNoImage(e)
{
    statusP.innerHTML = "Error: image '" + e.path[0].src + "' not found";
}

function startGame()
{
    statusP.innerHTML = "";
    c.textAlign = "center";
    generateEnemies();
    gameInterval = setInterval(update, gameIntervalSpeed);
    enemyMoveInterval = setInterval(moveEnemies, enemyMoveIntervalSpeed);
}   

function update()
{
    c.drawImage(backgroundImg, 0, 0);
    if(gameIsStarted)
        updateMainGame();
    else
        updateMenu();
}

function updateMainGame()
{
    image(playerImg, playerX, playerY);
    updateBullets();
    updateEnemies();
    drawEnemies();
    drawBullets();
}

function updateBullets()
{
    var i;
    for(i = 0; i < playerBullets.length; ++i)
    {
        playerBullets[i][1] -= bulletSpeed;
        if(playerBullets[i][1] < -bulletHeight)
        {
            playerBullets.splice(i, 1);
            --i;
        }
    }
    for(i = 0; i < enemyBullets.length; ++i)
    {
        enemyBullets[i][1] -= enemyBullets;
        if(enemyBullets[i][1] < -bulletHeight)
        {
            enemyBullets.splice(i, 1);
            --i;
        }
    }
}
function drawBullets()
{
    var i;
    for(i = 0; i < playerBullets.length; ++i)
    {
        image(playerBulletImg, playerBullets[i][0], playerBullets[i][1]);
    }
    for(i = 0; i < enemyBullets.length; ++i)
    {
        image(enemyBulletImg, enemyBullets[i][0], enemyBullets[i][1]);
    }
}

function updateEnemies()
{
    if(enemies.length < 1)
        return;
    
    for(var i = 0, j, bx, bxw, ex, exw, by, eyh; i < enemies.length; ++i)
    {
        for(j = 0; j < playerBullets.length; ++j)
        {
            bx = playerBullets[j][0];
            bxw = bx + playerBulletImg.width;
            ex = enemies[i][0];
            exw = ex + enemyImg.width;
            by = playerBullets[j][1];
            eyh = enemies[i][1] + enemyImg.height;
            
            if(bxw > ex && bx < exw && by < eyh)
            {
                enemies.splice(i, 1);
                if(i === 0)
                {
                    var newFirstEnemyIdx = 0;
                    for(var k = 1; k < enemies.length; ++k)
                    {
                        if(enemies[k][0] < enemies[newFirstEnemyIdx][0])
                            newFirstEnemyIdx = k;
                    }
                    enemies.unshift(enemies[newFirstEnemyIdx]);
                    enemies.splice(newFirstEnemyIdx, 1);
                }
                --i;
                playerBullets.splice(j, 1);
                break;
            }
        }
    }
}
function moveEnemies()
{
    if(enemies.length === 0)
        return;
    
        for(var i = 0; i < enemies.length; ++i)
        {
            enemies[i][0] += enemySpeed;
        }
    
    if(enemies[0][0] < enemySpeed//Img.width
       || enemies[enemies.length - 1][0] > cWidth - enemySpeed)
    {
        console.log("Enemies[0][0] =",enemies[0][0])
        for(i = 0; i < enemies.length; ++i)
        {
            enemies[i][0] -= enemySpeed *2;
            enemies[i][1] += enemyImg.height;
        }
        console.log("Enemies[0][0] now =",enemies[0][0])
        enemySpeed *= -1;
    }
}
function drawEnemies()
{
    for(var i = 0; i < enemies.length; ++i)
    {
        image(enemyImg, enemies[i][0], enemies[i][1]);
    }
}

function generateEnemies()
{
    enemies = [];
    for(var i = 0; i < 6; ++i)
    {
        for(var j = 0; j < 2; ++j)
        {
            enemies.push([i * enemyImg.width, j * enemyImg.height]);
        }
    }
}

function updateMenu()
{
    var x = 70;
    var w = cWidth - 140;
    var h = 200;
    var y = cHeight / 2 - h / 2;
    c.fillStyle = "rgba(255,255,255,0.4)";
    rect(x, y, w, h);
    
    c.font = "50px Arial";
    c.fillStyle = "#fff";
    text("Space Invasion", x + w / 2, y + 75);
    
    x += 50;
    w -= 100;
    y += 100;
    h -= 125;
    c.fillStyle = cursorIsOverRect(x, y, w, h) ? "rgba(0,0,0,0.3)"
                                               : "rgba(255,255,255,0.4)";
    rect(x, y, w, h);
    
    c.font = "30px Arial";
    c.fillStyle = "#fff";
    text("Start", x + w / 2, y + 45);
    
    if(mouseIsDown && cursorIsOverRect(x, y, w, h))
        gameIsStarted = true;
}

function handleMouseup(e)
{
    if(!gameIsStarted)
        menuHandleMouseup(e);
}
function handleMousedown(e)
{
    if(!gameIsStarted)
        menuHandleMousedown(e);
}
function menuHandleMouseup(e)
{
    e = e || window.event;
    mouseIsDown = false;
}
function menuHandleMousedown(e)
{
    e = e || window.event;
    mouseIsDown = true;
}

function handleKeydown(e)
{
    console.log(e);
    if(gameIsStarted)
    {
        e = e || window.event;
        switch(e.key)
        {
            case "A":
            case "a":
            case "ArrowLeft":
                if(playerX >= playerSpeed + 50)
                    playerX -= playerSpeed;
                break;
            case "D":
            case "d":
            case "ArrowRight":
                if(playerX <= maxPlayerX)
                    playerX += playerSpeed;
                break;
            case " ":
            case "Spacebar":
                playerBullets.push([playerX + bulletOffsetX, playerY - bulletHeight]);
                e.preventDefault();
                break;
        }
    }
}

function rect(x, y, w, h)
{
    c.beginPath();
    c.rect(x, y, w, h);
    c.fill();
}

function text(t, x, y)
{
    c.fillText(t, x, y);
}

function image(i, x, y)
{
    c.drawImage(i, x, y);
}

function cursorIsOverRect(x, y, w, h)
{
    return mouseX > x && mouseX < x + w
           && mouseY > y && mouseY < y + h;
}

function updateMousePos(e)
{
    var bcr = canvas.getBoundingClientRect();
    e = e || window.event;
    mouseX = e.clientX - bcr.left;
    mouseY = e.clientY - bcr.top;
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
addEvent(canvas, "mousemove", updateMousePos);
addEvent(canvas, "mouseup", handleMouseup);
addEvent(canvas, "mousedown", handleMousedown);
addEvent(window, "keydown", handleKeydown);

window.onload = loadGame();
