<?php

require_once('../include/init.php');
require_once('../include/fonctions.php');




if(!internauteConnecteAdmin()){
    header('location:' . URL . 'connexion.php');
    exit();
}
?>





<?php
$title= "Admin de " . $_SESSION['user']['pseudo'];
require_once('includeAdmin/headerAdmin.php');


?>



    <div class="globalContainer">

            <div class="adminContainer">

                <?php require_once('includeAdmin/navAside.php'); ?>

                <main class="mainAdmin bienvenuAdmin">
                
                    <h1>Bienvenue dans votre espace d'administration</h1>

                </main>

            </div>


    </div>


<?php require_once('includeAdmin/footerAdmin.php') ;?>



