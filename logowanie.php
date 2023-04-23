<?php
if (isset($_COOKIE["dane"])) {
    header("Location: glowna.php");
}
?>
<!DOCTYPE html>
<html lang="pl" data-bs-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Logowanie - sklep muzyczny</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <link rel="stylesheet" href="css/rejestracjaa.css">
</head>
<body>
    <?php
        $blad = "";

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $connect = mysqli_connect('localhost', 'root', '', 'sklep');

            @$nazwa = $_POST['nazwa'];
            @$haslo = $_POST["haslo"];
            $haslo = md5(htmlspecialchars($haslo)); //kodowanie hasła w bazie

            if (!empty($nazwa) && !empty($haslo)) {
                $zap = "SELECT id, email, numer, haslo FROM uzytkownicy WHERE nazwa = '$nazwa'";
                $wyk = mysqli_query($connect, $zap);

                $jestwbazie = false;
                while ($wiersz = mysqli_fetch_array($wyk)) {
                    $jestwbazie = true;
                    if ($haslo == $wiersz["haslo"]) {
                        $email = $wiersz["email"]; // potrzebne do informacje.php
                        $numer = $wiersz["numer"];
                        $id = $wiersz["id"];

                        setcookie('dane', $nazwa, time() + 60 * 60 * 24 * 365);
                        setcookie('email', $email, time() + 60 * 60 * 24 * 365);
                        setcookie('numer', $numer, time() + 60 * 60 * 24 * 365);
                        setcookie('id', $id, time() + 60 * 60 * 24 * 365);

                        echo "<p>Witamy ponownie $nazwa!</p>";
                        header("Location: glowna.php");
                    } else {
                        $blad = "Nieprawidłowa nazwa użytkownika bądź hasło";
                    }
                }

                if ($jestwbazie == false) {
                    $blad = "Nieprawidłowa nazwa użytkownika bądź hasło";
                }
            }
            mysqli_close($connect);
        }
    ?>
    <div id="baner">
        <div id="napis">
            <h1>Zaloguj się w naszym sklepie muzycznym</h1>
        </div>
    </div>
    <div id="glowny">
    <div id="blok">
    <form action="#" method="post"> 
        <input type="text" name="nazwa" value="" size="50" minlength="3" maxlength="50" required placeholder="Twoja nazwa użytkownika" class="form-control"><br>
        <input type="password" id="haslo" name="haslo" value="" size="50" minlength="6" maxlength="50" required placeholder="Twoje hasło" class="form-control"><br>
        <p class="text-danger"><?php echo $blad?></p>
        <input type="submit" value="Zaloguj się" name="wyślij" class="btn btn-primary my-2">
        <input type="reset" id="reset" value="Wyczyść formularz" name="wyślij"  class="btn btn-primary my-2">
    </form>
    <p>Nie masz jeszcze konta? <a href="rejestracja.php">Zarejestruj się.</a></p>
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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
</body>
</body>
</html>