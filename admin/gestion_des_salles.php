<?php

require_once('../include/init.php');
require_once('../include/fonctions.php');


$title= "Gestion des salles";


if(!internauteConnecteAdmin()){
    header('location:' . URL . 'connexion.php');
    exit();
}



// Validation du formulaire conditionné à l'action reçue dans l'url

if(isset($_GET["action"])){

    if($_POST){

        if (!isset($_POST['pseudo']) || !preg_match('#^[a-zA-Z0-9- _.]{3,20}$#', $_POST['pseudo'])) {
            $erreur .= "<div class='affichageDanger'> Pseudo : Pour ce champ, vous avez le droit d'utiliser tous les caractères alphanumériques. Les caractères spéciaux suivant : -_. et votre pseudo devra comporter au minimum trois caractère et 20 au maximum.</div>";
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

        if($_GET['action']=='add'){

            //mdp
            if (!isset($_POST['mdp']) || strlen($_POST['mdp']) < 3 || strlen($_POST['mdp']) > 20) {
                $erreur .= "<div class='affichageDanger'> Mot de passe : Il doit comporter minimum 8 caractères et maximum 20 </div>";
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

        }

        //Requête préparée pour l'insertion en BDD

        if(empty($erreur)) {

            if($_GET['action']=='update'){

                $modifierUser = $pdo->prepare("UPDATE membre SET  id_membre = :id_membre, pseudo = :pseudo, nom = :nom, prenom = :prenom, email = :email, civilite = :civilite WHERE id_membre = :id_membre");

                $modifierUser->bindValue(':id_membre', $_POST['id_membre'], PDO::PARAM_INT);
                $modifierUser->bindValue(':pseudo', $_POST['pseudo'], PDO::PARAM_STR);
            
                $modifierUser->bindValue(':nom', $_POST['nom'], PDO::PARAM_STR);
                $modifierUser->bindValue(':prenom', $_POST['prenom'], PDO::PARAM_STR);
                $modifierUser->bindValue(':email', $_POST['email'], PDO::PARAM_STR);
                $modifierUser->bindValue(':civilite', $_POST['civilite'], PDO::PARAM_STR);
    
                $modifierUser->execute();

                $queryUsers = $pdo->query("SELECT pseudo FROM membre WHERE id_membre ='$_GET[id_membre]' ");

                $user = $queryUsers->fetch(PDO::FETCH_ASSOC);

                $validate .= '<div class="reussiteInscription">
                <strong>Félicitations !</strong> Modification du user <strong>'. $user['pseudo'] .'</strong> réussie !>
                </div>';
                
            }else{

                $ajouterUser = $pdo->prepare("INSERT INTO membre (pseudo, mdp, nom, prenom, email, civilite) VALUES (:pseudo, :mdp, :nom, :prenom, :email, :civilite)");

                $ajouterUser->bindValue(':pseudo', $_POST['pseudo'], PDO::PARAM_STR);
                $ajouterUser->bindValue(':mdp', $_POST['mdp'], PDO::PARAM_STR);
                $ajouterUser->bindValue(':nom', $_POST['nom'], PDO::PARAM_STR);
                $ajouterUser->bindValue(':prenom', $_POST['prenom'], PDO::PARAM_STR);
                $ajouterUser->bindValue(':email', $_POST['email'], PDO::PARAM_STR);
                $ajouterUser->bindValue(':civilite', $_POST['civilite'], PDO::PARAM_STR);

                $ajouterUser->execute();

                $validate .="<div class ='reussiteInscription'>Félicitation ! Ajout du user réussie !</div>";
            }

        }

    }

    // Récupération des données de l'utilisateur pour les afficher dans les input

    if($_GET['action']=='update'){

        $queryUsers = $pdo->query("SELECT * FROM salle WHERE id_salle ='$_GET[id_salle]' ");
        $userActuel = $queryUsers->fetch(PDO::FETCH_ASSOC);
    

        $id_membre = (isset($userActuel['id_membre'])) ? $userActuel['id_membre'] : "";
        $pseudo = (isset($userActuel['pseudo'])) ? $userActuel['pseudo'] : "";
        $nom = (isset($userActuel['nom'])) ? $userActuel['nom'] : "";
        $prenom = (isset($userActuel['prenom'])) ? $userActuel['prenom'] : "";
        $email = (isset($userActuel['email'])) ? $userActuel['email'] : "";
        $civilite = (isset($userActuel['civilite'])) ? $userActuel['civilite'] : "";

    }

    if(isset($GET['action']) || $_GET['action']=='add'){
        $pseudo="";
        $nom="";
        $prenom="";
        $email="";
        $civilite="";
    }

    if($_GET['action'] == 'delete'){

        $pdo->query("DELETE FROM membre WHERE id_membre = '$_GET[id_membre]'");    
    }

}

?>





<?php
require_once('includeAdmin/headerAdmin.php');
?>

    <div class="globalContainer">

            <div class="adminContainer">

                <?php require_once('includeAdmin/navAside.php');?>

                <main class="mainAdmin">
                
                    <h1>Gestion des salles</h1>

                    <?php $queryUsers = $pdo->query("SELECT id_salle FROM salle") ?>

                    
                    <!-- Tableaux des membres -->

                    <h2>Nombre de salles en base de données : <?= $queryUsers->rowCount() ?></h2>


                    <div class="table-container">
                        <table>
                            <?php $afficheTousUsers = $pdo->query("SELECT * FROM salle ORDER BY titre") ?>

                            <thead>
                                <tr>
                                    <?php for ($i = 0; $i < $afficheTousUsers->columnCount(); $i++) {

                                        $colonne = $afficheTousUsers->getColumnMeta($i);

                                    ?>

                                        <?php if ($colonne['name'] != 'mdp') : ?>
                                            <th><?= $colonne['name'] ?></th>
                                        <?php endif; ?>

                                        <?php

                                        ?>

                                    <?php } ?>
                                    <th colspan="2">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php while ($tousUsers = $afficheTousUsers->fetch(PDO::FETCH_ASSOC)) : ?>
                                    <tr>
                                        <?php foreach ($tousUsers as $key => $value) : ?>
                                            <?php if ($key != 'mdp') : ?>
                                                <td><?= $value ?> </td>
                                            <?php endif; ?>
                                        <?php endforeach; ?>
                                        <td><a href='?action=update&id_salle=<?= $tousUsers['id_salle'] ?>'><i class="bi bi-pen-fill"></i></a></td>

                                        <td><a href="?action=delete&id_salle=<?= $tousUsers['id_salle'] ?>"><i class="bi bi-trash-fill" style="font-size: 1.5rem;"></i></a></td>

                                    </tr>
                                <?php endwhile;?>
                            </tbody>
                        </table>
                    </div>

                    <!-- Formulaire de modificaations des membres -->

                    <?php 
                    $actionbutton="?action=add";
                    ?>

                    <div class="modifFormulaire">
                        <a href="<?= $actionbutton;?>" class="espacemembre btnModifFormulaire">
                            <?php if(isset($_GET['action'])): ?>
                                Ajouter un utilisateur
                            
                            <?php else:?>
                                
                                Afficher le tableau
                                
                            <?php endif;?>

                        </a>
                    </div>

                    <?= $erreur; ?>
                    <?= $validate; ?>

                    <div class="inscription">


                        <?php if(isset($_GET['action'])): ?>

                            <h2>Formulaire <?= ($_GET['action'] == "add") ? "d'ajout" : "de modification" ?> des salles </h2>

                            <form action="" class="inscriptionForm form" method="POST">

                                <!-- 
                                    id_salle (hidden)
                                    Titre
                                    Description
                                    Photo
                                    Capacité
                                    Catégorie
                                    pays
                                    Ville
                                    Adresse
                                    Code Postale

                                -->
                                
                                <!-- id_salle -->

                                <div class="champInput">
                                    <input class="" type="hidden" name="id_salle" value="<?=$id_salle?>">
                                </div>

                                <!-- Titre -->

                                <div class="champInput">
                                    <label class="" for="titre">
                                    Titre
                                    </label>
                                    <input class="" type="text" value="<?= $titre ?>" name="titre" id="titre" placeholder="Description de la salle">
                                </div>

                                <!-- description -->

                                <div class="champInput">
                                    <label class="" for="description">
                                    Description
                                    </label>
                                    <textarea class="" type="text" name="description" id="description" placeholder="Description de la salle"><?= $description?></textarea>
                                </div>

                                <!-- Photo -->

                                <!-- Capacité -->

                                <div class="champInput">
                                    <label class="" for="capacite">
                                        capacite
                                    </label>
                                    <input class="" type="text" name="capacite" id="capacite" value="<?= $stock?>" placeholder="capacite">
                                </div>

                                <!-- Catégorie -->

                                <div class="champInput">

                                    <label for="categorie">Sélectionnez une catégorie</label>

                                    <select name="categorie" id="categorie">
                                        <option value="">--Choississez une option--</option>
                                        <option value="reunion"<?=($categorie=='reunion') ? 'selected': ''?>>Réunion</option>
                                        <option value="bureau"<?=($categorie=='bureau') ? 'selected': ''?>>Bureau</option>
                                    </select>
                                </div>

                                <!-- Pays -->

                                <div class="champInput">
                                    <label for="pays">Sélectionnez un pays</label>
                                    <select name="pays" id="pays">
                                        <option value="">--Choississez une option--</option>
                                        <option value="france"<?=($pays=='france') ? 'selected': ''?>>France</option>
                                        <option value="angleterre"<?=($pays=='angleterre') ? 'selected': ''?>>Angleterre</option>
                                        <option value="belgique"<?=($pays=='Belgique') ? 'selected': ''?>>Belgique</option>
                                        <option value="allemagne"<?=($pays=='allemagne') ? 'selected': ''?>>Allemagne</option>
                                    </select>
                                </div>

                                <!-- Ville -->

                                <div class="champInput">
                                    <label for="ville">Sélectionnez un pays</label>
                                    <select name="ville" id="ville">
                                        <option value="">--Choississez une option--</option>
                                        <option value="paris"<?=($pays=='paris') ? 'selected': ''?>>Paris</option>
                                        <option value="lyon"<?=($pays=='lyon') ? 'selected': ''?>>Lyon</option>
                                        <option value="marseille"<?=($pays=='marseille') ? 'selected': ''?>>Marseille</option>
                                    </select>
                                </div>

                                <!-- Adresse -->

                                
                                <!-- Code postal -->




                                <div class="champInput">
                                    <label class="" for="nom">
                                    Nom
                                    </label>
                                    <input class="" type="text" value="<?= $nom ?>" name="nom" id="nom" placeholder="Votre nom" required>
                                </div>
                                <div class="champInput">
                                    <label class="" for="prenom">
                                    Prénom
                                    </label>
                                    <input class="" type="text" name="prenom" id="prenom" value="<?= $prenom ?>" placeholder="Votre prénom" required>
                                </div>
                                <div class="champInput">
                                    <label class="" for="email">
                                    email
                                    </label>
                                    <input class="" type="email" name="email" id="email" placeholder="Votre email" value="<?= $email ?>">
                                </div>
                                <div class="">
                                    <p>
                                        <div class="">Civilité</div>
                                    </p>
                                    <div class="">
                                        <input class="" type="radio" name="civilite" id="civilite1" value="f" <?= ($civilite == "f") ? "checked" : "" ?>>
                                        <label class="" for="civilite1">f</label>
                                    </div>
                                    <div class="">
                                        <input class="" type="radio" name="civilite" id="civilite2" value="m" <?= ($civilite == "m") ? "checked" : "" ?>>
                                        <label class="" for="civilite2">m</label>
                                    </div>
                                </div>
                                <div class="champInput">
                                    <button name="buttonMembres" class="buttonFormulaire">Valider</button>
                                </div>
                            </form>
                        <?php endif; ?>
                    </div>

                </main>

            </div>


    </div>


<?php require_once('includeAdmin/footerAdmin.php') ?>



