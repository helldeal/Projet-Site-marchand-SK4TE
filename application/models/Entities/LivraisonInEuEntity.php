<?php
require_once APPPATH.'models'.DIRECTORY_SEPARATOR.'Entities'.DIRECTORY_SEPARATOR."LivraisonEntity.php";

class LivraisonInEuEntity extends LivraisonEntity{

    //STRATEGY : Calcul prix livraison EU (hors FRANCE)
    public function calculLivraison($prix):float{
        return $this->fdp;
    }

    
}