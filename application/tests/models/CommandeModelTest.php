<?php
class CommandeModelTest extends CIPHPUnitTestCase{

    public function load(){
        $this->CI = &get_instance();
        $this->CI->load->model('CommandeModel');
        $this->CommandeModel = $this->CI->CommandeModel;
    }

    public function testcountrecipe(){
        $this->load();
        $this->assertTrue($this->CommandeModel->countCommand()>=0);
    }

    public function testcountorder(){
        $this->load();
        $this->assertTrue($this->CommandeModel->countRecipe()>=0);
    }
    public function testAllCommands(){
        $this->load();
        $order = $this->CommandeModel->getAllCommands();
        $this->assertNotEmpty($order);
    }
    public function testAllCommandsfromUser(){
        $this->load();
        $order = $this->CommandeModel->getAllCommandsFromUser("dadmin");
        $this->assertNotEmpty($order);
    }
    public function testLivraisonbyId(){
        $this->load();
        $order = $this->CommandeModel->LivraisonById(1);
        $this->assertNotNull($order);
        $order = $this->CommandeModel->LivraisonById(0);
        $this->assertNull($order);
    }

}