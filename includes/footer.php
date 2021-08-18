<!-- Comments -->
<section class="comments">
    <h2>Comments</h2>
    <div>
        <?php
            if(isset($_GET['acf']))
                echo '<h4>Error: Could not add comment</h4>';
            
            if(!in_array("home/ymyri0wen43m/connect_db.php", get_included_files()))
            {
                include_once('/home/ymyri0wen43m/connect_db.php');
                $dbc = connect();
            }
            
            if(mysqli_connect_errno())
            {
                echo 'Could not load comments';
                goto endComments;
            }
            
            $r = mysqli_query($dbc, 'USE masonmackinnon');
            if(!$r)
            {
                echo "Could not load comments";
                goto endComments;
            }
            
            function endsWith($haystack, $needle)
            {
                $length = strlen($needle);
                if(!$length) return true;
                return substr($haystack, -$length) === $needle;
            }
            
            $pageloc = mysqli_real_escape_string($dbc, $_SERVER['REQUEST_URI']);
            $pageloc = strtok($pageloc, '?'); //Remove GET arguments
            $pageloc = strtok($pageloc, '#'); //Remove fragment identifier
            if(endswith($pageloc, 'index.php')) $pageloc = substr($pageloc, 0, -9); //Remove index.php
            $r = mysqli_query($dbc, 'SELECT id, user_id, content, date, num_replies FROM comments WHERE location = "' . $pageloc . '" AND reply_to = 0');
            if(!$r)
            {
                echo "Could not load comments";
                goto endComments;
            }
            
            while($row = mysqli_fetch_array($r, MYSQLI_ASSOC))
            {
                $ur = mysqli_query($dbc, 'SELECT name FROM users WHERE id = ' . $row['user_id']);
                echo '<div class="comment"><p>';
                echo $row['content'] . '</p>';
                if($row['num_replies'] !== "0")
                {
                    echo '<a href="/view-replies.php?cid=' . $row['id'] . '" target="_blank">';
                    echo "View ${row['num_replies']} replies</a>";
                }
                echo '<form method="POST" action="/add_comment.php">
                    <h4>Reply</h4>
                    <textarea class="content-ta-r" name="content" oninput="checkRemaining(this);"></textarea>
                    <p><span class="remaining-s-r"><noscript>Please enable JavaScript</noscript></span>/256</p>
                    <input type="hidden" name="origin" value="' . $pageloc . '">
                    <input type="hidden" name="replyto" value="' . $row['id'] . '">
                    <input type="submit" value="Submit">
                </form>';
                echo '</div>';
                if($ur && mysqli_num_rows($ur) > 0)
                    echo mysqli_fetch_array($ur, MYSQLI_ASSOC)['name'] . ' &bull; ';
                echo $row['date'];
            }
        ?>
        <form method="POST" action="/add_comment.php">
            <h3>Add a comment</h3>
            <textarea id="content-ta" name="content" oninput="checkRemaining();"></textarea>
            <p><span id="remaining-s"><noscript>Please enable JavaScript</noscript></span>/256</p>
            <input type="hidden" name="origin" value="<?php echo $pageloc; ?>">
            <input type="hidden" name="replyto" value="0">
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
            remainingS.innerHTML = 0;
        </script>
        <?php
            endComments:
        ?>
    </div>
