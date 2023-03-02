<?php
require_once APPPATH.'models'.DIRECTORY_SEPARATOR.'Entities'.DIRECTORY_SEPARATOR."ProductEntity.php";
require_once APPPATH.'models'.DIRECTORY_SEPARATOR.'Entities'.DIRECTORY_SEPARATOR."BrandEntity.php";
require_once APPPATH.'models'.DIRECTORY_SEPARATOR.'Entities'.DIRECTORY_SEPARATOR."CategoryEntity.php";
require_once APPPATH.'models'.DIRECTORY_SEPARATOR.'Entities'.DIRECTORY_SEPARATOR."ColorEntity.php";
require_once APPPATH.'models'.DIRECTORY_SEPARATOR.'Entities'.DIRECTORY_SEPARATOR."ProductInfosEntity.php";
require_once APPPATH.'models'.DIRECTORY_SEPARATOR.'Factories'.DIRECTORY_SEPARATOR."ProductFactory.php";
require_once APPPATH.'models'.DIRECTORY_SEPARATOR.'Factories'.DIRECTORY_SEPARATOR."ProductInfosFactory.php";
class ProductModel extends CI_Model {

    //Donne tous les produits sous la forme d'un tableau de productEntity (MainProductEntity // PromotionProductEntity)
    function findAll():array{
        $req="CALL product_getAllProducts()";
        $q=$this->db->query($req);
        $res=$q->result_array();

        $q->next_result();
        $q->free_result();

        $result_array=array();
        foreach($res as $r){
            
            $promo=$this->getPromoById($r["id"]);
            if($promo!=null){
                $r["promo"]=$promo;
            }
            $factory=new ProductFactory;
            $r=$factory->factory($r);
            array_push($result_array,$r);
        }
        return $result_array;
    }
    
    //Renvoi les 6 produits les plus récents sous la forme d'un tableau de ProductEntity (MainProductEntity // PromotionProductEntity) 
    function findAllNew():array{
        $req = "SELECT * FROM Product ORDER BY id DESC LIMIT 6";
        $q=$this->db->query($req);
        $res=$q->result_array();

        $q->next_result();
        $q->free_result();

        $result_array=array();
        foreach($res as $r){
            
            $promo=$this->getPromoById($r["id"]);
            if($promo!=null){
                $r["promo"]=$promo;
            }
            $factory=new ProductFactory;
            $r=$factory->factory($r);
            array_push($result_array,$r);
        }
        return $result_array;

    }

    //Renvoi toutes les promotions sous la forme d'un tableau de PromotionEntity
    function findAllPromotions():array{
        $req="CALL promo_getAllPromos()";
        $q=$this->db->query($req);
        $res=$q->custom_result_object('PromotionEntity');
    }

    //Renvoi un produit (ou null) correspondant au paramètre $id
    function findById(int $id):?ProductEntity{
        $data=[
            'id'=>$id,
        ];
        $req="CALL product_findById(?)";
        $res=$this->db->query($req, $data);
        $result=$res->result_array();

        $res->next_result();
        $res->free_result();


        $result_array=array();
        foreach($result as $r){
            $promo=$this->getPromoById($r["id"]);
            if($promo!=null){
                $r["promo"]=$promo;
            }
            $factory=new ProductFactory;
            $r=$factory->factory($r);
            array_push($result_array,$r);
        }
        
        if (empty($result)){
            return null;
        } else {
            return $result_array[0];
        }
    }

    //Savoir si un produit a une commande via les ProductInfos
    function isProductUse(int $id):Bool{
        $bool=false;
        $resultInfos=$this->getAllProductInformationsById($id);
        foreach($resultInfos as $infos){
            foreach($infos as $info){
                if($this->isProductInfoUse($info["id"])){
                    $bool=true;
                }
            }
        }
        return $bool;
    }

    //Savoir si une information de produit a une commande
    function isProductInfoUse(int $id):Bool{
        $result = $this->db->select('refprod')->from('Order')->where('refprod', $id)->limit(1)->get()->row();
        return gettype($result)!="NULL";
    }


    //Ajoute un produit a la base de données
    function add(int $id, string $name, int $brand, ?int $category, float $price, string $picture, ?string $description){
        $data=[
            'id'=>$id,
            'name'=>$name,
            'brand'=>$brand,
            'category'=>$category,
            'price'=>$price,
            'picture'=>$picture,
            'description'=>$description,
        ];
        $req="CALL product_addProduct(?,?,?,?,?,?,?)";
        $this->db->query($req, $data);
    }

