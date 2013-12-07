<?php
require_once 'ActiveRecord.php';
class Usuario extends ActiveRecord{
    protected $id;
    protected $login;
    protected $senha;
    protected $nome;
    
    function __construct($login = null, $nome = null, $senha = null, $id = null) {
        $this->id = $id;
        $this->login = $login;
        $this->senha = $senha;
        $this->nome = $nome;
    }
    
    public function getId() {
        return $this->id;
    }

    public function setNome($nome) {
        $this->nome = $nome;
    }
    
    public function getNome() {
        return $this->nome;
    }
    
    public function setId($id) {
        $this->id = $id;
    }

    public function setLogin($login) {
        $this->login = $login;
    }

    public function setSenha($senha) {
        $this->senha = $senha;
    }
}
