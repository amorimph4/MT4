<?php
/**
* Esta classe é ums classe lógica  * 
* @author Pedro Amorim <Pedroamorimh4@gmail.com> 
* @version 0.1 
* @copyright .....
* @access public 
* @package App 
* @subpackage Core
*/ 

namespace Core;

class Auth 
{

  /** 
* Comentário de variáveis 
* Variável recebe a instancia da Model City . 
* @access private 
* @name $id
* @name $system_user_username
* @name $system_user_email
* @name $system_user_permission
*/ 
    private static $id = null;
    private static $username = null;
    private static $email = null;
    private static $permission = null;


/** 
* Função construtor para iniciar sessão com as váriaveis preenchidas
* @access public 
* @return void
*/
    public function __construct()
    {
        if(Session::get('user')){
            $user = Session::get('user');
            
            self::$id= $user['id'];
            self::$username = $user['username'];
            self::$email = $user['email'];
            self::$permission = $user['tipoacesso'];
            
        }
    }


/** 
* Função para retornar váriaveis
* @access public 
* @return $id
*/
    public static function id()
    {
        return self::$id;
    }

/** 
* Função para retornar váriaveis
* @access public 
* @return $username
*/
     public static function name()
     {
         return self::$username;
     }

/** 
* Função para retornar váriaveis
* @access public 
* @return $email
*/
      public static function email()
      {
          return self::$email;
      }

/** 
* Função para retornar váriaveis
* @access public 
* @return $permission
*/
      public static function permission()
      {
        return self::$permission;
      }



/** 
* Função para verificar se váriveis estão prenchidas 
* @access public 
* @return boolean 
*/
      public static function check()
      { 
        if(self::$id == null && self::$username == null && self::$email == null && self::$permission == null)
            return false;
        return true;
          
      }


}








?>