    //Ajoute une picture a un produit de la base de données
    function addPictureOfProduct(int $id, int $pos, string $picture){
        $product=$this->findById($id);
        $old_picture_array=$product->getPictures();
        $product->addPictureAtIndex($picture, $pos-1);
        $new_picture_array=$product->getPictures();
        $new_picture_string=implode(", ", $new_picture_array);
        $this->update($id, $product->getName(), $product->getBrand(), $product->getCategory(), $product->getPrice(), $new_picture_string, $product->getDescription());
    }
    
    //Supprime un produit de la base de données
    function delete(int $id){
        $data=[
            'id'=>$id,
        ];
        $req="CALL product_deleteProduct(?)";
        $this->db->query($req, $data);
    }

    //Supprime une picture d'un proudit de la base de données
    function deletePictureOfProduct(int $id, string $pic){
        $product=$this->findById($id);
        $old_picture_array=$product->getPictures();
        $product->deletePicture($pic);
        $new_picture_array=$product->getPictures();
        $new_picture_string=implode(", ", $new_picture_array);
        $this->update($id, $product->getName(), $product->getBrand(), $product->getCategory(), $product->getPrice(), $new_picture_string, $product->getDescription());
    }

    //Modifie un produit de la base de données
    function update(int $id, string $name, int $brand, ?int $categories, float $price, string $picture, ?string $description){
        $data=[
            'id'=>$id,
            'name'=>$name,
            'brand'=>$brand,
            'category'=>$categories,
            'price'=>$price,
            'picture'=>$picture,
            'description'=>$description,
        ];
        $req="CALL product_updateProduct(?,?,?,?,?,?,?)";
        $this->db->query($req, $data);
    }

    //Renvoi le nombre de produits de la base de données
    function countProduct():Int{
        $this->db->select('*');
        $this->db->from('Product');
        return $this->db->count_all_results();
    }

    //Modifie une picture d'un produit
    function updatePictureOfProduct(int $id, string $old_picture, string $picture){
        $product=$this->findById($id);
        $old_picture_array=$product->getPictures();
        $index=array_search($old_picture, $old_picture_array);
        $product->setPictureAtIndex($picture, $index);
        $new_picture_array=$product->getPictures();
        $new_picture_string=implode(", ", $new_picture_array);
        $this->update($id, $product->getName(), $product->getBrand(), $product->getCategory(), $product->getPrice(), $new_picture_string, $product->getDescription());
    }



    //PANIER

    //Renvoi le panier sous la forme d'un tableau 
    function getAllCartArray():array{
		if (!$this->session->has_userdata("cart") || $this->session->cart=="")
            //echo "nothing";
			return array();
        else {
            //echo "some";
            $str= $this->session->cart;
			$arr=explode("/", $str);
			$new_array=array();
			foreach ($arr as $a){
				$b=explode(",",$a);
                if ($b[0]!=null){
                    if ($this->checkCartStock($b[1], $b[2])==TRUE){
                        array_push($new_array, $b);
                    }
                }
            }
        }
        //var_dump($new_array);
		return $new_array;     
	}

    //Renvoi le contenu du panier sous sa forme directe (string)
	function getAllCart():string{
		if (!$this->session->has_userdata("cart"))
			return "";
		else 
			$str= $this->session->cart;
			return $str;
	}

    //Vérifie si le produit en entrée possède dans la base de données la quantité en entrée. Renvoi un booléen
    public function checkCartStock(int $idInfo, int $wanted_quantity):Bool{
        $info=$this->getProductInformationsById($idInfo);
        if (empty($info)){
            return FALSE;
        } else {
            $qty=$info->getQuantity();
            if ($qty>=$wanted_quantity)
                return TRUE;
            else 
                return FALSE;
        }
        
    }


    //RECHERCHE

    //Supprime les produits en double d'un tableau. Renvoi un tableau de ProductEntity sans doublons
    function remove_duplicate_search_results($products):array{
        $models = array_map(function($product){
            return $product->getId();
        }, $products);
    
        $unique_product = array_unique($models);
    
        return array_values(array_intersect_key($products, $unique_product));
    }

