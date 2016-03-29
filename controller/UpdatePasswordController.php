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
	
	if(!empty($_POST['oldPassword']) 
	and $_POST['oldPassword']==$_SESSION['user']->password()){
		if($_POST['newPassword1']==$_POST['newPassword2']){
			$newPassword = htmlentities($_POST['newPassword1']);
			$idUser = $_SESSION['user']->id();
			$userManager = new UserManager($pdo);
			$userManager->changePassword($newPassword, $idUser);
			$_SESSION['password-update-success']="Le mot de passe a été changé avec succès.";
		}
		else{
			$_SESSION['password-update-error']="Les 2 nouveaux mots de passe ne sont pas identiques.";
		}
	}
	else{
		$_SESSION['password-update-error']="Vous devez saisir votre ancien mot de passe pour créer un nouveau.";
	}
	header('Location:../profil.php');
