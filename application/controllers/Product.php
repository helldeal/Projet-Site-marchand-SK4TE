<?php
defined('BASEPATH') OR exit('No direct script access allowed');


/**
 * [Description Product]
 */
class Product extends CI_Controller {

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
		$this->load->model('Factories/ProductInfosFactory');
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
	
	/**
	 * [Description for display]
	 *
	 * @param int $id
	 * 
	 * @return [type]
	 * 
	 */
	//Affiche un produit
	public function display(int $id = 1){
		$allInformations=$this->ProductModel->getAllProductInformationsById($id);
		if (is_null($allInformations)) {
			redirect(base_url()."index.php/Home",'refresh');
		}
		$allInformationsByColor=array();
		$allInformationsBySize=array();
                if(!isset($_GET["color"]))redirect(base_url()."index.php/Product/display/".$id."?color=".urlencode($allInformations[0][0]["color"]),'refresh');
		foreach($allInformations as $infos){
			foreach ($infos as $info){
				$allInformationsByColor[$infos[0]["color"]][$info["size"]]=$info;
			}
		}
		$product=$this->ProductModel->findById($id);
		$data["product"]=$product;
		$data["allcartproducts"] = $this->cartimport();
		$data["allInformations"]=$allInformationsByColor;
		if (is_null($product)) {
			redirect(base_url()."index.php/Home",'refresh');
		}
		//var_dump($allInformationsByColor);
		$this->load->view('displayProduct', $data);
	}


	// --------------------------------ADD-------------------------------//
	
	/**
	 * [Description for add]
	 *
	 * @return [type]
	 * 
	 */
	//Ajoute un produit 
	public function addProduct(){
		if (!isset($_SESSION['login']) || $_SESSION["login"]["status"] != "Administrator") redirect(base_url().'index.php/Home/accessDenied', 'refresh');
		$picture=$this->upload();
		$id= $this->findFreeId('Product');
		$name = $this->input->post('name');
		$brand= $this->input->post('brand');
		$category= $this->input->post('category');
		$price= $this->input->post('price');
		$description= $this->input->post('description');
		$this->ProductModel->add($id, $name, $brand, $category, $price, $picture, $description);
if(!isset($_GET["color"]))redirect(base_url()."index.php/Product/display/".$id."?color=".$allInformations[0][0]["color"],'refresh');		$response = ['success'=>"Produit ajouté"];
		echo json_encode($response);exit;
	}


// --------------------------------CATEGORY-------------------------------//
	
	/**
	 * [Description for add]
	 *
	 * @return [type]
	 * 
	 */
	//Ajoute une catégorie
	public function addCategory(){
		if (!isset($_SESSION['login']) || $_SESSION["login"]["status"] != "Administrator") redirect(base_url().'index.php/Home/accessDenied', 'refresh');
		$id=$this->findFreeId("Category");
		$category= $_GET['category'];
		$this->ProductModel->addCategory($id, $category);
		$response = ['success'=>"Catégorie ajoutée"];
		echo json_encode($response);exit;
	}

	//Supprime une catégorie
	public function deleteCategory(int $id=1){
		if (!isset($_SESSION['login']) || $_SESSION["login"]["status"] != "Administrator") redirect(base_url().'index.php/Home/accessDenied', 'refresh');
		if(is_null($this->ProductModel->findCategorybyId($id)))redirect(base_url()."index.php/Home/admin",'refresh');
		if ($this->ProductModel->isCategoryUse($id)){
			$response = ['success'=>"Catégorie utilisée par un produit."];
			echo json_encode($response);exit;
		} else{
			$this->ProductModel->deleteCategory($id);
			$response = ['success'=>'Catégorie supprimée.'];
			echo json_encode($response);exit;
		}
	}

// --------------------------------BRAND-------------------------------//
	
