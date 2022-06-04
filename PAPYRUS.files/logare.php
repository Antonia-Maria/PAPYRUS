<?php

session_start()

?>

<html lang="en">
<head>

    <title>Logare</title>

</head>

<div style='text-align:right'>
    <i><b>
 <span style="font-size: 20px;">

     <?php
// setare sesiune
     if (isset($_SESSION['counter_logare'])) {
         $_SESSION['counter_logare'] += 1;
     } else {
         $_SESSION['counter_logare'] = 1;
     }
     $msg = "Ai vizitat aceasta pagina de " . $_SESSION['counter_logare'] . " ori.";

     echo $msg;
     ?>
 </span></div>
</i> </b>

</html>

<?php
echo "<br/><br/><br/><br/><br/>"
?>

<html>
<h1></h1></he>
<div style='text-align:center'>
    <i>
        <span style="font-size: 70px; font-family:Lucida Calligraphy"> PAPYRUS </span></div>
</i></h1>
</html>

<?php
echo "<br/><br/><br/><br/><br/>"
?>
<!-- formular log in -->
<div style='text-align:center'>
    <!DOCTYPE html>
    <html lang="en">

    <html>
    <head>
        <meta charset="utf-8">
        <title>Login</title>
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css">
    </head>
    <body>
    <div class="login">
        <h1>Login</h1>
        <form action="login.php" method="post">
            <label for="username">
                <i class="fas fa-user"></i>
            </label>
            <input type="text" name="username" placeholder="Username" id="username" required>
            <label for="password">
                <i class="fas fa-lock"></i>
            </label>
            <input type="password" name="password" placeholder="Parola" id="password" required>
            <input type="submit" value="Login">
        </form>
    </div>
    </body>

    </html>



