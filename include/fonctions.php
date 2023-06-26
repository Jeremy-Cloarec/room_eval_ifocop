
<?php

//Fonction debug

function debug($var, $mode = 1){
    $trace = debug_backtrace();
    $trace = array_shift($trace);
    echo "Debug demandé sur le fichier <strong>" . $trace['file'] . "</strong>, en 
    ligne <strong>" . $trace['line'] . "</strong>";
    if($mode == 1){
    echo "<pre>"; print_r($var); echo "</pre>";
    }else{
    echo "<pre>"; var_dump($var); echo "</pre>";
    }
    }

// Vérifier si l'utilisateur est connecté ou non

function internauteConnecte(){
    if(!isset($_SESSION['membre'])){
    return FALSE;
    }else{
    return TRUE;
    }
}


// Vérifier le statut de l'utilisateur

function internauteConnecteAdmin(){
    if(internauteConnecte() && $_SESSION['membre']['statut'] == 1){
    return TRUE;
    }else{
    return FALSE;
    }
}