	/**
	 * [Description for add]
	 *
	 * @return [type]
	 * 
	 */
	//Ajoute une marque
	public function addBrand(){
		if (!isset($_SESSION['login']) || $_SESSION["login"]["status"] != "Administrator") redirect(base_url().'index.php/Home/accessDenied', 'refresh');
		$id=$this->findFreeId("Brand");
		$brand= $_POST['brand'];
		$this->ProductModel->addBrand($id, $brand);
		$response = ['success'=>"Marque ajoutée"];
		echo json_encode($response);exit;
	}
	
	//supprime une marque
	public function deleteBrand(int $id){
		if (!isset($_SESSION['login']) || $_SESSION["login"]["status"] != "Administrator") redirect(base_url().'index.php/Home/accessDenied', 'refresh');
		if(is_null($this->ProductModel->findBrandbyId($id)))redirect(base_url()."index.php/Home/admin",'refresh');
		if ($this->ProductModel->isBrandUse($id)){
			$response = ['success'=>'Marque utilisée par un produit.'];
			echo json_encode($response);exit;
		} else{
			$this->ProductModel->deleteBrand($id);
			$response = ['success'=>'Marque supprimée.'];
			echo json_encode($response);exit;
		}
	}

// --------------------------------QUANTITY-------------------------------//

	//Modifie la quantité d'un produit pour une certaine taille et couleur
	public function updateQuantity(int $id){
		if (!isset($_SESSION['login']) || $_SESSION["login"]["status"] != "Administrator") redirect(base_url().'index.php/Home/accessDenied', 'refresh');
		$qty=$this->input->post('qty');
		$this->ProductModel->changeQuantity($id, $qty);
		if (isset($_SESSION["redirect"])) {
			redirect($_SESSION["redirect"],'refresh');
		} else {
			redirect(base_url()."index.php/Home",'refresh');
		}
	}

	//ajoute une taille a un produit pour une certaine couleur
	public function addSize(int $productId){
		if (!isset($_SESSION['login']) || $_SESSION["login"]["status"] != "Administrator") redirect(base_url().'index.php/Home/accessDenied', 'refresh');
		$id=0;
		$product=$productId;
		$size=$this->input->post('size');
		$qty=0;
		$color=$this->input->post('color');
		$code=$this->input->post('colorCode');

		$infos=array(
			"size" =>$size,
			"id" =>$id,
			"productId" =>$product,
			"color" =>$color, 
			"quantity" =>$qty,
			"colorCode" =>$code
		);
		$factory=New ProductInfosFactory;
		$object=$factory->infosFactory($infos);

		$checksizes=$this->ProductModel->getAllProductInformationsById($product);
		foreach($checksizes as $check){
			if ($check[0]["color"]==$color){
				foreach($check as $c){
					if($size==$c["size"]){
						if (isset($_SESSION["redirect"])) {
							redirect($_SESSION["redirect"],'refresh');
						} else {
							redirect(base_url()."index.php/Home",'refresh');
						}
					}
				}
			}
			
		}


		if(!is_null($object)){
			$sizesOfColor=$this->getSizesFromColor($product, $color);
			$this->ProductModel->deleteColor($product, $color);
			$this->ProductModel->addSize($id, $product, $size, $qty, $color, $code);
		}

		if (isset($_SESSION["redirect"])) {
			redirect($_SESSION["redirect"],'refresh');
		} else {
			redirect(base_url()."index.php/Home",'refresh');
		}
	}

	//Supprime une taille pour une certaine couleur
	public function deleteSize(int $id){
		if (!isset($_SESSION['login']) || $_SESSION["login"]["status"] != "Administrator") redirect(base_url().'index.php/Home/accessDenied', 'refresh');
		if(!$this->ProductModel->isProductInfoUse($id)){
			$this->ProductModel->deleteSize($id);
		}
		if (isset($_SESSION["redirect"])) {
			redirect($_SESSION["redirect"],'refresh');
		} else {
			redirect(base_url()."index.php/Home",'refresh');
		}
	}

// --------------------------------COLOR-------------------------------//

