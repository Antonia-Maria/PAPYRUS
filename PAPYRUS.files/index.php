<?php

$DATABASE_HOST = 'localhost';
$DATABASE_USER = 'root';
$DATABASE_PASS = '';
$DATABASE_NAME = 'papyrusdb';
// Try and connect using the info above.
$con = mysqli_connect($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);
if (mysqli_connect_errno()) {
    // If there is an error with the connection, stop the script and display the error.
    exit('Failed to connect to MySQL: ' . mysqli_connect_error());
}
session_start();

if (!isset($_COOKIE["username"])) {
    header("location:logare.php");
}

if (isset($_SESSION['counter_index'])) {
    $_SESSION['counter_index'] += 1;
} else {
    $_SESSION['counter_index'] = 1;
}
?>

<html lang="en">
<head>

    <title>HOME</title>

</head>

<div style='text-align:right; font-size: 20px;'>
    <i><b>
            <?php $msg = "Ai vizitat aceasta pagina de " . $_SESSION['counter_index'] . " ori.";
            echo $msg; ?>
</div>
</html> </b>
<div style='text-align:left'>
    <i>
        <span style="font-size: 25px; font-family:Lucida Calligraphy"> PAPYRUS </span></div>
<div style='text-align:center'><br><br>
    <span style="font-size: 20px;">
    <?php
    if (isset($_COOKIE["username"])) {
        echo "Bine ai revenit, ";
    }
    ?>
    </span>
    <span style="text-transform:uppercase; font-size: 20px;"><?php echo $_COOKIE["username"] ?></span>

    <div style='text-align:right'>
        <button type="button"><a href="http://localhost/PAPYRUS/PAPYRUS.files/logout.php">LOG OUT</a></button>
    </div>
    <div style='text-align:center'>
        <button type="button"><a href="http://papyrus.test/AdaugaDosar">ADAUGA DOSAR NOU</a></button>
    </div>
    <br><br>
    <div style='text-align:center'>
        <button type="button"><a href="http://papyrus.test/DetaliiDosar">DETALII SI EDITARE</a></button>
    </div>
    <br><br>

    <?php

    $data = null;
    $filtru = null;
    $nume = null;
    $speta = null;
    $referent = null;

    if (isset($_POST['submit_nume'])) {
        $q = $con->real_escape_string($_POST['q_nume']);

        $sql_nume = $con->query("SELECT nume FROM clienti WHERE clienti.nume LIKE '%$q%'");
        if ($sql_nume->num_rows > 0) {
            while ($data = $sql_nume->fetch_array())
                $filtru = $data['nume'];
            $nume = "clienti.nume";
        }
    } elseif (isset($_POST['submit_speta'])) {
        $q = $con->real_escape_string($_POST['q_speta']);

        $sql_speta = $con->query("SELECT problema_drept FROM dosare WHERE dosare.problema_drept LIKE '%$q%'");
        if ($sql_speta->num_rows > 0) {
            while ($data = $sql_speta->fetch_array())
                $filtru = $data['problema_drept'];
            $speta = "dosare.problema_drept";
        }
    } elseif (isset($_POST['submit_referent'])) {
        $q = $con->real_escape_string($_POST['q_referent']);


        $sql_referent = $con->query("SELECT Prenume FROM utilizatori WHERE utilizatori.Prenume LIKE '%$q%'");
        if ($sql_referent->num_rows > 0) {
            while ($data = $sql_referent->fetch_array())
                $filtru = $data['Prenume'];
            $referent = "utilizatori.Prenume";
        }
    }


    if ($filtru === null) {

        $con->select_db("papyrusdb");
        $query = "SELECT  dosare.id, clienti.nume, dosare.status, dosare.problema_drept, dosare.data_inregistrare, utilizatori.Prenume,
       dosare.status, dosare.informatii FROM dosare INNER JOIN clienti ON dosare.client_id=clienti.id INNER JOIN utilizatori
           ON dosare.user_id=utilizatori.id ORDER BY dosare.id ASC";
    } elseif ($nume === 'clienti.nume')
        $query = "SELECT  dosare.id, clienti.nume, dosare.status, dosare.problema_drept, dosare.data_inregistrare, utilizatori.Prenume,
       dosare.status, dosare.informatii FROM dosare INNER JOIN clienti ON dosare.client_id=clienti.id INNER JOIN utilizatori
           ON dosare.user_id=utilizatori.id WHERE clienti.nume='$filtru' ORDER BY dosare.id ASC";
    elseif ($speta === 'dosare.problema_drept')
        $query = "SELECT  dosare.id, clienti.nume, dosare.status, dosare.problema_drept, dosare.data_inregistrare, utilizatori.Prenume,
       dosare.status, dosare.informatii FROM dosare INNER JOIN clienti ON dosare.client_id=clienti.id INNER JOIN utilizatori
           ON dosare.user_id=utilizatori.id WHERE dosare.problema_drept='$filtru' ORDER BY dosare.id ASC";
    elseif ($referent === "utilizatori.Prenume")
        $query = "SELECT  dosare.id, clienti.nume, dosare.status, dosare.problema_drept, dosare.data_inregistrare, utilizatori.Prenume,
       dosare.status, dosare.informatii FROM dosare INNER JOIN clienti ON dosare.client_id=clienti.id INNER JOIN utilizatori
           ON dosare.user_id=utilizatori.id WHERE utilizatori.Prenume='$filtru' ORDER BY dosare.id ASC";

    else echo "Cautarea nu afiseaza niciun rezultat";

    $result = mysqli_query($con, $query) or die(mysqli_error()); ?>


    <form method="post" action="index.php">
        <input type="text" name="q_nume" placeholder="Cauta dosar dupa nume">
        <input type="submit" name="submit_nume" value="Aplica">
        <button><?php $data = null ?>Sterge cautarea</button>
        <br><br>
        <input type="text" name="q_speta" placeholder="Cauta dosar dupa speta">
        <input type="submit" name="submit_speta" value="Aplica">
        <button><?php $data = null ?>Sterge cautarea</button>
        <br><br>
        <input type="text" name="q_referent" placeholder="Cauta dosar dupa referent">
        <input type="submit" name="submit_referent" value="Aplica">
        <button><?php $data = null ?>Sterge cautarea</button>
    </form>

    <h1> DOSARE </h1>

    <style> table {
            counter-reset: row-Num -1;
        }

        table tr {

            counter-increment: row-Num;

        }

        table tr:not(:first-child) td:first-child::before {
            content: counter(row-Num) ". ";
        }</style>

    <table>

        <link rel="stylesheet" href="style.php" media="screen">

        <tr>

            <th>Nr. crt.</th>
            <th>Nume dosar</th>
            <th>Speta</th>
            <th>Referent</th>


        </tr>


        <?php foreach ($result

        as $row) { ?>
        <tr>
            <td></td>
            <td>
                <div style='text-align:center'><?php echo($row["nume"]); ?></div>
            </td>
            <td>
                <div style='text-align:center'><?php echo($row["problema_drept"]); ?></div>
            </td>
            <td>
                <div style='text-align:center'><?php echo($row["Prenume"]); ?></div>
            </td>
            <?php } ?>

        </tr>
    </table>
