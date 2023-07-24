

<?php
require_once('include/fonctions.php');
require_once('include/init.php');


    if(internauteConnecte()){
        header('location:' . URL . 'profil.php');
        exit();
    }

    $title = "Formulaire d'insciption";

    if($_POST){

        //pseudo
        if (!isset($_POST['pseudo']) || !preg_match('#^[a-zA-Z0-9- _.]{3,20}$#', $_POST['pseudo'])) {
            $erreur .= "<div class='affichageDanger'> Pseudo : Pour ce champ, vous avez le droit d'utiliser tous les caractères alphanumériques. Les caractères spéciaux suivant : -_. et votre pseudo devra comporter au minimum trois caractère et 20 au maximum.</div>";
        }

        //mdp
        if (!isset($_POST['mdp']) || strlen($_POST['mdp']) < 3 || strlen($_POST['mdp']) > 20) {
            $erreur .= "<div class='affichageDanger'> Mot de passe : Il doit comporter minimum 8 caractères et maximum 20 </div>";
        }



        //Nom
        if (!isset($_POST['nom']) || iconv_strlen($_POST['nom']) < 3 || iconv_strlen($_POST['nom']) > 20) {
            $erreur .= "<div class='affichageDanger'> Nom : Pour ce champ, vous avez le droit d'utiliser tous les caractères alphanumériques. Les caractères spéciaux suivant : -_. et votre pseudo devra comporter au minimum trois caractère et 20 au maximum.</div>";
        }

        //Prénom
        if (!isset($_POST['prenom']) || iconv_strlen($_POST['prenom']) < 3 || iconv_strlen($_POST['prenom']) > 20) {
            $erreur .= "<div class='affichageDanger'> Prénom : Pour ce champ, vous avez le droit d'utiliser tous les caractères alphanumériques. Les caractères spéciaux suivant : -_. et votre pseudo devra comporter au minimum trois caractère et 20 au maximum.</div>";
        }

        //email
        if (!isset($_POST['email']) || !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
            $erreur .= "<div class='affichageDanger'> Email : Votre adresse semble ne pas respecter un format valide</div>";
        }

          //Civilite
        if (!isset($_POST['civilite']) || $_POST['civilite'] != 'f' && $_POST['civilite'] != 'm') {
        $erreur .= "<div class='affichageDanger'>Erreur, vous devez cocher une des options pour la civilité</div>";
    }

        //Vérification du pseudo

        $verifPseudo = $pdo->prepare("SELECT pseudo FROM membre WHERE pseudo = :pseudo");
        $verifPseudo->bindValue(':pseudo', $_POST['pseudo'], PDO::PARAM_STR);
        $verifPseudo->execute();

        if ($verifPseudo->rowCount() == 1) {
            $erreur .= "<div class='affichageDanger'> Ce pseudo est déjà utilisé, choisissez en un autre</div>";
        }

        //Cryptage du mdp

        $_POST['mdp'] = password_hash($_POST['mdp'], PASSWORD_DEFAULT);

        //Requête préparée pour l'insertion en BDD

        if(empty($erreur)) {

            $inscrireUser = $pdo->prepare("INSERT INTO membre (pseudo, mdp, nom, prenom, email, civilite) VALUES (:pseudo, :mdp, :nom, :prenom, :email, :civilite)");

            $inscrireUser->bindValue(':pseudo', $_POST['pseudo'], PDO::PARAM_STR);
            $inscrireUser->bindValue(':mdp', $_POST['mdp'], PDO::PARAM_STR);
            $inscrireUser->bindValue(':nom', $_POST['nom'], PDO::PARAM_STR);
            $inscrireUser->bindValue(':prenom', $_POST['prenom'], PDO::PARAM_STR);
            $inscrireUser->bindValue(':email', $_POST['email'], PDO::PARAM_STR);
            $inscrireUser->bindValue(':civilite', $_POST['civilite'], PDO::PARAM_STR);

            $inscrireUser->execute();

            header('location:' . URL . 'connexion.php?action=validate');

        }
        
    }

?>




    

    <?php
    require_once('include/header.php');
    ?>
    <div class="globalContainer">
        <main>
            <aside class="menuLateral"></aside>
            <h1>Inscription</h1>
            <div class="inscription">

                <h2>S'inscrire</h2>

                <?= $erreur ?>

                <form action="" class="inscriptionForm form" method="POST">
                    <!-- pseudo, mdp,nom, prenom, email -->
                    <div class="champInput">
                        <label class="" for="pseudo">
                        Pseudo
                        </label>
                        <input class="" type="text" name="pseudo" id="pseudo" placeholder="Votre pseudo" max-length="20" pattern="[a-zA-Z0-9-_.]{3,20}" required>
                    </div>
                    <div class="champInput">
                        <label class="" for="mdp">
                        Mot de passe
                        </label>
                        <input class="" type="password" name="mdp" id="mdp" placeholder="Votre mot de passe" max-length="20" pattern="[a-zA-Z0-9-_.]{3,20}" required>
                    </div>
                    <div class="champInput">
                        <label class="" for="nom">
                        Nom
                        </label>
                        <input class="" type="text" name="nom" id="nom" placeholder="Votre nom" required>
                    </div>
                    <div class="champInput">
                        <label class="" for="prenom">
                        Prénom
                        </label>
                        <input class="" type="text" name="prenom" id="prenom" placeholder="Votre prénom" required>
                    </div>
                    <div class="champInput">
                        <label class="" for="email">
                        email
                        </label>
                        <input class="" type="email" name="email" id="email" placeholder="Votre email" required>
                    </div>
                    <div class="">
                        <p>
                            <div class="">Civilité</div>
                        </p>
                        <div class="">
                            <input class="" type="radio" name="civilite" id="civilite1" value="f">
                            <label class="" for="civilite1">f</label>
                        </div>
                        <div class="">
                            <input class="" type="radio" name="civilite" id="civilite2" value="m">
                            <label class="" for="civilite2">m</label>
                        </div>
                    </div>
                    <div class="champInput">
                        <button name="buttonInscription" class="buttonFormulaire">Valider</button>
                    </div>
                </form>
            </div>


        </main>

    </div>

<?php require_once('include/footer.php');?>


