<?php
defined('BASEPATH') OR exit('No direct script access allowed');


/**
 * [Description Product]
 */
class Search extends CI_Controller {

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

	//Fonction unique de recherche de produits. Cette fonction prends en compte 5 filtres et 1 tri.
    public function index(){
        if (!isset($_GET["query"])) {
			$_GET['query']="";
		}
		
		$productsFound=$this->ProductModel->search($_GET['query']);
		if (isset($_GET["cat"])) {
			$productsFound=$this->ProductModel->filterSearchByCategories($_GET['cat'], $productsFound);
		}
		if (isset($_GET["col"])) {
			$productsFound=$this->ProductModel->filterSearchByColors($_GET['col'], $productsFound);
		}
		if (isset($_GET["brd"])) {
			$productsFound=$this->ProductModel->filterSearchByBrands($_GET['brd'], $productsFound);
		}
		if (isset($_GET["size"])) {
			$productsFound=$this->ProductModel->filterSearchBySizes($_GET['size'], $productsFound);
		}
		if (isset($_GET["prc"])) {
			$productsFound=$this->ProductModel->filterSearchByPrice($_GET['prc'], $productsFound);
		}
		if (isset($_GET["filter"])) {
			$productsFound=$this->ProductModel->filterSearch($_GET['filter'], $productsFound);
		}
        $request=htmlspecialchars($_GET['query']);

        $data['request']=$productsFound;
		$data["allcartproducts"] = $this->cartimport();
		$data['brands']=$this->ProductModel->getAllBrands();
		$data['categories']=$this->ProductModel->getAllCategories();
		$data['colors']=$this->ProductModel->getAllColors();
		$data["allnewproducts"] = $this->ProductModel->findAllNew();
		$data['biggestPrice']=499.99;
		//var_dump($data['request']);
		$_GET["aaaa"]="aaaa";
        $this->load->view('displayProducts', $data);
    }

}