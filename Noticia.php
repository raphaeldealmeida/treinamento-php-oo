<?php
require_once 'ActiveRecord.php';

class Noticia extends ActiveRecord{
    
    protected $id;
    protected $titulo;
    protected $texto;
    protected $dataCriacao;
//    protected $autor;
    
    function __construct($titulo = null, $texto = null, $dataCriacao = null, $id = null) {
        $this->id = $id;
        $this->titulo = $titulo;
        $this->texto = $texto;
        $this->dataCriacao = $dataCriacao;
    }
    
    public function setAutor(Usuario $autor) {
        $this->autor = $autor;
    }
    
    /**
     * 
     * @return Autor
     */
    public function getAutor() {
        return $this->autor;
    }
    
    public function setTitulo($titulo) {
        $this->titulo = $titulo;
    }
    
    public function getId() {
        return $this->id;
    }

    public function getTitulo() {
        return $this->titulo;
    }

    public function getTexto() {
        return $this->texto;
    }

    public function getDataCriacao() {
        return $this->dataCriacao;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function setTexto($texto) {
        $this->texto = $texto;
    }

    public function setDataCriacao($dataCriacao) {
        $this->dataCriacao = $dataCriacao;
    }





}