	//Renvoi les tailles relatives a une couleur d'un produit
	public function getSizesFromColor(int $productId, string $color){
		$allInfos=$this->ProductModel->getAllProductInformationsById($productId);
		$sizes=array();
		foreach($allInfos as $infosOfColor){
			if($infosOfColor[0]["color"]==$color){
				foreach($infosOfColor as $info)
					array_push($sizes, $info);
			}
		}
		return $sizes;
	}

	//Charge la vue d'ajout d'une couleur
	public function addColor(int $productId){
		if (!isset($_SESSION['login']) || $_SESSION["login"]["status"] != "Administrator") redirect(base_url().'index.php/Home/accessDenied', 'refresh');
		$infos=$this->ProductModel->getAllProductInformations();
		$colors=array();
		foreach ($infos as $info) {
			if ($info->getProduct()!=$productId){
				$color=New ColorEntity($info->getColor(), $info->getColorCode());
				array_push($colors, $color);
			}
		}
		$data["colors"]=$this->ProductModel->remove_duplicate_colors($colors);
		$data["productId"]=$productId;
		$data["productId"]=$productId;
		$this->load->view("addColor", $data);
	}

	//Ajoute une couleur a un produit
	public function addColorModel(int $productId){
		if (!isset($_SESSION['login']) || $_SESSION["login"]["status"] != "Administrator") redirect(base_url().'index.php/Home/accessDenied', 'refresh');
		$id=0;
		$color=$this->input->post("colorName");
		$colorCode=$this->input->post("colorCode");
		$this->ProductModel->addColor($id, $productId, $color, $colorCode);
		if (isset($_SESSION["redirect"])) {
			redirect($_SESSION["redirect"],'refresh');
		} else {
			redirect(base_url()."index.php/Home",'refresh');
		}
	}

	//Ajoute une couleur déja existante pour un autre produit a un produit
	public function addExistingColor(int $productId, string $colorCode, string $colorName){
		if (!isset($_SESSION['login']) || $_SESSION["login"]["status"] != "Administrator") redirect(base_url().'index.php/Home/accessDenied', 'refresh');
		$id=0;
		$this->ProductModel->addColor($id, $productId, urldecode($colorName), '#'.$colorCode);
		if (isset($_SESSION["redirect"])) {
			redirect($_SESSION["redirect"],'refresh');
		} else {
			redirect(base_url()."index.php/Home",'refresh');
		}
	}

// --------------------------------DELETE-------------------------------//
	
	
	/**
	 * [Description for delete]
	 *
	 * @param int $id
	 * 
	 * @return [type]
	 * 
	 */
	//Supprime un produit
	public function delete(int $id = 1){
		if (!isset($_SESSION['login']) || $_SESSION["login"]["status"] != "Administrator") redirect(base_url().'index.php/Home/accessDenied', 'refresh');
		$product=$this->ProductModel->findById($id);
		if (is_null($product)) {
			redirect(base_url()."index.php/Home/admin",'refresh');
		}
		if ($this->ProductModel->isProductUse($id)){
			$response = ['success'=>'Produit dans une commande.'];
			echo json_encode($response);exit;	
		}else{
			$this->ProductModel->deletePromo($id);
			$product=$this->ProductModel->findById($id);
			$count=$product->getPicturesSize();
			for ($i=0; $i<$count; $i++){
				if ($product->getPicture($i) != "error/null.jpg"){
					unlink("./public/img/products/".$product->getPicture($i));
				}
			}
			
			$this->ProductModel->delete($id);
			$response = ['success'=>'Produit supprimé.'];
			echo json_encode($response);exit;	
		}
		
	}

	



	// --------------------------------UPDATE-------------------------------//

