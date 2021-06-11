<?php
if($_SERVER['REQUEST_METHOD'] == 'POST')
{
    if(!isset($_POST['auth']) || !isset($_POST['po']))
        echo 'Not all data have been provided.';
    else if(hash('sha224', $_POST['auth']) != '1b53cb37b9cf6256ff0f4a3c9299583d26ed6a94798d1405154f1aa0')
        echo 'Typo? '.$_POST['auth'].' is wrong. Else, who are you?';
    else
    {
        require('../connect_db.php');
        $dbc = connect();
        $r = mysqli_query($dbc, 'USE masonmackinnon');
        if(!$r)
            {echo 'Bad'; die();}
        $c = mysqli_real_escape_string($dbc, $_POST['po']);
        $r = mysqli_query($dbc, 'INSERT INTO blog (content) VALUES ("'.$c.'")');
        if(!$r)
            echo 'Bad<br/>';
        echo 'Content: `' . $c . '`';
    }
}
else
{
?>
    <form action="#" method="POST">
        Password: <input type="text" name="auth">
        Text: <textarea name="po" style="width:100%;height:100%;box-sizing:border-box"></textarea>
        <input type="submit" name="Submit">
    </form>
<?php
}
