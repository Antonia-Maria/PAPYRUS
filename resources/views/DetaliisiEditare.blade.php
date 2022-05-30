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

if (isset($_SESSION['counter_detaliisieditaredosar'])) {
    $_SESSION['counter_detaliisieditaredosar'] += 1;
} else {
    $_SESSION['counter_detaliisieditaredosar'] = 1;
}
?>

<html lang="en">
<head>

    <title>Detalii Dosare</title>
    <style>table {
            margin-left: auto;
            margin-right: auto;
        }</style>
</head>

<div style='text-align:right; font-size: 20px;'>
    <i><b>
    <?php $msg = "Ai vizitat aceasta pagina de " . $_SESSION['counter_detaliisieditaredosar'] . " ori.";
    echo $msg;
    ?>
</div>

</html> </b>
<div style='text-align:left'>
    <i>
        <span style="font-size: 25px; font-family:Lucida Calligraphy"> PAPYRUS </span></div>
<div style='text-align:center'><br><br>
    <span style="font-size: 20px;">
     <div style='text-align:right'>
    <button type="button"><a href="http://localhost/PAPYRUS/PAPYRUS.files/logout.php">LOG OUT</a></button>
</div><br>
                <div style='text-align:right'>
    <button type="button"><a href="http://localhost/PAPYRUS/PAPYRUS.files/index.php">HOME</a></button>
</div>


<span style="font-size: 15px; text-align: center;"><h1> Detalii suplimentare si actiuni </h1></span>
<br><br>

        <style> table {
            counter-reset: row-Num -1;
        }

        table tr {

            counter-increment: row-Num;

        }
    table tr:not(:first-child) td:first-child::before{
        content: counter(row-Num)". ";
    }</style>


        <table border="1" style='text-align:center'>


<tr>
    <th>Nr. crt.</th>
    <th>ID Dosar</th>
    <th>Nume Dosar</th>
    <th>Speta</th>
    <th>Data Inregistrare</th>
    <th>Status</th>
    <th>Informatii</th>
    <th>Referent</th>
    <th>Actiuni</th>
</tr>
            @foreach($dosare as $dosar)
                <tr>
    <td> </td>

    <td>{{$dosar['nume']}}</td>
    <td>{{$dosar['problema_drept']}}</td>
    <td>{{$dosar['data_inregistrare']}}</td>
    <td>{{$dosar['status']}}</td>
    <td>{{$dosar['informatii']}}</td>
    <td>{{$dosar['Prenume']}}</td>
                    <td><button><a href={{"Editare/".$dosar['id']}}>Editare</a></button>
                        <button><a href={{"Stergere/".$dosar['id']}}>Stergere</a></button></td>

</tr>

            @endforeach


        </table>
