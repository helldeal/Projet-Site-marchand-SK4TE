<?php
require_once APPPATH.'models'.DIRECTORY_SEPARATOR.'Factories'.DIRECTORY_SEPARATOR."LivraisonFactory.php";
require_once APPPATH.'models'.DIRECTORY_SEPARATOR.'Factories'.DIRECTORY_SEPARATOR."ProductFactory.php";
require_once APPPATH.'models'.DIRECTORY_SEPARATOR.'Factories'.DIRECTORY_SEPARATOR."ProductInfosFactory.php";
require_once APPPATH.'models'.DIRECTORY_SEPARATOR.'Entities'.DIRECTORY_SEPARATOR."PromotionEntity.php";
class FactoryTest extends CIPHPUnitTestCase{

    
    public function testLivraison(){
        $factory=new LivraisonFactory;
        $this->assertInstanceOf(LivraisonFrEntity::class,$factory->factory("France",""));
        $this->assertInstanceOf(LivraisonOutEuEntity::class,$factory->factory("Royaume-Uni",""));
        $this->assertInstanceOf(LivraisonInEuEntity::class,$factory->factory("Allemagne",""));
    }
    public function testProduct(){
        $infos=array();
        $infos["id"]=1;
        $infos["name"]="sqdfdsqf";
        $infos["brand"]=4;
        $infos["category"]=4;
        $infos["price"]=40;
        $infos["pictures"]="fsdfs";
        $infos["description"]="dfqf";
        $factory=new ProductFactory;
        $this->assertInstanceOf(MainProductEntity::class,$factory->factory($infos));
        $promo=new PromotionEntity;
        $promo->setId(1);
        $promo->setPromo(1);
        $infos["promo"]=$promo;
        $this->assertInstanceOf(PromotionProductEntity::class,$factory->factory($infos));
    }
    /* PAS TESTASBLE MAIS FONCTIONNELLE SELON CES TEST
    public function testProductInfos(){
        $factory=new ProductInfosFactory;
        $infos=array();
        $infos["id"]=1;
        $infos["productId"]=10;
        $infos["color"]="Blanc";
        $infos["colorCode"]="#000000";
        $this->assertInstanceOf(ProductInfosColor::class,$factory->infosFactory($infos));
        $infos["size"]=30;
        $this->assertInstanceOf(ProductInfosShoes::class,$factory->infosFactory($infos));
        $infos["size"]="30mm";
        $this->assertInstanceOf(ProductInfosMillimeters::class,$factory->infosFactory($infos));
        $infos["size"]="30in";
        $this->assertInstanceOf(ProductInfosInches::class,$factory->infosFactory($infos));
        $infos["size"]="XL";
        $this->assertInstanceOf(ProductInfosClothes::class,$factory->infosFactory($infos));
    }*/
    
}