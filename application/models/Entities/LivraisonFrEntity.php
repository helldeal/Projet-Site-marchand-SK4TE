<?php
require_once APPPATH.'models'.DIRECTORY_SEPARATOR.'Entities'.DIRECTORY_SEPARATOR."LivraisonEntity.php";

class LivraisonFrEntity extends LivraisonEntity{

    //STRATEGY : Calcul prix livraison FRANCE
    public function calculLivraison($prix):float{
        return $this->taxe*$prix;
    }

    
}