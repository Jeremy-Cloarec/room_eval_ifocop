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

    if($_POST && isset($_POST["buttonSalles"])){

        //id_salle
        // if (!isset($_POST['id_salle']) || !preg_match('#^[a-zA-Z0-9- _.]{3,20}$#', $_POST['id_salle'])) {
        //     $erreur .= "<div class='affichageDanger'>id_salle : Pour ce champs, vous avez le droit d'utiliser tous les caractères alphanumériques.</div>";
        // }


        //Titre
        if (!isset($_POST['titre']) || iconv_strlen($_POST['titre']) < 3 || iconv_strlen($_POST['titre']) > 30) {
            $erreur .= "<div class='affichageDanger'> Titre : Pour ce champ, vous avez le droit d'utiliser tous les caractères alphanumériques. Les caractères spéciaux suivant : -_. et votre titre devra comporter au minimum trois caractère et 30 au maximum.</div>";
        }

        //Description
        if (!isset($_POST['description']) || iconv_strlen($_POST['description']) < 3 || iconv_strlen($_POST['description']) > 80) {
            $erreur .= "<div class='affichageDanger'> Prénom : Pour ce champ, vous avez le droit d'utiliser tous les caractères alphanumériques. Les caractères spéciaux suivant : -_. et votre description devra comporter au minimum trois caractère et 80 au maximum.</div>";
        }

        //Photo

            //Gestion de l'image : modification et ajout de l'image

            //Initialisation de la variable à vide

            $photo_bdd='';

            //En cas d'update de la photo, la valeur que prendra $photo_bdd

            if($_GET['action'] == 'update'){
                $photo_bdd = $_POST['photoActuelle'];
            }

            
            

            //Si l'input pour uploader l'image a reçu un nom de fichier on executera le code suivant dans le bloc d'instruction
            if(!empty($_FILES['photo']['name'])){

                //Je donne un nouveau nom au fichier image. je concatène la réf du produit avec le nom du fichier image
                $photo_nom = $_POST['cp'] . '_' . $_FILES['photo']['name'];

                // En cas d'insertion, $photo_bdd va prendre la valeur de photo_nom, qui sera de type string (double quotes)
                //Elle va servir dans les bindValues pour la modif ou l'insertion, voir ci-dessous
                $photo_bdd = "$photo_nom";

            

                //chemin physique pour uploader l'image vers le projet (dans le dossier img du projet)
                $photo_dossier = RACINE_SITE . "img/$photo_nom";

                //fonction prédéfinie pour copier l'image dans le dossier physique img
                //processus de programmation de copy, doit lui donner un nom de fichier temporaire (1 10e de scde) puis le verse avec son nom définitif dans le dossier img (valeur affectée à  $photo_dossier)
                copy($_FILES['photo']['tmp_name'], $photo_dossier);
            }

            print_r($_POST['photoActuelle']). "<br>";
            print_r($photo_bdd);
        
        //Pays
        if (!isset($_POST['pays']) || $_POST['pays'] != 'France' && $_POST['pays'] != 'Angleterre' && $_POST['pays'] != 'Belgique' && $_POST['pays'] != 'Allemagne') {
            $erreur .= "<div class='affichageDanger'>Pays : vous devez sélectionner une des options pour le pays</div>";
            }

        //Ville
        if (!isset($_POST['ville']) || $_POST['ville'] != 'Paris' && $_POST['ville'] != 'Lyon' && $_POST['ville'] != 'Marseille') {
            $erreur .= "<div class='affichageDanger'>Ville : vous devez sélectionner une des options pour la ville </div>";
            }
        
        //Adresse
        if (!isset($_POST['adresse']) || !preg_match('#^[a-zA-Z0-9-_ .]{3,50}$#', $_POST['adresse'])) {
            $erreur .= "<div class='affichageDanger'>Adresse : Pour ce champ, vous avez le droit d'utiliser tous les caractères alphanumériques. Les caractères spéciaux suivant : -_. et votre adresse devra comporter au minimum trois caractère et 50 au maximum</div>";
        }


        //Code postal
        if (!isset($_POST['cp']) || !preg_match('#^[0-9]{5}$#', $_POST['cp'])) {
            $erreur .= "<div class='affichageDanger'>Code postal : Code postal incorrect</div>";
        }
    

        //Capacité
        if (!isset($_POST['capacite']) || !preg_match('#^[0-9- _.]{0,20}$#', $_POST['capacite'])) {
            $erreur .= "<div class='affichageDanger'>Capacité : Pour ce champs, vous avez le droit d'utiliser tous les caractères numériques.</div>";
        }

        //Categorie
        if (!isset($_POST['categorie']) || $_POST['categorie'] != 'reunion' && $_POST['categorie'] != 'bureau') {
        $erreur .= "<div class='affichageDanger'>Catégorie : vous devez sélectionner une des options pour la catégorie</div>";
        }


        //Requête préparée pour l'insertion en BDD

        if(empty($erreur)) {

            if($_GET['action']=='update'){


                $modifieSalle = $pdo->prepare ("UPDATE salle SET  id_salle = :id_salle, titre = :titre, description = :description, photo = :photo, pays = :pays, ville = :ville, adresse = :adresse,  cp = :cp, capacite = :capacite, categorie = :categorie WHERE id_salle = :id_salle");

                $modifieSalle->bindValue(':id_salle', $_POST['id_salle'], PDO::PARAM_INT);
                $modifieSalle->bindValue(':titre', $_POST['titre'], PDO::PARAM_STR);
                $modifieSalle->bindValue(':description', $_POST['description'], PDO::PARAM_STR);
                $modifieSalle->bindValue(':photo', $photo_bdd, PDO::PARAM_STR);
                $modifieSalle->bindValue(':pays', $_POST['pays'], PDO::PARAM_STR);
                $modifieSalle->bindValue(':ville', $_POST['ville'], PDO::PARAM_STR);
                $modifieSalle->bindValue(':adresse', $_POST['adresse'], PDO::PARAM_STR);
                $modifieSalle->bindValue(':cp', $_POST['cp'], PDO::PARAM_INT);
                $modifieSalle->bindValue(':capacite', $_POST['capacite'], PDO::PARAM_INT);
                $modifieSalle->bindValue(':categorie', $_POST['categorie'], PDO::PARAM_STR);
    
                $modifieSalle->execute();


                $queryUsers = $pdo->query("SELECT titre FROM salle WHERE id_salle ='$_GET[id_salle]' ");

                $salle = $queryUsers->fetch(PDO::FETCH_ASSOC);

                $validate .= '<div class="reussiteInscription">
                <strong>Félicitations !</strong> Modification de la salle <strong>'. $salle['titre'] .'</strong> réussie
                </div>';
                
            }else{

                $ajouterSalle = $pdo->prepare("INSERT INTO salle (titre, description, photo, pays, ville, adresse, cp, capacite, categorie) VALUES (:titre, :description, :photo, :pays, :ville, :adresse, :cp, :capacite, :categorie)");
                
                
                $ajouterSalle->bindValue(':titre', $_POST['titre'], PDO::PARAM_STR);
                $ajouterSalle->bindValue(':description', $_POST['description'], PDO::PARAM_STR);
                $ajouterSalle->bindValue(':photo', $photo_bdd, PDO::PARAM_STR);
                $ajouterSalle->bindValue(':pays', $_POST['pays'], PDO::PARAM_STR);
                $ajouterSalle->bindValue(':ville', $_POST['ville'], PDO::PARAM_STR);
                $ajouterSalle->bindValue(':adresse', $_POST['adresse'], PDO::PARAM_STR);
                $ajouterSalle->bindValue(':cp', $_POST['cp'], PDO::PARAM_INT);
                $ajouterSalle->bindValue(':capacite', $_POST['capacite'], PDO::PARAM_INT);
                $ajouterSalle->bindValue(':categorie', $_POST['categorie'], PDO::PARAM_STR);
    
                $ajouterSalle->execute();

                $validate .="<div class ='reussiteInscription'>Félicitation ! Ajout de la salle réussie !</div>";
            }

        }

    }

    // Récupération des données de l'utilisateur pour les afficher dans les input

    if($_GET['action']=='update'){

        $queryUsers = $pdo->query("SELECT * FROM salle WHERE id_salle ='$_GET[id_salle]' ");
        $salleActuelle = $queryUsers->fetch(PDO::FETCH_ASSOC);

    }


        $id_salle = (isset($salleActuelle['id_salle'])) ? $salleActuelle['id_salle'] : "";
        $titre = (isset($salleActuelle['titre'])) ? $salleActuelle['titre'] : "";
        $description = (isset($salleActuelle['description'])) ? $salleActuelle['description'] : "";
        $photo = (isset($salleActuelle['photo'])) ? $salleActuelle['photo'] : "";
        $pays = (isset($salleActuelle['pays'])) ? $salleActuelle['pays'] : "";
        $ville = (isset($salleActuelle['ville'])) ? $salleActuelle['ville'] : "";
        $adresse = (isset($salleActuelle['adresse'])) ? $salleActuelle['adresse'] : "";
        $cp = (isset($salleActuelle['cp'])) ? $salleActuelle['cp'] : "";
        $capacite = (isset($salleActuelle['capacite'])) ? $salleActuelle['capacite'] : "";
        $categorie = (isset($salleActuelle['categorie'])) ? $salleActuelle['categorie'] : "";



    if($_GET['action'] == 'delete'){
        $pdo->query("DELETE FROM salle WHERE id_salle = '$_GET[id_salle]'");    
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
                                            <th><?= $colonne['name'] ?></th>
                                    <?php } ?>
                                    <th colspan="2">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php while ($tousUsers = $afficheTousUsers->fetch(PDO::FETCH_ASSOC)) : ?>
                                    <tr>
                                        <?php foreach ($tousUsers as $key => $value) : ?>
                                            <?php if ($key == 'photo') : ?>
                                                
                                                <td><img src="<?= URL . "img/" . $value ?>" alt="" width="50"></td>
                                            <?php else:?>
                                                <td><?= $value ?></td>                                                
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

                            <form action="" class="inscriptionForm form" method="POST" enctype="multipart/form-data">
                                
                                <!-- id_salle -->

                                <div class="champInput">
                                    <input class="" type="hidden" name="id_salle" value="<?=$id_salle?>">
                                </div>

                                <!-- Titre -->

                                <div class="champInput">
                                    <label class="" for="titre">
                                    Titre
                                    </label>
                                    <input class="" type="text" value="<?= $titre ?>" name="titre" id="titre" placeholder="Entrez votre titre">
                                </div>

                                <!-- Description-->

                                <div class="champInput">
                                    <label class="" for="description">
                                    Description
                                    </label>
                                    <textarea class="" type="text" name="description" id="description" placeholder="Entrez votre description"><?= $description?></textarea>
                                </div>


                                <!-- Photo -->

                                <div class="champInput">
                                    <label class="" for="photo">
                                    Photo
                                    </label>
                                    <input class="" type="file" name="photo" id="photo" placeholder="Photo">
                                    <?php if(!empty($photo)): ?>
                                        <div class="">
                                            <p>Vous pouvez changer d'image
                                                <img src="<?= URL . 'img/' . $photo ?> " width="50px" alt="Miniature de <?= $photo ?>">
                                            </p>
                                        </div>
                                    <?php endif; ?>

                                    <!-- Input de type hidden qi va permettre d'envoyer une nouvelle photo/valeur si on veut la modifier -->

                                    <input type="hidden" name='photoActuelle' value='<?=$photo?>'>
                                    
                                </div>

                                <!-- Pays -->

                                <div class="champInput">
                                    <label for="pays">Sélectionnez un pays</label>
                                    <select name="pays" id="pays">
                                        <option value="">--Choisissez une option--</option>
                                        <option value="France"<?=($pays=='France') ? 'selected': ''?>>France</option>
                                        <option value="Angleterre"<?=($pays=='Angleterre') ? 'selected': ''?>>Angleterre</option>
                                        <option value="Belgique"<?=($pays=='Belgique') ? 'selected': ''?>>Belgique</option>
                                        <option value="Allemagne"<?=($pays=='Allemagne') ? 'selected': ''?>>Allemagne</option>
                                    </select>
                                </div>

                                <!-- Ville -->

                                <div class="champInput">
                                    <label for="ville">Sélectionnez une ville</label>
                                    <select name="ville" id="ville">
                                        <option value="">--Choisissez une option--</option>
                                        <option value="Paris"<?=($ville=='Paris') ? 'selected': ''?>>Paris</option>
                                        <option value="Lyon"<?=($ville=='Lyon') ? 'selected': ''?>>Lyon</option>
                                        <option value="Marseille"<?=($ville=='Marseille') ? 'selected': ''?>>Marseille</option>
                                    </select>
                                </div>

                                <!-- Adresse -->

                                <div class="champInput">
                                <label class="" for="adresse">
                                        Adresse
                                    </label>
                                    <input class="" type="text" name="adresse" id="adresse" value="<?= $adresse?>" placeholder="adresse">
                                </div>

                                <!-- Code postal -->

                                <div class="champInput">
                                    <label class="" for="cp">
                                        Code postal
                                    </label>
                                    <input class="" type="text" name="cp" id="cp" value="<?=$cp?>" placeholder="Entrez votre code postal">
                                </div>


                                <!-- Capacité -->

                                <div class="champInput">
                                    <label class="" for="capacite">
                                        Capacité de la salle
                                    </label>
                                    <input class="" type="text" name="capacite" id="capacite" value="<?= $capacite?>" placeholder="capacite">
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


                                <div class="champInput">
                                    <button name="buttonSalles" class="buttonFormulaire">Valider</button>
                                </div>
                            </form>
                        <?php endif; ?>
                    </div>

                </main>

            </div>


    </div>


<?php require_once('includeAdmin/footerAdmin.php') ?>



