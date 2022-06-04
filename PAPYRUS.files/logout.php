<?php
// stergere cookie pentru log-out
setcookie("username", $_POST['username'], time() - 3600, "/", "", 0);

header("location: logare.php");
?>
