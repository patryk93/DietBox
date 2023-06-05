<?php

class UserManager {
    
    function loginForm(){
        ?>
<h3>Formularz logowania</h3>
    <form action="processLogin.php" method ="post">
            <table>
                <tbody>
                    <tr>
                        <td>Login: </td>
                        <td><input type="text" name="login"></td>
                    </tr>
                    <tr>
                        <td>Password: </td>
                        <td><input type="password" name="passwd"></td>
                    </tr>
                    <tr>
                        <td><input type="submit" value="Zaloguj" name="zaloguj"></td>
                        <td><input type="reset" value="Wyczyść" name="reset"></td>
                       <td><input type="submit" value="Powrót" name="powrót"></td>
                    </tr>
                </tbody>
            </table>
    </form> 
        <?php   
    }
    
    
    function login($db){
        $args = [
                'login' => FILTER_SANITIZE_ADD_SLASHES,
                'passwd'=> FILTER_SANITIZE_ADD_SLASHES
        ];
        $dane = filter_input_array(INPUT_POST,$args);
        
        $login = $dane["login"];
        $passwd = $dane["passwd"];
        //echo $passwd ," - LOGIN ";
        $userId = $db->selectUser($login,$passwd,"users");
        
        if($userId >=0){
            session_start();
            $sesId = session_id();
            $db->delete("DELETE * FROM logged_in_users WHERE userId=".$userId);
            $db->insert("INSERT INTO logged_in_users Values('$sesId','$userId','".date('Y-m-d H:i:s')."')");
        }
        return $userId;
    }
    
    function logout($db){
        session_start();
        $sesId = session_id();              
        if( isset($_COOKIE[session_name()]) ) {
            setcookie(session_name(), '', time() - 42000, '/');
        }
        session_destroy();
                $db->delete("DELETE FROM logged_in_users WHERE sessionId='$sesId'");
    }
    
    function getLoggedInUser($db,$sessionId){
         if($result = $db->mysqli->query("SELECT * FROM logged_in_users WHERE sessionId='$sessionId' ")){
             $row =$result->fetch_object();
             return $row->userId;
         }
         else{
             return -1;
         }
    }
    
}