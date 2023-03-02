<?php
require_once APPPATH.'models'.DIRECTORY_SEPARATOR.'Entities'.DIRECTORY_SEPARATOR."LivraisonEntity.php";

class LivraisonOutEuEntity extends LivraisonEntity{

    //STRATEGY : Calcul prix livraison HORS EU
    public function calculLivraison($prix):float{
        return ($this->taxe/100)*$prix+$this->fdp;
    }

    
}