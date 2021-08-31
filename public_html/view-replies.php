<?php
    $title = 'View Replies';
    include_once("../includes/header.php");
?>
<script src="https://www.google.com/recaptcha/api.js?render=reCAPTCHA_site_key"></script>
<section>
    <h1 class="center-text">View Replies</h1>
    <?php
        if(!isset($_GET['cid']))
        {
            echo '<h3>Error: Could not view replies of no comment</h3>';
            echo '<h4>Please select a comment to view the replies of.</h4></section>';
            require_once('../includes/footer.php');
            exit();
        }
        
        require_once('../connect_db.php');
        $dbc = connect();
        
        if(mysqli_connect_errno())
        {
            echo 'Could not load replies: Could not connect to database';
            goto endComments;
        }
        
        $r = mysqli_query($dbc, 'USE masonmackinnon');
        if(!$r)
        {
            echo "Could not load replies: Could not connect to database";
            goto endComments;
        }
        
        $cid = mysqli_real_escape_string($dbc, $_GET['cid']);
        $r = mysqli_query($dbc, "SELECT user_id, content, date FROM comments WHERE id = '$cid'");
        if(!$r)
        {
            echo 'Could not load replies: Could not fetch requested comment';
            goto endComments;
        }
        if(mysqli_num_rows($r) !== 1)
        {
            echo 'Could not load replies: Requested comment does not exist';
            goto endComments;
        }
        $row = mysqli_fetch_array($r, MYSQLI_ASSOC);
        $ur = mysqli_query($dbc, "SELECT name FROM users WHERE id = '${row['user_id']}'");
        echo '<div class="comment">';
        echo $row['content'];
        echo '</div>';
        if($ur && mysqli_num_rows($ur) > 0)
            echo mysqli_fetch_array($ur, MYSQLI_ASSOC)['name'] . ' &bull; ';
        echo $row['date'];
        
        $r = mysqli_query($dbc, "SELECT id, user_id, content, date, num_replies FROM comments WHERE reply_to = '$cid'");
        if(!$r)
        {
            echo 'Could not load replies: Could not fetch replies';
            goto endComments;
        }
        
        while($row = mysqli_fetch_array($r, MYSQLI_ASSOC))
        {
            $ur = mysqli_query($dbc, "SELECT name FROM users WHERE id = '${row['user_id']}'");
            echo '<div class="reply"><div class="comment"><p>';
            echo $row['content'] . '</p>';
        
            echo '<a href="view-replies.php?cid=' . $row['id'] . '" target="_blank">';
            $yies = $row['num_replies'] === '1' ? 'y' : 'ies';
            if($row['num_replies'] !== '0')
                echo "View ${row['num_replies']} repl$yies</a>";
            else
                echo "Reply</a>";
            
            echo '</div>';
            if($ur && mysqli_num_rows($ur) > 0)
                echo mysqli_fetch_array($ur, MYSQLI_ASSOC)['name'] . ' &bull; ';
            echo $row['date'];
            echo '</div>';
        }
    ?>
    <form method="POST" action="/add_comment.php">
        <h3>Add a reply</h3>
        <textarea id="content-ta" name="content" oninput="checkRemaining();"></textarea>
        <p><span id="remaining-s">0</span>/256</p>
        <input type="hidden" name="origin" value="<?php echo $_SERVER['REQUEST_URI']; ?>">
        <input type="hidden" name="replyto" value="<?php echo $cid; ?>">
        <input type="submit" value="Submit">
    </form>
    <script>
        var contentTA = document.getElementById("content-ta");
        var remainingS = document.getElementById("remaining-s");
        function checkRemaining()
        {
            if(contentTA.value.length > 256)
                contentTA.value = contentTA.value.substring(0, 256);
            remainingS.innerHTML = contentTA.value.length;
        }
    </script>
    <?php
        endComments:
    ?>
</section>
<style>
    footer
    {
        margin: 0;
        padding: 0;
    }
    .reply
    {
        margin-left: 50px;
    }
</style>
<?php include_once('../includes/footer.php') ?>
