
<?php
require_once('include/fonctions.php');
require_once('include/init.php');
require_once('include/affichage.php');

$title = 'Salle ' . $produit['titre'];

if(!internauteConnecte()){
    header('location:' . URL . 'connexion.php');
    exit();
}



// Vérification du formulaire

if($_POST){


     //Date de Départ
    if (empty($_POST['date_depart'])){
        $erreur .= "<div class='affichageDanger'> Date de départ : vous devez sélectionner une date de départ</div>";
    }

     //Date d'arrivée
    if (empty($_POST['date_arrivee'])){
        $erreur .= "<div class='affichageDanger'> Date d'arrivée : vous devez sélectionner une date d'arivée</div>";
    }

    if(empty($erreur)){

        $ajoutCommande= $pdo->prepare("INSERT INTO commande (id_membre, id_salle, prix, date_depart, date_arrivee) VALUES( :id_membre, :id_salle, :prix, :date_depart, :date_arrivee)");

        $ajoutCommande->bindValue(':id_membre', $_POST['id_membre'], PDO::PARAM_INT);
        $ajoutCommande->bindValue(':id_salle', $_POST['id_salle'], PDO::PARAM_INT);
        $ajoutCommande->bindValue(':prix', $_POST['prix'], PDO::PARAM_INT);
        $ajoutCommande->bindValue(':date_depart', $_POST['date_depart'], PDO::PARAM_STR);
        $ajoutCommande->bindValue(':date_arrivee', $_POST['date_arrivee'], PDO::PARAM_STR);

        $ajoutCommande->execute();
    }

}


?>

<?php require_once('include/header.php');?>


    <div class="globalContainer">


            <main>

                <div class="containerFicheProduit">

                    <div class="titreNote">
                        <h1>Salle <?= $produit['titre']?></h1>
                        <span class="material-symbols-outlined">
                            star
                        </span>
                    </div>
                    <div class="imageDescription">
                        <div class="imageProduit">
                            <img src="<?php URL ?>img/<?=$produit['photo']?>" alt="">
                        </div>
                        <div class="descriptionProduit">
                            <div class="descriptionCategorie">
                                <h3>Description</h3>
                                <p class="description"><?= $produit['description']?></p>
                            </div>
                            <div class="descriptionCategorie">
                                <h3>Adresse</h3>
                                <p class="description"><?= $produit['adresse'].', '. $produit['ville'].', '. $produit['cp'] ?></p>
                            </div>
                            <div class="descriptionCategorie">
                                <h3>capacité</h3>
                                <p class="description"><?= $produit['capacite']?> personnes</p>
                            </div>
                            <div class="descriptionCategorie">
                                <h3>Prix</h3>
                                <p class="description"><?= $produit['prix']?> €/jour</p>
                            </div>
                            <div class="descriptionCategorie">
                                <h3>Categorie</h3>
                                <p class="description"><?= $produit['categorie']?></p>
                            </div>            
                        </div>
                    </div>
                    <div class="reservationSalle">
                        <h2>Réservez votre salle</h2>

                        <?= $erreur; ?>

            
                        
                        <form action="" class="inscriptionForm form" method="POST" enctype="multipart/form-data">

                            <!-- id_membre -->

                            <div class="champInput">
                                <input class="" type="hidden" name="id_membre" value="<?= $_SESSION["user"]["id_membre"]?>">
                            </div>

                            <!-- id_produit -->

                            <div class="champInput">
                                <input class="" type="hidden" name="id_salle" value="<?= $produit['id_salle']?>">
                            </div>

                            <!-- Date arrivée-->

                            <div class="champInput">
                                <label class="" for="date_arrivee">
                                Date d'arrivée
                                </label>
                                <input type="datetime-local" id="date_arrivee" name="date_arrivee" value="">
                            </div>

                            <!-- Date depart-->

                            <div class="champInput">
                                <label class="" for="date_depart">
                                Date de départ
                                </label>
                                <input type="datetime-local" id="date_depart" name="date_depart" value="">
                            </div>

                            <!-- Prix -->

                            <div class="champInput">
                                <input class="" type="hidden" name="prix" id="prix" value="<?= $produit['prix']?>" placeholder="prix">
                            </div>

                            <div class="champInput">
                                <button name="buttonReservationSalle" class="buttonFormulaire">Valider</button>
                            </div>

                        </form>







                    </div>
                    <div class="containerAutresProduits">
                            <h2>Ces produits pourraient aussi vous intéresser</h2>
                        <div class="gridProduit">
                            <?php while($cards = $afficheCards ->fetch(PDO::FETCH_ASSOC)): ?>

                                <?php if($cards['categorie'] == $produit['categorie'] && $cards['id_salle'] != $produit['id_salle']):?>
                                    <a href="fiche_produit.php?id_salle=<?=$cards['id_salle']?>" class="containerCardSAlle">
                                        <div class="containerImage">
                                            <img src="<?= URL ?>img/<?=$cards['photo']?>" alt="">
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
                                <?php endif;?>
                            <?php endwhile; ?>
                            
                        </div>

                    </div>

                    
    
                

                </div>


            </main>

    </div>

<?php require_once('include/footer.php');?>