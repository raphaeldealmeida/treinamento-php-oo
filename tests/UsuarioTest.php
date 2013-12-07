<?php

require_once __DIR__ . '/../Usuario.php';

class UsuarioTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var Usuario 
     */
    protected $usuario;
    
    public function setUp(){
        
        $this->usuario = new Usuario('marcelo', 'Marcelo Jorge', 123);
    }

    public function testAlteraNome()
    {
        $this->usuario->setNome('Raphael de Almeida');
        $this->assertEquals('Raphael de Almeida', $this->usuario->getNome());
    }
    
    public function testInserir(){
        $this->usuario->save(); 
        $id = $this->usuario->getId();
        
        $con = new mysqli('localhost', 'root', '', 'noticias');
        $con->query(       
        "SELECT * FROM  `usuarios` WHERE 1 =1
        AND  `id` =  {$id}
        AND  `login` =  'marcelo'
        AND  `nome` =  'Marcelo Jorge'
        AND  `senha` =123");
        $this->assertEquals(1, $con->affected_rows);
    }
    
    /**
     * @depends testInserir
     */
    public function testFind(){
        $this->usuario->setNome('Fabio');
        $this->usuario->save();
        
        $id = $this->usuario->getId();
        
        $noticiaDoBanco = Usuario::find($id);
        
        $this->assertEquals($this->usuario->getNome(), $noticiaDoBanco->getNome());
        
    }
    
    /**
     * @depends testInserir
     */
    public function testFindBy(){
       
        $usuarios = Usuario::findBy(array('nome' => 'Fabio'));
        $this->assertGreaterThan(0, count($usuarios));
        $this->assertEquals('Fabio', $usuarios[0]->getNome());
        
    }
    
    /**
     * @depends testFindBy
     */
    public function testFindByMagic(){
        
        $usuarios = Usuario::find_by_nome('Fabio');
        $this->assertGreaterThan(0, count($usuarios));
        $this->assertEquals('Fabio', $usuarios[0]->getNome());
    }
    
    /**
     * @depends testFindByMagic
     */
    public function testFindByMagicInexistente(){
        
        $usuarios = Usuario::find_by_nome('NOME NAO EXISTENTE NO BANCO');
        $this->assertEquals(0, count($usuarios));
    }
    
    
    
    
    
}