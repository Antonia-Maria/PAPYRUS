<?php

session_start();
// este setata conexiunea la baza de date
require "database_connection.php";
// se verifica daca este setat cookie; daca da - redirectionare catre index
if (isset($_COOKIE["username"])) {
    header("location:index.php");


}
// se verifica daca sunt completate campurile pentru logare
if (!isset($_POST['username'], $_POST['password'])) {
    // daca nu, mesaj pentru completare
    exit('Please fill both the username and password fields!');
}

/** @var  $con */
if ($stmt = $con->prepare('SELECT id, Parola FROM utilizatori WHERE username = ?')) {

    $stmt->bind_param('s', $_POST['username']);
    $stmt->execute();
    // Se pastreaza rezultatul, pentru a se verifica daca exista contul in baza de date
    $stmt->store_result();
    if ($stmt->num_rows > 0) {
        $stmt->bind_result($id, $password);
        $stmt->fetch();
        // S-a verificat existenta contului, acum se verifica parola
        if ($_POST['password'] === $password) {
            setcookie("username", $_POST['username'], time() + 3600, "/", "", 0);
            header("location: index.php");
            // Utilizatorul s-a logat cu succes
            // Sunt create cookie-uri, pentru a fi recunoscut utilizatorul dupa logare
        } else {
            // Pop-out message pentru parola incorecta
            echo '<script type="text/javascript">alert("Parola incorecta");history.go(-1);</script>';
        }
    } else {
        // Pop-out message pentru Username incorect
        echo '<script type="text/javascript">alert("Username incorect");history.go(-1);</script>';
    }

    $stmt->close();
}

?>
