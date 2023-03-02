<?php
require_once APPPATH.'models'.DIRECTORY_SEPARATOR.'Entities'.DIRECTORY_SEPARATOR."UserEntity.php";
class UserModel extends CI_Model {
    
    //Renvoi le UserEntity correspondant a l'email donné en paramètre (ou null)
    function findByEmail(string $email): ?UserEntity{
        $req="CALL user_findByEmail(?)";
        $q=$this->db->query($req, array($email));
        $res=$q-> custom_result_object("UserEntity");
        $q->next_result();
        $q->free_result();
        if ($res!=null){
            return $res[0];
        } else {
            return null;
        }
    }

    //Renvoi tous les utilisateurs sous la forme d'un tableau de UserEntity
    function findAll():array{
        $req="CALL user_getAllUsers()";
        $q=$this->db->query($req);
        $res=$q-> custom_result_object("UserEntity");
        $q->next_result();
        $q->free_result();
        return $res;
    }

    //Ajoute un utilisateur a la base de données
    function add(string $email, string $pseudo, string $password, string $status){
        $data = [
            'email' => $email,
            'pseudo' => $pseudo,
            'password'  => password_hash($password, PASSWORD_DEFAULT),
            'status'  => $status,
        ];
        $req="CALL user_addUser(?,?,?,?)";
        $q=$this->db->query($req, $data);
    }
   
    //Supprime un utilisateur de la base de données grace au paramètre email
    function delete(string $email){
        $data=[
            'email'=>$email
        ];
        $req="CALL user_deleteUser(?)";
        $this->db->query($req, $data);
    }

    //Modifie un utilisateur grace aux paramètres
    function update(string $email, string $pseudo, string $password, string $status){
        $data=[
            "email"=>$email,
            "pseudo"=>$pseudo,
            "password"=>password_hash($password, PASSWORD_DEFAULT),
            "status"=>$status
        ];
        $req="CALL user_updateUser(?,?,?,?)";
        $this->db->query($req, $data);
    }

    //Modifie le pseudo de l'utilisateur lié a l'email en paramètre
    function updatePseudo(string $email, string $pseudo){
        $update_rows = array('pseudo' => $pseudo,);
		$this->db->where('email', $email );
		$this->db->update('User', $update_rows);	
    }

    //Modifie le mot de passe de l'utilisateur lié a l'email en paramètre
    function updateMDP(string $email, string $password){
        $update_rows = array('password' => password_hash($password, PASSWORD_DEFAULT),);
		$this->db->where('email', $email );
		$this->db->update('User', $update_rows);	
    }

    //Génere les tokens nécessaires a la réinitialisation du mot de passe. 
    function addResetPassword(string $passResetEmail, string $passResetSelector,string $passResetToken, string $passResetExpire){
        $this->deleteResetPassword($passResetEmail);
        $data = [
            'passResetEmail' => $passResetEmail,
            'passResetSelector' => $passResetSelector,
            'passResetToken'  => password_hash($passResetToken, PASSWORD_DEFAULT),
            'passResetExpire'  => $passResetExpire,
        ];
        $req="CALL pass_addResetPassword(?,?,?,?)";
        $this->db->query($req, $data);
    }

    //Supprime les informations nécessaires au reset du mot de passe
    function deleteResetPassword(string $passResetEmail){
        $data=[
            'passResetEmail'=>$passResetEmail
        ];
        $req="CALL pass_deleteResetPassword(?)";
        $this->db->query($req, $data);
    }

    //Vérifie la comformité des tokens
    function checkSelectorAndExpire(string $passResetSelector, string $passResetExpire):?array{
        $data=[
            'passResetSelector'=>$passResetSelector,
            'passResetExpire'=>$passResetExpire
        ];
        $req="CALL pass_checkSelectorAndExpire(?,?)";
        $res=$this->db->query($req, $data);
        $result=$res->result_array();
        if (empty($result)){
            return null;
        } else {
            $res->next_result();
            $res->free_result();
            return $result[0];
        }
    }

    //renvoi le nombre d'utilisateurs enregistrés (y compris admin)
    function countUser():Int{
        $this->db->select('*');
        $this->db->from('User');
        return $this->db->count_all_results();
    }

    function isUserUse(string $email):Bool{
        $result = $this->db->select('login')->from('Order')->where('login', $email)->limit(1)->get()->row();
        return gettype($result)!="NULL";
    }


}