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
    
}