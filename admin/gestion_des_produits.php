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

        //Date de Départ
        if (!isset($_POST['date_depart'])){
            $erreur .= "<div class='affichageDanger'> Date de départ : vous devez sélectionner une date de départ</div>";
        }

        //Date d'arrivée
        if (!isset($_POST['date_arrivee'])){
            $erreur .= "<div class='affichageDanger'> Date d'arrivée : vous devez sélectionner une date d'arivée</div>";
        }


        //Etat
        if (!isset($_POST['etat']) || $_POST['etat'] != 'Libre' && $_POST['etat'] != 'Reservé') {
            $erreur .= "<div class='affichageDanger'>Etat : Vous devez sélectionner un état</div>";
        }

        //Prix
        if(!isset($_POST['prix']) || !preg_match('#^[0-9]{1,5}$#', $_POST['prix']) ){
            $erreur .= "<div class='affichageDanger'>Prix : Le prix ne doit pas être vide et doit comporter seulement des nombres</div>";
        }

        if(empty($erreur)){

                $updateProduit= $pdo->prepare("UPDATE produit SET id_produit = :id_produit, date_depart = :date_depart, date_arrivee = :date_arrivee, prix = :prix, etat = :etat WHERE id_produit = :id_produit");

                
                $updateProduit->bindValue(':id_produit', $_POST['id_produit'], PDO::PARAM_STR);
                $updateProduit->bindValue(':date_depart', $_POST['date_depart'], PDO::PARAM_STR);
                $updateProduit->bindValue(':date_arrivee', $_POST['date_arrivee'], PDO::PARAM_STR);
                $updateProduit->bindValue(':prix', $_POST['prix'], PDO::PARAM_STR);
                $updateProduit->bindValue('etat', $_POST['etat'], PDO::PARAM_STR);

                $updateProduit->execute();
        }
    }

    if($_GET['action']=='update'){
        $queryGestionProduit = $pdo->query("SELECT * FROM produit WHERE id_produit ='$_GET[id_produit]'");
        $produitActuel = $queryGestionProduit->fetch(PDO::FETCH_ASSOC);
    }

    // $id_produit = (isset($produitActuel['id_produit'])) ? $produitActuel['id_produit'] : '';
    $id_produit = (isset($produitActuel['id_produit'])) ? $produitActuel['id_produit'] : '';
    $dateArrivee = (isset($produitActuel['date_arrivee'])) ? $produitActuel['date_arrivee'] : '';
    $dateDepart = (isset($produitActuel['date_depart'])) ? $produitActuel['date_depart'] : '';
    $prix = (isset($produitActuel['prix'])) ? $produitActuel['prix'] : '';
    $etat = (isset($produitActuel['etat'])) ? $produitActuel['etat'] : '';
}


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
                        
                            
                        <?php $afficheGestionProduit = $pdo->query("SELECT produit.id_produit, salle.id_salle, titre, DATE_FORMAT(date_arrivee, '%d/%m/%Y à %Hh %imn %ss'), DATE_FORMAT(date_depart, '%d/%m/%Y à %Hh %imn %ss'), prix, etat FROM produit, salle WHERE produit.id_salle = salle.id_salle ORDER BY produit.id_produit");
?>
                            <thead>
                                <tr>
                                    <?php for ($i = 0; $i < $afficheGestionProduit->columnCount(); $i++) {
                                        $colonne = $afficheGestionProduit->getColumnMeta($i);?>
                                        <?php if($colonne['name']!='titre'):?>
                                            <?php if($colonne['name']== "DATE_FORMAT(date_arrivee, '%d/%m/%Y à %Hh %imn %ss')"):?>
                                                <th>Date d'arrivée</th>
                                            <?php elseif($colonne['name']== "DATE_FORMAT(date_depart, '%d/%m/%Y à %Hh %imn %ss')"):?>
                                                <th>Date de départ</th>
                                            <?php else:?>
                                                <th><?= $colonne['name'] ?></th>
                                            <?php endif; ?>
                                        <?php endif; ?>
                                    <?php } ?>
                                    <th colspan="2">Actions</th>
                                </tr>
                            </thead>

                            <tbody>
                                <?php while ($tousUsers = $afficheGestionProduit->fetch(PDO::FETCH_ASSOC)) : ?>
                                    <tr>
                                        <?php foreach ($tousUsers as $key => $value) : ?>
                                            <?php if ($key != 'titre'):?>
                                                <?php if($key == 'id_salle'): ?>

                                                    <td><?= $value ?> : Salle <?= $tousUsers['titre']?></td>

                                                <?php else: ?>
                                                    <td><?= $value ?></td>
                                                <?php endif; ?>
                                            <?php endif;?>
                                        <?php endforeach; ?>                                              
                                        
                                        <td><a href='?action=update&id_produit=<?= $tousUsers['id_produit'] ?>'><i class="bi bi-pen-fill"></i></a></td>
                                        <td><a href="?action=delete&id_produit=<?= $tousUsers['id_produit'] ?>"><i class="bi bi-trash-fill" style="font-size: 1.5rem;"></i></a></td>
                                    </tr>
                                <?php endwhile;?>
                            </tbody>
                        </table>
                    </div>

                    <!-- Formulaire de modificaations des membres -->

                    <?php 
                    $actionbutton="?action=add";
                    ?>

                

                    <?= $erreur; ?>
                    <?= $validate; ?>

                    <div class="inscription">

                        <?php if(isset($_GET['action'])):?>
                            <?php if($_GET['action']=="update"):?>

                                <h2>Formulaire de modification des produits</h2>

                                <form action="" class="inscriptionForm form" method="POST" enctype="multipart/form-data">
                                    
                                    <!-- id_produit -->

                                    <div class="champInput">
                                        <input class="" type="hidden" name="id_produit" value="<?=$id_produit?>">
                                    </div>

                                    <!-- Date arrivée-->

                                    <div class="champInput">
                                        <label class="" for="date_arrivee">
                                        Date d'arrivée
                                        </label>
                                        <input type="datetime-local" id="date_arrivee" name="date_arrivee" value="<?=$dateArrivee?>">
                                    </div>

                                    <!-- Date depart-->

                                    <div class="champInput">
                                        <label class="" for="date_depart">
                                        Date de départ
                                        </label>
                                        <input type="datetime-local" id="date_depart" name="date_depart" value="<?=$dateDepart ?>">
                                    </div>

                                    <!-- Etat -->

                                    <div class="champInput">
                                        <label for="etat">Choississez un état</label>
                                        <select name="etat" id="etat">
                                            <option value="">--Choisissez un état--</option>
                                            <option value="Libre"<?=($etat=='Libre') ? 'selected': ''?>>Libre</option>
                                            <option value="Reservé"<?=($etat=='Réservé') ? 'selected': ''?>>Réservé</option>
                                        </select>
                                    </div>

                                    <!-- Prix-->

                                    <div class="champInput">
                                        <label class="" for="prix">
                                            Prix
                                        </label>
                                        <input class="" type="text" name="prix" id="prix" value="<?= $prix?>" placeholder="prix">
                                    </div>

                                    <div class="champInput">
                                        <button name="buttonGestionProduit" class="buttonFormulaire">Valider</button>
                                    </div>
                                </form>
                            <?php endif; ?>
                        <?php endif; ?>
                    </div>

                </main>

                </main>

            </div>


    </div>


<?php require_once('includeAdmin/footerAdmin.php') ?>



