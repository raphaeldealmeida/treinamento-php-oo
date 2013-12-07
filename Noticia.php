<?php
require_once 'ActiveRecord.php';

class Noticia extends ActiveRecord{
    
    protected $id;
    protected $titulo;
    protected $texto;
    protected $dataCriacao;
//    protected $autor;
    
    function __construct($titulo, $texto, $dataCriacao, $id = null) {
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




}