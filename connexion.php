<?php 
    require("bdd.php");
    session_start();
?>
<!DOCTYPE html>
<html>
    <body lang="fr">
        <header>
            <?php 
                include("head.php");
            ?>
        </header>
        <h1 class="h1Inscription">Bienvenue sur votre profil !</h1>
        <div class="block-profil">
            <?= "<p>Mail : ".$_SESSION['mail'].
                "</p><p>Id : ".$_SESSION['id_joueur'].
                "</p><p>Mot de passe crypté : ".$_SESSION['mdp'].
                "</p><p>Nom du personnage : ".$_SESSION['nom_perso']."</p>";
            ?>
        </div>
        <script src="js/main.js"></script>
</body>
</html>