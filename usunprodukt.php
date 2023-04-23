<?php 
$zalogowany = isset($_COOKIE["dane"]) && !empty($_COOKIE["dane"]);
$nazwa = "";
if ($zalogowany) {
  $nazwa = $_COOKIE["dane"];
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  @$id = $_POST["id"];

  if (!empty($id)) {
    session_start();

    if (!isset($_SESSION["koszyk"]) || empty($_SESSION["koszyk"])) {
      $_SESSION["koszyk"] = serialize([]);
    }

    $tab = unserialize($_SESSION["koszyk"]);

    if (in_array($id, $tab)) {
      unset($tab[array_search($id, $tab)]);
    }
  
    $_SESSION["koszyk"] = serialize($tab);
  }
}

header("Location: koszyk.php");
?>