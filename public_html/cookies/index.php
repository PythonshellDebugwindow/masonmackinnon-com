<?php
    $title = 'Cookies';
    include_once("../../includes/header.php")
?>
<section>
    <div>
        <h1 class="center-text darkred">Cookies</h1>
        <p class="justify">
            This site uses cookies for analytical purposes (records number of visitors, actions per visit, etc). Click <button id="tc">here</button> to toggle them. They are currently <span id="hc"></span><noscript>disabled because JavaScript is disabled.</noscript>. (Note: Disabling cookies will leave one cookie in localStorage, <tt>hasCookies</tt>, to remember your preference. Browse without JavaScript to disable it.)
        </p>
    </div>
</section>

<script>
    document.getElementById("tc").onclick = function()
    {
        //useCookies is the name
        if(!localStorage)
        {
            document.cookie = "";
            document.getElementById("hc").innerHTML = "disabled (needs localStorage to enable)";
            return;
        }
        var hasCookies = localStorage.getItem("useCookies") !== "No";
        var newHasCookies = hasCookies ? "No" : "Yes";
        if(!hasCookies)
        {
            document.cookie = "";
            localStorage.clear();
        }
        var hasCookiesMsg = newHasCookies === "Yes" ? "enabled" : "disabled";
        localStorage.setItem("useCookies", newHasCookies);
        document.getElementById("hc").innerHTML = hasCookiesMsg;
    };
    if(localStorage)
    {
        var hasCookies = localStorage.getItem("useCookies") !== "No";
        var hasCookiesMsg = hasCookies ? "enabled" : "disabled";
        document.getElementById("hc").innerHTML = hasCookiesMsg;
    }
</script>
<?php include_once("../../includes/footer.php") ?>
