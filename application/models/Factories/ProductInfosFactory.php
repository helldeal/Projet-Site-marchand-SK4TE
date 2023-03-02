<?php

//FACTORY : Si la taille et la quantité sont défini, alors il ne s'agit pas d'un ProductInfosColor
// Si size est un nombre et non un//plusieurs caractères, alors il s'agit d'un ProductInfosShoes
//Sinon, la factory renvoi un ProductInfosClothes
class ProductInfosFactory extends CI_Model{

    private array $clothesSizes;
    
    public function __construct(){
        $this->clothesSize=array(
            0 => 'XXXS',
            1 => 'XXS',
            2 => 'XS',
            3 => 'S',
            4 => 'M',
            5 => 'L',
            6 => 'XL',
            7 => 'XXL',
            8 => 'XXXL',
        );
    }

    public function infosFactory(array $infos){
        if (!isset($infos["size"]) && !isset($infos["quantity"])){
            return new ProductInfosColor($infos["id"], $infos["productId"], $infos["color"], $infos["colorCode"]);
        }
        if(is_numeric($infos["size"])&& strlen($infos["size"])==2){
            return new ProductInfosShoes($infos["id"], $infos["productId"], $infos["size"], $infos["quantity"], $infos["color"], $infos["colorCode"]);
        }
        if (substr($infos["size"], -2)=="mm") {
            return new ProductInfosMillimeters($infos["id"], $infos["productId"], $infos["size"], $infos["quantity"], $infos["color"], $infos["colorCode"]);
        }
        if (substr($infos["size"], -2)=="in") {
            return new ProductInfosInches($infos["id"], $infos["productId"], $infos["size"], $infos["quantity"], $infos["color"], $infos["colorCode"]);
        }
        if (in_array($infos["size"], $this->clothesSize)){
            return new ProductInfosClothes($infos["id"], $infos["productId"], $infos["size"], $infos["quantity"], $infos["color"], $infos["colorCode"]);
        }
        return null;
    }

}