    //Supprime les couleurs en double d'un tableau. Renvoi un tableau de ColorEntity sans doublons
    function remove_duplicate_colors($colors) {
        $models = array_map(function($color) {
            return $color->getName();
        }, $colors);
    
        $unique_product = array_unique($models);
    
        return array_values(array_intersect_key($colors, $unique_product));
    }

    //FONCTION COMPLEXE : Recherche dans la base données les produits semblables au paramètre d'entrée. 
    //Recherche dans l'id, dans la description, dans le nom, dans la marque, la catégorie...
    //Renvoi un tableau de ProductEntity sans doublons
    public function search(string $query):array{
        $query_array=explode(' ', $query);
        $result_array=array();
        foreach($query_array as $part){

            //Nom de produit
            $req1="SELECT * FROM Product WHERE name LIKE '%".$part."%'";
            $result1=$this->db->query($req1);
            $res1=$result1->result_array();
            foreach(array_values($res1) as $r){
                $promo=$this->getPromoById($r["id"]);
                if($promo!=null){
                    $r["promo"]=$promo;
                }
                $factory=new ProductFactory;
                $r=$factory->factory($r);
                array_push($result_array,$r);
            }

            //Description
            $req7="SELECT * FROM Product WHERE description LIKE '%".$part."%'";
            $result7=$this->db->query($req7);
            $res7=$result7->result_array();

            foreach(array_values($res7) as $r){
                $promo=$this->getPromoById($r["id"]);
                if($promo!=null){
                    $r["promo"]=$promo;
                }
                $factory=new ProductFactory;
                $r=$factory->factory($r);
                array_push($result_array,$r);
            }

            //Nom de la marque
            $req2="SELECT id FROM Brand WHERE name LIKE '%".$part."%'";
            $result2=$this->db->query($req2);
            $res2=$result2->result_array();
            $brandsfound=array();
            foreach(array_values($res2) as $r){
                array_push($brandsfound, $r["id"]);
            }
            foreach($brandsfound as $brandId){
                $req3="SELECT * FROM Product WHERE brand LIKE '%".$brandId."%'";
                $result3=$this->db->query($req3);
                $res3=$result3->result_array();
                foreach(array_values($res3) as $r){
                    $promo=$this->getPromoById($r["id"]);
                    if($promo!=null){
                        $r["promo"]=$promo;
                    }
                    $factory=new ProductFactory;
                    $r=$factory->factory($r);
                    array_push($result_array,$r);
                }
            } 

            //Catégorie
            $req4="SELECT id FROM Category WHERE name LIKE '%".$part."%'";
            $result4=$this->db->query($req4);
            $res4=$result4->result_array();
            $categoriesfound=array();
            foreach(array_values($res4) as $r){
                array_push($categoriesfound, $r["id"]);
            }
            foreach($categoriesfound as $categoryId){
                $req5="SELECT * FROM Product WHERE category LIKE '%".$categoryId."%'";
                $result5=$this->db->query($req5);
                $res5=$result5->result_array();
                foreach(array_values($res5) as $r){
                    $promo=$this->getPromoById($r["id"]);
                    if($promo!=null){
                        $r["promo"]=$promo;
                    }
                    $factory=new ProductFactory;
                    $r=$factory->factory($r);
                    array_push($result_array,$r);
                }
            }
        }
        return $this->remove_duplicate_search_results($result_array);
    }

    //Récupère le string des catégories, formatte ce string et vérifie les produits correspondants dans le tableau de résultats donné en entrée. 
    function filterSearchByCategories(string $filters, array $results):array{
        $filtersArray=array();
        $filteredResults=array();
        if ($filters=="" || $filters=='null') {
            return $results;
        }
        $filtersArray=explode('x', $filters);
        //var_dump($filtersArray);
        foreach($results as $result){
            foreach ($filtersArray as $cat) {
                if ($result->getCategory()==$cat){
                    array_push($filteredResults, $result);
                }
            }
            
        }
        return $this->remove_duplicate_search_results($filteredResults);
    }

