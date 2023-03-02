<?php
require_once APPPATH.'models'.DIRECTORY_SEPARATOR.'Entities'.DIRECTORY_SEPARATOR."UserMemento.php";

class UserEntity extends CI_Model{
    private string $email;
    private string $pseudo;
    private string $password;
    private string $status;
    /**
     * User constructor.
     * @param string $pseudo
     * @param string $password
     */

    
    public function saveToMemento(){
        return New UserMemento($this);
    }

    //Vérifie que le mot de passe donné en paramètre est le bon
    public function isValidPassword(string $password):bool{
        return password_verify($password, $this->password);
    }

    /**
     * @param string $pseudo
     */
    public function setEmail(string $email): void
    {
        $this->pseudo = $email;
    }

    public function setPseudo(string $pseudo): void
    {
        $this->pseudo = $pseudo;
    }

    /**
     * @param string $password
     */
    public function setPassword(string $password): void
    {
        $this->password = $password;
    }

    /**
     * @param string $status
     */
    public function setStatus(string $status): void
    {
        $this->status = $status;
    }

    public function getEmail():string
    {
        return $this->email;
    }

    /**
     * @return string
     */
    public function getStatus(): string
    {
        return $this->status;
    }

    /**
     * @return string
     */
    public function getPseudo(): string
    {
        return $this->pseudo;
    }

    /**
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }


}