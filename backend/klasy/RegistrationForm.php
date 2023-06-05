<?php

class RegistrationForm {
    protected $user;     
    
    function __construct(){ ?>      
        <h3>Formularz rejestracji</h3>
        <p>      
        <form action="rejestruj.php" method="post">        
        Nazwa użytkownika: <br/><input name="userName" /><br/>        
        Imię i Nazwisko: <br/><input name="fullName" /><br/>
        Hasło: <br/><input type="password" name="passwd" /><br/>
        Powtórz hasło: <br/><input type="password" name="passwd2" /><br/>
        Email: <br/><input name="email" /><br/>
        
        <br/><input type="submit" name="submit" value="Rejestruj"/>
        <input type="submit" name="cancel" value="Anuluj"/>
        <input type="submit" value="Powrót" name="powrót">
        </form></p>
     
<?php      
        
    }     
    function checkUser(){  
 
        $args = [
                    'userName' => ['filter' => FILTER_VALIDATE_REGEXP,                  
                                'options' => ['regexp' => '/^[0-9A-Za-ząęłńśćźżó_-]{2,25}$/']],       
                    'fullName' => ['filter' => FILTER_VALIDATE_REGEXP,
                                'options' => ['regexp' =>'/^[A-Za-ząęłńśćźżó-]{2,20}+\s*[A-Za-ząęłńśćźżó-]{2,20}$/']],
                    'passwd' => ['filter' => FILTER_VALIDATE_REGEXP,
                                'options' => ['regexp' => '/^(?=.*\d)\w{8,12}$/']],
                                //minimum 8 znaków, co najmniej 1 litera i 1 liczba
                    'passwd2' => ['filter' => FILTER_VALIDATE_REGEXP,
                                'options' => ['regexp' => '/^(?=.*\d)\w{8,12}$/']],
                    'email' => ['filter' => FILTER_VALIDATE_EMAIL]
     
                ];

        //przefiltruj dane:     
        $dane = filter_input_array(INPUT_POST, $args);  
         $passwd = $dane["passwd"];
          $passwd2 = $dane["passwd2"];
        $errors = "";
        foreach ($dane as $klucz=>$wartosc){
            if($wartosc===false or $wartosc===NULL){
                $errors.=$klucz." ";
            }
        }
        $polaczenie = mysqli_connect("localhost", "root", "", "zamowienia");
        $userName = $dane["userName"];
        $email = $dane['email'];
        $query = "SELECT userName FROM users WHERE userName ='".$userName."' and email = '".$email."'";
        $wynik= mysqli_query($polaczenie, $query);
        if ( mysqli_num_rows($wynik) == 0){
        if ($errors === "") {    
            if ($passwd == $passwd2) // sprawdzamy czy hasła takie same
            {
            //Dane poprawne – utwórz obiekt user         
            $this->user=new User($dane['userName'], $dane['fullName'], $dane['email'],$dane['passwd'],0, "'date('Y-m-d H:i:s')'");   
            }
            else echo "Podane hasła różnią się.";
        } 
        else {         
            echo "<p>Błędne dane:$errors</p>";        
            $this->user = NULL;     
        }     
       }
        else echo "<p>Nazwa użytkownika jest już zajęta. Wybierz inną.</p>"; 
        return $this->user;    
        
        
    }
}
   
            

