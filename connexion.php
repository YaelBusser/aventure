<?php
session_start();
    require('bdd.php');
    if(isset($_POST['btnConnexion'])){
        $pseudo = $_POST['pseudo'];
        $mdp = sha1($_POST['mdp']);
        if(!empty($pseudo) AND !empty($mdp)){
            $requete_membres = $bdd -> prepare('SELECT pseudo, mdp FROM membres WHERE pseudo = ? AND mdp = ?');
            $requete_membres -> execute(array($pseudo, $mdp));
            $pseudo_exist = $requete_membres -> rowCount();
            if($pseudo_exist == 1){
                $requete_user = $bdd -> prepare('SELECT * FROM membres WHERE pseudo = ?');
                $requete_user -> execute(array($pseudo));
                $user = $requete_user -> fetch(); 
                $_SESSION['id'] = $user['id'];
                $_SESSION['pseudo'] = $user['pseudo'];
                $_SESSION['email'] = $user['email'];
                $_SESSION['mdp'] = $user['mdp'];
                $_SESSION['jeux'] = $user['jeux'];
                $_SESSION['sexualite'] = $user['sexualite'];
                $_SESSION['age'] = $user['age'];
                header('Location: profil.php?id='.$_SESSION['id'].'');
            }
            else{
                $error = "<p style='color: red; font-family: bello;'>Le pseudo ou le mot de passe est incorrect !</p>";
                $errorAlert = "";
            }
        }
        else{
            $error = "<p style='color: red; font-family: bello;'>Tous les champs doivent être complétés !</p>";
        }
    }
?>