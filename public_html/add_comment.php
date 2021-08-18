<?php
session_start();

function fail()
{
    header('Location: ' . 'http://masonmackinnon.com' . $_POST['origin'] . '?acf', true, 301);
    exit();
}

if($_SERVER['REQUEST_METHOD'] !== 'POST')
    exit();
if(!isset($_POST['origin']))
    exit();
if(!isset($_POST['content']) || !isset($_POST['replyto']))
    fail();

include_once('../connect_db.php');
$dbc = connect();
if(mysqli_connect_errno())
    fail();

$r = mysqli_query($dbc, 'USE masonmackinnon');
if(!$r)
    fail();

$userId = (isset($_SESSION['id']) && ctype_digit($_SESSION['id'])) ? $_SESSION['id'] : 0;
$replyTo = $_POST['replyto'];
if(!ctype_digit($replyTo))
    fail();
$replyTo = intval($replyTo);
$c = htmlspecialchars(mysqli_real_escape_string($dbc, $_POST['content']));

$loc = mysqli_real_escape_string($dbc, $_POST['origin']);
$loc = $replyTo === 0 ? "" : $loc;

$r = mysqli_query($dbc, "INSERT INTO comments (user_id, content, location, date, reply_to) VALUES ($userId, '$c', '$loc', NOW(), $replyTo)");
if(!$r)
    fail();

header('Location: ' . 'http://masonmackinnon.com' . $_POST['origin'], true, 301);
exit();
