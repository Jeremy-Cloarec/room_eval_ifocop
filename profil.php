<?php
require_once('include/fonctions.php');
require_once('include/init.php');


//Si internaute pas connecté, on le redirige vers la page connexion

if(!internauteConnecte()){
    header('location:' . URL . 'connexion.php');
    exit();
}


// Message de félicitation
if(isset($_GET['action']) && $_GET['action'] == 'validate'){
    $validate .= '<div class="reussiteInscription"> Félicitations </strong>' . $_SESSION['user']['pseudo'] . ' !'. '</strong> Vous êtes connecté !</div>';
}
?>



    

<?php
$title = 'Profil de' . $_SESSION['user']['pseudo'];
require_once('include/header.php');
?>

        <div class="globalContainer">

            <main>

                <h1>
                    Bonjour <?= (internauteConnecteAdmin()) ?$_SESSION['user']['pseudo'] .  " vous êtes admin du site" : $_SESSION['user']['pseudo'] . ", bienvenu(e) sur votre profil" ?>
                </h1>

                <?= $validate ?>

                <div class="containeProfil">
                    <div class="containeInfoProfil">
                        <h2>Vos infos</h2>
                        <ul>
                            <li>
                                Prénom : <?= $_SESSION['user']['prenom'] ?>
                            </li>
                            <li>
                                Nom : <?= $_SESSION['user']['nom'] ?>
                            </li>
                            <li>
                                Pseudo : <?= $_SESSION['user']['pseudo'] ?>
                            </li>
                            <li>
                                Mail : <?= $_SESSION['user']['email'] ?>
                            </li>
                        </ul>
                    </div>
                    <div class="containerCommande">
                        <h2>Vos Commandes</h2>

                        
                        <?php

                            
                            $id_m = $_SESSION['user']['id_membre'];
                            $queryUsers = $pdo->prepare("SELECT id_commande FROM commande WHERE id_membre = :id_membre");
                            $queryUsers->bindValue(':id_membre', $id_m, PDO::PARAM_INT);
                            $queryUsers->execute();
                                
                        ?>

                        <?php if($queryUsers->rowCount() >= 1): ?>
                        
                            <div class="table-container">
                            
                                <table>
                                    <?php $afficheGestionCommande = $pdo->query("SELECT id_commande, id_membre, pseudo, email, id_salle, prix, DATE_FORMAT(date_arrivee, '%d/%m/%Y à %Hh %imn %ss')AS date_arrivee, DATE_FORMAT(date_depart, '%d/%m/%Y à %Hh %imn %ss')AS date_depart
                                    FROM commande
                                    ORDER BY id_commande");
                                    ?>


                                        <thead>
                                            <tr>
                                                <?php for ($i = 0; $i < $afficheGestionCommande->columnCount(); $i++) {
                                                    $colonne = $afficheGestionCommande->getColumnMeta($i);?>
                                                        <th><?= $colonne['name'] ?></th>
                                                <?php } ?>
                                            </tr>
                                        </thead>

                                        <tbody>
                                                <?php while ($commande = $afficheGestionCommande->fetch(PDO::FETCH_ASSOC)) : ?>
                                                    <tr>
                                                        <?php foreach ($commande as $value) : ?>
                                                            <?php if($commande['id_membre'] == $_SESSION['user']['id_membre']):?> 
                                                                <td><?= $value ?></td>
                                                            <?php endif;?>
                                                        <?php endforeach; ?>
                                                    </tr>
                                                <?php endwhile;?>
                                        </tbody>
                                    
                                </table>
                            </div>
                        <?php else:?>

                            <p>Vous n'avez pas encore de commande</p>

                        <?php endif;?>
                        
                    </div>
                </div>
                

            </main>

        </div>


<?php require_once('include/footer.php');?>