<?php
class UserModelTest extends CIPHPUnitTestCase{

    public function load(){
        $this->CI = &get_instance();
        $this->CI->load->model('UserModel');
        $this->UserModel = $this->CI->UserModel;
    }

    public function testFindbyId(){
        $this->load();
        $user = $this->UserModel->findByEmail("d");
        $this->assertSame($user->getEmail(),"d");
    }

    public function testFindbyIdNoOne(){
        $this->load();
        $user = $this->UserModel->findByEmail("nonexistent@example.com");
        $this->assertNull($user);
    }

    public function testFindAll(){
        $this->load();
        $users = $this->UserModel->findAll();
        $this->assertNotEmpty($users);
    }
    public function testAdd(){
        $this->load();
        $user = $this->UserModel->findByEmail("nonexistent@example.com");
        $this->assertNull($user);
        $this->UserModel->add("nonexistent@example.com","1","1","Visitor");
        $user = $this->UserModel->findByEmail("nonexistent@example.com");
        $this->assertSame($user->getEmail(),"nonexistent@example.com");
        $out=$this->request('POST','User/loginCheck',array('login'=>'nonexistent@example.com','password'=>'1'));
        $this->assertSame($_SESSION['login']['email'],'nonexistent@example.com') ;
    }
    public function testUpdate(){
        $this->load();
        $this->UserModel->update("nonexistent@example.com","2","1","Administrator");
        $user = $this->UserModel->findByEmail("nonexistent@example.com");
        $this->assertSame($user->getStatus(),"Administrator");
        $this->assertSame($user->getPseudo(),"2");
    }
    public function testUpdateMDP(){
        $this->load();
        $this->UserModel->updateMDP("nonexistent@example.com","50");
        $out=$this->request('POST','User/loginCheck',array('login'=>'nonexistent@example.com','password'=>'50'));
        $this->assertSame($_SESSION['login']['email'],'nonexistent@example.com') ;
    }
    public function testUpdatePseudo(){
        $this->load();
        $this->UserModel->updatePseudo("nonexistent@example.com","50");
        $user = $this->UserModel->findByEmail("nonexistent@example.com");
        $this->assertSame($user->getPseudo(),"50");
    }
    public function testCountUser(){
        $this->load();
        $this->assertTrue($this->UserModel->countUser()>=0);
    }
    public function testDelete(){
        $this->load();
        $user = $this->UserModel->findByEmail("nonexistent@example.com");
        $this->assertSame($user->getEmail(),"nonexistent@example.com");
        $this->UserModel->delete("nonexistent@example.com");
        $user = $this->UserModel->findByEmail("nonexistent@example.com");
        $this->assertNull($user);
    }
}