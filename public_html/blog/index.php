<?php
    $title = 'Blog';
    include_once("../../includes/header.php")
?>
<section>
    <div>
        <h1 class="center-text darkred">Blog</h1>
        <p class="justify">This is a blog about programs, programming, and programming languages. For a programming tutorial, see <a href="two.php">2LAO</a>.</p>
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
            
            $q = 'SELECT id, title, content, time FROM blog';
            if($_SERVER['REQUEST_METHOD'] == 'GET')
            {
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
                echo '<p><a href="post.php?p=' . $row['id'] . '">Read More</a>';
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
