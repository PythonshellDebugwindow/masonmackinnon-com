<?php
    function fail()
    {
        $title = 'Error | Blog';
        include_once('../../includes/header.php');
        
        echo '<h1>This error is not your problem</h1>';
        echo '<p>Error: `' . mysqli_error($dbc) . " " . mysqli_errno($dbc) . '`</p>';
        die();
    }
    
    function nopost()
    {
        global $foundPost, $ptitle, $pcontent;
        $foundPost = false;
        $ptitle = 'Post Not Found';
        $pcontent = 'The specified post could not be found. Is there a typo?';
    }
    
    if($_SERVER['REQUEST_METHOD'] != 'GET')
        nopost();
    else if(!isset($_GET['p']) || !ctype_digit($_GET['p']))
        nopost();
    else
    {
        require('../../connect_db.php');
        $dbc = connect();
        if(mysqli_connect_errno())
        {
            echo 'Failed to connect to MySQL: ' . mysqli_connect_error();
            die();
        }
        
        $r = mysqli_query($dbc, 'USE masonmackinnon');
        if(!$r)
            fail();
        
        $id = $_GET['p'];
        $db = isset($_GET['t']) ? 'tlao' : 'blog';
        $q = "SELECT title, content, time FROM $db WHERE id = $id";
        $r = mysqli_query($dbc, $q);
        if(!$r)
            fail();
        
        if(mysqli_num_rows($r) == 0)
            nopost();
        else
        {
            $foundPost = true;
            
            $row = mysqli_fetch_array($r, MYSQLI_ASSOC);
            $ptitle = $row['title'];
            $pcontent = $row['content'];
            
            $newFmtDate = 'F d, Y';
            $newFmtTime = 'g:i A';
            $dt = date_create($row['time']);
            
            $timeStrDate = $dt->format($newFmtDate);
            $timeStrTime = $dt->format($newFmtTime);
        }
    }
    
    $isTLAO = $_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['t']);
    $b = ($isTLAO ? 'Two Languages At Once' : 'Blog');
    $title = "$ptitle | $b";
    include_once('../../includes/header.php');
?>
<section>
    <div>
        <h1 class="center-text darkred"><?php echo $ptitle; ?></h1>
    </div>
    
    <div class="posts">
        <?php
            echo '<div class="post">';
            // echo '<h2>' . $ptitle . "</h2>";
            echo '<p>' . $pcontent . '</p>';
            echo '</div>';
            
            if($foundPost)
            {
                echo '<br /><p>Post #' . $id . ' &bull; ';
                echo "$timeStrDate at $timeStrTime</p>";
            }
            
            $u = '/blog/';
            if($isTLAO)
                $u .= '?t';
            echo '<a href="' . $u . '">';
            echo '<img class="arrow" src="../images/arrow-left.png">Go Back</a>';
        ?>
    </div>
</section>

<style>
    .post
    {
        padding: 15px;
    }
    .post h2
    {
        font-size: 1.8em;
        font-weight: 600;
    }
    .post p
    {
        white-space: pre-wrap;
        text-align: justify;
    }
    .split
    {
        display: flex;
        justify-content: space-between;
        /*width: 50%;*/
        /*border: 1px solid #000;*/
        background: #f9f9f9;
        padding: 20px 10px;
        margin: 10px 0;
    }
    .split > div
    {
        padding: 20px 10px;
        width: 50%;
    }
    .split > div span
    {
        display: block;
        font-size: 1.2em;
        margin-bottom: 10px;
    }
    .split > div:nth-child(1)
    {
        border-right: 1px solid #000;
    }
    pre
    {
        display: block;
        font-family: "Courier New", "Courier", monospace;
        padding: 10px;
        background: #eee;
    }
    .arrow
    {
        height: 0.8em;
        margin-right: 5px;
    }
</style>
<?php include_once('../../includes/footer.php'); ?>
