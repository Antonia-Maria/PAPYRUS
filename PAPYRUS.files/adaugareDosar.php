<?php


echo "<br>";
echo "Aceasta este pagina Adaugare Dosar";
echo "<br><br>";
session_start();
if(isset($_SESSION['counter_adaugareDosar']))
    $_SESSION['counter_adaugareDosar'] +=1;
 else
    $_SESSION['counter_adaugareDosar'] = 1;
$msg = "Ai vizitat aceasta pagina de " . $_SESSION['counter_adaugareDosar'] . " ori";

echo $msg;

?>



