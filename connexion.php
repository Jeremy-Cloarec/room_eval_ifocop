
<?php
require_once('include/fonctions.php');
require_once('include/init.php');


//Procédure de déconnexion avec unset

if (array_key_exists('action', $_GET) && $_GET['action'] =='deconnexion'){
    unset($_SESSION['user']); 
    header('location:' .URL. 'connexion.php');
}


//Redirection vers la page profil si l'internaute est déjà connecté

if(internauteConnecte()){
    header('location:' . URL . 'profil.php');
    exit();
}

//Message de félicitation à l'internaute qui vient de réussir son inscription
if(isset($_GET['action']) && $_GET['action'] == 'validate'){
    $validate .= '<div class="reussiteInscription"> Félicitations !</strong> Votre inscription est réussie 😉, vous pouvez vous connecter !</div>';
}



if(isset($_POST['buttonConnexion'])){

    //On vérifie que le pseudo existe bien en BDD en faisant une requête préparée

    $verifUser = $pdo->prepare("SELECT * FROM membre WHERE pseudo = :pseudo");
    $verifUser->bindValue(':pseudo', $_POST['pseudo'], PDO::PARAM_STR);
    $verifUser->execute();

    //Si le résultat = 1, alors le pseudo existe

    if($verifUser->rowCount() == 1){

        //On continue la procédure d'authentification avec le mdp
        
        $user = $verifUser->fetch(PDO::FETCH_ASSOC);

        //passord_verrify nécessaire pour comparer un mdp non crypté avec son équivalent crypté en BDD

        if(password_verify($_POST['mdp'], $user['mdp'])) {

            //Si les deux mdp sont similaires on continue en créant une session utilisateur
            foreach($user as $key => $value) {
                if($key != 'mdp'){
                    $_SESSION['user'][$key] = $value;

                    //On redirige ensuite l'utilisateur vers : 

                    //Page admin s'il est admin

                    if (internauteConnecteAdmin()){
                        header('location:' . URL . 'admin/index.php?action=validate');
                    } 

                    //Page panier s'il vient du panier
                    
                    elseif (isset($_GET['action']) && $_GET['action'] == 'acheter') {
                        header('location' . URL . 'panier.php');
                    }

                    //Page profil

                    else {
                        //C'est un utilisateur lambda, je le redirige vers sa page profil
                        header('location:' . URL . 'profil.php?action=validate');
                    }
                }
            }

        } else{
            // MDP n'existe pas
            $erreur .= '<div class="affichageDanger">Erreur, ce mot de passe n\'existe pas</div>';
        }
    
    } else {
        //Pseudo n'existe pas

        $erreur .= '<div class="affichageDanger">Erreur, votre pseudo est inconnu, inscrivez vous ou alors vérifiez votre pseudo !</div>';
    }



}




?>

    <div class="globalContainer">

        <?php
        require_once('include/header.php');
        $title = "Connexion";
        ?>

        <main>
            <h1>Connexion</h1>

            <?=$validate;?>
            <?=$erreur;?>

            <form action="" class="connexionForm form" method="POST">
                    <!-- pseudo, mdp -->
                    <div class="champInput">
                        <label class="" for="pseudo">
                        Pseudo
                        </label>
                        <input class="" type="text" name="pseudo" id="pseudo" placeholder="Votre pseudo" max-length="20" pattern="[a-zA-Z0-9-_.]{3,20}" required>
                    </div>
                    <div class="champInput">
                        <label class="" for="mdp">
                        Mot de passe
                        </label>
                        <input class="" type="password" name="mdp" id="mdp" placeholder="Votre mot de passe" max-length="20" pattern="[a-zA-Z0-9-_.]{3,20}" required>
                    </div>
                    <div class="champInput">
                        <button name="buttonConnexion" class="buttonConnexion">Valider</button>
                    </div>
                </form>

        </main>
        


    </div>

<?php require_once('include/footer.php');?>