<?php

abstract class ActiveRecord {
    
    public static function find($id) {
        $con = self::getConnection();

        $result = $con->query("SELECT * FROM noticias WHERE id = {$id}");

        while ($row = $result->fetch_assoc()) {
            $noticia = new Noticia($row['titulo'],  $row['texto'], 
                                   $row['data_criacao'], $row['id']);
        }
        return $noticia;
    }
    
    public function save(){
        
        $con = self::getConnection();
	
        if(!is_null($this->id)){
            if($stmt = $con->prepare("UPDATE  noticias SET  titulo = ? 
                                     WHERE id = ?;")){
                $stmt->bind_param('si', $this->titulo, $this->id);
                $stmt->execute();
            }
        }  else {
            $this->insert();
        }
    }
    
    private function insert() {
        $con = self::getConnection();

        $tabela = strtolower(get_called_class()) . 's';
        
        $atributos = get_object_vars($this); 
        
        $parametros = '';
        $tipos = '';
        $parametrosBind = array();
       
        foreach ($atributos as $key => $value) {
            
            if($atributos[$key] instanceof DateTime){
                $atributos[$key] = $atributos[$key]->format('Y-m-d h:i:s');
            }       
            
            $parametrosBind[] = &$atributos[$key];
            
            if($key != 'id'){
                $tipos .= 's';
                $parametros .= '?, ';
            }
        }
        
        $parametrosBind[0] = $tipos;
        $parametros = substr($parametros, 0, -2);
                
        $sql = "INSERT INTO {$tabela} 
                VALUES (NULL, {$parametros});";
        
        
        if ($stmt = $con->prepare($sql)) {
            call_user_func_array(array($stmt, 'bind_param'), 
                                 $parametrosBind);
            $stmt->execute();
            $this->id = $con->insert_id;
        }
        
        if($con->errno){
            throw new Exception($con->error);
        }
        
    }

    private static function getConnection() {
        $con = new mysqli('localhost', 'root', '', 'noticias');
        if (mysqli_connect_errno()) {
            die('N�o foi poss�vel acessar a base de dados');
        }
        return $con;
    }
}