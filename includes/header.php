<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="MasonMackinnon.Com - A website">
    <meta name="keywords" content="masonmackinnon,masonmackinnon.com,mason mackinnon,pythonshelldebugwindow">
    <title><?php echo "$title"; if("$title" != "") echo " | " ?>MasonMackinnon.Com</title>
    <link rel="stylesheet" href="/styles/main.css" />
    <link rel="stylesheet" href="/styles/header.css" />
    <?php
        if(isset($styles))
        {
            foreach($styles as $style)
                echo "<link rel=\"stylesheet\" href=\"$style.css\" />";
        }
    ?>
</head>
<body>
<!-- Begin Header -->
<?php @session_start(); ?>
<script src="/scripts/matomo.js"></script>
<div class="header-top">
    <a href="/">
        <img src="/favicon-3.png">
        <h1><span class="mmk">MasonMacKinnon</span>.Com<span class="toggle inline-toggle"></span></h1>
    </a>
    <div class="toggle main-toggle"></div>
    <ul>
        <li><a href="/about/">About</a></li>
        <li><a href="/blog/">Blog</a></li>
        <li><a href="/projects/">Projects</a></li>
        <li><a href="/trivia/">Trivia</a></li>
        <li><a href="/misc/">Miscellany</a></li>
        <li><a href="/contact/">Contact</a></li>
        <li><a href="/<?php echo isset($_SESSION['id']) ? 'user' : 'login'; ?>/">User</a></li>
    </ul>
</div>
<script src="/scripts/header.js"></script>
<!-- End Header -->
