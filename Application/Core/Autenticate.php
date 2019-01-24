<?php
/** 
* Comentário de cabeçalho de arquivos 
* Esta classe é um Controller  
* @author Pedro Amorim <Pedroamorimh4@gmail.com> 
* @version 0.1 
* @copyright .....
* @access public 
* @package Core 
*/ 
namespace Core;

use App\Models\Usuario;
use Core\BaseController;	
use Core\Redirect;
use Core\Validator;
use Core\Container;



trait Autenticate{
 

/**
* Função para verificar usuario login de usúario e joga-lo na sessão com seus dados
* @access public  
* @param $request  
* @name $pass 
* @result  
*/

 public function auth($request)
    {   
        
          //system_user_email                   //gambiarra no campo de login vou guardar os emails login é o email
        $result = $this->usuarios->finds( [$request->post->email] );
    
        $senhaBD = $result->senha;
 
        if($result && password_verify($request->post->senha , $senhaBD) )  
        {           
            $user = [ 
                    'id'                     => $result->id,
                    'username'               => $result->nome, 
                    'email'                  => $result->email,     
                    'tipoacesso'             => $result->tipoacesso 
            ];
            
            Session::set('user', $user);
            return Redirect::route('/');
            
        }

        return Redirect::route('/login',[
            'errors'=>['Usuario ou senha invalida'],        
            'inputs'=>['system_user_email'=>  $request->post->system_user_email]
        ]);
    }




/**
* Função para destruir sessão criada e redirecionar para usuário novamente fazer login 
* @access public 
* @return chamada pra método  
*/
    public function logout(){

        Session::destroy('user');
        return Redirect::route('/login');
    } 




}
?>


