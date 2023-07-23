<?php 

// Page d'accueil


    $afficheCards = $pdo->query("SELECT DISTINCT titre, description, prix, id_salle, photo, categorie FROM salle ORDER BY titre ASC");
            

// affichage d'un produit

    if(isset($_GET['id_salle'])){

        $afficheProduit = $pdo->query("SELECT * FROM salle WHERE id_salle = '$_GET[id_salle]' ");
        $produit = $afficheProduit -> fetch(PDO::FETCH_ASSOC);
    }