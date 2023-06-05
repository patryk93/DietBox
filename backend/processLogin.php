<!DOCTYPE html>
<html lang="pl">
    <head>
        <title>Logowanie</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=true">
        <link rel="stylesheet" href="css/style.css" />
    </head>
    <body>
        <header>
            <p class="srodek">
                <img src="zdjęcia/fitness.jpg" alt="Zdjęcie" />
            </p>
            <h1>Usługi cateringowe</h1>
            <nav>
                <a href="index.php">Strona główna</a>
                <a href="processLogin.php">Zaloguj się</a>
                <a href="rejestruj.php">Utwórz konto</a>
                <a href="problem.php">Zgłoś problem</a>
            </nav>
        </header>
        <section>
 <?php
    include_once 'klasy/Baza.php';
    include_once 'klasy/User.php';
    include_once 'klasy/UserManager.php';
    
    $db = new Baza("localhost","root","","zamowienia");
    $um = new UserManager();
    
    if(filter_input(INPUT_GET, "akcja")=="wyloguj"){
        $um ->logout($db);
    }
    if (filter_input(INPUT_POST, "powrót"))
            header("location:index.php");
if (filter_input(INPUT_POST, "zaloguj")) {
    $userId=$um->login($db); //sprawdź parametry logowania
    if ($userId > 0) {
        header("location:zalogowany.php");
    } 
    else {
        echo "<p>Błędna nazwa użytkownika lub hasło. Spróbuj ponownie.</p>";
        
        $um->loginForm(); //Pokaż formularz logowania
    }
 } 
 else {
 //pierwsze uruchomienie skryptu processLogin
 $um->loginForm();
 }
 ?>
 </section>
        <footer>&copy;PS&JK</footer>
    </body>
</html>
    
    
