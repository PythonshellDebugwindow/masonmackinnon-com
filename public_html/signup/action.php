<?php
$enteredUsername = '';
$enteredPassword = '';
$errors = array();

$submitted = $_SERVER['REQUEST_METHOD'] == 'POST';
if($submitted)
{
    $enteredUsername = @$_POST['name'];
    $enteredPassword = @$_POST['pass'];
    $enteredPassword2 = @$_POST['pass2'];
    
    $hasUsername = isset($enteredUsername) && $enteredUsername !== '';
    $hasPassword = isset($enteredPassword) && $enteredPassword !== '';
    if(!$hasUsername || !$hasPassword)
    {
        if(!$hasUsername) $errors[] = "Please enter a username";
        if(!$hasPassword) $errors[] = "Please enter a password";
    }
    if($enteredPassword != $enteredPassword2)
    {
        $errors[] = "Passwords do not match";
    }
    if(ctype_digit($enteredUsername))
    {
        $errors[] = "Username must not be numeric (can be confused with an ID)";
    }
    if(count($errors) > 0)
    {
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
 
    $enteredUsername = mysqli_real_escape_string($dbc, $enteredUsername);
    $enteredPassword = mysqli_real_escape_string($dbc, $enteredPassword);   
    $q = "SELECT NULL FROM users WHERE name = '$enteredUsername'";
    
    $u = mysqli_query($dbc, $q);
    if(!$u)
        fail();
    
    if(mysqli_num_rows($u) > 0)
    {
        $errors[] = 'Username is taken';
    }
    else
    {
        $hashedPassword = hash('sha224', $enteredPassword);
        $q = "INSERT INTO users (name, pass) VALUES ('$enteredUsername', '$hashedPassword')";
        if(mysqli_query($dbc, $q))
        {
            //Signed up successfully, redirect to login
            header('Location: /login/');
            exit();
        }
        else
        {
            $errors[] = 'Something went wrong, please try again';
        }
    }
}
