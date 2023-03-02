<?php

class ProductControllerTest extends CIPHPUnitTestCase{

    //$CI =& get_instance();
    //$out=$this->request('POST','User/loginCheck',array('login'=>'dadmin','password'=>'1'));

    //TESTS VUE

    //  Display
    public function testVueDisplayProductNoId(){
        $out=$this->request('GET', 'Product/display');
        $this->assertStringContainsString('<p class="tva">INC. TVA</p>',$out );
    }

    public function testVueDisplayProductWrongId(){
        $out=$this->request('GET', 'Product/display/151515');
        $this->assertRedirect("Home");
    }

    public function testVueDisplayProduct(){
        $out=$this->request('GET', 'Product/display/1');
        $this->assertStringContainsString('<p class="tva">INC. TVA</p>',$out );
    }

    //Update
    public function testVueUpdateProductNoId(){
        $CI =& get_instance();
        $out=$this->request('POST','User/loginCheck',array('login'=>'dadmin','password'=>'1'));
        $out=$this->request('GET', 'Product/update/');
        $this->assertStringContainsString('<p>Ajouter une nouvelle image</p>',$out );
    }

    public function testVueUpdateProductWrongId(){
        $out=$this->request('GET', 'Product/update/151515');
        $this->assertRedirect("Home/accessDenied");
    }

    public function testVueUpdateProductVisitor(){
        $CI =& get_instance();
        $out=$this->request('POST','User/loginCheck',array('login'=>'d','password'=>'1'));
        $out=$this->request('GET', 'Product/update/1');
        $this->assertRedirect("Home/accessDenied");
    }

    public function testVueUpdateProductAdmin(){
        $CI =& get_instance();
        $out=$this->request('POST','User/loginCheck',array('login'=>'dadmin','password'=>'1'));
        $out=$this->request('GET', 'Product/update/1');
        $this->assertStringContainsString('<p>Ajouter une nouvelle image</p>',$out );
    }


}