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
            padding: 7px;
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
