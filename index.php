<?php




require_once('include/fonctions.php');
require_once('include/init.php');
require_once('include/affichage.php');

$title= "Accueil";





?>



<?php require_once('include/header.php');?>


    <div class="globalContainer">
            <main>
                <h1>Découvrez notre service exeptionnelle de location de salle</h1>

                <div class="containerProduitFiltre">
                    <div class="containerFiltre">
                        <div class="filtreContainer">
                            <h2>Nos catégories</h2>
                            <a href="<?= URL?>?categories">Toutes nos salles</a>
                            <a href="<?= URL?>?categorie=reunion">Réunion</a>
                            <a href="<?= URL?>?categorie=bureau">Bureau</a>
                            <a href="<?= URL?>?categorie=formation">Formation</a>
                        </div>
                    </div>

                    <!-- Réunion -->
                    <?php if(isset($_GET['categorie']) && $_GET['categorie']== "reunion"):?>
                        <div class="containerProduit">
                            <div class="gridProduit">
                                <?php while($cards = $afficheCards ->fetch(PDO::FETCH_ASSOC)): ?>

                                    <?php if($cards['categorie']=='reunion') :?>
                                        <a href="fiche_produit.php?id_salle=<?= $cards['id_salle']?>" class="containerCardSAlle">
                                            <div class="containerImage">
                                                <img src="<?= URL ?>img/<?= $cards['photo']?>" alt="">
                                            </div>
                                            <div class="titreSalle">
                                                <h3>Salle <?= $cards['titre'] ?></h3>
                                            </div>
                                            <p class="prix"><?= $cards['prix'] ?>€/jour</p>
                                            
                                        </a>
                                    <?php endif;?>

                                <?php endwhile;?>

                            </div>
                        </div>

                    <!-- Bureau -->

                    <?php elseif(isset($_GET['categorie']) && $_GET['categorie']== "bureau"):?>
                        <div class="containerProduit">
                            <div class="gridProduit">
                                <?php while($cards = $afficheCards ->fetch(PDO::FETCH_ASSOC)): ?>

                                    <?php if($cards['categorie']=='bureau') :?>
                                        <a href="fiche_produit.php?id_salle=<?= $cards['id_salle']?>" class="containerCardSAlle">
                                            <div class="containerImage">
                                                <img src="<?= URL ?>img/<?= $cards['photo']?>" alt="">
                                            </div>
                                            <div class="titreSalle">
                                                <h3>Salle <?= $cards['titre'] ?></h3>
                                            </div>
                                            <p class="prix"><?= $cards['prix'] ?>€/jour</p>
                                        </a>
                                    <?php endif;?>

                                <?php endwhile;?>

                            </div>
                        </div>

                    <!-- Formation -->

                    <?php elseif(isset($_GET['categorie']) && $_GET['categorie']== "formation"):?>
                        <div class="containerProduit">
                            <div class="gridProduit">
                                <?php while($cards = $afficheCards ->fetch(PDO::FETCH_ASSOC)): ?>

                                    <?php if($cards['categorie']=='formation') :?>
                                        <a href="fiche_produit.php?id_salle=<?= $cards['id_salle']?>" class="containerCardSAlle">
                                            <div class="containerImage">
                                                <img src="<?= URL ?>img/<?= $cards['photo']?>" alt="">
                                            </div>
                                            <div class="titreSalle">
                                                <h3>Salle <?= $cards['titre'] ?></h3>
                                            </div>
                                            <p class="prix"><?= $cards['prix'] ?>€/jour</p>
                                        </a>
                                    <?php endif;?>
                                <?php endwhile;?>

                            </div>
                        </div>
                    
                    <!-- Tous les produits -->

                    <?php else:?>
                        <div class="containerProduit">
                            <div class="gridProduit">
                                <?php while($cards = $afficheCards ->fetch(PDO::FETCH_ASSOC)): ?>
                                        <a href="fiche_produit.php?id_salle=<?= $cards['id_salle']?>" class="containerCardSAlle">
                                            <div class="containerImage">
                                                <img src="<?= URL ?>img/<?= $cards['photo']?>" alt="">
                                            </div>
                                            <div class="titreSalle">
                                                <h3>Salle <?= $cards['titre'] ?></h3>
                                            </div>
                                            <p class="prix"><?= $cards['prix'] ?>€/jour</p>
                                        </a>

                                <?php endwhile;?>

                            </div>
                        </div>
                    <?php endif;?>
                </div>
            </main>
    </div>


<?php require_once('include/footer.php');?>

