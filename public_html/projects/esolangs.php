<?php
    $title = "Esolangs";
    include_once("../../includes/header.php");
?>
<section>
    <h1>Esolangs Online</h1>
    <div>
        <h2>Language:</h2>
        <select id="language">
            <option>Choose One</option>
            <option value="dashes">—- (Dashes)</option>
            <option value="base2">Base2</option>
            <option value="bout">Bout</option>
            <option value="depend" selected>Depend</option>
            <option value="linefeed">Line Feed</option>
            <option value="pom">PlusOrMinus</option>
        </select>
        <h2>Code:</h2>
        <textarea id="codebox">0->2
2->1
1-></textarea>
        <h2>Input:</h2>
        <textarea id="input"></textarea>
        <button id="run">Run</button>
        <h2>Output:</h2>
        <textarea id="output"></textarea>
    </div>
</section>

<script src="base2.js"></script>
<script src="plus-or-minus.js"></script>
<script src="depend.js"></script>

<script>
    var languageSwitch = document.getElementById("language");
    var codebox = document.getElementById("codebox");
    var inputBox = document.getElementById("input");
    var run = document.getElementById("run");
    var outputBox = document.getElementById("output");
    
    run.onclick = function()
    {
        var language = languageSwitch.value;
        var code = codebox.value;
        var inputs = inputBox.value.split("\n");
        var output = "";
        
        function input()
        {
            return inputs.shift();
        }
        
        switch(language)
        {
            case "dashes":
                output = dashes(code);
                break;
            case "base2":
                output = base2(code);
                break;
            case "bout":
                output = bout(code);
                break;
            case "depend":
                output = depend(code);
                break;
            case "linefeed":
                output = lineFeed(code);
                break;
            case "pom":
                output = plusOrMinus(code);
                break;
            case "":
                (code);
                break;
            default:
                output = "Please choose a valid language";
                break;
        }
        
        outputBox.value = output;
    };
</script>

<style>
    textarea
    {
        display: block;
        width: 100%;
        min-height: 100px;
        resize: vertical;
        padding: 5px;
        font-family: "Courier New", "Courier", monospace;
    }
    #run
    {
        padding: 5px;
        margin-top: 5px;
        border-radius: 5px;
        background: #fff;
        border: 1px solid #000;
    }
    #run:hover
    {
        background: #f0f0f0;
    }
</style>
<?php include_once('../../includes/footer.php'); ?>
