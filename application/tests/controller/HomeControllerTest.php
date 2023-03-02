<?php
class HomeControllerTest extends CIPHPUnitTestCase{
    public function testvueIndex(){
        $out=$this->request('GET',"Home");
        $this->assertStringContainsString('<h1 class="logoskate">S<span style="color: var(--classic-blue-color);">K</span>ATE</h1>',$out );
    }

    public function testvueDroit(){
        $out=$this->request('GET',"Home/droit");
        $this->assertStringContainsString('<div class="droit-titre">Mentions légales</div>',$out );
    }

    public function testvueDeliveryInfo(){
        $out=$this->request('GET',"Home/deliveryInfo");
        $this->assertStringContainsString('<div class="titre">Détails de livraison</div>',$out );
    }
/*
* la page localisation est pas encore mis 
*
    public function testvueLocinfo(){
        $out=$this->request('GET',"Home/Locinfo");
        $this->assertStringContainsString('',$out );
    }
*/

    public function testvueAdmin(){
        $CI =& get_instance();
        $out = $this->request("POST","User/loginCheck", array("login"=>"dadmin","password"=>"1"));

        $out=$this->request('GET',"Home/admin");
        $this->assertStringContainsString('<h1>Admin</h1>',$out );
    }

    public function testvueAdminSessionNull(){        
        $out=$this->request('GET',"Home/admin");
        $this->assertNull($out);
    }

    public function testvueAdminSessionVisitor(){
        $CI =& get_instance();
        $out = $this->request("POST","User/loginCheck", array("login"=>"d","password"=>"1"));

        $out=$this->request('GET',"Home/admin");
        $this->assertNull($out);
    }

    public function testvueAccesDenied(){
        $CI =& get_instance();
        $out = $this->request("POST","User/loginCheck", array("login"=>"d","password"=>"1"));

        $out=$this->request('GET',"Home/accessDenied");
        $this->assertStringContainsString('<h1> Access Denied</h1>',$out );
    }

    public function testvueAccesDeniedNull() {
        $out=$this->request('GET',"Home/accessDenied");
        $this->assertNull($out);
    }

    public function testvueSessionOver() {
        $out=$this->request('GET',"Home/sessionOver");
        $this->assertStringContainsString('<p class="state error">Zzzzzz</p>',$out );
    }
}
?>