    //Récupère le string des marques, formatte ce string et vérifie les produits correspondants dans le tableau de résultats donné en entrée. 
    function filterSearchByBrands(string $filters, array $results):array{
        $filtersArray=array();
        $filteredResults=array();
        if ($filters=="" || $filters=='null') {
            return $results;
        }
        $filtersArray=explode('x', $filters);
        //var_dump($filtersArray);
        foreach($results as $result){
            foreach ($filtersArray as $brd) {
                if ($result->getBrand()==$brd){
                    array_push($filteredResults, $result);
                }
            }  
        }
        return $this->remove_duplicate_search_results($filteredResults);
    }

    //Récupère le string des couleurs, formatte ce string et vérifie les produits correspondants dans le tableau de résultats donné en entrée. 
    function filterSearchByColors(string $filters, array $results):array{
        $filtersArray=array();
        $filteredResults=array();
        if ($filters=="" || $filters=='null') {
            return $results;
        }
        $filtersArray=explode('x', $filters);
        foreach($results as $result){
            $resultInfos=$this->getAllProductInformationsById($result->getId());
            foreach($resultInfos as $infos){
                foreach($infos as $info){
                    if (in_array(trim($info["colorCode"], "#"), $filtersArray)) {
                        array_push($filteredResults, $result);
                    }
                } 
            }
        }
        return $this->remove_duplicate_search_results($filteredResults);
    }

    //Récupère le string des prix, formatte ce string et vérifie les produits correspondants dans le tableau de résultats donné en entrée. 
    function filterSearchByPrice(string $filter, array $results):array{
        $filteredResults=array();
        if ($filter=="" || $filter=='null') {
            return $results;
        }
        foreach($results as $result){
            if ($result->getPrice()<=$filter&&$result->getPrice()>=$filter-50){
                array_push($filteredResults, $result);
            }  
        }
        return $this->remove_duplicate_search_results($filteredResults);
    }

    //Récupère le string des tailles, formatte ce string et vérifie les produits correspondants dans le tableau de résultats donné en entrée. 
    function filterSearchBySizes(string $filters, array $results):array{
        $filtersArray=array();
        $filteredResults=array();
        if ($filters=="" || $filters=='null') {
            return $results;
        }
        $filtersArray=explode("y", $filters);
        if ($filtersArray[0]=="") {
            unset($filtersArray[0]);
        }
        foreach($results as $result){
            $resultInfos=$this->getAllProductInformationsById($result->getId());
            foreach($resultInfos as $infos){
                foreach($infos as $info){
                    if (in_array($info["size"], $filtersArray)) {
                        array_push($filteredResults, $result);
                    }
                } 
            }
        }
        return $this->remove_duplicate_search_results($filteredResults);
    }

    //Tri le tableau de résultats donnés en entré selon la valeur du paramètre $filter, et renvoi un tableau trié
    function filterSearch(string $filter, array $results):array{
        $filteredResults=array();

        //Tri les produits par prix (croissant)
        if ($filter ==1) { 
            if (!function_exists('cmpPriceAsc'))   {
                function cmpPriceAsc($a, $b) {
                    return $a->getNewPrice() > $b->getNewPrice();
                }
            }
            usort($results, 'cmpPriceAsc');
            $filteredResults=$results;
        }

        //Tri les produits par prix (décroissant)
        if ($filter ==2) { 
            if (!function_exists('cmpPriceDesc'))   {
                function cmpPriceDesc($a, $b) {
                    return $a->getNewPrice() < $b->getNewPrice();
                }
            }
            usort($results, 'cmpPriceDesc');
            $filteredResults=$results;
        }

        //Tri les produits par nom (A -> Z)
        if ($filter ==3) { 
            if (!function_exists('cmpNameAlpha'))   {
                function cmpNameAlpha($a, $b) {
                    return strcmp($a->getName(), $b->getName());
                }
            }
            usort($results, 'cmpNameAlpha');
            $filteredResults=$results;
        }

        //Tri les produits par nom (Z -> A)
        if ($filter ==4) { 
            if (!function_exists('cmpNameNonAlpha'))   {
                function cmpNameNonAlpha($a, $b) {
                    return strcmp($b->getName(), $a->getName());
                }
            }
            usort($results, 'cmpNameNonAlpha');
            $filteredResults=$results;
        }

        //Renvoi seulement les produits en promotion        
        if ($filter ==5) { 
            foreach ($results as $result){
                if (get_class($result)=="PromotionProductEntity") {
                    array_push($filteredResults, $result);
                }
            }
        }
        return $this->remove_duplicate_search_results($filteredResults);
    }




