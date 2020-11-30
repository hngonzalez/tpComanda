<?php
namespace App\Controllers;
use Clases\Usuario;
use Clases\Empleados;

use App\Models\Empleado;

class EmpleadoController {
    public $datos = array ('datos' => '.');
    
    
    public function registro($request, $response, $args)
    {
        $parsedBody = $request->getParsedBody();
        $nombre = $parsedBody['nombre'];
        $apellido = $parsedBody['apellido'];
        $tipo = $parsedBody['tipo'];

        
        if($nombre != null && $apellido != null && $tipo != null){
            
            
            $rta = Empleado::where('nombre', $nombre)->where('apellido',$apellido)->where('tipo',$tipo)->first();

            if($rta == null)
            {
                $newEmpleado = new Empleados($nombre,$apellido,$tipo);

                if($newEmpleado->tipo == null){
                    $datos['datos'] = "Tipo de empleado incorrecto ('bartender', 'mozo', 'cervecero' o 'cocinero')";
                    
                }
                else{
                    $empleado = new Empleado;
                    $empleado->nombre = $newEmpleado->nombre;
                    $empleado->apellido = $newEmpleado->apellido;
                    $empleado->tipo = $newEmpleado->tipo;
                    $empleado->disponible = $newEmpleado->disponible;
                    $empleado->operaciones = 0;
                    $empleado->id_estado = 1;
                    if($newEmpleado->tipo == "bartender"){
                        $empleado->id_sector = 1;
                    }
                    if($newEmpleado->tipo == "cervecero"){
                        $empleado->id_sector = 2;
                    }
                    if($newEmpleado->tipo == "cocinero"){
                        $empleado->id_sector = 3;
                    }
                    if($newEmpleado->tipo == "mozo"){
                        $empleado->id_sector = 4;
                    }
                    
                
                    $rta = $empleado->save();
                    
                    $datos['datos'] = 'Se creo el empleado correctamente!';
                }
            }
            else
            {
                $rta = false;
                $datos['datos'] = "Error, empleado existente";
                
            }
        }
        else{
            $rta = false;
            $datos['datos'] = "Complete los campos correctamente.";
        }
        $payload = json_encode($datos);
        $response->getBody()->write($payload);
        
        return $response->withHeader('Content-Type', 'application/json');
    }
    
    public function login($request, $response, $args)
    {
        
        $parsedBody = $request->getParsedBody();
        
        $email = $parsedBody['email'];
        $clave = $parsedBody['clave'];
        // $nombre = $parsedBody['nombre'];
        
        $usuario = User::where('email', $email)
        ->first();
        
        
        if($usuario != null){
            
            $token = Usuario::Login($email,$clave,$usuario->password,$usuario->imagenNombre,$usuario->tipo);
            
        }
        else {
            $token = false;
        }
        

        if($token != false)
        {
            $datos['datos'] = 'Login Exitoso.';
            $datos['token'] = $token;
            
        }
        else
        {
            $datos['datos'] = 'Nombre o Clave Incorrecto';                       
        }
        $payload = json_encode($datos);

        $response->getBody()->write($payload);
        return $response
          ->withHeader('Content-Type', 'application/json');
    }
    
}