<?php
    $title = 'Log In';
    include_once("../../includes/header.php");
    require_once("action.php");
?>
<section class="center-items full-page">
    <div>
        <?php
            if(count($missing) > 0)
            {
                echo '<h3>Please enter</h3>';
                echo '<ul style="list-style-position: inside">';
                foreach($missing as $item)
                    echo "<li>$item</li>";
                echo '</ul>';
            }
        ?>
        <h1 class="center-text">Log In</h1>
        <p>This is not necessary, but some data (such as scores for <a href="/projects/">games</a>) can be stored in accounts.</p>
        <form method="POST" action="/login/">
            <label>
                Username:
                <input type="text" name="name" cols="16" maxlength="16" value="<?php echo $submitted ? $enteredUsername : ''; ?>">
            </label>
            <label>
                Password:
                <input type="password" name="pass" value="<?php echo $submitted ? $enteredPassword : ''; ?>">
            </label>
            <input type="submit" value="Log In">
        </form>
        <h2 class="center-text">Don&#39;t have an account?</h2>
        <p><a href="/signup/">Sign up</a>.</p>
    </div>
</section>

<style>
    label
    {
        display: block;
        padding: 3px;
        cursor: text;
    }
    input
    {
        border: 1px solid #000;
        border-radius: 20px;
    }
    label input
    {
        padding: 3px;
    }
    input[type="submit"]
    {
        padding: 10px;
        background: #fff;
        font-size: 1.05em;
    }
    input[type="submit"]:hover
    {
        background: #eee;
    }
</style>
<?php include_once("../../includes/footer.php") ?>
