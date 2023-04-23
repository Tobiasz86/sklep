<?php 
$connect = mysqli_connect('localhost', 'root', '', 'sklep');

$zalogowany = isset($_COOKIE["dane"]) && !empty($_COOKIE["dane"]);

if ($zalogowany) {
  $nazwa = $_COOKIE["dane"];
}

session_start();
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    @$platnosc = $_POST['platnosc'];
    $zap = "INSERT INTO zamowienia(id_uzytkownika, produkty, platnosc) VALUES (".$_COOKIE['id'].", '".$_SESSION["koszyk"]."', '$platnosc')";
    $wyk = mysqli_query($connect, $zap);
    header("Location: wyczysckoszyk.php");
}


mysqli_close($connect);
?>