</section>
<!-- Begin Footer -->
<footer>
    <div class="container">
        <div class="sec quicklinks">
            <h2>Quick Links</h2>
            <ul>
                <li><a href="/about/">About</a></li>
                <li><a href="/blog/">Blog</a></li>
                <li><a href="/blog/?t">Two Languages At Once</a></li>
                <li><a href="/projects/">Projects</a></li>
                <li><a href="/trivia/">Trivia</a></li>
                <li><a href="/misc/">Miscellany</a></li>
                <li><a href="/cookies/">Cookies</a></li>
                <li><a href="/contact/">Contact</a></li>
                <li><?php
                    if(!isset($_SESSION['id']))
                    {
                        ?><a href="/login/">Log In</a> / <a href="/signup/">Sign Up</a><?php
                    }
                    else
                    {
                        ?><a href="/user/">Userpage</a><?php
                    }
                ?></li>
            </ul>
        </div>
        <div class="sec contactme">
            <h2>Con<wbr />tact Me</h2>
            <ul>
                <li>
                    <span>123 Fake Street<br />
                    Canada City, Canada, Earth</span>
                </li>
                <li>
                    <span><img src="/images/phone.png" alt="Phone"></span>
                    <a href="tel:+1555-555-0123">+1 (555) 555-0123</a>
                </li>
                <li>
                    <span><img src="/images/envelope.png" alt="Email"></span>
                    <a href="mailto:pythonshelldebugwindow@gmail.com" rel="noopener noreferrer">Email Me</a>
                </li>
                <li>
                    <span><img src="/images/book.png" alt="Contact"></span>
                    <a href="/contact/">Con<wbr />tact Page</a>
                </li>
            </ul>
        </div>
        <div class="sec aboutthis">
            <h2>About This</h2>
            <p>This is the website of me, Mason MacKinnon. For more information, see the <a href="/about/">About page</a>.</p>
        </div>
        <div class="sec copywrong">
            <h2>License</h2>
            <p>Do whatever you want with <a href="https://github.com/PythonshellDebugwindow/masonmackinnon-com">the code</a>. Mason<wbr />Mac<wbr />Kinnon.Com has no warranty. This site is by Mason MacKinnon 2021-<?php echo date("Y"); ?>.</p>
        </div>
    </div>
</footer>
<style>
    footer
    {
        position: relative;
        box-sizing: border-box;
        width: 100%;
        height: auto;
        padding: 50px;
        background: #eee;
        display: flex;
        justify-content: space-between;
        flex-wrap: wrap;
    }
    footer .container
    {
        display: flex;
        justify-content: space-between;
        flex-wrap: wrap;
        flex-direction: row;
    }
    footer .container .sec
    {
        padding: 0 20px;
        /*margin-right: 30px;*/
    }
    footer .container .aboutthis
    {
        width: 40%;
    }
    footer .container h2
    {
        position: relative;
        font-weight: 500;
        margin-bottom: 15px;
    }
    footer .container h2::before
    {
        content: '';
        position: absolute;
        bottom: -5px;
        left: 0;
        width: 100%;
        height: 2px;
        background: #aaa;
    }
    footer p
    {
        color: #333;
    }
    footer .container .quicklinks
    {
        /*position: relative;*/
        /*width: 25%;*/
    }
    footer .quicklinks ul
    {
        margin-top: 20px;
    }
    footer .quicklinks ul li
    {
        list-style: none;
    }
    footer .quicklinks ul li a
    {
        font-variant: small-caps;
        margin-bottom: 10px;
        display: inline-block;
    }
    footer .quicklinks ul li a:hover
    {
        color: #333;
    }
    footer .container .contactme
    {
        /*width: calc(35% - 60px);*/
    }
    footer .container .contactme ul
    {
        position: relative;
    }
    footer .container .contactme ul li
    {
        display: flex;
        margin-bottom: 16px;
    }
    footer .container .contactme ul li img
    {
        width: 1em;
        height: 1em;
        margin-right: 0.5em;
    }
    
    footer .container .copywrong
    {
        /*max-width: 40%;*/
    }
    footer .container .copywrong p span
    {
        padding: 0.2em;
        font-size: 0.9em;
        border: 1px solid #000;
        border-radius: 50%;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        flex-direction: column;
        width: 1em;
    }
    footer .container .copywrong p span::after
    {
        content: '';
        width: 2em;
        height: 0;
        border-bottom: 1px solid #000;
        transform: translateY(-7px) rotate(315deg);
    }
    .comment
    {
        padding: 15px 15px 0;
    }
    
    @media (max-width: 399px)
    {
        footer
        {
            padding: 25px;
        }
    }
    @media (max-width: 358px)
    {
        footer
        {
            padding: 21px 7px;
        }
        footer .container .quicklinks ul
        {
            margin-top: 5px;
        }
        footer .quicklinks ul li a
        {
            margin-bottom: 5px;
        }
        footer .container .contactme ul li
        {
            margin-bottom: 8px;
        }
    }
</style>
</body>
</html>
