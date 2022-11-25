<?php
include_once("../configuration/json-Format.php");
include_once("../configuration/DBconnect.php");

$pdo = getconnexion();

function login(){
   
        if (!empty($_POST['compte_mail']) && !empty($_POST['compte_pwd'])) {
            global $pdo;
            $passw = sha1($_POST['compte_pwd']);
            try {
                $requete = $pdo->prepare("SELECT * FROM compte where compte_mail =:valeur1 
                and compte_pwd =:valeur2");
                $requete->bindParam(':valeur1', $_POST['compte_mail']);
                $requete->bindParam(':valeur2', $passw);
                $requete->execute();
                if ($requete->rowcount()) {
                    json_login_response("true","bienvenue",$_POST['compte_mail']);

                } else {
                    json_general_response(false, "Impossible de se connecter");
                }
            } catch (Exception $ex) {
                echo $ex;
            }
        } else {
            json_general_response(false, "email ou mot de passe vide");
        }

}

if ($_SERVER['REQUEST_METHOD'] == 'POST'){
    login();
}