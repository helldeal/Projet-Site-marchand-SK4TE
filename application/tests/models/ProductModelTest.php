<?php
class ProductModelTest extends CIPHPUnitTestCase{

    public function load(){
        $this->CI = &get_instance();
        $this->CI->load->model('ProductModel');
        $this->ProductModel = $this->CI->ProductModel;
    }

    public function testFindAll(){
        $this->load();
        $prod = $this->ProductModel->findAll();
        $this->assertNotEmpty($prod);
    }
    public function testfindAllNew(){
        $this->load();
        $prod = $this->ProductModel->findAllNew();
        $this->assertNotEmpty($prod);
        $this->assertTrue(count($prod)>=0);
        $this->assertTrue(count($prod)<7);
    }
    /*
    public function testFindAllPromo(){
        $this->load();
        $prod = $this->ProductModel->findAllPromotions();
        $this->assertNotEmpty($prod);
    }*/
    public function testFindbyId(){
        $this->load();
        $prod = $this->ProductModel->findById(1);
        $this->assertSame($prod->getId(),1);
        $prod = $this->ProductModel->findById(21474);
        $this->assertNull($prod);
    }
    public function testProductUse(){
        $this->load();
        $prod = $this->ProductModel->isProductUse(1);
        $this->assertTrue($prod);
        $prod = $this->ProductModel->findById(21474);
        $this->assertNull($prod);
    }
    public function testProductInfoUse(){
        $this->load();
        $prod = $this->ProductModel->isProductInfoUse(509);
        $this->assertTrue($prod);
        $prod = $this->ProductModel->findById(21474);
        $this->assertNull($prod);
    }
    public function testProductAdd(){
        $this->load();
        $prod = $this->ProductModel->add(21474,"",1,1,1.0,"","");
        $prod = $this->ProductModel->findById(21474);
        $this->assertSame($prod->getId(),21474);
    }
    public function testProductUp(){
        $this->load();
        $prod = $this->ProductModel->update(21474,"oui",1,1,1.0,"","");
        $prod = $this->ProductModel->findById(21474);
        $this->assertSame($prod->getName(),"oui");
    }
    public function testProductDelete(){
        $this->load();
        $prod = $this->ProductModel->delete(21474);
        $prod = $this->ProductModel->findById(21474);
        $this->assertNull($prod);
    }
    public function testProdCount(){
        $this->load();
        $prod = $this->ProductModel->countProduct();
        $this->assertTrue($prod>=0);
    }


    // BRAND
    public function testFindAllBrand(){
        $this->load();
        $prod = $this->ProductModel->getAllBrands();
        $this->assertNotEmpty($prod);
    }
    public function testFindBrandbyId(){
        $this->load();
        $prod = $this->ProductModel->findBrandbyId(3);
        $this->assertSame($prod,"Carhartt");
        $prod = $this->ProductModel->findBrandbyId(21474);
        $this->assertNull($prod);
    }
    public function testBrandUse(){
        $this->load();
        $prod = $this->ProductModel->isBrandUse(1);
        $this->assertTrue($prod);
        $prod = $this->ProductModel->isBrandUse(21474);
        $this->assertFalse($prod);
    }
    public function testBrandAdd(){
        $this->load();
        $prod = $this->ProductModel->addBrand(21474,"ouioui");
        $prod = $this->ProductModel->findBrandbyId(21474);
        $this->assertSame($prod,"ouioui");
    }
    public function testBrandDelete(){
        $this->load();
        $prod = $this->ProductModel->deleteBrand(21474);
        $prod = $this->ProductModel->findBrandbyId(21474);
        $this->assertNull($prod);
    }

    // Category
    public function testFindAllCategory(){
        $this->load();
        $prod = $this->ProductModel->getAllCategories();
        $this->assertNotEmpty($prod);
    }
    public function testFindCategorybyId(){
        $this->load();
        $prod = $this->ProductModel->findCategorybyId(3);
        $this->assertSame($prod,"Chaussures");
        $prod = $this->ProductModel->findCategorybyId(21474);
        $this->assertNull($prod);
    }
    public function testCategoryUse(){
        $this->load();
        $prod = $this->ProductModel->isCategoryUse(1);
        $this->assertTrue($prod);
        $prod = $this->ProductModel->isCategoryUse(21474);
        $this->assertFalse($prod);
    }
    public function testCategoryAdd(){
        $this->load();
        $prod = $this->ProductModel->addCategory(21474,"ouioui");
        $prod = $this->ProductModel->findCategorybyId(21474);
        $this->assertSame($prod,"ouioui");
    }
    public function testCategoryDelete(){
        $this->load();
        $prod = $this->ProductModel->deleteCategory(21474);
        $prod = $this->ProductModel->findCategorybyId(21474);
        $this->assertNull($prod);
    }


    // Infos
    public function testFindAllProductInformations(){
        $this->load();
        $prod = $this->ProductModel->getAllProductInformations();
        $this->assertNotEmpty($prod);
    }
    public function testFindProductInformationsbyId(){
        $this->load();
        $prod = $this->ProductModel->getProductInformationsById(509);
        $this->assertSame($prod->getId(),509);
        $prod = $this->ProductModel->getProductInformationsById(21474);
        $this->assertNull($prod);
    }
    public function testFindAllProductInformationsOfProduct(){
        $this->load();
        $prod = $this->ProductModel->getAllProductInformationsById(1);
        $this->assertNotEmpty($prod);
    }

    //Promo

    public function testgetPromoById(){
        $this->load();
        $prod = $this->ProductModel->getPromoById(17);
        $this->assertSame($prod->getId(),17);
        $prod = $this->ProductModel->getPromoById(21474);
        $this->assertNull($prod);
    }
    public function testaddPromo(){
        $this->load();
        $prod = $this->ProductModel->addPromo(1,10);
        $prod = $this->ProductModel->getPromoById(1);
        $this->assertSame($prod->getId(),1);
    }
    
    public function testdeletePromo(){
        $this->load();
        $prod = $this->ProductModel->deletePromo(1);
        $prod = $this->ProductModel->getPromoById(1);
        $this->assertNull($prod);
    }


}