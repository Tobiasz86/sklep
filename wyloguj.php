<?php
$zalogowany = isset($_COOKIE["dane"]) && !empty($_COOKIE["dane"]);
if ($zalogowany) {
    @$nazwa = $_COOKIE["dane"];
  
    $mies = 2592000 + time();
    // https://www.php.net/manual/en/datetime.format.php
    setcookie("wizyta_$nazwa", date("j.m.Y - G:i:s"), $mies); // April 18th - 11:06pm
    setcookie('dane', '', time() - 3600);
    header('Location: logowanie.php');

}
?>
