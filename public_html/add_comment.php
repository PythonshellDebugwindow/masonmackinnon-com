<?php
session_start();

function leave($acf)
{
    $a = $acf ? '?acf' : '';
    header('Location: ' . 'http://masonmackinnon.com' . $_POST['origin'] . $a, true, 301);
    exit();
}

if($_SERVER['REQUEST_METHOD'] !== 'POST')
    exit();
if(!isset($_POST['origin']))
    exit();
if(!isset($_POST['content']) || !isset($_POST['replyto']))
    leave(true);

if($_POST['content'] === "")
    leave(false);

include_once('../connect_db.php');
$dbc = connect();
if(mysqli_connect_errno())
    leave(true);

$r = mysqli_query($dbc, 'USE masonmackinnon');
if(!$r)
    leave(true);

$userId = (isset($_SESSION['id']) && ctype_digit($_SESSION['id'])) ? $_SESSION['id'] : 0;
$replyTo = $_POST['replyto'];
if(!ctype_digit($replyTo))
    leave(true);
$replyTo = intval($replyTo);
$c = htmlspecialchars(mysqli_real_escape_string($dbc, $_POST['content']));

$loc = mysqli_real_escape_string($dbc, $_POST['origin']);
$loc = $replyTo === 0 ? $loc : "";

$r = mysqli_query($dbc, "INSERT INTO comments (user_id, content, location, date, reply_to) VALUES ($userId, '$c', '$loc', NOW(), $replyTo)");
if(!$r)
    leave(true);

if($replyTo !== 0)
{
    $f = mysqli_query($dbc, "UPDATE comments SET num_replies = num_replies + 1 WHERE id = $replyTo");
    if(!$f)
        leave(true);
}

leave(false);
