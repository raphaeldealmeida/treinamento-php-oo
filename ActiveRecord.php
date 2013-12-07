<?php

abstract class ActiveRecord {
    
    public static function find($id) {
        $entidades = self::findBy(array('id' => $id));
        return current($entidades);
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
                
        $sql = "INSERT INTO " . self::getNomeTabela()  
                . " VALUES (NULL, {$parametros});";
        
        
        if ($stmt = $con->prepare($sql)) {
            call_user_func_array(array($stmt, 'bind_param'), 
                                 $parametrosBind);
            $stmt->execute();
            $this->id = $stmt->insert_id;
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
    
    private static function getNomeTabela(){
        return strtolower(get_called_class()) . 's';
    }
    
    public static function findBy(array $params){
        $con = self::getConnection();
        
        $where = ' WHERE 1 = 1 ';
        foreach ($params as $coluna => $value) {
            if(is_array($value)){
                
                $value = implode("','", $value);
                $where .= "AND {$coluna} in ('{$value}') ";
                
            }else{
                $where .= "AND {$coluna} = '{$value}' ";
            }
        }
                
        $sql = "SELECT * FROM " . self::getNomeTabela() . "  $where ";
                
        $result = $con->query($sql);

        $entidades = array();
        while ($row = $result->fetch_assoc()) {
            $NomeDaClasse = get_called_class();
            
            $entidade = new $NomeDaClasse();
            
            foreach ($row as $nome => $valor) {
                
                $a = explode('_', $nome);
                array_walk($a, function (&$val, $key){
                    $val = ucfirst($val);
                });
                $a = implode('', $a);
                
                $setName = 'set' . $a;                
                $entidade->$setName($valor);
            }
            $entidades[] = $entidade;
        }
        return $entidades;
    }
    
    public static function __callStatic($name, $arguments) {
        
        $temp = explode('_', $name);
        $coluna = end($temp);

        $valor = current($arguments);

        return self::findBy(array($coluna => $valor));
    }
}