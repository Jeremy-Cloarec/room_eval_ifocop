<?php

require_once('../include/init.php');
require_once('../include/fonctions.php');


$title= "Gestion des sommandes";

if(!internauteConnecteAdmin()){
    header('location:' . URL . 'connexion.php');
    exit();
}

?>







<?php require_once('includeAdmin/headerAdmin.php');?>

    <div class="globalContainer">

            <div class="adminContainer">

                <?php require_once('includeAdmin/navAside.php');?>

                <main class="mainAdmin">
                
                    <h1>Gestion des commandes</h1>

                    <?php $queryUsers = $pdo->query("SELECT id_commande FROM commande") ?>

                    
                    <!-- Tableaux des membres -->

                    <h2>Nombre de produits en base de données : <?= $queryUsers->rowCount() ?></h2>


                    <div class="table-container">
                        <table>
                        
                        <!-- On fait une jointure pour appeler les colonnes titre et photo de la table salle -->
                            
                        <?php $afficheGestionProduit = $pdo->query("SELECT produit.id_produit, salle.id_salle, salle.photo, titre, DATE_FORMAT(date_arrivee, '%d/%m/%Y à %Hh %imn %ss'), DATE_FORMAT(date_depart, '%d/%m/%Y à %Hh %imn %ss'), prix, etat FROM produit, salle WHERE produit.id_salle = salle.id_salle ORDER BY produit.id_produit");
?>
                            <thead>
                                <tr>
                                    <?php for ($i = 0; $i < $afficheGestionProduit->columnCount(); $i++) {
                                        $colonne = $afficheGestionProduit->getColumnMeta($i);?>
                                        <?php if($colonne['name']!='titre'):?>
                                            <?php if($colonne['name']!='photo'):?>
                                                <?php if($colonne['name']== "DATE_FORMAT(date_arrivee, '%d/%m/%Y à %Hh %imn %ss')"):?>
                                                    <th>Date d'arrivée</th>
                                                <?php elseif($colonne['name']== "DATE_FORMAT(date_depart, '%d/%m/%Y à %Hh %imn %ss')"):?>
                                                    <th>Date de départ</th>
                                                <?php else:?>
                                                    <th><?= $colonne['name'] ?></th>
                                                <?php endif; ?>
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
                                                <?php if ($key != 'photo'):?>
                                                    <?php if($key == 'id_salle'): ?>

                                                        <td>
                                                            <?= $value ?> : Salle <?= $tousUsers['titre']?>
                                                            <br><img src="<?= URL . "img/" . $tousUsers['photo']?>" alt="" width="50"> 
                                                        </td> 

                                                    <?php else: ?>
                                                        <td><?= $value ?></td>
                                                    <?php endif; ?>
                                                <?php endif;?>
                                            <?php endif;?>
                                        <?php endforeach; ?>                                              
                                        
                                        <td><a href='?action=update&id_produit=<?= $tousUsers['id_produit'] ?>'><i class="bi bi-pen-fill"></i></a></td>
                                        <td><a href="?action=delete&id_produit=<?= $tousUsers['id_produit'] ?>"><i class="bi bi-trash-fill" style="font-size: 1.5rem;"></i></a></td>
                                    </tr>
                                <?php endwhile;?>
                            </tbody>
                        </table>
                    </div>

                </main>

            </div>


    </div>


<?php require_once('includeAdmin/footerAdmin.php') ?>



