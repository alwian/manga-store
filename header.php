<nav class="navbar navbar-expand-lg" role="navigation">
    <div class="container">
        <a class="navbar-brand js-scroll-trigger" href="/">Manga Store</a>
        <form class="input-group-append" action="search.php" method="POST">
            <input id="form-control"
                value="<?php if (isset($value)) {echo $value;} ?>"
                name='search' type="text"
                placeholder="Search"></input>
            <span>
                <svg id="search-img" xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 0 24 24" width="24">
                    <path d="M0 0h24v24H0V0z" fill="none" />
                    <path d="M15.5 14h-.79l-.28-.27c1.2-1.4 1.82-3.31 1.48-5.34-.47-2.78-2.79-5-5.59-5.34-4.23-.52-7.79 3.04-7.27 7.27.34 2.8 2.56 5.12 5.34 5.59 2.03.34 3.94-.28 5.34-1.48l.27.28v.79l4.25 4.25c.41.41 1.08.41 1.49 0 .41-.41.41-1.08 0-1.49L15.5 14zm-6 0C7.01 14 5 11.99 5 9.5S7.01 5 9.5 5 14 7.01 14 9.5 11.99 14 9.5 14z" />
                </svg>
            </span>
        </form>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive"
            aria-controls="#navbarResponsive" aria-label="Toggle navigation">
            Menu
        </button>
        <div class="collapse navbar-collapse" id="navbarResponsive">
            <ul class="navbar-nav ml-auto">
<?php
if (isset($_SESSION['Logged']) && $_SESSION['Logged'] == true) {
    echo "<li class=\"nav-item\"><a href=\"profile.php\">Account</a></li>";
    echo "<li class=\"nav-item\"><a href=\"logout.php\">Logout</a></li>";
} else {
    echo "<li class=\"nav-item\"><a href=\"login.php\">Login</a></li>
                              <li class=\"nav-item\"><a href=\"signup.php\">Sign Up</a></li>";
}
?>

            </ul>
        </div>
    </div>
</nav>