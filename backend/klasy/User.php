<?php

class User {
    const STATUS_USER = 1; 
    const STATUS_ADMIN = 2; 
    protected $userName; 
    protected $passwd;
    protected $fullName;
    protected $email;
    protected $date;
    protected $status;


    //metody klasy: 
    function __construct($userName, $fullName, $email, $passwd ){ 
        //implementacja konstruktora 
        $this->status=User::STATUS_USER; 
      
        //nadać wartości pozostałym polom – zgodnie z parametrami 
        $this->userName=$userName;
        $this->passwd= hash('sha256',$passwd);
        $this->fullName=$fullName;
        $this->email=$email;
        $this->date=(new DateTime)->format('Y-m-d H:i');
    } 
    
    function show() { 
        echo $this->status."<br/>";
        echo $this->userName."<br/>";
        echo $this->passwd."<br/>";
        echo $this->fullName."<br/>";
        echo $this->email."<br/>";
        echo $this->date."<br/>";
        
    } 
    
    function getUserName() {
        return $this->userName;
    }

    function getPasswd() {
        return $this->passwd;
    }

    function getFullName() {
        return $this->fullName;
    }

    function getEmail() {
        return $this->email;
    }

    function setUserName($userName) {
        $this->userName = $userName;
    }

    function setPasswd($passwd) {
        $this->passwd = $passwd;
    }

    function setFullName($fullName) {
        $this->fullName = $fullName;
    }

    function setEmail($email) {
        $this->email = $email;
    }

    function getDate() {
        return $this->date;
    }

    function setStatus($status) {
        $this->status = $status;
    }

    function save(){
        //wczytujemy plik XML:
        $xml = simplexml_load_file('users.xml');
        //dodajemy nowy element user (jako child)
        $xmlCopy=$xml->addChild("user");
        //do elementu dodajemy jego właściwości o określonej nazwie i treści
        $xmlCopy->addChild("userName", $this->userName);
        $xmlCopy->addChild("passwd",$this->passwd);
        $xmlCopy->addChild("fullName", $this->fullName);
        $xmlCopy->addChild("email", $this->email);  
        $xmlCopy->addChild("date", $this->date);
        $xmlCopy->addChild("status",$this->status);
        //zapisujemy zmodyfikowany XML do pliku:
        $xml->asXML('users.xml');
    }
    
    static function getAllUsers(){
        $allUsers = simplexml_load_file('users.xml');
        echo "<ul>";
        foreach ($allUsers as $user):
            $userName=$user->userName;
            $date=$user->date;
            $fullName=$user->fullName;
            $email=$user->email;
            echo "<li>$userName, $date, $fullName, $email </li>";
        endforeach;
        echo "</ul>";
    }
    
    function saveDB($db){
        $sql="INSERT INTO users VALUES(NULL,'$this->userName','$this->fullName','$this->email','$this->passwd','$this->status','$this->date')";
        $db->insert($sql);
    }
    
    static function getAllUsersFromDB($db){
        $sql="SELECT*FROM users";
        echo $db->select($sql, ["userName","fullName","email","passwd","status","date"]);
    }
}


