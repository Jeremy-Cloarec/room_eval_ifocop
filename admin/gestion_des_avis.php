<?php

require_once('../include/init.php');
require_once('../include/fonctions.php');


$title= "Gestion des avis";


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
                
                    <h1>Gestion des avis</h1>
                    
                    <?php $queryUsers = $pdo->query("SELECT id_avis FROM avis") ?>

                    
                    <!-- Tableaux des membres -->

                    <h2>Nombre d'avis' en base de données : <?= $queryUsers->rowCount() ?></h2>


                    <div class="table-container">
                        <table>
                            
                        <?php $afficheGestionAvis = $pdo->query("SELECT id_avis, id_membre, id_salle, commentaire, note, DATE_FORMAT(date_enregistrement, '%d/%m/%Y à %Hh %imn %ss')AS date_enregistrement
                        FROM avis
                        ORDER BY id_avis");
                        ?>


                            <thead>
                                <tr>
                                    <?php for ($i = 0; $i < $afficheGestionAvis->columnCount(); $i++) {
                                        $colonne = $afficheGestionAvis->getColumnMeta($i);?>
                                            <th><?= $colonne['name'] ?></th>
                                    <?php } ?>
                                </tr>
                            </thead>

                            <tbody>
                                    <?php while ($avis = $afficheGestionAvis->fetch(PDO::FETCH_ASSOC)) : ?>
                                        <tr>
                                            <?php foreach ($avis as $value) : ?>
                                                <td><?= $value ?></td>
                                            <?php endforeach; ?>
                                        </tr>
                                    <?php endwhile;?>
                            </tbody>

                        </table>
                    </div>
                </main>

            </div>


    </div>


<?php require_once('includeAdmin/footerAdmin.php') ;?>



