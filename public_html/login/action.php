<?php
$enteredUsername = '';
$enteredPassword = '';
$missing = array();

$submitted = $_SERVER['REQUEST_METHOD'] == 'POST';
if($submitted)
{
    $enteredUsername = @$_POST['name'];
    $enteredPassword = @$_POST['pass'];
    
    $hasUsername = isset($enteredUsername) && $enteredUsername !== '';
    $hasPassword = isset($enteredPassword) && $enteredPassword !== '';
    if(!$hasUsername || !$hasPassword)
    {
        if(!$hasUsername) $missing[] = "Your username";
        if(!$hasPassword) $missing[] = "Your password";
        return; //Return to parent script
    }
    
    function fail()
    {
        echo '<p>Error: ' . mysqli_error($dbc) . " " . mysqli_errno() . '</p>';
        die();
    }
    
    require('../../connect_db.php');
    $dbc = connect();
    if(mysqli_connect_errno())
    {
        echo "Failed to connect to MySQL: " . mysqli_connect_error();
        die();
    }
    
    $r = mysqli_query($dbc, 'USE masonmackinnon');
    if(!$r)
        fail();
    
    $hashedPassword = hash('sha224', $enteredPassword);
    $q = "SELECT id, name FROM users WHERE name = '$enteredUsername' AND pass = '$hashedPassword'";
    
    $u = mysqli_query($dbc, $q);
    if(!$u)
        fail();
    
    if(mysqli_num_rows($u) == 1)
    {
        //Logged in successfully
        @session_start();
        $row = mysqli_fetch_array($u, MYSQLI_ASSOC);
        $_SESSION['id'] = $row['id'];
        $_SESSION['name'] = $row['name'];
        header('Location: /');
        exit();
    }
    else
    {
        $missing[] = "A valid user";
    }
}
