<?php
defined('BASEPATH') OR exit('No direct script access allowed');


/**
 * [Description Product]
 */
class Commande extends CI_Controller {

	

	public function __construct(){
		parent::__construct();
		$this->load->helper('url');
		$this->load->helper('file');
		$this->load->helper('cookie');
		//$this->load->library('pdf');
		$this->load->model('ProductModel');
		$this->load->model('UserModel');
		$this->load->model('UserEntity');
		$this->load->model('CommandeModel');
		$this->load->model('CommandeEntity');
		$this->load->model('Factories/LivraisonFactory');
	}

	//Récupère le panier et renvoi un tableau sous un format exploitable
	public function cartimport()
	{
		$this->load->model('ProductModel');
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
		return $allProductsOfCart;
	}

	//Charge la vue de récapitulatif de commande et de saisie d'adresse
	public function displayCheckout(){
		$data['allcartproducts']=$this->cartimport();
		$this->load->view("checkout.php",$data);
	}
	
	//Sauvegarde une commande, si les infos de paiement sont correctes
	public function save(string $pays,string $add){
		$freeId=$this->findFreeId();
		$nl=new LivraisonFactory();
		$nl= $nl->factory($pays,$add);
		$data = [
			'id' => $freeId,
			'taxe'  => $nl->getTaxe(),
			'fdp'  =>$nl->getFdp(),
			'adresse'  => $nl->getAdresse(),
		];
		$this->db->insert('Livraison', $data);
		$this->CommandeModel->addCommandFromCart($freeId);
		if (isset($_SESSION["login"])) {
			redirect(base_url()."index.php/Product/syncCartAndDatabase", "refresh");
		} else {
			redirect(base_url()."index.php/Home",'refresh');
		}
	}

	//En fonction de la table, trouve un id disponible
	public function findFreeId():int{
		$allCommands=array_reverse($this->CommandeModel->getAllCommands());
		$allIds=array();
		foreach($allCommands as $commande){
			array_push($allIds, $commande->getId());
		}
		if (empty($allIds)){
			return 1;
		}
		if ($allIds[0]!=1){
			return 1;
		} else {
			for ($i=2; $i<=sizeof($allIds); $i++){
				if (!in_array($i, $allIds)){
					return $i;
				}
			}
		}
		return sizeof($allIds)+1;
	}

	//Charge la vue de paiement
	public function Paiement(){
		$pays=$_GET['pays'];
		$add=$_GET['firstname'].'::'.$_GET['lastname'].'::'.$_GET['address'].'::'.$_GET['codepostal'].'::'.$_GET['city'].'::'.$pays;
		$nl=new LivraisonFactory();
		$nl= $nl->factory($pays,$add);
		$data['pays']=$pays;
		$data['livraison']=$nl;
		$data['allcartproducts']=$this->cartimport();
		$this->load->view("paiement.php",$data);
	}
	
}