	/**
	 * [Description for update]
	 *
	 * @param int $id
	 * 
	 * @return [type]
	 * 
	 */
	//Charge la vue de modification d'un produit
	public function update(int $id = 1){
		if (!isset($_SESSION['login']) || $_SESSION["login"]["status"] != "Administrator") redirect(base_url().'index.php/Home/accessDenied', 'refresh');
		$data["id"]=$id;
		$product=$this->ProductModel->findById($id);
		if (is_null($product)) {
			redirect(base_url()."index.php/Home/admin",'refresh');
		}
		$data["name"]=$product->getName();
		$data["price"]=$product->getPrice();
		$data["actualBrand"]=$product->getBrand();
		$data["actualCategory"]=$product->getCategory();
		$data["description"]=$product->getDescription();
		$data["allpictures"]=$product->getPictures();
		$brands=$this->ProductModel->getAllBrands();
		$data["brands"]=$brands;
		$categories=$this->ProductModel->getAllCategories();
		$data["categories"]=$categories;
		$sizes=$this->ProductModel->getAllProductInformationsById($id);
		$data["sizes"]=$sizes;
		if (get_class($product)=="PromotionProductEntity"){
			$data["promo"]=$product->promotion();
		} 
		$this->load->view('updateProduct', $data);
	}
	
	/**
	 * [Description for updateProduct]
	 *
	 * @return [type]
	 * 
	 */
	//Modifie un produit
	public function updateProduct(){
		if (!isset($_SESSION['login']) || $_SESSION["login"]["status"] != "Administrator") redirect(base_url().'index.php/Home/accessDenied', 'refresh');
		$id= $this->input->post('id');
		$name = $this->input->post('name');
		$brand= $this->input->post('brand');
		$category= $this->input->post('category');
		$price= $this->input->post('price');
		$description=$this->input->post("description");
		$product=$this->ProductModel->findById($id);
		$pictures=$product->getPictures();
		$picture=implode(", ", $pictures);
		$this->ProductModel->update($id, $name, $brand, $category, $price, $picture, $description);
		
		if (isset($_SESSION["login"])) {
			redirect('Home/admin', 'refresh');
		} else {
			redirect(base_url()."index.php/Home",'refresh');
		}
	}

	//Décrémente Un produit d'une certaine couleur et d'une certaine taille du panier
	public function decreaseProductQuantity(int $id=1, int $qtyToDecrement=1){
		$info = $this->ProductModel->getProductInformationsById($id);
		$this->ProductModel->changeQuantity($id,$info->getQuantity()-$qtyToDecrement);
	}

	//Supprime les produits du panier dans la base de données
	public function syncCartAndDatabase(){
		$cart=$this->ProductModel->getAllCartArray();
		foreach ($cart as $product){
			$info = $this->ProductModel->getProductInformationsById(intval($product[1]));
			$this->decreaseProductQuantity($info->getId(),$product[2]);
		}
		delete_cookie("cart");
		$cart=$this->ProductModel->getAllCartArray();
		
		if (isset($_SESSION["login"])) {
			redirect('Home/index', 'refresh');
		} else {
			redirect(base_url()."index.php/Home",'refresh');
		}
	}



// --------------------------------PICTURES-------------------------------//

	//Modifie l'image d'un produit
	public function updatePictureOfProduct(int $id=1, string $old_picture=""){
		if (!isset($_SESSION['login']) || $_SESSION["login"]["status"] != "Administrator") redirect(base_url().'index.php/Home/accessDenied', 'refresh');
		$product=$this->ProductModel->findById($id);
		$picture=$this->upload();
		$count=$product->getPicturesSize();
		if($count==1){
			$this->ProductModel->update($id, $product->getName(), $product->getBrand(), $product->getCategory(), $product->getPrice(), $picture, $product->getDescription());
			if (isset($_SESSION["login"])) {
				redirect("Product/update/".$id, "refresh");
			} else {
				redirect(base_url()."index.php/Home",'refresh');
			}
		}
		else{
			$this->ProductModel->updatePictureOfProduct($id, $old_picture, $picture);
			redirect("Product/update/".$id, "refresh");
		}
	}

