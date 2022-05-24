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

if (isset($_SESSION['counter_adaugadosar'])) {
    $_SESSION['counter_adaugadosar'] += 1;
} else {
    $_SESSION['counter_adaugadosar'] = 1;
}
$query = "SELECT nume FROM clienti";
$query2 = "SELECT Prenume FROM utilizatori";
$query3 = "SELECT problema_drept FROM dosare";
$result = mysqli_query($con, $query) or die(mysqli_error());
$result2 = mysqli_query($con, $query2) or die(mysqli_error());
$result3 = mysqli_query($con, $query3) or die(mysqli_error());
?>

<html lang="en">
<head>

    <title>Adauga Dosar</title>

</head>

<div style='text-align:right; font-size: 20px;'>
    <i><b>
    <?php $msg = "Ai vizitat aceasta pagina de " . $_SESSION['counter_adaugadosar'] . " ori.";
    echo $msg; ?>
</div>
</html> </b>
<div style='text-align:left'>
    <i>
        <span style="font-size: 25px; font-family:Lucida Calligraphy"> PAPYRUS </span></div>
<div style='text-align:center'><br><br>
    <span style="font-size: 20px;">

<span style="font-size: 15px; text-align: center;"><h1> Adauga date dosar </h1></span>
        <br><br><br><br>

<form action="submit" method="POST">
    @csrf

<label for="Nume dosar">Nume dosar:</label>
<input type="text" name="nume" id="nume" list="nume_dosar" placeholder="Alege clientul din lista">
    <datalist id="nume_dosar">
            <option value="Nume client">Nume client</option>
              <?php foreach ($result

          as $row) { ?>
          <option><?php echo($row["nume"]); }?></option>
        </datalist>
        <br><br>
    <label for="Speta">Speta:</label>
<input type="text" name="problema_drept" id="problema_drept" list="Speta" placeholder="Speta">
    <datalist id="Speta">
            <option>Speta</option>
              <?php foreach ($result3

        as $row) { ?>
          <option><?php echo($row["problema_drept"]); }?></option>
        </datalist>
    <br><br>
    <label for="Referent">Referent:</label>
<input type="text" name="Prenume" id="Prenume" list="Referent" placeholder="Alege referent din lista">
    <datalist id="Referent">
            <option>Referent</option>
              <?php foreach ($result2

        as $row) { ?>
          <option><?php echo($row["Prenume"]); }?></option>
        </datalist>
    <br><br>
    <label for="Referent">Status dosar:</label>
<input type="text" name="Status" id="Status" list="Status_id" placeholder="Seteaza status">
    <datalist id="Status_id">
            <option>Status</option>
          <option>Preluat in lucru</option>
        </datalist>
    <br><br>
        <label for="Info">Informatii dosar:</label>
<input type="text" name="info" id="info" placeholder="Adauga informatii">
       <br><br>
    <button type="submit">Adauga Dosar</button>
</form>



