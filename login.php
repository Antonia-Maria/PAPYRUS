<?php

session_start();
// Change this to your connection info.
require "database_connection.php";

if(isset($_COOKIE["username"])){
    header("location:index.php");


}
if ( !isset($_POST['username'], $_POST['password']) ) {
    // Could not get the data that should have been sent.
    exit('Please fill both the username and password fields!');
}

/** @var  $con */
if ($stmt = $con->prepare('SELECT id, Parola FROM utilizatori WHERE username = ?')) {
    // Bind parameters (s = string, i = int, b = blob, etc), in our case the username is a string so we use "s"
    $stmt->bind_param('s', $_POST['username']);
    $stmt->execute();
    // Store the result so we can check if the account exists in the database.
    $stmt->store_result();
    if ($stmt->num_rows > 0) {
        $stmt->bind_result($id, $password);
        $stmt->fetch();
        // Account exists, now we verify the password.
        // Note: remember to use password_hash in your registration file to store the hashed passwords.
        if ($_POST['password'] === $password) {
            setcookie("username", $_POST['username'], time() + 3600, "/", "", 0);
            header ("location: index.php");
            // Verification success! User has logged-in!
            // Create sessions, so we know the user is logged in, they basically act like cookies but remember the data on the server.
        } else {
            // Incorrect password
            echo '<script type="text/javascript">alert("Parola incorecta");history.go(-1);</script>';
        }
    } else {
        // Incorrect username
        echo '<script type="text/javascript">alert("Username incorect");history.go(-1);</script>';
    }

    $stmt->close();
}

?>
