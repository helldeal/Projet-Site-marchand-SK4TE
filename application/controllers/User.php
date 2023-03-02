<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->helper('url');
		$this->load->helper('file');
		$this->load->helper('cookie');
		$this->load->helper('email');
		$this->load->model('ProductModel');
		$this->load->model('UserModel');
		$this->load->model('UserEntity');
		$this->load->model('CommandeModel');
		$this->load->model('CommandeEntity');
	}

	//Charge la page de connection et d'inscription
	public function login(){
		//$data["allcartproducts"]=$home->cartimport();
		$this->load->view('login');
	}

	//Connecte un utilisateur si les infos sont correctes
	public function loginCheck(){
		$email = $_POST['login']; //MODIFIER
        $password = $_POST ['password'];
        $user = $this->UserModel->findByEmail($email);
        if ($user !=null && $user->isValidPassword($password)) {
            $this->session->set_userdata('login', array("email"=>$user->getEmail(), "pseudo"=>$user->getPseudo(), "status"=>$user->getStatus()));
            redirect(base_url(), 'refresh');
            die();
        }
		redirect(base_url()."index.php/User/login?error=invalid", 'refresh');
	}

	//Crée un compte si les informations sont correctes
	public function signinCheck(){
		$email = $_POST['email'];
        $password = $_POST ['password'];
        $cpassword = $_POST ['confpassword'];
		$pseudo = explode("@",$email);
        $user = $this->UserModel->findByEmail($email);
        if ($user == null && $password==$cpassword) {
			$this->UserModel->add($email, $pseudo[0], $password, "Visitor");
			$user = $this->UserModel->findByEmail($email);
            $this->session->set_userdata('login', array("email"=>$user->getEmail(),"pseudo"=>$user->getPseudo(), "status"=>$user->getStatus()));
            redirect(base_url()."index.php/Home",'refresh');
            die();
        } else if ($user!=null){
			if (isset($_SESSION["login"])) {
				redirect(base_url()."index.php/Home",'refresh');
			} else {
				redirect(base_url().'index.php/User/login', 'refresh');
			}	
		}
		$this->load->view('login');
	}

	//Déconecte un utilisateur
	public function logout(){
        	$this->session->set_userdata('login', array("email"=>"", "pseudo"=>"", "status"=>"Visitor"));
		redirect(base_url(), 'refresh');
	}

	//Affiche la page de profil d'un utilisateur
    public function display(string $email="a"){
		
		if (!isset($_SESSION['login']) || $_SESSION["login"]["status"] != "Administrator" &&$_SESSION["login"]["email"]!=$email){
			redirect('User/login', 'refresh');
		}
		$user=$this->UserModel->findByEmail($email);
		if($user==null)redirect(base_url()."index.php/User/login",'refresh');
		$allCommands=$this->CommandeModel->getAllCommandsFromUser($email);
		$data['user']=$user;
		$tab=array();
		foreach($allCommands as $cmd){
			$info=$this->ProductModel->getProductInformationsById($cmd->getRefProd());
			$product=$this->ProductModel->findById($info->getProduct());
			$product->setPrice($cmd->getPrice());
			$info->setQuantity($cmd->getQuantity());
			if (empty($tab[$cmd->getId()])){
				$tab[$cmd->getId()]=array($cmd);
			}
			array_push($tab[$cmd->getId()],array($product,$info));
		}
		$data['allCommands']=$tab;
		//include_once("Home.php"); $home = new Home(); 
		$cart = $this->ProductModel->getAllCartArray();
		$allProductsOfCart = array();
		if (!empty($cart)) {
			foreach ($cart as $item) {
				$id = intval($item[0]);
				$product = $this->ProductModel->findById($item[0]);
				$info = $this->ProductModel->getProductInformationsById(intval($item[1]));
				$qty = $item[2];
				$size=$info->getSize(); 
				$color=$info->getColor();
				$idInfo = $info->getId();
				$maxQty = $info->getQuantity();
				$arr = array($product, array($qty, $size, $color, $idInfo, $maxQty));
				array_push($allProductsOfCart, $arr);
			}
		}
		$data["allcartproducts"]=$allProductsOfCart;
		$this->load->view('user', $data);
    }

	//Permet de supprimer un utilisateur
	//MEMENTO : Lors de la supression d'un user, le memento prends en attribut l'user supprimé
    public function delete(string $email="a"){
		if (!isset($_SESSION['login']) || $_SESSION["login"]["status"] != "Administrator") redirect(base_url().'index.php/Home/accessDenied', 'refresh');
		$userToDelete=$this->UserModel->findByEmail($email);
		if($userToDelete==null)redirect(base_url()."index.php/Home",'refresh');
		if ($this->UserModel->isUserUse($email)){
			$response = ['success'=>'Le compte possède une commande.'];
			echo json_encode($response);if (isset($_SERVER['PHPUNIT_TEST']) && $_SERVER['PHPUNIT_TEST'] == 1) {redirect(base_url()."index.php/Home/admin",'refresh');}else exit;
		}else{
			$memento=$userToDelete->saveToMemento();
			$this->session->set_flashdata('UserMemento', $memento);
			$this->UserModel->delete($email);
			$response = ['success'=>'Compte supprimé.'];
			echo json_encode($response);if (isset($_SERVER['PHPUNIT_TEST']) && $_SERVER['PHPUNIT_TEST'] == 1) {redirect(base_url()."index.php/Home/admin",'refresh');}else exit;
		}
		
	}

	//Modifie un utilisateur
    public function updateUser(){
		if (!isset($_SESSION['login']) || $_SESSION["login"]["status"] != "Administrator") redirect(base_url().'index.php/Home/accessDenied', 'refresh');
		$email= $_POST['email'];
		$pseudo= $_POST['pseudo'];
		$password = $_POST['password'];
		$status= $_POST['status'];
		$user=$this->UserModel->findByEmail($email);
		$this->UserModel->update($email, $pseudo, $password, $status);
		$data['allusers']=$this->UserModel->findAll();
		$response = ['success'=>'Compte modifié.'];
		echo json_encode($response);if (isset($_SERVER['PHPUNIT_TEST']) && $_SERVER['PHPUNIT_TEST'] == 1) {redirect(base_url()."index.php/Home/admin",'refresh');}else exit;
	}

	//Modifie le pseudo d'un utilisateur
	public function updateUserPseudo($email){
		if (!isset($_SESSION["login"]['status'])) {
			redirect(base_url()."index.php/Home",'refresh');
		}
		$pseudo= $_GET['pseudo'];
		$this->UserModel->updatePseudo($email, $pseudo);
		if (isset($_SESSION["redirect"])) {
			redirect($_SESSION["redirect"],'refresh');
		} else {
			redirect(base_url()."index.php/Home",'refresh');
		}
	}

	//Modifie le mot de passe d'un utilisateur
	public function updateUserMDP($email){
		if (!isset($_SESSION["login"]['status'])) {
			redirect(base_url()."index.php/Home",'refresh');
		}
		$p= $_GET['password'];
		$np= $_GET['newpassword'];
		$this->UserModel->updateMDP($email, $np);
		if (isset($_SESSION["redirect"])) {
			redirect($_SESSION["redirect"],'refresh');
		} else {
			redirect(base_url()."index.php/Home",'refresh');
		}
	}

	//Ajoute un utilisateur
	public function addUser(){
		if (!isset($_SESSION['login']) || $_SESSION["login"]["status"] != "Administrator") redirect(base_url().'index.php/Home/accessDenied', 'refresh');
		$email= $_POST['email'];
		$pseudo= $_POST['pseudo'];
		$password = $_POST['password'];
		$status= $_POST['status'];

		if ($this->UserModel->findByEmail($email)==null){
			$this->UserModel->add($email, $pseudo, $password, $status);
			$data['allusers']=$this->UserModel->findAll();
			$response = ['success'=>'Compte ajouté.'];
			echo json_encode($response);if (isset($_SERVER['PHPUNIT_TEST']) && $_SERVER['PHPUNIT_TEST'] == 1) {redirect(base_url()."index.php/Home/admin",'refresh');}else exit;
		} else {
			//CASE WHERE USER ALREADY EXISTS IN DATABASE
			$response = ['errors'=>array('Compte deja existant.')];
			echo json_encode($response);if (isset($_SERVER['PHPUNIT_TEST']) && $_SERVER['PHPUNIT_TEST'] == 1) {redirect(base_url()."index.php/Home/admin",'refresh');}else exit;
		}
	}

	public function addUserModel(){
		if (!isset($_SESSION['login']) || $_SESSION["login"]["status"] != "Administrator") redirect(base_url().'index.php/Home/accessDenied', 'refresh');
		$email= $_POST['email'];
		$pseudo= $_POST['pseudo'];
		$password = $_POST['password'];
		$status= $_POST['status'];

		if ($this->UserModel->findByEmail($email)==null){
			$this->UserModel->add($email, $pseudo, $password, $status);
		}
		if (isset($_SESSION["redirect"])) {
			redirect($_SESSION["redirect"],'refresh');
		} else {
			redirect(base_url()."index.php/Home",'refresh');
		}
	}

	//Charge la vue de saisie d'email afin de réinitialiser le mot de passe
	public function forgotPassword(){
		$this->load->view('resetPass');
	}

	//Envoi un email a l'adresse spécifiée si le compte existe bien
	public function forgotPasswordEmail(){
		//SI L'EMAIL EXISTE ET QUE L'USER A CLIQUE
		$client_mail=$_POST['email'];
		$email_verif=$this->UserModel->findByEmail($client_mail);
		if (isset($_POST['reset_request']) && ($email_verif!=null)){
			//CREATION DES TOKENS
			$select=bin2hex(random_bytes(8));
			$token=random_bytes(32);

			//CREATION DU LIEN DE RESET
			$link=base_url()."index.php/User/resetPasswordForm?selector=".$select."&validator=".bin2hex($token);
			$expire=date("U")+1800;
			$this->UserModel->addResetPassword($client_mail, $select, $token, $expire);

			//ENVOI DU MAIL
			$headers = "MIME-Version: 1.0" . "\r\n"; 
			$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n"; 
			$headers .= 'From: '."Skate Shop".'<'.EMAIL.'>' . "\r\n"; 
			$headers .= 'Cc: welcome@example.com' . "\r\n"; 
			$headers .= 'Bcc: welcome2@example.com' . "\r\n"; 
			$htmlContent = file_get_contents("application/views/email/passwordMail.php").$link;
			mail($client_mail, "Réinitialisation du mot de passe...", $htmlContent, $headers);
			redirect("User/forgotPassword?state=success", 'refresh');
		} else {
			//CASE WHERE EMAIL DOESN'T EXISTS IN THE DATABASE
			redirect("User/forgotPassword?state=fail&error=1", 'refresh');
		}
	}

	//Charge la vue de saisie du nouveau mot de passe (acessible depuis le lien envoyé par mail)
	public function resetPasswordForm(){
		$this->load->view('resetPassForm');
	}

	//Vérifie les tokens, les nouveaux mots de passe et modifie le mot de passe
	public function resetPassword(){
		if(isset($_POST['reset_pass_submit'])){
			$selector=$_POST["selector"];
			$validator=$_POST["validator"];
			$new_pass=$_POST["pass"];
			$new_pass_conf=$_POST["pass_repeat"];

			if ($new_pass!=$new_pass_conf) {
				$_POST['reset_pass_submit']="Submit Query";
				redirect(base_url()."index.php/User/resetPasswordForm"."?selector=".$selector."&validator=".$validator."&state=fail&error=1", "refresh");
			} else {
				$currentDate=date("U");
				$search=$this->UserModel->checkSelectorAndExpire($selector, $currentDate);
				if($search==null){
					$this->load->view('errors/wrongTokens');
				} else {
					$tokenBin = hex2bin($validator);
					$tokenCheck=password_verify($tokenBin, $search['passResetToken']);
					if($tokenCheck===false){
						$_POST['reset_pass_submit']="Submit Query";
						redirect(base_url()."index.php/User/resetPasswordForm"."?selector=".$selector."&validator=".$validator."&state=fail&error=2", "refresh");
					} else if ($tokenCheck === true) {
						$user=$this->UserModel->findByEmail($search['passResetEmail']);
						if($user!=null){
							$this->UserModel->update($user->getEmail(), $user->getPseudo(), $new_pass, $user->getStatus());
							$this->load->view('successPass');
						} else {
							$_POST['reset_pass_submit']="Submit Query";
							redirect(base_url()."index.php/User/resetPasswordForm"."?selector=".$selector."&validator=".$validator."&state=fail&error=3", "refresh");
						}
						
					}
				}
			}
		} else {
			$this->load->view('errors/wrongTokens');
		}
	}
} 
