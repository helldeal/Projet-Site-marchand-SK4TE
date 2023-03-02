<?php
defined('BASEPATH') or exit('No direct script access allowed');
require_once APPPATH . 'controllers' . DIRECTORY_SEPARATOR . "Product.php";


class Home extends CI_Controller
{
	public function __construct(){
		parent::__construct();
		$this->load->helper('url');
		$this->load->helper('file');
		$this->load->helper('cookie');
		$this->load->model('ProductModel');
		$this->load->model('UserModel');
		$this->load->model('UserEntity');
		$this->load->model('CommandeModel');
		$this->load->model('CommandeEntity');
	}
	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/userguide3/general/urls.html
	 */

	//Récupère le panier et le renvoi sous un format exploitable
	public function cartimport(){
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

	//FONCTION CHARGEE DE BASE : Charge le menu principal
	public function index()
	{
		$data["allcartproducts"] = $this->cartimport();
		$data["allproducts"] = $this->ProductModel->findAllNew();
		$this->load->view('home', $data);
	}

	//Charge la vue des conditions légales
	public function droit(){
		$data["allcartproducts"] = $this->cartimport();
		$this->load->view('droit',$data);
	}
	//Charge la vue des infos de livraison
	public function deliveryInfo(){
		$data["allcartproducts"] = $this->cartimport();
		$this->load->view('deliveryInfo',$data);
	}

	//Charge la vue de localisation des magasins
	public function locinfo()
	{
		$data["allcartproducts"] = $this->cartimport();
		$this->load->view('locinfo', $data);
	}

	//Charge la vue administrateur (si l'utilisateur possède le status "admin")
	public function admin()
	{
		// $this->load->helper('url');
		// $headers = 'From: florian_the_gay_lord_of_gay_pride@pornhub.com' . "\r\n" .
		// 	'Reply-To: webmaster@yourdot.com' . "\r\n" .
		// 	'X-Mailer: PHP/' . phpversion();

		// mail('', "WSSP my neighbourg", "SUUUUUUU", $headers);
		//$this->output->enable_profiler(TRUE);

		$data["allusers"] = $this->UserModel->findAll();
		$data["allproducts"] = $this->ProductModel->findAll();
		$data["allcartproducts"] = $this->cartimport();
		$data['brands']=$this->ProductModel->getAllBrands();
		$data['categories']=$this->ProductModel->getAllCategories();
		$data["allcommands"]=$this->CommandeModel->getAllCommands();
		$data['countbrand']=$this->ProductModel->countBrand();
		$data['countpromo']=$this->ProductModel->countPromo();
		$data['countProd']=$this->ProductModel->countProduct();
		$data['countuser']=$this->UserModel->countUser();
		$data['countorder']=$this->CommandeModel->countCommand();
		$data['recipe']=$this->CommandeModel->countRecipe();
		//var_dump($data["allproducts"]);
		$this->load->view('admin', $data);
	}

	//Charge la vue d'accès refusé
	public function accessDenied()
	{
		$this->load->view('errors/accessDenied');
	}

	//Charge la vue de session expirée
	public function sessionOver()
	{
		$this->load->view('errors/session_over');
	}

}
