<?php
require_once APPPATH.'models'.DIRECTORY_SEPARATOR.'Entities'.DIRECTORY_SEPARATOR."LivraisonFrEntity.php";
require_once APPPATH.'models'.DIRECTORY_SEPARATOR.'Entities'.DIRECTORY_SEPARATOR."LivraisonInEuEntity.php";
require_once APPPATH.'models'.DIRECTORY_SEPARATOR.'Entities'.DIRECTORY_SEPARATOR."LivraisonOutEuEntity.php";

//FACTORY : Cette factory prends en entrée un string correspondant a un pays. En fonction de ce pays, on renvoit les classes adaptées
class LivraisonFactory extends CI_Model{

    public function factory(string $pays,string $add){
        if ($pays=="France"){
            return new LivraisonFrEntity(0,0,0,$add);
        }elseif ($pays=="Royaume-Uni"){
            return new LivraisonOutEuEntity(0,5,10,$add);
        }else{
            return new LivraisonInEuEntity(0,0,10,$add);
        }
    }
}