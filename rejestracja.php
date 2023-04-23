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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <link rel="stylesheet" href="css/rejestracjaa.css">
    <title>Rejestracja - sklep muzyczny</title>
</head>

<body>
    <?php
        $blad = "";
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $connect = mysqli_connect('localhost', 'root', '', 'sklep');
            @$imie = $_POST["imie"]; // Pobiera dane wprowadzone przez użytkownika i wysyła do bazy
            @$nazwisko = $_POST['nazwisko'];
            @$email = $_POST["email"];
            @$numer = $_POST["numer"];
            @$nazwa = $_POST['nazwa'];
            @$haslo1 = $_POST["haslo1"];
            @$haslo2 = $_POST["haslo2"];

            if ($haslo1 == $haslo2) {
                $haslo = md5(htmlspecialchars($haslo1)); //kodowanie hasła w bazie
                // Laska123!
                // a66f20981a72224bad4df65469ff2e63
                
                // Usuwa spacje z początku i końca wprowadzonych pól
                $imie = trim($imie);
                $nazwisko = trim($nazwisko);
                $email = trim($email);
                $numer = trim($numer);
                $nazwa = trim($nazwa);

                $numer = str_replace(["-", " "], "", $numer);

                $select = "SELECT nazwa, email, numer FROM uzytkownicy WHERE numer = '$numer' OR email = '$email' OR nazwa = '$nazwa'"; // sprawdza czy sa podane przez uzytkownika dane
                $wyk = mysqli_query($connect, $select); // wykonuje zapytanie wyzej
                $jestwbazie = false; // nie ma w bazie
                $emailzajety = false;
                $nazwazajety = false;
                $numerzajety = false;
                while ($wiersz = mysqli_fetch_array($wyk)) { // sprawdza kazdy wiersz bazy
                    $jestwbazie = true; // jest w bazie
                    if ($wiersz["email"] == $email) {
                        $emailzajety = true; // sprawdza ktore dane wprowadzone przez uzytkownika sa juz w bazie
                    }
                    if ($wiersz["nazwa"] == $nazwa) {
                        $nazwazajety = true; 
                    }
                    if ($wiersz["numer"] == $numer) {
                        $numerzajety = true; 
                    }     
                }

                if (!$jestwbazie) { // jeżeli nie ma w bazie to: 
                    $zap = "INSERT INTO uzytkownicy(imie, nazwisko, email, numer, nazwa, haslo) VALUES 
                            ('$imie','$nazwisko','$email', '$numer','$nazwa','$haslo')"; // do podanych pól kolejno wprowadza dane wprowadzone przez użytkownika
                    echo $zap;
                    mysqli_query($connect, $zap); // wykonuje zapytanie wyzej
                    
                    header("Location: logowanie.php"); // przekierowuje na strone główna
                } else {
                    if ($emailzajety) {
                        $blad .= 'Email jest zajęty';
                    }
                    if ($nazwazajety) {
                        $blad .= '<br>Nazwa jest zajęta';
                    }
                    if ($numerzajety) {
                        $blad .= '<br>Numer telefonu jest zajęty';
                    }     
                }
            } else {
                $blad = "Hasła się nie zgadzają!";
            }

            mysqli_close($connect); // zamyka połączenie
        }
    ?>
    <div id="baner">
        <div id="napis">
            <h1>Zarejestruj się w naszym sklepie muzycznym</h1>
        </div>
    </div>
    

    <div id="glowny">
    <div id="blok">
    <form action="#" method="post" id="form">
        <input type="text" name="imie" value="" size="50" minlength="3" maxlength="30" required placeholder="Twoje imie" class="form-control"><br>
        <input type="text" name="nazwisko" value="" size="50" minlength="3" maxlength="35" required placeholder="Twoje nazwisko" class="form-control"><br>
        <input type="email" name="email" value="" size="50" minlength="3" maxlength="70" required placeholder="Twój adres e-mail" class="form-control"><br>
        <input type="tel" name="numer" pattern="\+{0,1}[0-9\- ]+" value="" size="50" required placeholder="Twój numer telefonu" class="form-control"><br>
        <input type="text" name="nazwa" value="" size="50" minlength="3" maxlength="50" required placeholder="Twoja nazwa użytkownika" class="form-control"><br>
        <input type="password" id="haslo" name="haslo1" value="" size="50" minlength="6" maxlength="50" required placeholder="Twoje hasło" class="form-control"><br>
        <input type="password" name="haslo2" value="" size="50" minlength="6" maxlength="50" required placeholder="Potwierdź Twoje hasło" class="form-control"><br>

        <p class="text-danger"><?php echo $blad; ?></p>

        <h4><div id="warunek">Hasło powinno zawierać conajmniej 6 znaków, w tym:</div>
        <small class="text-body-secondary"><div id="mala" class="warunek">conajmniej 3 małe litery,</div>
        <div id="duza" class="warunek">conajmniej 1 dużą literę,</div>
        <div id="cyfra" class="warunek">conajmniej 1 cyfrę,</div>
        <div id="znak" class="warunek">conajmniej 1 znak specjalny.</div></small></h4>
        <p><input type="submit" value="Zarejestruj się" name="wyślij" class="btn btn-primary"></p>
        <p><input type="reset" id="reset" value="Wyczyść formularz" name="wyślij"  class="btn btn-primary"></p>
    </form>
    <p>Masz już konto? <a href="logowanie.php">Zaloguj się.</a></p>
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

    <script>
        let duza = document.querySelector("#duza");
        let mala = document.querySelector("#mala");
        let cyfra = document.querySelector("#cyfra");
        let znak = document.querySelector("#znak");
        let haslo = document.querySelector("#haslo");
        let reset = document.querySelector("#reset");
        let form = document.querySelector("#form");

        let male = 0; // liczy male litery
        let duze = 0; // zmienna oznaczajaca duze litery
        let liczby = false; // zmienna oznaczajaca cyfry
        let znaczki = false; //zmienna oznaczajaca znaki specjalne

        haslo.addEventListener('input', () => {
            let znaki = "~!@#$%^&*()_+-=[];'\",./\\<>?:|"; // znaki specjalne

            male = 0;
            for (let i = 0; i < haslo.value.length; i++) { // petla sprawdzajaca cala dlugosc hasla
                if(haslo.value[i] == haslo.value[i].toLowerCase() && isNaN(parseInt(haslo.value[i]))) { // sprawdza czy sa male litery i odrzuca cyfry ktore zapisywaly sie jako litery
                    male += 1; // liczy ilosc malych liter
                    for (let j = 0; j < znaki.length; j++) {
                        if(haslo.value[i] == znaki[j]) { 
                            male -= 1; // odrzuca znaki specjalne ktore liczyly sie jako litery
                        }
                    }
                }
            }
            if(male>=3) {  // warunek sprawdzajacy czy sa conajmniej 3 male litery
                mala.style.color = 'lime';
            } else {
                mala.style.color = 'red';
            }
            
            duze = 0;
            for (let i = 0; i < haslo.value.length; i++) {
                if(haslo.value[i] == haslo.value[i].toUpperCase() && isNaN(parseInt(haslo.value[i]))) { // sprawdza czy sa duze litery i odrzuca cyfry ktore zapisywaly sie jako litery
                    duze += 1; // spelnia warunek conajmniej jednej duzej litery
                    for (let j = 0; j < znaki.length; j++) { 
                        if(haslo.value[i] == znaki[j]) {
                            duze -= 1; // odrzuca znaki specjalne ktore liczyly sie jako litery
                        }
                    }
                }
            }

            if(duze >= 1) { // warunek sprawdzajacy czy jest conajmniej 1 duza litera
                duza.style.color = 'lime';
            } else {
                duza.style.color = 'red';
            }
            
            liczby = false;
            for (let i = 0; i < haslo.value.length; i++) { 
                if(!isNaN(parseInt(haslo.value[i]))) { // sprawdza czy wpisany znak jest cyfra, jezeli tak spelnia warunek conajmniej 1 cyfry
                    liczby = true;
                }
            }
            if(liczby == true) { // warunek sprawdzajacy czy jest conajmniej 1 cyfra
                cyfra.style.color = 'lime';
            } else {
                cyfra.style.color = 'red';
            }

            znaczki = false
            for (let i = 0; i < haslo.value.length; i++) { // sprawdza dlugosc hasla
                for (let j = 0; j < znaki.length; j++) { // sprawdza czy sa znaki
                    if(haslo.value[i] == znaki[j]) { // sprawdza czy podany znak jest znakiem specjalnym
                        znaczki = true;
                    }
                }
            }
            if(znaczki == true) { // warunek sprawdzajacy czy jest conajmniej 1 znak specjalny
                znak.style.color = 'lime';
            } else {
                znak.style.color = 'red';
            }
        });

        form.addEventListener('submit', (e) => {
            if (!(male >= 3 && duze >= 1 && liczby == true && znaczki == true)) {
                e.preventDefault(); // blokuje formularz jezeli wymagania hasla nie sa spelnione
                alert("Wymagania dotyczące hasła nie są spełnione.");
            }
        });

        reset.addEventListener('click', () => { // po kliknieciu przycisku reset, tekst warunkow znowu jest zmieniany na czerwony
            duza.style.color = 'red';
            mala.style.color = 'red';
            cyfra.style.color = 'red';
            znak.style.color = 'red';
        });
    </script>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
</body>
</html>