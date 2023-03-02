<?php
class SearchControllerTest extends CIPHPUnitTestCase{
    public function testvueIndex(){
        $out=$this->request('GET',"Search");
        $this->assertStringContainsString('<h5>Catérogies</h5>',$out );
    }
}
?>