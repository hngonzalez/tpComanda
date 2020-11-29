<?php
namespace App\Controllers;
use Clases\Usuario;
use Clases\Personas;
use App\Models\Cliente;

class ClienteController {
    public $datos = array ('datos' => '.');
    
    public function registro($request, $response, $args)
    {

        $parsedBody = $request->getParsedBody();
        $nombre = $parsedBody['nombre'];
        $usuario = $parsedBody['usuario'];
        $apellido = $parsedBody['apellido'];
        $clave = $parsedBody['clave'];

        if($nombre != null && $apellido != null){            
            $usuarioCreado = Usuario::CrearUsuario($usuario,$nombre,$apellido,$clave,'',"cliente");

            $clienteCreado = new Personas($usuarioCreado->usuario,$usuarioCreado->nombre,$usuarioCreado->apellido,$usuarioCreado->clave);
            $token = Usuario::Login($usuario,$clave,$usuarioCreado->clave,$usuarioCreado->imagenNombre,"cliente");

            $cliente = new Cliente;
            $cliente->nombre = $clienteCreado->nombre;
            $cliente->apellido = $clienteCreado->apellido;
            $cliente->usuario = $clienteCreado->usuario;
            $cliente->clave = $clienteCreado->clave;
        

            $rta = $cliente->save();
            
            $datos['datos'] = 'Se creo el cliente correctamente!';
            $datos['token'] = $token;
            
        }
        else{
            $rta = false;
            $datos['datos'] = "Complete los campos correctamente.";
        }
        $payload = json_encode($datos);
        $response->getBody()->write($payload);
        
        return $response->withHeader('Content-Type', 'application/json');
    }
}