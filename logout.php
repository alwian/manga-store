<!-- Log out function -->
<?php
session_start();
unset($_SESSION);
session_destroy();
header("Location: login.php");
exit;