	//Supprime l'image d'un produit
	public function deletePictureOfProduct(int $id=1, string $picture=""){
		if (!isset($_SESSION['login']) || $_SESSION["login"]["status"] != "Administrator") redirect(base_url().'index.php/Home/accessDenied', 'refresh');
		$product=$this->ProductModel->findById($id);
		$count=$product->getPicturesSize();
		if($count==1){
			$index=array_search($picture,$product->getPictures());
			unlink("./public/img/products/".$product->getPicture($index));
			$this->ProductModel->update($id, $product->getName(), $product->getBrand(), $product->getCategory(), $product->getPrice(), "error/null.jpg", $product->getDescription());
			if (isset($_SESSION["login"])) {
				redirect("Product/update/".$id, "refresh");
			} else {
				redirect(base_url()."index.php/Home",'refresh');
			}
		} else {
			$index=array_search($picture,$product->getPictures());
			unlink("./public/img/products/".$product->getPicture($index));
			$this->ProductModel->deletePictureOfProduct($id, $picture);
			if (isset($_SESSION["login"])) {
				redirect("Product/update/".$id, "refresh");
			} else {
				redirect(base_url()."index.php/Home",'refresh');
			}
		}
	}

	//Ajoute une image a un produit
	public function addPictureOfProduct(int $id=1){
		if (!isset($_SESSION['login']) || $_SESSION["login"]["status"] != "Administrator") redirect(base_url().'index.php/Home/accessDenied', 'refresh');
		$product=$this->ProductModel->findById($id);
		$picture=$this->upload();
		if (isset($_POST['pos']))
			$pos=$_POST['pos'] ;
		else
			$pos=0;
		$count=$product->getPicturesSize();
		if($count==1 && $product->getPicture(0)=="error/null.jpg"){
			$this->ProductModel->update($id, $product->getName(), $product->getBrand(), $product->getCategory(), $product->getPrice(), $picture, $product->getDescription());
			if (isset($_SESSION["login"])) {
				redirect("Product/update/".$id, "refresh");
			} else {
				redirect(base_url()."index.php/Home",'refresh');
			}
		}
		else{
			$this->ProductModel->addPictureOfProduct($id, $pos, $picture);
			if (isset($_SESSION["login"])) {
				redirect("Product/update/".$id, "refresh");
			} else {
				redirect(base_url()."index.php/Home",'refresh');
			}
		}
	}

// --------------------------------UPLOAD-------------------------------//

	//Si l'image est correcte, upload l'image / sinon, renvoi l'image "no picture"
	public function upload():string { 
		if (!isset($_SESSION['login']) || $_SESSION["login"]["status"] != "Administrator") redirect(base_url().'index.php/Home/accessDenied', 'refresh');
		$config['allowed_types'] = 'gif|jpg|png|jpeg';
		$config['upload_path']   = 'public/img/products/'; 
		$config['encrypt_name']=TRUE;
		$config['max_size'] = 1500;
		$this->load->library('upload', $config);
		if (isset($_FILES['userfile']['name']) && is_array($_FILES['userfile']['name'])){
			$countfiles = count($_FILES['userfile']['name']);
		}
		else {
			if( ! $this->upload->do_upload('userfile')){
				$data["upload_error"]=$this->upload->display_errors(); 
				//$this->load->view('addProduct', $data);
				return "error/null.jpg";
			} else {
				$uploadData = $this->upload->data();
				$filename = $uploadData['file_name'];
				return $filename;
			}
		}

		//CAS OU 0 FICHIERS CHARGES
		if ($_FILES['userfile']['name'][0]==""){
			return "error/null.jpg";
		}

		//CAS OU FICHIER CHARGE
		else if ($countfiles==1){
			if(!empty($_FILES['userfile']['name'][0])){
				// Define new $_FILES array - $_FILES['file']
				$_FILES['file']['name'] = $_FILES['userfile']['name'][0];
				$_FILES['file']['type'] = $_FILES['userfile']['type'][0];
				$_FILES['file']['tmp_name'] = $_FILES['userfile']['tmp_name'][0];
				$_FILES['file']['error'] = $_FILES['userfile']['error'][0];
				$_FILES['file']['size'] = $_FILES['userfile']['size'][0];

				if( ! $this->upload->do_upload('file')){
			// Get data about the file
					$data["upload_error"]=$this->upload->display_errors(); 
					$this->load->view('addProduct', $data);
					return "error/null.jpg";
				} else {
					$uploadData = $this->upload->data();
					$filename = $uploadData['file_name'];
					return $filename;
				}
			}

		}

		//CAS OU PLUSIEURS FICHIERS CHARGES 
		else{
			$files=array();
			for ($i=0; $i<$countfiles; $i++){
				if(!empty($_FILES['userfile']['name'][$i])){
					// Define new $_FILES array - $_FILES['file']
					$_FILES['file']['name'] = $_FILES['userfile']['name'][$i];
					$_FILES['file']['type'] = $_FILES['userfile']['type'][$i];
					$_FILES['file']['tmp_name'] = $_FILES['userfile']['tmp_name'][$i];
					$_FILES['file']['error'] = $_FILES['userfile']['error'][$i];
					$_FILES['file']['size'] = $_FILES['userfile']['size'][$i];

					if($this->upload->do_upload('file')){
				// Get data about the file
						$uploadData = $this->upload->data();
						$filename = $uploadData['file_name'];
						array_push($files, $filename);
					}
				}
			}
			//On retourne le tableau de noms de fichiers sous la forme d'un string exploitable par la suite (, et espace)
			if (empty($files))
				return "error/null.jpg";
			else
				return implode(', ', $files);
		}
	}




