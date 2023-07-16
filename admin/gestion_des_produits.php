<?php

require_once('../include/init.php');
require_once('../include/fonctions.php');


$title= "Gestion des produits";

if(!internauteConnecteAdmin()){
    header('location:' . URL . 'connexion.php');
    exit();
}

if(isset($_GET["action"])){

    if($_POST && isset($_POST["buttonGestionProduit"])){
        
        //Titre
        if (!isset($_POST['titre']) || iconv_strlen($_POST['titre']) < 3 || iconv_strlen($_POST['titre']) > 30) {
            $erreur .= "<div class='affichageDanger'> Titre : Pour ce champ, vous avez le droit d'utiliser tous les caractères alphanumériques. Les caractères spéciaux suivant : -_. et votre titre devra comporter au minimum trois caractère et 30 au maximum.</div>";
        }

        //Date de Départ
        if (!isset($_POST['dateDepart'])){
            $erreur .= "<div class='affichageDanger'> Date de départ : vous devez sélectionner une date de départ</div>";
        }

        //Date d'arrivée
        if (!isset($_POST['dateArrivee'])){
            $erreur .= "<div class='affichageDanger'> Date d'arrivée : vous devez sélectionner une date d'arivée</div>";
        }

        //Prix
        if(!isset($_POST['prix']) || !preg_match('#^[0-9]{1,5}$#',$_POST['prix']) ){
            $erreur .= "<div class='affichageDanger'> Etat : Vous devez sélectionner un état</div>";
        }

        //Etat
        if (!isset($_POST['etat']) || $_POST['etat'] != 'Libre' && $_POST['etat'] != 'Reservé') {
            $erreur .= "<div class='affichageDanger'> Prix : Le prix ne doit pas être vide et comporter seulement des nombres</div>";
        }

        if(empty($erreur)){

                $updateProduit= $pdo->prepare("UPDATE produit SET id_produit = :id_produit, id_salle = :id_salle, date_depart = :date_depart, date_arrivee = :date_arrivee, prix = :prix, etat = :etat WHERE id_produit = :id_produit");

                $updateProduit->bindValue(':id_produit', $_POST['id_produit'], PDO::PARAM_INT);
                $updatProduit->bindValue(':id_salle', $_POST['id_salle'], PDO::PARAM_INT);
                $updateProduit->bindValue('date_depart', $_POST['date_depart'], PDO::PARAM_STR);
                $updateProduit->bindValue('date_arrivee', $_POST['date_arrivee'], PDO::PARAM_STR);
                $updateProduit->bindValue('prix', $_POST['prix'], PDO::PARAM_STR);
                $updateProduit->bindValue('etat', $_POST['etat'], PDO::PARAM_STR);

                $updateCommande->execute();

        }
    }

    $id_produit = (isset($commandeActuelle['id_commande'])) ? $commandeActuelle['id_commande'] : '';
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

                    <h2>Nombre de produits en base de données : <?= $queryUsers->rowCount() ?></h2>


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


                        <?php if(($_GET['action'])): ?>

                            <h2>Formulaire <?= ($_GET['action'] == "add") ? "d'ajout" : "de modification" ?> des salles </h2>

                            <form action="" class="inscriptionForm form" method="POST" enctype="multipart/form-data">
                                
                                <!-- id_produit -->

                                <div class="champInput">
                                    <input class="" type="hidden" name="id_salle" value="<?=$id_salle?>">
                                </div>

                            
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

                                <!-- Date arrivée-->

                                <div class="champInput">
                                    <label class="" for="dateArrivee">
                                    Date d'arrivée
                                    </label>
                                    <input type="datetime-local" id="dateArrivee" name="dateArrivee" value="<?=$dateArrivee ?>"
                                    min="2018-06-07T00:00" max="2018-06-14T00:00">
                                </div>

                                <!-- Date depart-->

                                <div class="champInput">
                                    <label class="" for="dateDepart">
                                    Date de départ
                                    </label>
                                    <input type="datetime-local" id="dateDepart" name="dateDepart" value="<?=$dateDepart ?>"
                                    >
                                </div>



                                <!-- Etat -->

                                <div class="champInput">
                                    <label for="etat">Choississez un état</label>
                                    <select name="etat" id="etat">
                                        <option value="">--Choisissez un état--</option>
                                        <option value="Libre"<?=($pays=='Libre') ? 'selected': ''?>>libre</option>
                                        <option value="Libre"<?=($pays=='Reservé') ? 'selected': ''?>>Reservé</option>
                                    </select>
                                </div>

                                

                                <!-- Prix-->

                                <div class="champInput">
                                    <label class="" for="prix">
                                        Prx
                                    </label>
                                    <input class="" type="text" name="prix" id="prix" value="<?= $prix?>" placeholder="prix">
                                </div>

                                <div class="champInput">
                                    <button name="buttonGestionProduit" class="buttonFormulaire">Valider</button>
                                </div>
                            </form>
                        <?php endif; ?>
                    </div>

                </main>

                </main>

            </div>


    </div>


<?php require_once('includeAdmin/footerAdmin.php') ?>



