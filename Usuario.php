<?php
require_once 'ActiveRecord.php';
class Usuario extends ActiveRecord{
    protected $id;
    protected $login;
    protected $senha;
    protected $nome;
    
    function __construct($login, $nome, $senha, $id = null) {
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


}
