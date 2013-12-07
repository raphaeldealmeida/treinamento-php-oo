<?php

require_once __DIR__ . '/../Noticia.php';

class NoticiaTest extends PHPUnit_Framework_TestCase{
    
    /**
     *
     * @var Noticia 
     */
    protected $noticia;

    public function setUp(){
        
        $this->noticia = new Noticia('Titulo 1', 'Texto da noticia', new DateTime);
    }
    
    public function testInserir(){
        $this->noticia->save(); 
        
        $con = new mysqli('localhost', 'root', '', 'noticias');
        $con->query(       
        "SELECT * FROM  `noticias` WHERE 1 =1
        AND  `id` =  {$this->noticia->getId()}
        AND  `titulo` =  '{$this->noticia->getTitulo()}'
        AND  `texto` =  '{$this->noticia->getTexto()}'
        AND  `data_criacao` = '{$this->noticia->getDataCriacao()->format('Y-m-d h:i:s')}'");
        $this->assertEquals(1, $con->affected_rows);
    }
    
    public function testUpdate(){
        $this->markTestSkipped('Testar primeiro o ActiveRecord::find');
    }
    
    /**
     * @depends testInserir
     */
    public function testFind(){
        $this->noticia->setTitulo('Procurar');
        $this->noticia->save();
        
        $id = $this->noticia->getId();
        
        $noticiaDoBanco = Noticia::find($id);
        
        $this->assertEquals($this->noticia->getTitulo(), $noticiaDoBanco->getTitulo());
        
    }
    
    
    
    
}

