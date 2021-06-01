<!-- Begin Header -->
<?php @session_start(); ?>
<link rel="stylesheet" href="/styles/header.css"></style>
<script src="/scripts/matomo.js"></script>
<div class="header-top">
    <a href="/">
        <img src="/favicon-3.png">
        <!-- Div is for responsiveness (see style) -->
        <h1><span class="mmk">MasonMacKinnon</span>.Com<div class="toggle inline-toggle"></div></h1>
    </a>
    <div class="toggle main-toggle"></div>
    <ul>
        <li><a href="/about/">About</a></li>
        <li><a href="/projects/">Projects</a></li>
        <li><a href="/trivia/">Trivia</a></li>
        <li><a href="/misc/">Miscellany</a></li>
        <li><a href="/words/">Words</a></li>
        <li><a href="/contact/">Contact</a></li>
        <li><a href="/<?php echo isset($_SESSION['id']) ? 'user' : 'login'; ?>/">User</a></li>
    </ul>
</div>
<script src="/scripts/header.js"></script>
<!-- End Header -->
