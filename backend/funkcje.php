<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


function drukuj_form_standard() { ?>
    <form action="formularz_standard.php" method="GET" >   
        <header>
            <a href="zalogowany.php">wróć</a> 
            <h2>Wybór diety standardowej:</h2>

        </header>
        <section >
<h3>Kaloryczność: </h3>
            <?php
            $kalorie = array("1200", "1500", "1800", "2000", "2200");
            foreach ($kalorie as $el) {
            echo "<input type='radio'name='kalorie[]' value='$el '>$el";
            }
            ?>
            <br />
            <h3>Liczba posiłków: </h3>
             <?php
            $posilki = array("5 posiłków", "3 posiłki");
            foreach ($posilki as $el) {
                echo "<input type='radio' name='posilki[]' value='$el '>$el";
            }
            ?>
            <br />
            <h3>Długość diety: </h3>
            <input type="number" id="dlugosc" name="dlugosc" value="30" /> dni<br />
            <h3>Sposób zapłaty: </h3>
            <?php
            $platnosc = array("Eurocard", "Visa", "Przelew");
            foreach ($platnosc as $el) {
                echo "<input type='radio' name='platnosc[]' value='$el '>$el";
            }
            ?>
            <br/>  
            <br/>  
            <input type="submit" value="Wyczyść" name="submit">
            <input type="submit" value="Dodaj" name="submit" />
            <input type="submit" value="Pokaż" name="submit" />
            
         Podaj id do usunięcia: <input name="Id" />
                     <input type="submit" value="Usuń" name="submit" />
        </section>
        
    </form>           
    <?php
}


function drukuj_form_vege() { ?>
    <form action="formularz_vege.php" method="GET" >   
        <header>
            <a href="zalogowany.php">wróć</a> 
            <h2>Wybór diety wegetariańskiej:</h2>

         </header>
        <section >
<h3>Kaloryczność: </h3>
            <?php
            $kalorie = array("1200", "1500", "1800", "2000", "2200");
            foreach ($kalorie as $el) {
                echo "<input type='radio' name='kalorie[]' value='$el '>$el";
            }
            ?>
            <br />
            <h3>Liczba posiłków: </h3>
             <?php
            $posilki = array("5 posiłków", "3 posiłki");
            foreach ($posilki as $el) {
                echo "<input type='radio' name='posilki[]' value='$el '>$el";
            }
            ?>
            <br />
            <h3>Długość diety: </h3>
            <input type="number" id="dlugosc" name="dlugosc" value="30" /> dni<br />
            <h3>Sposób zapłaty: </h3>
            <?php
            $platnosc = array("Eurocard", "Visa", "Przelew");
            foreach ($platnosc as $el) {
                echo "<input type='radio' name='platnosc[]' value='$el '>$el";
            }
            ?>
            <br/>  
            <br/>  
            <input type="submit" value="Wyczyść" name="submit">
            <input type="submit" value="Dodaj" name="submit" />
            <input type="submit" value="Pokaż" name="submit" />
            
             
                  Podaj id do usunięcia: <input name="Id" />
                     <input type="submit" value="Usuń" name="submit" />
                    
        </section>
    </form>           
    <?php
}