	// --------------------------------OTHER FUNCTIONS-------------------------------//
	
	//Pour une table donnée, trouve un id libre
	public function findFreeId(string $table=""):int{
		if ($table == 'Product')
			$allItems=$this->ProductModel->findAll();
		else if ($table == 'Category')
			$allItems=$this->ProductModel->getAllCategories();
		else if ($table == 'Brand')
			$allItems=$this->ProductModel->getAllBrands();
		$allIds=array();
		foreach($allItems as $item){
			array_push($allIds, $item->getId());
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



// --------------------------------CART FUNCTIONS-------------------------------//

	//Ajoute au panier un produit d'une certaine taille et d'une certaine couleur
	public function addToCart(int $id=1){
		$size=$_POST["size"];
		$color=$_POST["color"];
		$idInfo=$this->ProductModel->findInfoId($size, $color, $id);
		$idInfo=$idInfo["id"];
		$val=$id.",".$idInfo.",1";
		if (! $this->session->has_userdata('cart') or empty($this->session->cart)){
			$this->session->set_userdata('cart', $val);
		} else {
			$cart=$this->ProductModel->getAllCartArray();
			foreach ($cart as $product){
				if ($product[1]==$idInfo){
					$this->updateCartQtyByDiff($idInfo, 1);
					if (isset($_SESSION["redirect"])) {
						redirect($_SESSION["redirect"],'refresh');
					} else {
						redirect(base_url()."index.php/Home",'refresh');
					}
				}
			}
			$cart_content=$this->session->cart;
			$val="/".$id.",".$idInfo.",1";
			$cart_content=$cart_content.$val;
			$this->session->set_userdata('cart', $cart_content);
		}
		if (isset($_SESSION["redirect"])) {
			redirect($_SESSION["redirect"],'refresh');
		} else {
			redirect(base_url()."index.php/Home",'refresh');
		}
	}

	//Supprime un produit d'une certaine taille et d'une certaine couleur d'un produit
	public function deleteToCart(int $id=1){
		$cart=$this->ProductModel->getAllCartArray();
		for ($i=0; $i<sizeOf($cart); $i++){
			if ($cart[$i][1]==$id){
				unset($cart[$i]);
			}
		}
		$final_str="";
		foreach($cart as $pro){
			$str=implode(',',$pro);
			$final_str=$final_str.$str."/";
		}
		$final_str=substr($final_str, 0, -1);
		$this->session->set_userdata('cart', $final_str);
		if (isset($_SESSION["redirect"])) {
			redirect($_SESSION["redirect"],'refresh');
		} else {
			redirect(base_url()."index.php/Home",'refresh');
		}
	}

	//Modifie la quantité d'un produit dans le panier
	public function updateCartQtyByDiff(int $idInfo=1, int $new_qty=0){
		$cart=$this->ProductModel->getAllCartArray();
		$info=$this->ProductModel->getProductInformationsById($idInfo);
		$index=0;
		$oldval=0;
		for ($i=0; $i<sizeOf($cart); $i++){
			if ($cart[$i][1]==$idInfo){
				$oldval=$cart[$i][2];
				unset($cart[$i]);
				$index=$i;
			}
		}	
		$new_qty+=$oldval;
		if ($new_qty>$info->getQuantity())
			$new_qty=$info->getQuantity();
		
		if ($new_qty<=0)
			$new_qty=0;
		if ($new_qty+$oldval<=0 or $new_qty>$info->getQuantity()){
			$new_qty=$info->getQuantity();
		}
		$final_str="";
		
		if (empty($cart)){
			$final_str=$info->getProduct().",".$idInfo.",".$new_qty;
		}
		else {
			for ($i=0; $i<=sizeOf($cart); $i++){
		 		if ($i==$index){
		 			$str=$info->getProduct().",".$idInfo.",".$new_qty."/";
		 			$final_str=$final_str.$str;
		 		} else{ 
		 			$str=implode(',',$cart[$i]);
		 			$final_str=$final_str.$str."/";
		 		}	
		 	}
		 	$final_str=substr($final_str, 0, -1);
		}
		$this->session->set_userdata('cart', $final_str);
	}

	//Incrémente de 1 la quantité d'un produit dans le panier
	public function increaseCartQty(int $idInfo, int $previous_qty){
		if ($this->ProductModel->checkCartStock($idInfo, $previous_qty+1))
			$this->updateCartQtyByDiff($idInfo, 1);
		// redirect("Home/cart");
	}

	//Décrémente de 1 la quantité d'un produit dans le panier
	public function decreaseCartQty(int $idInfo, int $previous_qty){
		if ($previous_qty==1){
			//AJOUTER FENETRE DE COMFIRMATION DE SUPRESSION
			$this->deleteToCart($idInfo);

		} else {
			$this->updateCartQtyByDiff($idInfo,-1);
			redirect("Home/cart");
		}
		
	}

	//Donne le prix total du panier
	public function getCartTotal():float{
		$cart=$this->ProductModel->getAllCartArray();
		$total=0.0;
		if (!empty($cart)){
			foreach ($cart as $product){
				$total+=$product[0]*$product[1];
			}
		}
		return $total;
	}

	//Supprime tout le panier
	public function dropCart(){
		$this->session->unset_userdata('cart');
		if (isset($_SESSION["redirect"])) {
			redirect($_SESSION["redirect"],'refresh');
		} else {
			redirect(base_url()."index.php/Home",'refresh');
		}
	}
	
	//Charge la vue d'ajout d'une promotion
	public function addPromotion(int $id=1){
		if (!isset($_SESSION['login']) || $_SESSION["login"]["status"] != "Administrator") redirect(base_url().'index.php/Home/accessDenied', 'refresh');
		$data["id"]=$id;
		$this->load->view("addPromo", $data);
	}

	//Ajoute une promotion
	public function addPromoModel(){
		if (!isset($_SESSION['login']) || $_SESSION["login"]["status"] != "Administrator") redirect(base_url().'index.php/Home/accessDenied', 'refresh');
		$id=$this->input->post('id');
		$promo=$this->input->post('promo');
		$this->ProductModel->addPromo($id, $promo);
		if (isset($_SESSION["redirect"])) {
			redirect($_SESSION["redirect"],'refresh');
		} else {
			redirect(base_url()."index.php/Home",'refresh');
		}
	}

	//Supprime une promotion d'un produit
	public function deletePromo(int $id=1){
		if (!isset($_SESSION['login']) || $_SESSION["login"]["status"] != "Administrator") redirect(base_url().'index.php/Home/accessDenied', 'refresh');
		$this->ProductModel->deletePromo($id);
		if (isset($_SESSION["redirect"])) {
			redirect($_SESSION["redirect"],'refresh');
		} else {
			redirect(base_url()."index.php/Home",'refresh');
		}
	}

}




