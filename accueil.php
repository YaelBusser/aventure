    <?php 
    session_start();
        require('bdd.php');

        $errorInscription1 = "Veuillez renseigner votre pseudo ! ";
        $errorInscription12 = "Votre pseudo doit être compris entre 3 et 16 caractères !";
        $errorInscription2 = "Veuillez renseigner le niveau de difficulté ! ";

        if(isset($_POST['btnInscription'])){
            $pseudo = htmlspecialchars($_POST['pseudo']);
            $difficulte = htmlspecialchars($_POST["difficulte"]);
            $mailInscription = htmlspecialchars($_POST['mailInscription']);
            $mailInscription2 = htmlspecialchars($_POST['mailInscription2']);
            $mdpInscription = sha1($_POST['mdpInscription']);
            $mdpInscription2 = sha1($_POST['mdpInscription2']);

            $_SESSION["pseudo"] = $pseudo;
            $_SESSION["difficulte"] = $difficulte;

            if(!empty($pseudo)){
                header("Location: accueil.php?errorInscription");
                if(!empty($difficulte)){
                    if(strlen($_SESSION["pseudo"]) <= 16 && strlen($_SESSION["pseudo"]) >= 3){

                        //header("Location: accueil.php?errorInscription");
                    }else{
                        header("Location: accueil.php?errorInscription&errorInscription12");
                    }
                }else{
                    header("Location: accueil.php?errorInscription&errorInscription2");
                }
            }else{
                header("Location: accueil.php?errorInscription&errorInscription1");
            }
        }
    ?>
