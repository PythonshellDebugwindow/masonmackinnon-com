<?php
    $isTLAO = $_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['t']);
    $title = $isTLAO ? 'Two Languages At Once' : 'Blog';
    include_once("../../includes/header.php")
?>
<section>
    <div>
        <?php if($isTLAO) { ?>
            <h1 class="center-text darkred">Two Languages At Once</h1>
            <p class="justify">This is a programming tutorial in which you will learn two of the computer's languages, Python and JavaScript, simultaneously, even if it doesn't learn any of yours. For a blog about programs, programming, and programming languages, see <a href="?">the Blog</a>.</p>
        <?php } else { ?>
            <h1 class="center-text darkred">Blog</h1>
            <p class="justify">This is a blog about programs, programming, and programming languages. For a programming tutorial in which you will learn two languages at once, see <a href="?t">Two Languages At Once</a>.</p>
        <?php } ?>
    </div>
    
    <div class="posts">
        <?php
            function fail()
            {
                echo '<h1>This error is Not Your Problem</h1>';
                echo '<p>Error: `' . mysqli_error($dbc) . " " . mysqli_errno($dbc) . '`</p>';
                die();
            }
            function shorten($text, $len = 50)
            {
                return substr($text, 0, $len) . '...';
            }
            
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
            
            $q = 'SELECT id, title, content, time FROM ';
            if($_SERVER['REQUEST_METHOD'] == 'GET')
            {
                if(isset($_GET['t']))
                    $q .= 'tlao';
                else
                    $q .= 'blog';
                
                $validCols = array('id', 'time');
                $validDirs = array('ASC', 'DESC');
                if(isset($_GET['scol']))
                {
                    $sortCol = strtolower($_GET['scol']);
                    if(in_array($sortCol, $validCols))
                        $q .= " ORDER BY $sortCol";
                    else
                        $q .= ' ORDER BY id';
                }
                else
                    $q .= ' ORDER BY id';
                
                if(isset($_GET['sdir']))
                {
                    $sortDir = strtoupper($_GET['sdir']);
                    if(in_array($sortDir, $validDirs))
                        $q .= " $sortDir";
                    else
                        $q .= ' ASC';
                }
                else
                    $q .= ' ASC';
            }
            else
                $q .= 'blog';
            
            $r = mysqli_query($dbc, $q);
            if(!$r)
                fail();
            while($row = mysqli_fetch_array($r, MYSQLI_ASSOC))
            {
                $newFmtDate = 'F d, Y';
                $newFmtTime = 'g:i A';
                $dt = date_create($row['time']);
                
                $timeStrDate = $dt->format($newFmtDate);
                $timeStrTime = $dt->format($newFmtTime);
                
                echo '<div class="post">';
                echo '<h2>' . $row['title'] . "</h2>";
                echo '<p>' . shorten($row['content']) . '</p>';
                echo '<p><a href="post.php?p=' . $row['id'];
                if(isset($_GET['t']))
                    echo '&t';
                echo '">Read More</a>';
                echo '<p>Post #' . $row['id'] . ' &bull; ';
                echo "$timeStrDate at $timeStrTime</p>";
                echo '</div>';
            }
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
</style>
<?php include_once("../../includes/footer.php") ?>
