<?php
session_start();
if(isset($_SESSION['counter_editareDosar'])) {
    $_SESSION['counter_editareDosar'] +=1;
} else {
    $_SESSION['counter_editareDosar'] = 1;
}
$msg = "Ai vizitat aceasta pagina de " . $_SESSION['counter_editareDosar'] . " ori";
echo $msg;

echo "<br><br>";
echo "EDITARE DOSAR";
echo "<br>";


?>

    <html>

<?php
echo "<br><br>";
echo"1. Documente dosar";
?>


<button class="GFG"
        onclick="window.location.href = 'http://localhost/projects/Antonia%20bureata-Stefanescu/documenteDosar.php';">
    VIZUALIZARE
</button>
<button type="button">ADAUGARE</button>
    </html>

<?php
echo "<br><br>";
echo"2. Date dosar";
?>
<html>
<button type="button">VIZUALIZARE</button><button type="button">EDITARE</button>
</html>

<?php
echo "<br><br>";
echo"3. Informatii suplimentare";
?>
<html>
<button type="button">EDITARE</button>
</html>