<!DOCTYPE html>
<html>
    <?php
        include("head.php");
    ?>
    <body lang="fr">
        <header>

        </header>
        <div class="flex-column accueil-block">
            <img src="images/LogoAventure.jpg">
            <h1>Le jeu</h1>
            <form method="POST" action="connexion.php" class="form-connexion">
                <div class="flex-column connexion" style="<?php if(isset($_GET["errorInscription"])){?>display: none;<?php } ?>" id="connexion">
                    <h2>Connexion</h2>
                    <div class="flex-column">
                        <div class="flex auto">
                            <label for="mail"><i class="fa fa-user"></i></label>
                            <input type="email" name="mail" id="mail" placeholder="Entrez votre adresse mail...">
                        </div>
                        <div class="erreurForm" id="erreurMail"></div>
                    </div>
                    <div class="flex auto">
                        <label for="mdp"><i class="fa fa-lock"></i></label>
                        <input type="password" name="mdp" id="mdp" placeholder="Entrez votre mot de passe...">
                    </div>
                    <input type="submit" name="btn" id="btn" value="Entrez dans l'aventure !">
                    <p class="text-under-submit">Pas encore inscrit ? <span id="span-inscription">Cliquez ici.</span></p>
                </div>
            </form>
            <form method="POST" class="form-connexion">
                <div class="flex-column inscription" style="<?php if(isset($_GET["errorInscription"])){?>display: block;<?php } ?>" id="inscription">
                    <h2>Créer votre avatar !</h2>
                    <div class="flex-column">
                        <div class="flex auto">
                            <label for="pseudo"><i class="fa fa-user-circle"></i></label>
                            <input type="text" name="pseudo" id="pseudo" placeholder="Entrez votre pseudonyme..." value="<?php if(isset($_SESSION["pseudo"])){ echo $_SESSION["pseudo"]; } ?>">
                        </div>
                        <div class="erreurForm" <?php if(isset($_GET["errorInscription1"]) || isset($_GET["errorInscription12"])){ echo "style='display: block;'";} ?>>
                            <?php 
                                if(isset($_GET["errorInscription1"])){ 
                                    echo $errorInscription1; 
                                }
                                if(isset($_GET["errorInscription12"])){
                                    echo $errorInscription12;
                                }
                            ?>
                        </div>
                    </div>
                    <div class="flex-column">
                        <div class="flex auto">
                            <label for="difficulte"><i class="iconify" data-icon="emojione-monotone:level-slider"></i></label>
                            <select name="difficulte" id="difficulte">
                                <option value="<?php if(!empty($_SESSION["difficulte"])){ echo $_SESSION["difficulte"]; } ?>"><?php if(!empty($_SESSION["difficulte"])){ echo $_SESSION["difficulte"]; }else{?>Veuillez sélectionner une difficulté...<?php }?></option>
                                <?php if($_SESSION["difficulte"] != "facile"){?><option value="facile">facile</option><?php } ?>
                                <?php if($_SESSION["difficulte"] != "normale"){?><option value="normale">normale</option><?php } ?>
                                <?php if($_SESSION["difficulte"] != "challenge"){?><option value="challenge">challenge</option><?php } ?>
                                <?php if($_SESSION["difficulte"] != "impossible"){?><option value="impossible">impossible</option><?php } ?>
                            </select>
                        </div>
                        <div class="erreurForm" <?php if(isset($_GET["errorInscription2"])){ echo "style='display: block;'";} ?>><?php if(isset($_GET["errorInscription2"])){ echo $errorInscription2; } ?></div>
                    </div>
                    <div class="flex caracteristiques">
                        <label for="force"><i class="iconify" data-icon="icon-park-outline:muscle"></i></label>
                        <img id="img-arrow-left-force" src="images/arrow_left.png" onclick="this.parentNode.querySelector('input[type=number]').stepDown()" >
                        <input type="number" min="0" max="40" placeholder="0" name="force" id="force" value="10" readonly>
                        <img id="img-arrow-right-force" src="images/arrow_right.png" onclick="this.parentNode.querySelector('input[type=number]').stepUp()">
                        <div class="bonus-malus" id="bonusMalusForce"></div>
                    </div>
                    <div class="flex caracteristiques">
                        <label for="agilite"><i class="iconify" data-icon="grommet-icons:yoga"></i></label>
                        <img id="img-arrow-left-agilite" src="images/arrow_left.png" onclick="this.parentNode.querySelector('input[type=number]').stepDown()" >
                        <input type="number" min="0" max="40" placeholder="0" name="agilite" id="agilite" value="10" readonly>
                        <img id="img-arrow-right-agilite" src="images/arrow_right.png" onclick="this.parentNode.querySelector('input[type=number]').stepUp()">
                        <div class="bonus-malus" id="bonusMalusAgilite"></div>
                    </div>
                    <div class="flex caracteristiques">
                        <label for="dexterite"><i class="iconify" data-icon="icon-park-outline:brain"></i></label>
                        <img id="img-arrow-left-dexterite" src="images/arrow_left.png" onclick="this.parentNode.querySelector('input[type=number]').stepDown()" >
                        <input type="number" min="0" max="40" placeholder="0" name="dexterite" id="dexterite" value="10" readonly>
                        <img id="img-arrow-right-dexterite" src="images/arrow_right.png" onclick="this.parentNode.querySelector('input[type=number]').stepUp()">
                        <div class="bonus-malus" id="bonusMalusDexterite"></div>
                    </div>
                    <div class="flex caracteristiques">
                        <label for="constitution"><i class="iconify" data-icon="ion:body"></i></label>
                        <img id="img-arrow-left-constitution" src="images/arrow_left.png" onclick="this.parentNode.querySelector('input[type=number]').stepDown()" >
                        <input type="number" min="0" max="40" placeholder="0" name="constitution" id="constitution" value="10" readonly>
                        <img id="img-arrow-right-constitution" src="images/arrow_right.png" onclick="this.parentNode.querySelector('input[type=number]').stepUp()">
                        <div class="bonus-malus" id="bonusMalusConstitution"></div>
                    </div>
                    <div class="flex auto">
                        <label for="mailInscription"><i class="iconify" data-icon="bi:at"></i></label>
                        <input type="email" name="mailInscription" id="mailInscription" placeholder="Entrez votre adresse mail...">
                    </div>
                    <div class="flex auto">
                        <label for="mailInscription2"><i class="iconify" data-icon="bi:at"></i></label>
                        <input type="email" name="mailInscription2" id="mailInscription2" placeholder="Confirmez votre adresse mail...">
                    </div>
                    <div class="flex auto">
                        <label for="mdpInscription"><i class="fa fa-lock"></i></label>
                        <input type="password" name="mdpInscription" id="mdpInscription" placeholder="Entrez votre mot de passe...">
                    </div>
                    <div class="flex auto">
                        <label for="mdpInscription2"><i class="fa fa-lock"></i></label>
                        <input type="password" name="mdpInscription2" id="mdpInscription2" placeholder="Confirmez votre mot de passe...">
                    </div>
                    <input type="submit" name="btnInscription" id="btnInscription" value="S'inscrire">
                    <p class="text-under-submit">Déjà inscrit ? <span id="span-connexion">Cliquez ici.</span></p>
                    <div class="erreurForm" id="erreurPseudo"><?php if(isset($_GET["errorInscription1"])){ echo $errorInscription1; } ?></div>
                </div>
            </form>
        </div>
        <div class="accueil-description">
            <h1>Description</h1>
            <div class="block-p-description auto">
                <p>Bienvenue dans Aventure, jeu de rôle en ligne dans lequel vous incarnerez un avatar.</p>
                <p>Cet avatar arrivera dans un monde dont il ne connaît rien avec un équipement limité.</p>
                <p>Son seul but sera de survivre, de progresser et de trouver la clé permettant de passer dans le monde suivant.</p>
                <p>Etes-vous prêt à tenter l’aventure ?</p>
            </div>
        </div>
        <footer>
            <?php 
                include("footer.php");
            ?>
        </footer>
        <script src="js/main.js"></script>
    </body>
</html>