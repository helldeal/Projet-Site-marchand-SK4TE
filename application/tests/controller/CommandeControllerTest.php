<?php
class CommandeControllerTest extends CIPHPUnitTestCase{
    public function TestdisplayCheckout(){
        $out=$this->request('GET','Commande/displayCheckout');
        $this->assertStringContainsString('<div class="title-livraison">Livraison<div class="split-bar"></div></div>',$out);
        
    }

}
?>