<?php
require_once 'Noticia.php';
require_once 'Usuario.php';

/*
$noticia = new Noticia();
$autor = new Usuario();
$autor->setNome('Marcelo');

$noticia->setAutor($autor);

$autor2 = clone $autor;
$autor2->setNome('Nascimento');

var_dump($noticia->getAutor()->getNome());
 */

$noticia = Noticia::find(7);

var_dump($noticia);

$noticia->setTitulo('Novo Titulo');
//$noticia->save();

$noticia2 = new Noticia('Novo', 
                        'Esta e uma noticia completamente nova', 
                        new DateTime);

$noticia2->save();  
        