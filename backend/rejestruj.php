<!DOCTYPE html>
<html lang="pl">
    <head>
        <title>Rejestracja</title>
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
        require_once('klasy/User.php');
        require_once('klasy/RegistrationForm.php');
        require_once('klasy/Baza.php');
        
        //$user1 = new User ('login', 'FULLNAME', 'email@email.pl', 'haslo', '1', '2018-12-19 00:00:00');         
       
        $db=new Baza("localhost", "root", "", "zamowienia");
        $rf = new RegistrationForm(); 
        
            if (filter_input(INPUT_POST, "powrót"))
            header("location:index.php");
       
        if (filter_input(INPUT_POST, 'submit', FILTER_SANITIZE_FULL_SPECIAL_CHARS)) {
            $user = $rf->checkUser(); //sprawdza poprawność danych
            if ($user === NULL) {
                echo "<p>Niepoprawne dane rejestracji.</p>";
            } 
            else {
                echo "<p>Konto zostało utworzone.</p>";
               // $user->show();
                $user->saveDB($db);
            }
        }
       
        ?>
   </section>
        <footer>&copy;PS&JK</footer>
    </body>
</html>
