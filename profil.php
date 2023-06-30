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



    <div class="globalContainer">

        <?php
        $title = 'Profil de' . $_SESSION['user']['pseudo'];
        require_once('include/header.php');
        ?>

        <main>

            <h1>Profil</h1>

            <?= $validate ?>

            <h2>
                Bonjour <?= (internauteConnecteAdmin()) ?$_SESSION['user']['pseudo'] .  " vous êtes admin du site" : $_SESSION['user']['pseudo'] ?>
            </h2>
            <h3>Vos infos</h3>
            <div class="infoProfil">
                <ul>
                    <li>
                        <?= $_SESSION['user']['prenom'] ?>
                    </li>
                    <li>
                        <?= $_SESSION['user']['nom'] ?>
                    </li>
                    <li>
                        <?= $_SESSION['user']['pseudo'] ?>
                    </li>
                    <li>
                        <?= $_SESSION['user']['email'] ?>
                    </li>
                    
                </ul>
            </div>

        </main>

        


    </div>


<?php require_once('include/footer.php');?>