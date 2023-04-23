<?php
$zalogowany = isset($_COOKIE["dane"]) && !empty($_COOKIE["dane"]);
$nazwa = "";
if ($zalogowany) {
  $nazwa = $_COOKIE["dane"];
}

session_start();

if (!isset($_SESSION["koszyk"]) || empty($_SESSION["koszyk"])) {
  $_SESSION["koszyk"] = serialize([]);
}

$tab = unserialize($_SESSION["koszyk"]);

$produkty = join(",", $tab); // "1,2,3,4"
$connect = mysqli_connect('localhost', 'root', '', 'sklep');
?>
<!DOCTYPE html>
<html lang="pl" data-bs-theme="dark">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Koszyk</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
  <link rel="stylesheet" href="css/glowna.css">
</head>

<body>
  <div id="baner">
    <div id="napis">
      <h1>Jesteś w koszyku</h1>
    </div>
  </div>

  <div class="sticky-top">
    <p>
    <div class="dropdown">
      <a class="btn btn-secondary dropdown-toggle btn btn-outline-light" href="#" role="button" data-bs-toggle="dropdown"
        aria-expanded="false">
        Twoje konto
      </a>
      <ul class="dropdown-menu">
        <li class="dropdown-item disabled">Witaj <?php echo $nazwa; ?></li>
        <li><hr class="dropdown-divider"></li>
        <li><a class="dropdown-item" href="informacje.php">Informacje o koncie</a></li>
        <li><a class="dropdown-item" href="historia.php">Historia zamówień</a></li>
        <li><hr class="dropdown-divider"></li>
        <li><a class="dropdown-item" href="wyloguj.php">Wyloguj się</a></li>
      </ul>
    </div>
    </p>

    <p>
    <div class="dropdown">
      <a class="btn btn-secondary dropdown-toggle btn btn-outline-light" href="#" role="button" data-bs-toggle="dropdown"
        aria-expanded="false">
        Koszyk
      </a>
      <ul class="dropdown-menu">
        <?php 

        if (!isset($_SESSION["koszyk"]) || empty($_SESSION["koszyk"])) {
          $_SESSION["koszyk"] = serialize([]);
        }

        $tab = unserialize($_SESSION["koszyk"]);
        ?>
        <li><a class="dropdown-item disabled">Ilość rzeczy w koszyku: <?php echo count($tab);?></a></li>
        <li><hr class="dropdown-divider"></li>
        <?php
        $produkty = join(",", $tab); // "1,2,3,4"
        $zap = "SELECT id, tytul, autor, rok, muzyka FROM produkty WHERE id IN ($produkty) LIMIT 3";
        $wyk = mysqli_query($connect, $zap);

        if ($wyk != false) {
          while ($wiersz = mysqli_fetch_array($wyk)) {
            $id = $wiersz["id"];
            $tytul = $wiersz["tytul"];
            $autor = $wiersz["autor"];
            $rok = $wiersz["rok"];
    
            echo "<li><a class=\"dropdown-item disabled\">$autor - $tytul ($rok)</a></li>";
          }
        }
        ?>
        <li><hr class="dropdown-divider"></li>
        <li><a class="dropdown-item link-info" href="koszyk.php">Zobacz cały koszyk</a></li>
      </ul>
      
    </div>
    </p>

    <p>
    <div class="dropdown">
      <a class="btn btn-secondary dropdown-toggle btn btn-outline-light" href="#" role="button" data-bs-toggle="dropdown"
        aria-expanded="false">
        Powiadomienia
      </a>
      <ul class="dropdown-menu">
        <li>Brak żadnych nowych powiadomień</li>
      </ul>
    </div>
    </p>

    <p>
      <div class="dropdown" id="promocja">
        <a class="btn btn-primary btn btn-outline-light" href="promocje.php" role="button" aria-expanded="false" aria-controls="collapseExample">
          Promocje
        </a>
      </div>
      </p>
      <p>
          <div class="dropdown" id="stronaglowna">
              <a class="btn btn-primary btn btn-outline-light" href="glowna.php" role="button" aria-expanded="false" aria-controls="collapseExample">
                  Przejdź na stronę główną
              </a>
          </div>
      </p>
      <div class="input-group">     
      </div>

  </div>

  <div id="glowny" class="container">
    <h1>Twój koszyk</h1>

    <div class="koszyk row d-flex justify-content-center">
      <?php
        $zap = "SELECT id, tytul, autor, rok, muzyka FROM produkty WHERE id IN ($produkty)";
        $wyk = mysqli_query($connect, $zap);

        if ($wyk != false) {
          while ($wiersz = mysqli_fetch_array($wyk)) {
            $id = $wiersz["id"];
            $tytul = $wiersz["tytul"];
            $autor = $wiersz["autor"];
            $rok = $wiersz["rok"];
            $muzyka = $wiersz["muzyka"];

            echo "
            <div class=\"blok col-12 col-md-6 col-lg-4\">
              <img src=\"https://www.tapeciarnia.pl/tapety/normalne/tapeta-gramofon-w-grafice.jpg\" alt=\"płyta\"
                class=\"img-responsive\">
              <p class=\"autor\">$autor</p>
              <p class=\"tytul\">$tytul</p>
              <p class=\"rok\">$rok</p>
                <audio controls class=\"odsluchaj\" controlsList=\"nodownload\">
                  <source src=\"$muzyka\" />
                </audio>
                <form action=\"usunprodukt.php\" method=\"POST\">
                  <input type=\"hidden\" name=\"id\" value=\"$id\">
                  <input type=\"submit\" value=\"Usuń z koszyka\" name=\"wyślij\" class=\"btn btn-primary\">
                </form>
              </p>
            </div>
            ";
          
          }
        } else {
          echo "<div class=\"col-12 text-center text-danger my-2\">Twój koszyk jest pusty!</div>";
        }

      
      ?>

        <div class="przejscie">
          <form action="kup.php" method="POST">
            <p>Wybierz metodę płatności:</p>
            <input type="radio" id="blik" name="platnosc" value="blik" required>Blik
            <input type="radio" id="przelew" name="platnosc" value="przelew" required>Przelew
            <input type="radio" id="SMS" name="platnosc" value="SMS" required>SMS
            <input type="submit" class="btn btn-primary btn-outline-light" aria-expanded="false" aria-controls="collapseExample" value="Kup">
          </form>
            <a class="btn btn-primary btn-outline-light" href="wyczysckoszyk.php" role="button" aria-expanded="false" aria-controls="collapseExample" style="margin-top: 1%">
                Wyczyść koszyk
            </a>
        </div>
    </div>
  </div>

  <div id="stopka">
    <div id="left">
      <h6>Stronę wykonał: Tobiasz Bala</h6>
      <h6><img src="obrazki/telefon.png" class="ikona"> XXX-XXX-XXX</h6>
      <h6><img src="obrazki/fb.png" class="ikona"><a href="https://www.facebook.com/" target="_blank">XXX</a></h6>
      <h6><img src="obrazki/insta.png" class="ikona"><a href="https://www.instagram.com" target="_blank">XXX</a></h6>
      <h6><img src="obrazki/poczt.png" class="ikona">XXX@gmail.com</h6>
    </div>
    <div id="middle">
      <h5>Oświadczenie o prawach autorskich</h5>
      <h6>Oświadczam, że jestem autorem dostarczonej strony i nie naruszam praw autorskich oraz dóbr osobistych innych
        osób.<br>
        Nie wyrażam zgody na nieodpłatne wykorzystywanie, rozpowszechnianie oraz prezentacje owego projektu.</h6>
    </div>
    <div id="right">
      <h6>Partnerzy: </h6>
      <h6><a href="https://zs3-wyszkow.pl/">Zespół Szkół nr 3 im. Jana Kochanowskiego w Wyszkowie</a></h6>
      <h6><a href="https://www.youtube.com/">YouTube</a></h6>
      <h6><a href="https://pl.wikipedia.org/wiki/Fryderyk_Chopin">Fryderyk Chopin</a></h6>
      <h6><a href="https://pl.wikipedia.org/wiki/Johann_Sebastian_Bach">Jan Sebatian Bach</a></h6>
    </div>
  </div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN"
    crossorigin="anonymous"></script>
</body>
</body>

</html>
<?php mysqli_close($connect); ?>