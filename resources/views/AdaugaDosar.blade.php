<?php

//blade afisat din butonul Adauga Dosar din index
$DATABASE_HOST = 'localhost';
$DATABASE_USER = 'root';
$DATABASE_PASS = '';
$DATABASE_NAME = 'papyrusdb';
// conectare la baza de date
$con = mysqli_connect($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);
// In caz de eroare la conexiune, returneaza mesajul:
if (mysqli_connect_errno()) {

    exit('Failed to connect to MySQL: ' . mysqli_connect_error());
}
session_start();
// verifica daca este setat cookie; daca nu este, redirectioneaza catre pagina de logare
if (!isset($_COOKIE["username"])) {
    header("location:logare.php");
}
// verifica daca este setata sesiunea
if (isset($_SESSION['counter_adaugadosar'])) {
    $_SESSION['counter_adaugadosar'] += 1;
} else {
    $_SESSION['counter_adaugadosar'] = 1;
}
$query_nume = "SELECT nume FROM clienti ORDER BY nume ASC";
$query_Prenume = "SELECT Prenume FROM utilizatori ORDER BY Prenume ASC";
$query_Speta = "SELECT problema_drept FROM dosare";
$result_nume = mysqli_query($con, $query_nume) or die(mysqli_error());
$result_Prenume = mysqli_query($con, $query_Prenume) or die(mysqli_error());
$result_Speta = mysqli_query($con, $query_Speta) or die(mysqli_error());
?>

<html lang="en">
<head>

    <title>Adauga Dosar</title>

</head>

<div style='text-align:right; font-size: 20px;'>
    <i><b>
    <?php $msg = "Ai vizitat aceasta pagina de " . $_SESSION['counter_adaugadosar'] . " ori.";
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

<span style="font-size: 15px; text-align: center;"><h1> Adauga date dosar </h1></span>
        <br><br><br><br>

<form action="submit" method="POST">
    @csrf

<label for="Nume dosar">Nume dosar:</label>
<input type="text" name="nume" id="nume" list="nume_dosar" placeholder="Alege clientul din lista">
    <datalist id="nume_dosar">
            <?php foreach ($result_nume

        as $row) { ?>
          <option><?php echo($row["nume"]); }?></option>
        </datalist>
        <br><br>
    <label for="Speta">Speta:</label>
<input type="text" name="problema_drept" id="problema_drept" list="Speta" placeholder="Speta">
    <datalist id="Speta">
            <?php foreach ($result_Speta

        as $row) { ?>
          <option><?php echo($row["problema_drept"]); }?></option>
        </datalist>
    <br><br>
    <label for="Referent">Referent:</label>
<input type="text" name="Prenume" id="Prenume" list="Referent" placeholder="Alege referent din lista">
    <datalist id="Referent">
            <?php foreach ($result_Prenume

        as $row) { ?>
          <option><?php echo($row["Prenume"]); }?></option>
        </datalist>
    <br><br>
    <label for="Referent">Status dosar:</label>
<input type="text" name="Status" id="Status" list="Status_id" placeholder="Seteaza status">
    <datalist id="Status_id">
            <option>Preluat</option>
        </datalist>
    <br><br>
        <label for="Info">Informatii dosar:</label>
<input type="text" name="info" id="info" placeholder="Adauga informatii">
       <br><br>
    <button type="submit">Adauga Dosar</button>
</form>



