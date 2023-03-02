<?php
require_once APPPATH.'models'.DIRECTORY_SEPARATOR.'Entities'.DIRECTORY_SEPARATOR."CommandeEntity.php";
class CommandeModel extends CI_Model {

    //ACTION : Crée un enregistrement du contenu du panier dans la table "Order". Supprime le contenu du panier ensuite
    function addCommandFromCart($id){
        $idfree=$id;
        if (isset($_SESSION["login"]["email"])) $email=$_SESSION["login"]["email"];
        $this->load->model('ProductModel');
        $this->load->helper('date');
        date_default_timezone_set(TIMEZONE);
        //$phpdate = strtotime( '2022-11-28 08:28:34' );
        //$mysqldate = date( 'Y-m-d H:i:s', $phpdate );
        $datestring = '%Y-%m-%d  %h:%i:%s';
        $time = now();
        $date= mdate($datestring, $time);
        $mysqldate = date( 'Y-m-d H:i:s', $time );
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
        foreach ($allProductsOfCart as $product){
            $data = [
                    'id' => $idfree,
                    'refprod'  => $product[1][3],
                    'login'  =>$email,
                    'quantity'  => $product[1][0],
                    'price'  => $product[0]->getNewPrice()* $product[1][0],
                    'time'  => $mysqldate
                ];
            $this->db->insert('Order', $data);
        }
        $this->session->unset_userdata('cart');
    }

    //Donne toutes les commandes sous la forme d'un tableau de CommandeEntity
    function getAllCommands():array{
        $this->db->select('*');
        $q = $this->db->get('Order');
        $response = array();
        foreach ($q->result() as $cmd){
            $obj=new CommandeEntity;
            $obj->setID($cmd->{'ID'});
            $obj->setLogin($cmd->{'LOGIN'});
            $obj->setRefprod($cmd->{'REFPROD'});
            $obj->setQuantity($cmd->{'QUANTITY'});
            $obj->setPrice($cmd->{'PRICE'});
            $obj->setTime($cmd->{'TIME'});
            array_push($response, $obj);
        }
        return array_reverse($response);
    }

    //Donne toutes les commandes d'un utilisateur sous la forme d'un tableau de CommandeEntity
    function getAllCommandsFromUser(string $login):array{
        $allCommands=$this->getAllCommands();
        $returnArray=array();
        foreach ($allCommands as $command){
            if($command->getLogin() == $login){
                array_push($returnArray, $command);
            }
        }
        return $returnArray;
    }

    //Donne le nombre total de commandes effectuées sur le site
    function countCommand():?Int{
        $this->db->distinct();
        $this->db->select('id');
        $this->db->from('Order');
        return $this->db->count_all_results();
    }

    //Donne la somme totale dépensée sur le site
    function countRecipe():?Float{
        $this->db->select_sum('price');
        $this->db->from('Order');
        $query = $this->db->get();

        return $query->row()->price; // Will prompt the sum of all prices in your table
    }

    //Renvoi ????????
    function LivraisonById(int $id){
        $result = $this->db->select('*')->from('Livraison')->where('id', $id)->limit(1)->get()->row();
        return $result;
    }

}