    //MARQUE

    //Renvoi toutes les marques, sous la forme d'un tableau de BrandEntity
    function getAllBrands():array{
        //$this->db->select('*');
        //$q = $this->db->get('product');
        //$res = $q-> custom_result_object("ProductEntity");
        
        $req="CALL brand_GetAllBrands()";
        $q=$this->db->query($req);
        $res=$q->custom_result_object("BrandEntity");

        $q->next_result();
        $q->free_result();

        return $res;
    }

    //Renvoi le nom de la marque correspondant au paramètre id
    function findBrandbyId(int $id):?String{
        $result = $this->db->select('name')->from('Brand')->where('id', $id)->limit(1)->get()->row();
        return $result->name;
    }

    //Renvoi un booléen, si une marque est utilisée par au moins un produit
    function isBrandUse(int $id):Bool{
        $result = $this->db->select('brand')->from('Product')->where('brand', $id)->limit(1)->get()->row();
        return gettype($result)!="NULL";
    }

    //Ajoute une marque
    function addBrand(int $id, string $name){
        $data=[
            'id'=>$id, 
            'name'=>$name, 
        ];
        $req="CALL brand_addBrand(?,?)";
        $this->db->query($req, $data);
    }

    //Supprime une marque
    function deleteBrand(int $id){
        $data=[
            'id'=>$id,
        ];
        $req="CALL brand_deleteBrand(?)";
        $this->db->query($req, $data);
    }

    //Renvoi le nombre de marques de la base de données
    function countBrand():Int{
        $this->db->select('*');
        $this->db->from('Brand');
        return $this->db->count_all_results();
    }

    //CATEGORIE

    //Renvoi toutes les catégories sous la forme d'une tableau de CategoryEntity
    function getAllCategories():Array{
        //$this->db->select('*');
        //$q = $this->db->get('product');
        //$res = $q-> custom_result_object("ProductEntity");
        
        $req="CALL category_GetAllCategories()";
        $q=$this->db->query($req);
        $res=$q->custom_result_object("CategoryEntity");

        $q->next_result();
        $q->free_result();

        return $res;
    }

    //Ajoute une catégorie 
    function addCategory(int $id, string $name){
        $data=[
            'id'=>$id,
            'name'=>$name,
        ];
        $req="CALL category_addCategory(?,?)";
        $this->db->query($req, $data);
    }

    //Supprime une catégorie
    function deleteCategory(int $id){
        $data=[
            'id'=>$id,
        ];
        $req="CALL category_deleteCategory(?)";
        $this->db->query($req, $data);
    }
    
    //Renvoi le nom de la catégorie de l'id en paramètre (ou null)
    function findCategorybyId(int $id):?String{
        $result = $this->db->select('name')->from('Category')->where('id', $id)->limit(1)->get()->row();
        return $result->name;
    }

    //Renvoi un booléen si la catégorie de l'id en paramètre est utilisée par un produit
    function isCategoryUse(int $id):Bool{
        $result = $this->db->select('category')->from('Product')->where('category', $id)->limit(1)->get()->row();
        return gettype($result)!="NULL";
    }



    //INFOS

    //Renvoi le ProductInfosEntity correspondant a l'id en paramètre
    function getProductInformationsById(int $id):?ProductInfos{
        $data=[
            'id'=>$id,
        ];
        $req="CALL infos_getInfoById(?)";
        $q=$this->db->query($req, $data);
        $res=$q->result_array();

        $q->next_result();
        $q->free_result();
        
        if (isset($res[0])) {
            $fac=New ProductInfosFactory();
            $info=$fac->infosFactory($res[0]);
            return $info;
        }
        return null;

    }

    //renvoi toutes les informations de produits sous la forme d'un tableau de productInfos
    function getAllProductInformations():array{
        $arr=array();
        $req="CALL infos_getAllInfos()";
        $q=$this->db->query($req);
        $res=$q->result_array();

        $q->next_result();
        $q->free_result();

        foreach($res as $r){
            $fac=New ProductInfosFactory();
            $info=$fac->infosFactory($r);
            array_push($arr, $info);
        }
    
        return $arr;
    }

