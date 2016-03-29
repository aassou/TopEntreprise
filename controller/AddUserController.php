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
    include('../config.php');  
    //classes loading end
    session_start();
    
    //post input processing
    if(!empty($_POST['login']) and !empty($_POST['password']) and !empty($_POST['profil']) and ($_POST['password']==$_POST['password2'])){    
        $login = htmlentities($_POST['login']);
		$password = htmlentities($_POST['password']);
		$profil = htmlentities($_POST['profil']);
		$created = date('Y-m-d h:i:s');
		//source creation
		$user = new User(array('login'=>$login, 'password'=>$password,
		'profil'=>$profil, 'created'=>$created));
		$userManager = new UserManager($pdo);
		$userManager->add($user);
		$_SESSION['user-success'] = "Le nouvel utilisateur a été ajouté avec succès.";
		header('Location:../users.php');
    }
    else{
        $_SESSION['user-error'] = "Vous devez remplir les champs <strong>Login</strong>,
        <strong>Mot de passe</strong> et <strong>Rôle</strong> correctement.";
		header('Location:../users.php');
    }
    