function dodajdoBD_standard($bd) {
    error_reporting(0);
    echo "Dane zamówienia:</br>";
    $kalorie = array("1200", "1500", "1800", "2000", "2200");
    if (!isset($_REQUEST['kalorie'])) {
        echo '<form action="funkcje.php"
method="request">';
        echo "</form>";
    } else {
        $checked = $_REQUEST['kalorie']; //tablica łańcuchów
        $kal = "";
        foreach ($checked as $el) {
            $kal .= $el . " ";
        }
        
        echo "Kaloryczność: " . $kal . " kcal </br>";
    }
    

    $posilki = array("5 posiłków", "3 posiłki");
    if (!isset($_REQUEST['posilki'])) {
        echo '<form action="funkcje.php"
method="request">';
        echo "</form>";
    } else {
        $checked = $_REQUEST['posilki']; //tablica łańcuchów
        $pos = "";
        foreach ($checked as $el) {
            $pos .= $el . " ";
        }
        echo "Liczba posiłków: " . $pos . " </br>";
    }

    if (isset($_REQUEST['dlugosc']) && ($_REQUEST['dlugosc'] != "")) {
        $dlugosc = htmlspecialchars(trim($_REQUEST['dlugosc']));
        echo "Dlugosc diety: " . $dlugosc . " dni </br>";
    }

    $platnosc = array("Eurocard", "Visa", "Przelew");
    if (!isset($_REQUEST['platnosc'])) {
        echo '<form action="funkcje.php"
method="request">';
        echo "</form>";
    } else {
        $checked = $_REQUEST['platnosc']; //tablica łańcuchów
        $plat = "";
        foreach ($checked as $el) {
            $plat .= $el . " ";
        }
        echo "Zapłata:" . $plat . " </br>";
    }

    $sql = "INSERT INTO zamowienia (Rodzaj, Kalorycznosc, LiczbaPosilkow, DlugoscDiety, Platnosc)
VALUES ('standard', '$kal', '$pos', '$dlugosc', '$plat')" or die(mysql_error());
if (!($bd->insert($sql))|| $kal==NULL || $pos==NULL || $dlugosc==NULL || $plat==NULL) {
    
        echo "</br>" . "Zamówienie niekompletne. Proszę usunąć zamówienie!!!!";
    } else 
        echo "Zamówienie dodane, dziękujemy i zapraszamy ponownie.";
    
     
}

function dodajdoBD_vege($bd) {
   error_reporting(0);
    echo "Dane zamówienia:</br>";
    $kalorie = array("1200", "1500", "1800", "2000", "2200");
    if (!isset($_REQUEST['kalorie'])) {
        echo '<form action="funkcje.php"
method="request">';
        echo "</form>";
    } else {
        $checked = $_REQUEST['kalorie']; //tablica łańcuchów
        $kal = "";
        foreach ($checked as $el) {
            $kal .= $el . " ";
        }
        
        echo "Kaloryczność: " . $kal . " kcal </br>";
    }
    

    $posilki = array("5 posiłków", "3 posiłki");
    if (!isset($_REQUEST['posilki'])) {
        echo '<form action="funkcje.php"
method="request">';
        echo "</form>";
    } else {
        $checked = $_REQUEST['posilki']; //tablica łańcuchów
        $pos = "";
        foreach ($checked as $el) {
            $pos .= $el . " ";
        }
        echo "Liczba posiłków: " . $pos . " </br>";
    }

    if (isset($_REQUEST['dlugosc']) && ($_REQUEST['dlugosc'] != "")) {
        $dlugosc = htmlspecialchars(trim($_REQUEST['dlugosc']));
        echo "Dlugosc diety: " . $dlugosc . " dni </br>";
    }

    $platnosc = array("Eurocard", "Visa", "Przelew");
    if (!isset($_REQUEST['platnosc'])) {
        echo '<form action="funkcje.php"
method="request">';
        echo "</form>";
    } else {
        $checked = $_REQUEST['platnosc']; //tablica łańcuchów
        $plat = "";
        foreach ($checked as $el) {
            $plat .= $el . " ";
        }
        echo "Zapłata:" . $plat . " </br>";
    }

    $sql = "INSERT INTO zamowienia (Rodzaj, Kalorycznosc, LiczbaPosilkow, DlugoscDiety, Platnosc)
VALUES ('wegetariańska', '$kal', '$pos', '$dlugosc', '$plat')";
if (!($bd->insert($sql))|| $kal==NULL || $pos==NULL || $dlugosc==NULL || $plat==NULL) {
        echo "</br>" . "Zamówienie niekompletne. Proszę usunąć zamówienie!!!!";
    } else 
        echo "Zamówienie dodane, dziękujemy i zapraszamy ponownie.";
}

function usuwanie($bd, $ID) {
    $sql = "Delete from zamowienia where Id = '$ID' ";
    $bd->delete($sql);
}
