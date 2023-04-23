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

    if (!in_array($id, $tab)) {
      array_push($tab, $id);
    }
  
    $_SESSION["koszyk"] = serialize($tab);
  }
}
?>
<!DOCTYPE html>
<html lang="pl" data-bs-theme="dark">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Sklep muzyczny</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
  <link rel="stylesheet" href="css/glowna.css">
</head>

<body>
  <div id="baner">
  </div>

  <div id="glowny">
    <h1>Dziękujemy! Twój produkt został dodany do koszyka</h1>
        <div class="przejscie">
            <a class="btn btn-primary btn btn-outline-light" href="glowna.php" role="button" aria-expanded="false" aria-controls="collapseExample">
                Kontynuuj zakupy
            </a>
        </div>

        <div class="przejscie">
            <a class="btn btn-primary btn btn-outline-light" href="koszyk.php" role="button" aria-expanded="false" aria-controls="collapseExample">
                Przejdź do koszyka
            </a>
        </div>

        <div class="przejscie">
            <a class="btn btn-primary btn btn-outline-light" href="wyczysckoszyk.php" role="button" aria-expanded="false" aria-controls="collapseExample">
                Wyczyść koszyk
            </a>
        </div>
  </div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN"
    crossorigin="anonymous"></script>
</body>
</body>

</html>