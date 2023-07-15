<?php

require_once('../include/init.php');
require_once('../include/fonctions.php');


$title= "Gestion des produits";

if(!internauteConnecteAdmin()){
    header('location:' . URL . 'connexion.php');
    exit();
}

?>





<?php
require_once('includeAdmin/headerAdmin.php');
?>

    <div class="globalContainer">

            <div class="adminContainer">

                <?php require_once('includeAdmin/navAside.php');?>

                <main class="mainAdmin">
                
                    <h1>Gestion des produits</h1>

                    <?php $queryUsers = $pdo->query("SELECT id_produit FROM produit") ?>

                    
                    <!-- Tableaux des membres -->

                    <h2>Nombre de salles en base de données : <?= $queryUsers->rowCount() ?></h2>


                    <div class="table-container">
                        <table>
                            <?php $afficheGestionProduit = $pdo->query("SELECT id_produit, id_salle, DATE_FORMAT(date_arrivee, '%d/%m/%Y à %Hh %imn %ss'), DATE_FORMAT(date_depart, '%d/%m/%Y à %Hh %imn %ss'), prix, etat FROM produit ORDER BY id_produit") ?>
                            <thead>
                                <tr>
                                    <?php for ($i = 0; $i < $afficheGestionProduit->columnCount(); $i++) {
                                        $colonne = $afficheGestionProduit->getColumnMeta($i);
                                    ?>
                                        <?php if($colonne['name']== "DATE_FORMAT(date_arrivee, '%d/%m/%Y à %Hh %imn %ss')"):?>
                                            <th>Date d'arrivée</th>
                                        <?php elseif($colonne['name']== "DATE_FORMAT(date_depart, '%d/%m/%Y à %Hh %imn %ss')"):?>
                                            <th>Date de départ</th>
                                        <?php else:?>
                                            <th><?= $colonne['name'] ?></th>
                                        <?php endif; ?>
                                    <?php } ?>
                                    <th colspan="2">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php while ($tousUsers = $afficheGestionProduit->fetch(PDO::FETCH_ASSOC)) : ?>
                                    <tr>
                                        <?php foreach ($tousUsers as $key => $value) : ?>
                                            <td><?= $value ?></td>                                                
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
                                
                                <!-- id_produit -->

                                <div class="champInput">
                                    <input class="" type="hidden" name="id_salle" value="<?=$id_salle?>">
                                </div>

                                <!-- Titre -->
                                <!-- id_salle -->

                                <div class="champInput">
                                    <input class="" type="texte" name="id_salle" value="<?=$id_salle?>">
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

                </main>

            </div>


    </div>


<?php require_once('includeAdmin/footerAdmin.php') ?>



