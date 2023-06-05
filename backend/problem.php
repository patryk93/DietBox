<!DOCTYPE html>
<html lang="pl">
    <head>
        <title>Problem</title>
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
            
            <h2>Zgłoszenie problemu</h2>
            <p>
                W przypadku problemów z zalogowaniem się lub rejestrację prosimy o kontakt pod numerem telefonu: +48 748 110 112, kontakt mailowy: uslugicateringowe@gmail.com lub napisz na czacie poniżej.
            </p>
            <div class="chatContainer">
   <div class="chatHeader">
   </div>

   <div class="chatMessages"></div>

   <div class="chatBottom">
      <form action="#" onSubmit='return false;' id="chatForm">
         <input type="hidden" id="name" value=""/>
         <input type="text" name="text" id="text" value="" placeholder="Wpisz wiadomość" />
         <input type="submit" name="submit" value="Wyślij" />
      </form>
   </div>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<script>
   $(document).ready(function(){

   });
</script>
        <form action="index.php" method="post">        
        
        </form>
        <?php
    

?>
        </section>
        <footer>&copy;PS&JK</footer>
    </body>
</html>
