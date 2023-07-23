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

                    </div>
                    <div class="containerProduit">
                        <div class="gridProduit">

                            

                            <?php while($cards = $afficheCards ->fetch(PDO::FETCH_ASSOC)): ?>

                                <a href="fiche_produit.php?id_salle=<?=$cards['id_salle']?>" class="containerCardSAlle">
                                    <div class="containerImage">
                                        <img src="<?php URL ?>img/<?=$cards['photo']?>" alt="">
                                    </div>
                                    <div class="titreSalle">
                                        <h3>Salle <?=$cards['titre'] ?></h3>
                                    </div>
                                    <p class="prix"><?=$cards['prix'] ?>€/jour</p>
                                    <div class="etoiles">
                                        <span class="material-symbols-outlined">
                                            star
                                        </span>
                                    </div>
                                </a>

                            <?php endwhile;?>

                        </div>
                    </div>
                </div>
            </main>
    </div>


<?php require_once('include/footer.php');?>

