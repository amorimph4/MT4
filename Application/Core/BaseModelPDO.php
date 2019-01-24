<?php

namespace Core;


/**
* Esta classe é ums classe base para que todas as model possa estendelás * 
* @author Pedro Amorim <Pedroamorimh4@gmail.com> 
* @version 0.1 
* @copyright .....
* @access public 
* @package App 
* @subpackage Core
*/ 

use PDO;

abstract class BaseModelPDO
{


/** 
* Comentário de variáveis .
* @access public  
* @name $pdo  
* @name $table
*/
    private $pdo;
    protected $table;
    private $id;


/** 
* Função construtora para inicar objetos nas variaveis
* @access public 
*/
    public function __construct( $pdo)
    {   
        $this->pdo = $pdo;
    }

/**
* Função recebe por parametro tabela e faz busca no banco na tabela recebida por parametro
* @access public 
* @param $table
* @return $result
*/
    public function All($limit = false)
    {
        if($limit){
            $query = "SELECT * FROM {$this->table} limit $limit";
        }else{
            $query = "SELECT * FROM {$this->table}";
        }
        $stmt = $this->pdo->prepare($query);
        $stmt->execute();
        $result = $stmt->fetchAll();
        $stmt->closeCursor();
        return $result;
    }


/**
* Função recebe por parametro um array e faz busca no banco na tabela recebida por parametro
* @access public 
* @param $array
* @return $result
*/
    public function finds($array)
    {
        
        $query = "SELECT * FROM {$this->table} WHERE email = ? ";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute($array);
        $result = $stmt->fetch();
        $stmt->closeCursor();
        return $result;
    }


/**
* Função recebe por parametro tabela e faz busca no banco na tabela recebida por parametro
* @access public 
* @param $array
* @return $result
*/
    public function find($id)
    {
        $query = "SELECT * FROM {$this->table} WHERE id=:id";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindValue(":id", $id);
        $stmt->execute();
        $result = $stmt->fetch();
        $stmt->closeCursor();
        return $result;
    }

/**
* Função recebe por parametro tabela e faz busca no banco na tabela recebida por parametro
* @access public 
* @param $array
* @return $result
*/
    public function create(array $data)
    {
        $data = $this->prepareDataInsert($data);
        $query = "INSERT INTO {$this->table} ({$data[0]}) VALUES ({$data[1]})";
        $stmt = $this->pdo->prepare($query);
        for($i = 0; $i < count($data[2]); $i++){    
            $stmt->bindValue("{$data[2][$i]}", $data[3][$i]);
        }
        $result = $stmt->execute();
        $stmt->closeCursor();
        return $result;
    }

/**
* Função recebe por parametro tabela e faz busca no banco na tabela recebida por parametro
* @access public 
* @param $array
* @return $result
*/
    private function prepareDataInsert(array $data)
    {

        $strKeys = "";
        $strBinds = "";
        $values = [];
        $binds = [];

        foreach ($data as $key => $value){
            $strKeys = "{$strKeys}, {$key}";
            $strBinds = "{$strBinds},:{$key}";
            $binds[] = ":{$key}";
            $values[] = $value;
         }
         $strKeys = substr($strKeys, 1);
         $strBinds = substr($strBinds, 1);
         return [$strKeys, $strBinds, $binds, $values];
    }

/**
* Função recebe por parametro tabela e faz busca no banco na tabela recebida por parametro
* @access public 
* @param $array
* @return $result
*/
    public function update(array $data, $id)
    {
        $data = $this->prepareDataUpdate($data);
        $query="UPDATE {$this->table} SET {$data[0]} WHERE id=:id";
        $stmt= $this->pdo->prepare($query);
        $stmt->bindValue(":id", $id);
        for($i = 0; $i < count($data[1]); $i++){
            $stmt->bindValue("{$data[1][$i]}", $data[2][$i]);
        } 
        $result = $stmt->execute();
        $stmt->closeCursor();
        return $result;
    }


/**
* Função recebe por parametro tabela e faz busca no banco na tabela recebida por parametro
* @access public 
* @param $array
* @return $result
*/

    private function prepareDataUpdate(array $data)
    {
        $strKeysBinds = "";
        $binds = [];
        $values = [];

        foreach ($data as $key => $value){
            $strKeysBinds = "{$strKeysBinds},{$key}=:{$key}";
            $binds[] = ":{$key}";
            $values[] = $value;
        }
        $strKeysBinds = substr($strKeysBinds, 1);
        return [$strKeysBinds, $binds, $values];
    }

/**
* Função recebe por parametro tabela e faz busca no banco na tabela recebida por parametro
* @access public 
* @param $array
* @return $result
*/
    public function delete($id)
    {
        $query = "DELETE FROM {$this->table} WHERE id=:id";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindValue(":id", $id);
        $result = $stmt->execute();
        $stmt->closeCursor();
        return $result;
    }

    public function getLastId()
    {
        return $this->pdo->lastInsertId();
    }

    public function getId()
    {
        return $this->id;
    }
    
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }
}

?>