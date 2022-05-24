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
        <button type="button"><a href="logout.php">LOG OUT</a></button>
    </div>
    <div style='text-align:center'>
        <button type="button"><a href="AdaugaDosar.blade.php">ADAUGA DOSAR NOU</a></button>
    </div>

    <br><br><br>

    <?php

    $data = null;
    $filtru = null;
    if (isset($_POST['submit'])) {
        $q = $con->real_escape_string($_POST['q']);
        $column = $con->real_escape_string($_POST['column']);

        if ($column == "" || ($column != "nume" && $column != "Prenume" && $column != "data_inregistrare" && $column != "problema_drept"))
            $column = "nume";

        $sql = $con->query("SELECT nume FROM clienti WHERE $column LIKE '%$q%'");
        if ($sql->num_rows > 0) {
            while ($data = $sql->fetch_array())
                $filtru = $data['nume'];
        } else
            echo "Cautarea nu afiseaza niciun rezultat";
    }

    if ($filtru === null) {

        $con->select_db("papyrusdb");
        $query = "SELECT  clienti.nume, dosare.status, dosare.problema_drept, dosare.data_inregistrare, utilizatori.Prenume,
       dosare.status, dosare.informatii FROM dosare INNER JOIN clienti ON dosare.client_id=clienti.id INNER JOIN utilizatori
           ON dosare.user_id=utilizatori.id ORDER BY dosare.id ASC";
    } else
        $query = "SELECT  clienti.nume, dosare.status, dosare.problema_drept, dosare.data_inregistrare, utilizatori.Prenume,
       dosare.status, dosare.informatii FROM dosare INNER JOIN clienti ON dosare.client_id=clienti.id INNER JOIN utilizatori
           ON dosare.user_id=utilizatori.id WHERE clienti.nume='$filtru' ORDER BY dosare.id ASC";


    $result = mysqli_query($con, $query) or die(mysqli_error()); ?>


    <form method="post" action="index.php">
        <input type="text" name="q" placeholder="Cauta dosar...">
        <select name="column">
            <option value="">Alege filtru</option>
            <option value="nume">Nume dosar</option>
        </select>
        <input type="submit" name="submit" value="Aplica">
        <button><?php $data = null ?>Sterge cautarea</button>
    </form>

    <h1> DOSARE </h1>

    <table>
        <style> table {
                counter-reset: rowNumber;
            }

            table tr::before {
                display: table-cell;
                counter-increment: rowNumber;
                content: counter(rowNumber) ".";
                padding-right: 0.3em;
                text-align: right;
            } </style>
        <link rel="stylesheet" href="style.php" media="screen">

        <tr>

            <th>Nr. crt.</th>
            <th>Nume dosar</th>
            <th>Speta</th>
            <th>Data inregistrare</th>
            <th>Referent</th>
            <th>Status</th>
            <th>Mai multe actiuni</th>
        </tr>


        <?php foreach ($result

        as $row) { ?>
        <tr>
            <td>  </td>
            <td><div style='text-align:center'><?php echo($row["nume"]); ?></div></td>
            <td><div style='text-align:center'><?php echo($row["problema_drept"]); ?></div></td>
            <td><div style='text-align:center'><?php echo($row["data_inregistrare"]); ?></div></td>
            <td><div style='text-align:center'><?php echo($row["Prenume"]); ?></div></td>
            <td><div style='text-align:center'><?php echo($row["status"]); ?></div></td>
            <td><div style='text-align:center'><form action="VizualizareDosar" method="GET" > <button type="submit">Vizualizare Dosar</button></form>
                <form action="Editare Dosar" method="GET" ><button type="submit">Editare Dosar</button></form>
                    <form action="Stergere Dosar" method="GET" > <button type="submit">Stergere Dosar</button></form></div>
                     <?php } ?> </td>

        </tr>
    </table>
