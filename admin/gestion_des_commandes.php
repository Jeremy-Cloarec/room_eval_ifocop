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
                            
                        <?php $afficheGestionCommande = $pdo->query("SELECT commande.id_commande, membre.id_membre, produit.id_produit, produit.prix, DATE_FORMAT(commande.date_enregistrement, '%d/%m/%Y à %Hh %imn %ss')AS date_enregistrement
                        FROM commande, membre, produit 
                        WHERE commande.id_membre = membre.id_membre 
                        AND commande.id_produit = produit.id_produit 
                        ORDER BY commande.id_commande");
                        ?>




                            <thead>
                                <tr>
                                    <?php for ($i = 0; $i < $afficheGestionCommande->columnCount(); $i++) {
                                        $colonne = $afficheGestionCommande->getColumnMeta($i);?>
                                            <th><?= $colonne['name'] ?></th>
                                    <?php } ?>
                                    <th colspan="2">Actions</th>
                                </tr>
                            </thead>

                            <tbody>
                                <?php while ($tousUsers = $afficheGestionCommande->fetch(PDO::FETCH_ASSOC)) : ?>
                                    <tr>
                                        <?php foreach ($tousUsers as $value) : ?>
                                            <td><?= $value ?></td>
                                        <?php endforeach; ?>
                                    </tr>
                                <?php endwhile; ?>
                            </tbody>

                        </table>
                    </div>

                </main>

            </div>


    </div>


<?php require_once('includeAdmin/footerAdmin.php') ?>



