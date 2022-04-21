<?php 
    session_start();
    require("bdd.php");
    if(isset($_POST['btn-connexion'])){
        if(isset($_POST["mail"]) && isset($_POST["mdp"])){
            $mailConnexion = htmlspecialchars($_POST["mail"]);
            $mdpConnexion = htmlspecialchars($_POST["mdp"]);
            $requete_membres = $bdd -> prepare("SELECT mail_joueur, mdp_joueur FROM joueur WHERE mail_joueur = :mail AND mdp_joueur = PASSWORD(:mdp)");
            $requete_membres -> bindValue(":mail",$mailConnexion , PDO::PARAM_STR);
            $requete_membres -> bindValue(":mdp", $mdpConnexion, PDO::PARAM_STR);
            $requete_membres -> execute();
            $user_exist = $requete_membres -> rowCount();
            if($user_exist == 1){
                $requete_user = $bdd -> prepare("SELECT id_joueur, mail_joueur, mdp_joueur FROM joueur WHERE mail = :mail");
                $requete_membres -> bindValue(":mail", $mailConnexion, PDO::PARAM_STR);
                $user = $requete_membres -> fetch(); 
                $req_perso = $bdd -> prepare("SELECT nom_perso, id_difficulte, force_perso, agilite_perso, dexterite_perso, constitution_perso FROM perso WHERE 
                id_joueur = :idJoueur");
                $req_perso -> bindValue(":idJoueur", $user["id_joueur"], PDO::PARAM_INT);
                $req_perso -> execute();
                $perso = $req_perso -> fetch();
                $_SESSION["id_joueur"] = $user["id_joueur"];
                $_SESSION["mail"] = $user["mail_joueur"];
                $_SESSION["mdp"] = $user["mdp_joueur"];
                $_SESSION["nom_perso"] = $perso["nom_perso"];
                header("Location: connexion.php");
            }else{
                $erreurConnexion = "Le compte ou le mot de passe n'existe pas !";
            }
        }
    }
    if(isset($_POST['btnInscription'])){
        if(isset($_POST['pseudo']) && isset($_POST["difficulte"]) && isset($_POST["force"]) &&
        isset($_POST["agilite"]) && isset($_POST["dexterite"]) && isset($_POST["constitution"]) && 
        isset($_POST['mailInscription']) && isset($_POST['mailInscription2']) && isset($_POST['mdpInscription']) &&
        isset($_POST['mdpInscription2'])){
            $pseudo = htmlspecialchars($_POST['pseudo']);
            $difficulte = htmlspecialchars($_POST["difficulte"]);
            echo $difficulte;
            $force = htmlspecialchars($_POST["force"]);
            $agilite = htmlspecialchars($_POST["agilite"]);
            $dexterite = htmlspecialchars($_POST["dexterite"]);
            $constitution = htmlspecialchars($_POST["constitution"]);
            $mailInscription = htmlspecialchars($_POST['mailInscription']);
            $mailInscription2 = htmlspecialchars($_POST['mailInscription2']);
            $mdpInscription = htmlspecialchars($_POST['mdpInscription']);
            $mdpInscription2 = htmlspecialchars($_POST['mdpInscription2']);
            if(!empty($pseudo) && !empty($difficulte) && !empty($force) && !empty($force) && !empty($agilite) && !empty($dexterite) && !empty($constitution) &&
                !empty($mailInscription) && !empty($mailInscription2) && !empty($mdpInscription) && !empty($mdpInscription2)){
                    $req_compte = $bdd -> prepare("SELECT id_joueur, mail_joueur FROM joueur WHERE mail_joueur = :mail");
                    $req_compte -> bindValue(":mail", $mailInscription, PDO::PARAM_STR);
                    $req_compte -> execute();
                    $compte_exist = $req_compte -> rowCount();
        
                    if($compte_exist == 0){
                        $creation_compte = $bdd -> prepare("INSERT INTO joueur(mail_joueur, mdp_joueur) VALUES(:mail, PASSWORD(:mdp))");
                        $creation_compte -> bindValue(":mail", $mailInscription, PDO::PARAM_STR);
                        $creation_compte -> bindValue(":mdp", $mdpInscription, PDO::PARAM_STR);
                        $creation_compte -> execute();
                        $id_joueur = $bdd -> lastInsertId();
        
                        $req_difficulte = $bdd -> prepare("SELECT id_difficulte FROM difficulte WHERE nom_difficulte = :nomDifficulte");
                        $req_difficulte -> bindValue(":nomDifficulte", $difficulte, PDO::PARAM_STR);
                        $req_difficulte -> execute();
                        $req_difficulte -> debugDumpParams();
                        $info_difficulte = $req_difficulte -> fetch();
                        echo $info_difficulte["id_difficulte"];
                        echo $difficulte;

                        $creation_perso = $bdd -> prepare("INSERT INTO perso(id_joueur, id_difficulte, nom_perso, force_perso, agilite_perso, dexterite_perso, constitution_perso) 
                        VALUES(:idJoueur, :idDifficulte, :nomPerso, :forcePerso, :agilitePerso, :dexteritePerso, :constitutionPerso)");
                        $creation_perso -> bindValue(":idJoueur", $id_joueur, PDO::PARAM_INT);
                        $creation_perso -> bindValue(":idDifficulte", $info_difficulte["id_difficulte"], PDO::PARAM_INT);
                        $creation_perso -> bindValue(":nomPerso", $pseudo, PDO::PARAM_STR);
                        $creation_perso -> bindValue(":forcePerso", $force, PDO::PARAM_INT);
                        $creation_perso -> bindValue(":agilitePerso", $agilite, PDO::PARAM_INT);
                        $creation_perso -> bindValue(":dexteritePerso", $dexterite, PDO::PARAM_INT);
                        $creation_perso -> bindValue(":constitutionPerso", $constitution, PDO::PARAM_INT);
                        $creation_perso -> execute();
        
                        Header("Location: inscription.php");
                    }else{
                        $erreurInscription = "Le mail existe déjà !";
                    }
                }else{
                    $erreurInscription = "Veuillez renseigner tous les champs !";
                }

        }else{
            Header("Location: accueil.php");
        }
    }
?>
<!DOCTYPE html>
<html>
    <body lang="fr">
        <header>
            <?php 
                include("head.php");
            ?>
        </header>
        <div class="loader">
            <span class="lettre">C</span>
            <span class="lettre">H</span>
            <span class="lettre">A</span>
            <span class="lettre">R</span>
            <span class="lettre">G</span>
            <span class="lettre">E</span>
            <span class="lettre">M</span>
            <span class="lettre">E</span>
            <span class="lettre">N</span>
            <span class="lettre">T</span>
        </div>
        <div class="flex-column accueil-block">
            <img src="images/LogoAventure.jpg">
            <h1>Le jeu</h1>
            <form method="POST" class="form-connexion">
                <div class="flex-column connexion" id="connexion">
                    <h2>Connexion</h2>
                    <div class="flex-column">
                        <div class="flex auto">
                            <label for="mail"><i class="fa fa-user"></i></label>
                            <input type="email" name="mail" id="mail" placeholder="Entrez votre adresse mail..." value="<?php if(isset($_POST["mail"])){ echo $_POST["mail"]; } ?>">
                        </div>
                        <div class="erreurForm" id="erreurMail"></div>
                    </div>
                    <div class="flex auto">
                        <label for="mdp"><i class="fa fa-lock"></i></label>
                        <input type="password" name="mdp" id="mdp" placeholder="Entrez votre mot de passe...">
                    </div>
                    <input type="submit" name="btn-connexion" id="btn" value="Entrez dans l'aventure !">
                    <p class="text-under-submit">Pas encore inscrit ? <span id="span-inscription">Cliquez ici.</span></p>
                    <?php
                        if(isset($erreurConnexion)){
                            echo $erreurConnexion;
                        }
                    ?>
                </div>
            </form>
            <form method="POST" action="" class="form-connexion">
                <div class="flex-column inscription" id="inscription">
                    <h2>Créer votre avatar !</h2>
                    <div class="flex-column">
                        <div class="flex auto">
                            <label for="pseudo"><i class="fa fa-user-circle"></i></label>
                            <input type="text" name="pseudo" id="pseudo" placeholder="Entrez votre pseudonyme..." value="<?php if(isset($_POST["pseudo"])){ echo $_POST["pseudo"]; } ?>">
                        </div>
                        <div class="erreurForm"></div>
                    </div>
                    <div class="flex-column">
                        <div class="flex auto">
                            <label for="difficulte"><i class="iconify" data-icon="emojione-monotone:level-slider"></i></label>
                            <select name="difficulte" id="difficulte">
                                <option value=""><span>Veuillez sélectionner une difficulté...</span></option>
                                <option value="facile" <?php if(isset($_POST["difficulte"]) && $_POST["difficulte"] == "facile"){ echo "selected"; }else{ echo ""; } ?>>facile</option>
                                <option value="normale" <?php if(isset($_POST["difficulte"]) && $_POST["difficulte"] == "normale"){ echo "selected"; } else{ echo ""; } ?>>normale</option>
                                <option value="challenge" <?php if(isset($_POST["difficulte"]) && $_POST["difficulte"] == "challenge"){ echo "selected"; } else{ echo ""; } ?>>challenge</option>
                                <option value="impossible" <?php if(isset($_POST["difficulte"]) && $_POST["difficulte"] == "impossible"){ echo "selected"; } else{ echo ""; } ?>>impossible</option>
                            </select>
                        </div>
                        <div class="erreurForm"></div>
                    </div>
                    <div class="flex caracteristiques">
                        <label for="force"><i class="iconify" data-icon="icon-park-outline:muscle"></i></label>
                        <img id="img-arrow-left-force" src="images/arrow_left.png" onclick="this.parentNode.querySelector('input[type=number]').stepDown()" >
                        <input type="number" min="0" max="40" placeholder="0" name="force" id="force" value="10" readonly value="<?php if(isset($_POST["force"])){ echo $_POST["force"]; } ?>">
                        <img id="img-arrow-right-force" src="images/arrow_right.png" onclick="this.parentNode.querySelector('input[type=number]').stepUp()">
                        <div class="bonus-malus" id="bonusMalusForce"></div>
                    </div>
                    <div class="flex caracteristiques">
                        <label for="agilite"><i class="iconify" data-icon="grommet-icons:yoga"></i></label>
                        <img id="img-arrow-left-agilite" src="images/arrow_left.png" onclick="this.parentNode.querySelector('input[type=number]').stepDown()" >
                        <input type="number" min="0" max="40" placeholder="0" name="agilite" id="agilite" value="10" readonly value="<?php if(isset($_POST["agilite"])){ echo $_POST["agilite"]; } ?>">
                        <img id="img-arrow-right-agilite" src="images/arrow_right.png" onclick="this.parentNode.querySelector('input[type=number]').stepUp()">
                        <div class="bonus-malus" id="bonusMalusAgilite"></div>
                    </div>
                    <div class="flex caracteristiques">
                        <label for="dexterite"><i class="iconify" data-icon="icon-park-outline:brain"></i></label>
                        <img id="img-arrow-left-dexterite" src="images/arrow_left.png" onclick="this.parentNode.querySelector('input[type=number]').stepDown()" >
                        <input type="number" min="0" max="40" placeholder="0" name="dexterite" id="dexterite" value="10" readonly value="<?php if(isset($_POST["dexterite"])){ echo $_POST["dexterite"]; } ?>"">
                        <img id="img-arrow-right-dexterite" src="images/arrow_right.png" onclick="this.parentNode.querySelector('input[type=number]').stepUp()">
                        <div class="bonus-malus" id="bonusMalusDexterite"></div>
                    </div>
                    <div class="flex caracteristiques">
                        <label for="constitution"><i class="iconify" data-icon="ion:body"></i></label>
                        <img id="img-arrow-left-constitution" src="images/arrow_left.png" onclick="this.parentNode.querySelector('input[type=number]').stepDown()" >
                        <input type="number" min="0" max="40" placeholder="0" name="constitution" id="constitution" value="10" readonly value="<?php if(isset($_POST["constitution"])){ echo $_POST["constitution"]; } ?>">
                        <img id="img-arrow-right-constitution" src="images/arrow_right.png" onclick="this.parentNode.querySelector('input[type=number]').stepUp()">
                        <div class="bonus-malus" id="bonusMalusConstitution"></div>
                    </div>
                    <div class="flex auto">
                        <label for="mailInscription"><i class="iconify" data-icon="bi:at"></i></label>
                        <input type="email" name="mailInscription" id="mailInscription" placeholder="Entrez votre adresse mail..." value="<?php if(isset($_POST["mailInscription"])){ echo $_POST["mailInscription"]; } ?>">
                    </div>
                    <div class="flex auto">
                        <label for="mailInscription2"><i class="iconify" data-icon="bi:at"></i></label>
                        <input type="email" name="mailInscription2" id="mailInscription2" placeholder="Confirmez votre adresse mail..." value="<?php if(isset($_POST["mailInscription2"])){ echo $_POST["mailInscription2"]; } ?>">
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
                    <?php if(isset($erreurInscription)){
                            echo "<span id='erreurInscription'>".$erreurInscription."</span>"; 
                        } 
                    ?>
                    <p class="text-under-submit">Déjà inscrit ? <span id="span-connexion">Cliquez ici.</span></p>
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
        <?php 
            if(isset($erreurInscription)){
                echo "<script>
                        let afficherRegister = document.getElementById('span-inscription');
                        let blockLogin = document.getElementById('connexion');
                        let blockRegister = document.getElementById('inscription');
                        blockRegister.style.display = 'inline-block';
                        blockLogin.style.display = 'none';
                    </script>";
            }
        ?>
    </body>
</html>