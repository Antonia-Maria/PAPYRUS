<?php

// blade care afiseaza functia "edit" din controller
$DATABASE_HOST = 'localhost';
$DATABASE_USER = 'root';
$DATABASE_PASS = '';
$DATABASE_NAME = 'papyrusdb';
// conectare la baza de date
$con = mysqli_connect($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);
if (mysqli_connect_errno()) {
    // In caz de eroare la conexiune, returneaza mesajul:
    exit('Failed to connect to MySQL: ' . mysqli_connect_error());
}
session_start();
// verifica daca este setat cookie; daca nu este, redirectioneaza catre pagina de logare
if (!isset($_COOKIE["username"])) {
    header("location:logare.php");
}
// verifica daca este setata sesiunea
if (isset($_SESSION['counter_editaredosar'])) {
    $_SESSION['counter_editaredosar'] += 1;
} else {
    $_SESSION['counter_editaredosar'] = 1;
}
?>

<html lang="en">
<head>

    <title>Editare Dosare</title>

</head>

<div style='text-align:right; font-size: 20px;'>
    <i><b>
    <?php $msg = "Ai vizitat aceasta pagina de " . $_SESSION['counter_editaredosar'] . " ori.";
    echo $msg;
    $query_nume = "SELECT nume FROM clienti ORDER BY nume ASC";
    $query_Prenume = "SELECT Prenume FROM utilizatori ORDER BY Prenume ASC";
    $query_Speta = "SELECT problema_drept FROM dosare";
    $result_nume = mysqli_query($con, $query_nume) or die(mysqli_error());
    $result_Prenume = mysqli_query($con, $query_Prenume) or die(mysqli_error());
    $result_Speta = mysqli_query($con, $query_Speta) or die(mysqli_error());
    ?>

</div>

</html> </b>
<div style='text-align:left'>
    <i>
        <span style="font-size: 25px; font-family:Lucida Calligraphy"> PAPYRUS </span></div>
<div style='text-align:center'><br><br>
    <span style="font-size: 20px;">
        <div style='text-align:right'>
    <button type="button"><a href="../../Papyrus2/logout.php">LOG OUT</a></button>
</div><br>
                <div style='text-align:right'>
    <button type="button"><a href="http://localhost/PAPYRUS/PAPYRUS.files/index.php">HOME</a></button>
</div>

    </span></div>
<span style="font-size: 15px; text-align: center;"><h1> Modifica date dosar </h1></span>
<br><br><br><br>
{{--Campuri pentru introducerea datelor si aducerea datelor din baza de date, cu scopul de editare a dosarului selectat--}}
<div style='text-align:center'>
    <form action="/edit" method="POST">
        @csrf
        @foreach($dosare as $dosar)
            <input type="hidden" name="id" value="{{$dosar['id']}}">
            <label for="Nume dosar">Seteaza nume dosar: </label>
            <input type="text" name="nume" list="nume_dosar" value="{{$dosar['nume']}}">
            <datalist id="nume_dosar">
                <?php foreach ($result_nume

                as $row) { ?>
                <option><?php echo($row["nume"]); }?></option>
            </datalist><br><br>
            <label for="Speta">Modifica speta: </label>
            <input type="text" name="problema_drept" list="speta_dosar" value="{{$dosar['problema_drept']}}">
            <datalist id="speta_dosar">
                <?php foreach ($result_Speta

                as $row) { ?>
                <option><?php echo($row["problema_drept"]); }?></option>
            </datalist><br><br>
            <label for="Data inregistrare">Modifica data inregistrare: </label>
            <input type="date" name="data_inregistrare" value="{{$dosar['data_inregistrare']}}" }> <br><br>
            <label for="Status">Modifica status: </label>
            <input type="text" name="status" list="status_dosar" value="{{$dosar['status']}}">
            <datalist id="status_dosar">
                <option>Preluat</option>
                <option>Analizat</option>
                <option>Finalizat</option>
            </datalist> <br><br>
            <label for="Informatii">Modifica informatii: </label>
            <input type="text" name="informatii" value="{{$dosar['informatii']}}"> <br><br>
            <label for="Referent">Seteaza referent: </label>
            <input type="text" name="Prenume" list="Prenume_referent" value="{{$dosar['Prenume']}}"> <br><br>
        @endforeach
        <datalist id="Prenume_referent">
            <?php foreach ($result_Prenume

            as $row) { ?>
            <option><?php echo($row["Prenume"]); }?></option>
        </datalist>
        <br><br>
        <button type="submit">Salveaza modificari</button>

    </form>
</div>
