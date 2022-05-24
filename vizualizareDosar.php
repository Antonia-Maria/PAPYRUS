<?php
session_start();
if(isset($_SESSION['counterListaDosare'])) {
    $_SESSION['counterListaDosare'] +=1;
} else {
    $_SESSION['counterListaDosare'] = 1;
}
$msg = "Ai vizitat aceasta pagina de " . $_SESSION['counter'] . " ori";

echo $msg;
echo "<br><br>";
echo "Aceasta este pagina Lista Dosare";
echo "<br><br>";


?>

<button type="button">CAUTARE</button><button type="button">SORTARE</button>
<?php
echo "<br><br>";
echo"Click pentru editare dosar: "
?>
<a href="editareDosar.php">Editare Dosar</a>
</html>
