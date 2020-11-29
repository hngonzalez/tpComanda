<?php
namespace Clases;

use Clases\Token;

class Usuario{
    public $usuario;
    public $nombre;
    public $apellido;
    public $clave;
    public $imagenNombre;
    public $tipo;

    public function __construct($usuario,$nombre,$apellido, $clave, $imagenNombre,$tipo)
    {
        $this->usuario = $usuario;
        $this->nombre = $nombre;
        $this->apellido = $apellido;
        $this->clave = $clave;
        $this->imagenNombre = $imagenNombre;
        $this->tipo = $tipo;
    }

    public static function Login($usuario,$clave,$claveBase,$imagenNombre,$tipo){
        $retorno = false;
        
        if ( Usuario::verificarContraseña($clave,$claveBase)) {
            $usuario = array('usuario' => $usuario, 'clave' => $claveBase,'tipo'=>$tipo);
            
            $token = Token::crearToken($usuario);
            
            return $token;
        }
        else {
            return false;
        }
    }    

    public static function CrearUsuario($usuario,$nombre,$apellido,$clave,$imagenNombre,$tipo){
        $retorno = false;
        
        $claveEncriptada = Usuario::encriptarContraseña($clave);
        $imagenNombre = "";

        $usuario = new Usuario($usuario,$nombre,$apellido,$claveEncriptada,'./imagenes/'.$imagenNombre,$tipo);
        
        return $usuario;
    }
    
    public static function encriptarContraseña($clave){
        return password_hash($clave, PASSWORD_DEFAULT);
    }

    public static function verificarContraseña($clave,$hash){
        return password_verify($clave, $hash);
    }


}


?>