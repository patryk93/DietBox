<!DOCTYPE html>
<html lang="pl">
    <head>
        <title>Dieta Standard</title>
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
        include_once("funkcje.php");
        drukuj_form_standard();
        include_once "klasy/Baza.php";
//tworzymy uchwyt do bazy danych:
        $bd = new Baza('localhost', 'root', '', 'zamowienia');
        echo $bd->select("select Id, Rodzaj, Kalorycznosc, LiczbaPosilkow, DlugoscDiety, Platnosc from zamowienia", array("Id", "Rodzaj", "Kalorycznosc", "LiczbaPosilkow", "DlugoscDiety", "Platnosc"));

        
        if (filter_input(INPUT_GET, "submit")) {
            $akcja = filter_input(INPUT_GET, "submit");
            switch ($akcja) {
                case "Dodaj" : dodajdoBD_standard($bd);
                    echo $bd->select("select Id, Rodzaj, Kalorycznosc, LiczbaPosilkow, DlugoscDiety, Platnosc from zamowienia", array("Id", "Rodzaj", "Kalorycznosc", "LiczbaPosilkow", "DlugoscDiety", "Platnosc"));

                    break;
                case "Pokaż" : {
                  echo $bd->select("select Id, Rodzaj, Kalorycznosc, LiczbaPosilkow, DlugoscDiety, Platnosc from zamowienia ", array("Id", "Rodzaj", "Kalorycznosc", "LiczbaPosilkow", "DlugoscDiety", "Platnosc"));    
                    break;
                }
               
                case "Usuń" : 
                    $Id=$_GET['Id'];
                    usuwanie($bd, $Id);
                    echo $bd->select("select Id, Rodzaj, Kalorycznosc, LiczbaPosilkow, DlugoscDiety, Platnosc from zamowienia ", array("Id", "Rodzaj", "Kalorycznosc", "LiczbaPosilkow", "DlugoscDiety", "Platnosc"));    

                    break;
            }
        }
        ?>
    </section>
        <footer>&copy;PS&JK</footer>
    </body>
</html>
