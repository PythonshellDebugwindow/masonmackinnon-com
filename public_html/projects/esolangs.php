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
            <option value="depend">Depend</option>
            <option value="linefeed">Line Feed</option>
            <option value="pom">PlusOrMinus</option>
        </select>
        <h2>Code:</h2>
        <textarea id="codebox"></textarea>
        <h2>Input:</h2>
        <textarea id="input"></textarea>
        <button id="run">Run</button>
        <h2>Output:</h2>
        <textarea id="output"></textarea>
    </div>
</section>

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
</style>
<?php include_once('../../includes/footer.php'); ?>