    //Renvoi les infos relatives a l'id en paramètre sous la forme d'un tableau d'infos
    function getAllProductInformationsById(int $id):array{
        $data=[
            'id'=>$id,
        ];
        $req="CALL infos_getInfosById(?)";
        $q=$this->db->query($req, $data);
        $res=$q->result_array();
        $q->next_result();
        $q->free_result();

        $colorArray=array();
        $returnArray=array();
        while (sizeof($res)!=0){
            $color=array_values($res)[0]["color"];
            foreach ($res as $info){
                if ($info["color"]==$color){
                    array_push($colorArray, $info);
                    unset($res[array_search($info, $res)]);
                }
            }
            usort($colorArray, function($a, $b) {return $a["size"]> $b["size"];});
            array_push($returnArray, $colorArray);
            $colorArray=array();
        } 
        return $returnArray;
    }

    //Change la quantité d'u productInfo
    function changeQuantity(int $id, int $qty){
        $data=[
            'id'=>$id,
            'quantity'=>$qty,
        ];
        $req="CALL infos_changeQuantity(?,?)";
        $this->db->query($req, $data);
    }

    //Ajoute une taille a un produit en fonction d'une couleur
    function addSize(int $id, int $productId, string $size, int $qty, string $color, string $code){
        $data=[
            'id'=>$id,
            'productId'=>$productId,
            'size'=>$size,
            'quantity'=>$qty,
            'color'=>$color,
            'colorCode'=>$code,
        ];
        $req="CALL infos_addSize(?,?,?,?,?,?)";
        $this->db->query($req, $data);
    }

    //Supprime une taille d'un produit relative a une couleur
    function deleteSize(int $id){
        $data=[
            'id'=>$id,
        ];
        $req="CALL infos_deleteSize(?)";
        $this->db->query($req, $data);
    }

    //Ajoute une couleur a un produit
    function addColor(int $id, int $productId, string $color, string $code){
        $data=[
            'id'=>$id,
            'productId'=>$productId,
            'color'=>$color,
            'colorCode'=>$code,
        ];
        $req="CALL infos_addColor(?,?,?,?)";
        $this->db->query($req, $data);
    }

    //Supprime une couleur d'un produit
    function deleteColor(int $productId, string $color){
        $data=[
            'productId'=>$productId,
            'color'=>$color,
        ];
        $req="CALL infos_deleteColor(?,?)";
        $this->db->query($req, $data);
    }

    //retourne l'identifiant du ProductInfo correspondant a une taille, une couleur et un produit. 
    function findInfoId(string $size, string $color, int $id):array{
        $data=[
            'id'=>$id,
            'size'=>$size,
            'color'=>$color,
        ];
        $req="CALL infos_findInfoId(?,?,?)";
        $q=$this->db->query($req, $data);
        $res=$q->result_array();
        $q->next_result();
        $q->free_result();

        return $res[0];
    }

    //Renvoi toutes les coeuleurs existantes sous la forme d'un tableau de ColorEntity
    function getAllColors():array{
        $allInfos=$this->getAllProductInformations();
        $colorsArray=array();
        foreach($allInfos as $info){
            $colorObject=new ColorEntity($info->getColor(), $info->getColorCode());
            if (!in_array($colorObject, $colorsArray)){
                
                array_push($colorsArray, $colorObject);
            }
        }
        return $colorsArray;
    }

    //Ajoute une promotion a un produit
    function addPromo(int $id, int $promo){
        $data=[
            'id'=>$id,
            'promo'=>$promo,
        ];
        $req="CALL promo_addPromotion(?,?)";
        $this->db->query($req, $data);
    }

    //Renvoi la promotion d'un produit (ou null) sous la forme d'un promotionEntity
    function getPromoById(int $id):?PromotionEntity{
        $data=[
            'id'=>$id,
        ];
        $req="CALL promo_getPromoById(?)";
        $q=$this->db->query($req, $data);
        $res=$q->custom_result_object('PromotionEntity');
        $q->next_result();
        $q->free_result();
        if (empty($res)){
            return null;
        } else {
            return $res[0];
        }     
    }

    //Supprime la promotion d'un produit
    function deletePromo(int $id){
        $data=[
            'id'=>$id,
        ];
        $req="CALL promo_deletePromo(?)";
        $q=$this->db->query($req, $data);
    }
     //Renvoi le nombre de promotions de la base de données
     function countPromo():Int{
        $this->db->select('*');
        $this->db->from('Promotion');
        return $this->db->count_all_results();
    }

}