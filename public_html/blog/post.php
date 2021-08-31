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
                echo '<br /><p class="pid">Post #' . $id . ' &bull; ';
                echo "$timeStrDate at $timeStrTime</p>";
            }
            
            echo '<div id="post-links">';
            if($foundPost)
            {
                if($id > 1)
                {
                    echo '<a id="left" href="post.php?p=' . ($id - 1);
                    if($isTLAO)
                        echo '&t';
                    echo '"><img class="arrow" src="../images/arrow-left.png">';
                    echo 'Previous</a>';
                }
                $id = $_GET['p'];
                $db = $isTLAO ? 'tlao' : 'blog';
                $q = "SELECT null FROM $db";
                $r = mysqli_query($dbc, $q);
                if($r && $id < mysqli_num_rows($r))
                {
                    echo '<a id="right" href="post.php?p=' . ($id + 1);
                    if($isTLAO)
                        echo '&t';
                    echo '">Next';
                    echo '<img class="arrow" src="../images/arrow-right.png">';
                    echo '</a>';
                }
            }
            
            $u = '/blog/';
            if($isTLAO)
                $u .= '?t';
            
            echo '<a id="back" href="' . $u . '">';
            echo '<img class="arrow" src="../images/arrow-left.png">';
            echo 'Go Back</a>';
            echo '</div>';
        ?>
    </div>
</section>

<script>
    function makeToggleClass(el)
    {
        return function()
        {
            var cl = el.className;
            if(el.className.split(" ").indexOf("active") > 0)
                el.className = el.className.replace("active", "");
            else
                el.className = el.className + " active";
        }
    }
    var split = document.getElementsByClassName("split");
    var children;
    for(var i = 0; i < split.length; ++i)
    {
        children = split[i].children;
        for(var j = 0; j < children.length; ++j)
        {
            children[j].onclick = makeToggleClass(children[j]);
        }
    }
</script>

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
        flex-direction: column;
        width: 100%;
        /*border: 1px solid #000;*/
        padding: 20px 10px;
    }
    .split > div
    {
        background: #f9f9f9;
        padding: 20px 10px;
        margin: 10px 0;
        width: 100%;
        height: 0;
        overflow-y: hidden;
    }
    .split > div::before,
    .split > div::after
    {
        display: -moz-inline-block;
        display: inline-block;
        -o-transform: translateY(-50%);
        -moz-transform: translateY(-50%);
        -webkit-transform: translateY(-50%);
        transform: translateY(-50%);
        font-size: 1.2em;
    }
    .split > div.active
    {
        height: initial;
    }
    .split > div:nth-child(1)::before
    {
        content: 'Python \02C5';
    }
    .split > div.active:nth-child(1)::before
    {
        content: 'Python \02C4';
    }
    .split > div:nth-child(2)::before
    {
        content: 'JavaScript \02C5';
    }
    .split > div.active:nth-child(2)::before
    {
        content: 'JavaScript \02C4';
    }
    .split > div.mb:nth-child(2)::before
    {
        content: 'Malbolge \02C5';
    }
    .split > div.mb.active:nth-child(2)::before
    {
        content: 'Malbolge \02C4';
    }
    .split > div span
    {
        display: block;
        font-size: 1.2em;
        margin-bottom: 10px;
    }
    
    .post pre,
    .post code
    {
        font-family: "Courier New", "Courier", monospace;
        background: #eee;
    }
    .post pre
    {
        display: block;
        padding: 10px;
    }
    .post code
    {
        padding: 2px;
        font-size: 0.9em;
    }
    .post hr
    {
        margin: 1em 0;
    }
    table
    {
        border-collapse: collapse;
        border-spacing: 0;
    }
    table thead td
    {
        font-weight: bold;
    }
    table td
    {
        border: 1px solid rgba(1,1,1,0.5);
        padding: 5px;
    }
    .pid
    {
        margin-bottom: 5px;
    }
    .arrow
    {
        height: 0.8em;
        margin-right: 5px;
    }
    #post-links
    {
        position: relative;
        padding: 30px 0;
    }
    #post-links a
    {
        position: absolute;
        font-size: 1.1em;
    }
    #left
    {
        left: 0;
    }
    #left .arrow
    {
        margin-right: 10px;
    }
    #right
    {
        right: 0;
    }
    #right .arrow
    {
        margin-left: 10px;
    }
    #back
    {
        left: 50%;
        -o-transform: translate(-50%, -50%);
        -ms-transform: translate(-50%, -50%);
        -moz-transform: translate(-50%, -50%);
        -webkit-transform: translate(-50%, -50%);
        transform: translate(-50%, -50%);
    }
    #back .arrow
    {
        display: block;
        left: 50%;
        -o-transform: translate(50%, -50%) rotate(90deg);
        -ms-transform: translate(50%, -50%) rotate(90deg);
        -moz-transform: translate(50%, -50%) rotate(90deg);
        -webkit-transform: translate(50%, -50%) rotate(90deg);
        transform: translate(50%, -50%) rotate(90deg);
        margin-bottom: 10px;
    }
    @media (max-width: 1991px)
    {}
</style>
<?php include_once('../../includes/footer.php'); ?>
