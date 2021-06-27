<?php
    $title = 'User';
    include_once("../../includes/header.php");
    if($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['a']))
    {
        $action = $_GET['a'];
        if($action != 'visit' && $action != 'random')
            $action = '';
    }
    else
    {
        $action = '';
    }
    
    $visitingId = '';
    $visitingName = '';
    
    if($action == '' && !isset($_SESSION['id']))
    {
        $action = 'pleaseLogin';
    }
    else if($action == '')
    {
        $visitingId = $_SESSION['id'];
        $visitingName = $_SESSION['name'];
    }
    else if($action == 'visit')
    {
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
        
        $idOrName = $_GET['id-or-name'];
        $type = ctype_digit($idOrName) ? 'id' : 'name';
        $q = "SELECT id, name FROM users WHERE $type = '$idOrName'";
        
        $u = mysqli_query($dbc, $q);
        if(!$u)
            fail();
        
        if(mysqli_num_rows($u) == 1)
        {
            //Found user
            $foundUser = true;
            $row = mysqli_fetch_array($u, MYSQLI_ASSOC);
            $visitingId = $row['id'];
            $visitingName = $row['name'];
        }
        else
        {
            $foundUser = false;
        }
    }
    else if($action == 'random')
    {
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
        
        $r = mysqli_query($dbc, 'SELECT NULL FROM users');
        if(!$r)
            fail();
        
        $numUsers = mysqli_num_rows($r);
        $chosenId = rand(1, $numUsers);
        
        $q = "SELECT id, name FROM users WHERE id = '$chosenId'";
        
        $u = mysqli_query($dbc, $q);
        if(!$u)
            fail();
        
        if(mysqli_num_rows($u) == 1)
        {
            $foundUser = true;
            $row = mysqli_fetch_array($u, MYSQLI_ASSOC);
            $visitingId = $row['id'];
            $visitingName = $row['name'];
        }
    }
?>

<section class="center-items">
    <div>
        <?php if($action == 'pleaseLogin') { ?>
        <p>Please <a href="/login/">log in</a> or <a href="/signup/">sign up</a> to view your userpage.</p>
        <?php } else if($action == '') {?>
        <h1 class="center-text">User: <?php echo $visitingName; ?></h1>
        <p>You are User #<?php echo $visitingId; ?></p>
        <form id="logout-form" action="/logout/" method="POST">
            <input type="submit" value="Log Out">
        </form>
        <?php } else if($foundUser || $action == 'random') { ?>
        <h1 class="center-text">User: <?php echo $visitingName; ?></h1>
        <p><?php echo $visitingName; ?> is User #<?php echo $visitingId; ?></p>
        <?php } else { ?>
        <h1 class="center-text">User not found</h1>
        <p>The user by the name or ID of "<?php echo $_GET['id-or-name']; ?>" does not exist.</p>
        <?php } ?>
        <hr />
        <div>
            <h1>See another user</h1>
            <form id="visit-form" action="" method="GET">
                <input type="hidden" name="a" value="visit">
                <label>
                    Username or user ID:
                    <input type="text" name="id-or-name" cols="16" maxlength="16">
                </label>
                <div>
                    <input type="submit" value="Visit">
                </div>
            </form>
            <a href="/user/">See yourself</a>
            &bull;
            <a href="?a=random">See a random user</a>
        </div>
    </div>
</section>

<style>
    label
    {
        display: block;
        cursor: text;
    }
    input
    {
        background: #fff;
        border: 1px solid #000;
        border-radius: 10px;
        padding: 3px;
    }
    #logout-form,
    #visit-form div
    {
        display: flex;
        justify-content: center;
        margin: 10px 0;
    }
    input[type="submit"]
    {
        padding: 7px;
        background: #fff;
        font-size: 1.05em;
    }
    input[type="submit"]:hover
    {
        background: #eee;
    }
</style>
<?php include_once("../../includes/footer.php") ?>
