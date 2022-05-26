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

if (isset($_SESSION['counter_editaredosar'])) {
    $_SESSION['counter_editaredosar'] += 1;
} else {
    $_SESSION['counter_editaredosar'] = 1;
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
    <?php $msg = "Ai vizitat aceasta pagina de " . $_SESSION['counter_editaredosar'] . " ori.";
    echo $msg;
    ?>
</div>
</html> </b>
<div style='text-align:left'>
    <i>
        <span style="font-size: 25px; font-family:Lucida Calligraphy"> PAPYRUS </span></div>
<div style='text-align:center'><br><br>
    <span style="font-size: 20px;">
<span style="font-size: 15px; text-align: center;"><h1> Detalii suplimentare si actiuni </h1></span>
<br><br><br><br>




        <table border="1"style='text-align:center'>



<tr>
    <td>id</td>
    <td>Nume</td>
    <td>problema_drept</td>
    <td>data_inregistrare</td>
    <td>Prenume</td>
    <td>Status</td>
    <td>informatii</td>
</tr>
            @foreach($dosare as $dosar)
                <tr>
    <td>{{$dosar['id']}}</td>
    <td>{{$dosar['nume']}}</td>
    <td>{{$dosar['problema_drept']}}</td>
    <td>{{$dosar['data_inregistrare']}}</td>
    <td>{{$dosar['status']}}</td>
    <td>{{$dosar['informatii']}}</td>
    <td>{{$dosar['Prenume']}}</td>
                    <td><a href={{"Editare/".$dosar['id']}}>Editare</a></td>
                    <td><a href={{"Stergere/".$dosar['id']}}>Stergere</a></td>
</tr>

            @endforeach


        </table>
