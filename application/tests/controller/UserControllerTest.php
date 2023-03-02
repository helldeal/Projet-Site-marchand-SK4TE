<?php
class UserControllerTest extends CIPHPUnitTestCase{
    //vue
    public function testvuelogin(){
        $out=$this->request('GET',"User/login");
        $this->assertStringContainsString('<label for="identifiant">Identifiant</label>',$out );
    }

    public function testconnexion(){
        $CI =& get_instance();
        $out=$this->request('POST','User/loginCheck',array('login'=>'dadmin','password'=>'1'));
        $this->assertSame($_SESSION['login']['email'],'dadmin') ;
    }
    public function testNoConnexion(){
        $CI =& get_instance();
        $out=$this->request('POST','User/loginCheck',array('login'=>'dadmin','password'=>'14441'));
		$this->assertRedirect('User/login?error=invalid');
    }

    //DISPLAY
    public function testDisplay(){
        $CI =& get_instance();
        $out=$this->request('POST','User/loginCheck',array('login'=>'dadmin','password'=>'1'));
        $out=$this->request('GET',"User/display/dadmin");
        $this->assertStringContainsString('<input type="text" name="pseudo" placeholder="Modifier le pseudo" value="AdminTest/Ne pas supprimer">',$out );
    }
    public function testDisplayNoCo(){
        $out=$this->request('GET',"User/display/dadmin");
		$this->assertRedirect('User/login');
    }
    public function testDisplayAdmin(){
        $CI =& get_instance();
        $out=$this->request('POST','User/loginCheck',array('login'=>'dadmin','password'=>'1'));
        $out=$this->request('GET',"User/display/d");    
        $this->assertStringContainsString('<input type="text" name="pseudo" placeholder="Modifier le pseudo" value="adminTest(ne pas supp)">',$out );
    }
    public function testDisplayNoAdmin(){
        $CI =& get_instance();
        $out=$this->request('POST','User/loginCheck',array('login'=>'d','password'=>'1'));
        $out=$this->request('GET',"User/display/dadmin");
		$this->assertRedirect('User/login');
    }
    public function testDisplayVide(){
        $CI =& get_instance();
        $out=$this->request('POST','User/loginCheck',array('login'=>'dadmin','password'=>'1'));
        $out=$this->request('GET',"User/display/");    
		$this->assertRedirect('User/login');
    }

    //INSCRIPTION -> DELETE
    
    public function testInscription(){
        $CI =& get_instance();
        $out=$this->request('POST','User/signinCheck',array('email'=>'aaa','password'=>'1','confpassword'=>'1'));
		$this->assertRedirect('Home');
    }
    public function testInscriptionAlreadyExist(){
        $CI =& get_instance();
        $out=$this->request('POST','User/signinCheck',array('email'=>'aaa','password'=>'1','confpassword'=>'1'));
		$this->assertRedirect('User/login');
    }
    public function testDeleteNoAdmin(){
        $CI =& get_instance();
        $out=$this->request('POST','User/loginCheck',array('login'=>'d','password'=>'1'));
        $out=$this->request('GET','User/delete/aaa');
		$this->assertRedirect('Home/accessDenied');
    }
    public function testDeleteVide(){
        $CI =& get_instance();
        $out=$this->request('POST','User/loginCheck',array('login'=>'dadmin','password'=>'1'));
        $out=$this->request('GET','User/delete/');
		$this->assertRedirect('Home');
    } 
    public function testDeleteNull(){
        $CI =& get_instance();
        $out=$this->request('POST','User/loginCheck',array('login'=>'dadmin','password'=>'1'));
        $out=$this->request('GET','User/delete/a');
		$this->assertRedirect('Home');
    }
    public function testDeleteAdmin(){
        $_SERVER['PHPUNIT_TEST']=1;
        $CI =& get_instance();
        $out=$this->request('POST','User/loginCheck',array('login'=>'dadmin','password'=>'1'));
        $out=$this->request('GET','User/delete/aaa/');
        $out=$this->request('POST','User/loginCheck',array('login'=>'aaa','password'=>'1'));
		$this->assertRedirect('User/login?error=invalid');
    }

    //ADD USER
    public function testUserAddNoAdmin(){
        $out=$this->request('POST','User/addUser',array('email'=>'aaaa','pseudo'=>'1','password'=>'1','status'=>'Visitor'));
		$this->assertRedirect('Home/accessDenied');
    }

    public function testUserAddAdmin(){
        $_SERVER['PHPUNIT_TEST']=1;
        $CI =& get_instance();
        $out=$this->request('POST','User/loginCheck',array('login'=>'dadmin','password'=>'1'));
        $out=$this->request('POST','User/addUser',array('email'=>'aaaa','pseudo'=>'1','password'=>'1','status'=>'Visitor'));
		$this->assertRedirect('Home/admin');
        $out=$this->request('POST','User/loginCheck',array('login'=>'aaaa','password'=>'1'));
        $this->assertSame($_SESSION['login']['email'],'aaaa') ;
    }

    //Update
    public function testUserUpdateNoAdmin(){
        $out=$this->request('POST','User/updateUser',array('email'=>'aaaa','pseudo'=>'55','password'=>'1','status'=>'Visitor'));
		$this->assertRedirect('Home/accessDenied');
    }

    public function testUserUpdateAdmin(){
        $_SERVER['PHPUNIT_TEST']=1;
        $CI =& get_instance();
        $out=$this->request('POST','User/loginCheck',array('login'=>'dadmin','password'=>'1'));
        $out=$this->request('POST','User/updateUser',array('email'=>'aaaa','pseudo'=>'55','password'=>'1','status'=>'Visitor'));
		$this->assertRedirect('Home/admin');
        $out=$this->request('POST','User/loginCheck',array('login'=>'aaaa','password'=>'1'));
        $this->assertSame($_SESSION['login']['pseudo'],'55') ;
        $out=$this->request('POST','User/loginCheck',array('login'=>'dadmin','password'=>'1'));
        $out=$this->request('GET','User/delete/aaaa');
    }


}