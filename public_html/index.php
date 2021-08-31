<?php
    $title = "";
    include_once("../includes/header.php");
?>
<section>
    <h1>Hello!</h1>
    <h2>Welcome to MasonMackinnon.Com!</h2>
    <p>Please note that this is a <b>major</b> work in progress, not the horrible finished product. Check back later for more <s>terrible</s> content!</p>
    <hr />
    <h2>Number of the Day: <span id="notd"></span><noscript>42</noscript></h2>
    <p>Each day, this number is chosen carefully by a team of analysts and PRNGs.</p>
    <hr />
    <h2>Weather Forecast</h2>
    <p>Tomorrow will be <span id="weather"></span><noscript>cloudy</noscript> with a chance of ~25%.</p>
    <hr />
    <h2>Cookies</h2>
    <p>See <a href="/cookies/">Cookies.</a></p>
    <hr />
    <div class="earth">
        <img src="earth3d.png" alt="Earth" usemap="#earthmap">
        <img src="earth3d.png" alt="Earth" usemap="#earthmap">
    </div>
    <map name="earthmap" id="earthmap">
        <area alt="North America" title="North America" href="https://en.wikipedia.org/wiki/North_America" rel="noopener noreferrer" coords="0,3,290,172" shape="rect">
        <area alt="South America" title="South America" href="https://en.wikipedia.org/wiki/South_America" rel="noopener noreferrer"  coords="299,175,121,352" shape="rect">
        <area alt="Africa" title="Africa" href="https://en.wikipedia.org/wiki/Africa" rel="noopener noreferrer" coords="453,288,301,166" shape="rect">
        <area alt="Africa" title="Africa" href="https://en.wikipedia.org/wiki/Africa" rel="noopener noreferrer" coords="294,112,420,164" shape="rect">
        <area alt="Europe" title="Europe" href="https://en.wikipedia.org/wiki/Europe" rel="noopener noreferrer" coords="293,1,445,111" shape="rect">
        <area alt="Asia" title="Asia" href="https://en.wikipedia.org/wiki/Asia" rel="noopener noreferrer" coords="675,26,456,223" shape="rect">
        <area alt="Asia" title="Asia" href="https://en.wikipedia.org/wiki/Asia" rel="noopener noreferrer" coords="446,0,455,165" shape="rect">
        <area alt="Asia" title="Asia" href="https://en.wikipedia.org/wiki/Asia" rel="noopener noreferrer" coords="422,110,444,167" shape="rect">
        <area alt="Oceania" title="Oceania" href="https://en.wikipedia.org/wiki/Oceania" rel="noopener noreferrer" coords="506,226,718,352" shape="rect">
        <area alt="Oceania" title="Oceania" href="https://en.wikipedia.org/wiki/Oceania" rel="noopener noreferrer" coords="117,176,0,351" shape="rect">
        <area alt="Antarctica" title="Antarctica" href="https://en.wikipedia.org/wiki/Antarctica" rel="noopener noreferrer" coords="0,356,718,398" shape="rect">
    </map>
</section>

<script>
    //Modified version of xmur3(str) - https://gist.github.com/tionkje/6ab66360dcfe9a9e2b5560742d259389
    function rand(str)
    {
        for(var i = 0, h = 1779033703 ^ str.length; i < str.length; i++)
            h = Math.imul(h ^ str.charCodeAt(i), 3432918353), h = h << 13 | h >>> 19;
        h = Math.imul(h ^ h >>> 16, 2246822507);
        h = Math.imul(h ^ h >>> 13, 3266489909);
        return (h ^= h >>> 16) >>> 0;
    }
    function getNumberOfTheDay()
    {
        let d = new Date();
        var dateStr = d.getDate() + " " + d.getMonth() + " " + d.getYear();
        return rand(dateStr) % 999 + 1;
    }
    document.getElementById("notd").innerText = getNumberOfTheDay();
    
    var weathers = ["rainy", "sunny", "cloudy"];
    var idx = Math.floor(Math.random() * 3);
    document.getElementById("weather").innerText = weathers[idx];
</script>

<style>
    .earth
    {
        position: relative;
        background: #0078c4;
        /*background-blend-mode: mix;*/
        width: 400px;
        height: 400px;
        max-width: 100%;
        max-height: 100%;
        background-size: cover;
        border-radius: 50%;
        box-shadow: inset 0 0 50px rgba(0,0,0,0.85);
        overflow: hidden;
    }
    .earth img
    {
        position: absolute;
        padding: -20px;
        animation: earth 16s linear infinite;
        animation-direction: reverse;
        animation-delay: -4s;
    }
    .earth img:nth-child(2)
    {
        animation-delay: -12s;
    }
    @keyframes earth
    {
        0%
        { 
           left: 300px;
        }
        100%
        {
            left: calc(719px *-2);
        }
    }
    @media (max-width: 470px)
    {
        .earth
        {
            width: 75vw;
            height: 75vw !important;
        }
        .earth img
        {
            width: 100%;
            height: 100%;
        }
    }
</style>
<?php include_once("../includes/footer.php") ?>
