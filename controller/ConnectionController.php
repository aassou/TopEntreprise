<?php

//classes loading begin
function classLoad ($myClass) {
    if(file_exists('../model/'.$myClass.'.php')){
        include('../model/'.$myClass.'.php');
    }
    elseif(file_exists('../controller/'.$myClass.'.php')){
        include('../controller/'.$myClass.'.php');
    }
}
spl_autoload_register("classLoad");
include("../config.php");
//classes loading end
session_start();

$redirectLink='../index.php';

if(empty($_POST['login']) || empty($_POST['password'])){
    $_SESSION['connection_error'] = "<strong>Login</strong> et <strong>Mot de passe</strong> obligatoires";
}
else{
    $login = htmlspecialchars($_POST['login']);
    $password = htmlspecialchars($_POST['password']);
    $userManager = new UserManager($pdo);
    if($userManager->exists($login, $password)){
        $_SESSION['user'] = $userManager->getUserByLoginPassword($login, $password);
        $redirectLink='../dashboard.php';
    }
    else{
        $_SESSION['connection_error']="<strong>Login</strong> ou <strong>Mot de passe</strong> invalide";
    }
}
header('Location:'.$redirectLink);
exit;
?>