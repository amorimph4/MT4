<?php
namespace App\Controllers;

include_once './../Core/BaseController.php';
include_once './../Core/Container.php';
include_once './../Core/Redirect.php';
include_once './../Core/BaseTable.php';

use Core\BaseController;
use Core\BaseTable;
use Core\Container;
use Core\Redirect;

class DeviceController extends BaseController
{	
	protected $device;
    protected $salt;
    protected $conn;
    protected $alfa = [
            'a' => 0,
            'b' => 1,
            'c' => 2,
            'd' => 3,
            'e' => 4,
            'f' => 5,
            'g' => 6,
            'h' => 7,
            'i' => 8,
            'j' => 9,
            'k' => 10,
            'l' => 11,
            'm' => 12,
            'n' => 13,
            'o' => 14,
            'p' => 15,
            'q' => 16,
            'r' => 17,
            's' => 18,
            't' => 19,
            'u' => 20,
            'v' => 21,
            'w' => 22,
            'x' => 23,
            'y' => 24,
            'z' => 25
        ];

    public function __construct()
    {
        parent::__construct();
        $this->device 	= 	Container::getModel("Device");
        $this->salt = self::decript('cldud');
    }

    public function index()
    {
        $rows = $this->device->All();
        $this->view->devices = BaseTable::decodeTable($rows, "Device");
        $this->renderview('Device/index', "layout");
    }

    public function create()
    {
        $this->renderview('Device/create', "layout");
    }

    public function conect($id)
    {
        $this->view->device = $this->device->find($id);
        $this->renderview('Device/conect', "layout");
    }

    public function store($request)
    {       
        $data = [
            'hostname'      =>  $request->post->hostname ,
            'ip'            =>  $request->post->Ip ,
            'tipo'          =>  $request->post->tipo,  
            'fabricante'    => $request->post->fabricante
        ];

        try {
            if( $this->device->create( $data) ) {
                Redirect::route("/", [
                    'success'=>['criado com sucesso']
                ]);
            }
        }catch (\Exception $e){
            Redirect::route("/", [
                'error'=>['falha ao criar']
            ]);
        }
    }

    public function edit($id){
        $this->view->device = $this->device->find($id);
        $this->renderview('Device/edit', "layout");
    }

    public function update($id,$request)
    {
        $data = [
            'hostname'      =>  $request->post->hostname ,
            'ip'            =>  $request->post->Ip ,
            'tipo'          =>  $request->post->tipo,  
            'fabricante'    => $request->post->fabricante
        ];

        try {
            if( $this->device->update( $data , $id) ) {
                Redirect::route("/", [
                    'success'=>['criado com sucesso']
                ]);
            }
        }catch (\Exception $e){
            Redirect::route("/", [
                'error'=>['falha ao criar']
            ]);
        }
    }

    public function delete($id)
    {
        try {
            if( $this->device->delete($id) )
            {
                return Redirect::route("/", [
                    'success'=>['deletado com sucesso']
                ]);
            }
        } catch (\Exception $e) {
            Redirect::route("/", [
                'error'=>['falha ao criar']
            ]);
        }
    }

    public function setConnection($id,$request)
    {
        try{
            $device = $this->device->find($id);

            $con = ssh2_connect($device->ip, 22);
            if (!$con) {
                $this->view->output = "Falha na conexão";
                $this->renderview('Device/output', "layout");
            }
            if (!ssh2_auth_password ( $con , $request->post->user, $request->post->password)) {
                $this->view->output = "Usuário ou senha inválidos";
                $this->renderview('Device/output', "layout");
            }

            $stream = ssh2_exec($con, $request->post->command);
            stream_set_blocking($stream, true);
            $stream_out = ssh2_fetch_stream($stream, SSH2_STREAM_STDIO);
            $this->view->output = stream_get_contents($stream_out);
            $this->renderview('Device/output', "layout");

        }catch (\Exception $e){
            $this->view->output = $e->getMessage();
            $this->renderview('Device/output', "layout");
        }
    }

    public function criptView()
    {
        $this->renderview('Device/cript', "layout");
    }

    public function cript($request, $return = null )
    {
        $text = '';
        $cript = [];

        foreach (str_split($request->post->text) as $letra ) {
            $cript[] = ($this->alfa[$letra] + 3) % 26;
        }

        foreach ($cript as $value ) {
            $text .= array_search($value, $this->alfa);         
        }

        if ($return) {
            return $text;
        }

        $this->view->criptcesar = $text;
        $this->view->criptsalt = $this->encryptSalt($request->post->text);
        $this->renderview('Device/cript', "layout"); 
    }

    public function managerDecript($request)
    {
        if (strstr($request->post->text, '::')) {
            $this->view->criptcesar = $this->decript($this->cript($this->decryptSalt($request->post->text)));
            $this->view->criptsalt = $this->decryptSalt($request->post->text);
            $this->renderview('Device/cript', "layout");
        }else{
            $this->view->criptcesar = $this->decript($text);
            $this->view->criptsalt = $this->decryptSalt($this->encryptSalt($this->decript($request)));
            $this->renderview('Device/cript', "layout");
        }
    }

    public function decript($textreq)
    {
        $text = '';
        $decript = [];

        foreach (str_split($textreq) as $letra ) {
            $value = $this->alfa[$letra] - 3;
            if ($value < 0) {
                $decript[] = 26 + $value;
            }else{
                $decript[] = $value;
            }
        }

        foreach ($decript as $value) {
            $text .= array_search($value, $this->alfa); 
        }

        return $text;
    }

    public function encryptSalt($plaintext)
    {
        $cipher_method = 'AES256';
        $enc_key = openssl_digest(php_uname(), 'AES256', TRUE);
        $enc_iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length($cipher_method));
        $crypted_token = openssl_encrypt($plaintext, $cipher_method, $enc_key, 0, $enc_iv) . "::" . bin2hex($enc_iv);
        unset($plaintext, $cipher_method, $enc_key, $enc_iv);

        return $crypted_token;
    }

    public function decryptSalt($crypted_token)
    {
        list($crypted_token, $enc_iv) = explode("::", $crypted_token);
        $cipher_method = 'AES256';
        $enc_key = openssl_digest(php_uname(), 'AES256', TRUE);
        $token = openssl_decrypt($crypted_token, $cipher_method, $enc_key, 0, hex2bin($enc_iv));
        unset($crypted_token, $cipher_method, $enc_key, $enc_iv);

        return $token;
    }

    public function compareView()
    {
        $this->renderview('Device/comparehash', "layout");
    }

    public function compareHash($request)
    {
        $this->view->compare = 'diferente';
        if ($request->post->hash) {
            $this->view->compare = $this->sha512($request->post->text) == $this->sha512($request->post->text, $request->post->hash) ? 'igual' : 'diferente';
        }
        $this->view->criptsha512 = $this->sha512($request->post->text);
        $this->view->criptHMAC = $this->HMAC($request->post->text);
        $this->renderview('Device/comparehash', "layout");
    }

    public function sha512($text , $salt = null)
    {
        if ($salt) {
            return crypt($text, '$6$rounds=5000$'.$salt);
        }
        return crypt($text, '$6$rounds=5000$'.$this->salt);

    }

    public function HMAC($text, $salt = null)
    {
        if ($salt) {
            return hash_hmac('sha512', $text, $salt);
        }
        return hash_hmac('sha512', $text, $this->salt);
    }

}

return new DeviceController();
