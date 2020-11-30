<?php
namespace App\Controllers;
use Clases\Usuario;
use Clases\Personas;

use App\Models\Socio;
use App\Models\Empleado;
use App\Models\EstadoEmpleado;


class SocioController {
    public $datos = array ('datos' => '.');
    public static function getAllCount () {
        $rta = Socio::get()->count();

        return json_encode($rta);
    }

    public function getUserEmail($request, $response, $args, $email){
        $rta = User::where('email', $email)
        ->first();
        return $rta;
    }
    
    public function registro($request, $response, $args)
    {
        $parsedBody = $request->getParsedBody();
        $nombre = $parsedBody['nombre'];
        $usuario = $parsedBody['usuario'];
        $apellido = $parsedBody['apellido'];
        $clave = $parsedBody['clave'];
        $countSocios = SocioController::getAllCount();
        
        if($nombre != null && $apellido != null){
            
            if($countSocios < 3){
                
                $rta = Socio::where('nombre', $nombre)->where('apellido',$apellido)->where('usuario',$usuario)->first();
            
                if($rta == null)
                {
                    $usuarioCreado = Usuario::CrearUsuario($usuario,$nombre,$apellido,$clave,'',"socio");
                    $newSocio = new Personas($usuarioCreado->usuario, $usuarioCreado->nombre,$usuarioCreado->apellido, $usuarioCreado->clave);

                    $socio = new Socio;
                    $socio->nombre = $newSocio->nombre;
                    $socio->apellido = $newSocio->apellido;
                    $socio->usuario = $newSocio->usuario;
                    $socio->clave = $newSocio->clave;
                    
                    $rta = $socio->save();

                    $token = Usuario::Login($usuario,$clave,$usuarioCreado->clave,$usuarioCreado->imagenNombre,"socio");

                    $datos['datos'] = 'Socio generado exitosamente!';
                    $datos['token'] = $token;
                }
                else
                {
                    $rta = false;
                    $datos['datos'] = "Ya existe el socio en la DB";
                    
                }
            }
            else{
                $datos['datos'] = "La cantidad máxima de socios registrados son 3";
            }
        }
        else{
            $rta = false;
            $datos['datos'] = "Complete los campos correctamente.";
        }
        $payload = json_encode($datos);
        $response->getBody()->write($payload);
        
        return $response
          ->withHeader('Content-Type', 'application/json');
    }
    public function login($request, $response, $args)
    {
        
        $parsedBody = $request->getParsedBody();
        
        $email = $parsedBody['email'];
        $clave = $parsedBody['clave'];

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

    public function getEmpleados($request, $response, $args){
        $empleados = Empleado::get()->toArray();
        $datos['datos'] = " ";
        
        if($empleados != null){
            
            foreach ($empleados as $key => $value) {
                $estadoEmpleado = EstadoEmpleado::where('id',$value['id_estado'])->first();
                

                $datos['datos'] .= "<br> Empleado: Nombre: " . $value['nombre'] . " - Apellido: " . $value['apellido']
                . "<br> - Fecha de ingreso:" . "  " . $value['created_at']
                . "<br> - Cantidad de operaciones:" . "  " . $value['operaciones']
                . "<br> - Estado del empleado:" . "  " . $estadoEmpleado->descripcion. "<br><br>" ;
            }
            
        }
        $payload = json_encode($datos);
        $response->getBody()->write($payload);
        
        return $response
          ->withHeader('Content-Type', 'application/json');
    }

    public function update($request, $response, $args)
    {
        $params = (array)$request->getQueryParams();

        $id = $args['id'];
        $email = $params['email'];
        $name = $params['name'];

        $user = User::find($id);
        if($user){
            $user->email = $email;
            $user->name = $name;
            
            if($user->save()){

                $datos['datos'] = "Se modifico el usuario correctamente.";
                
            }
            else{
                $datos['datos'] = "Error al modificar datos";
            }
            
        }
        else{
            $datos['datos'] = "Error. ID no encontrado";
        }

        // $rta = $user->save();

        $response->getBody()->write(json_encode($datos));
        return $response;
    }



    public function delete($request, $response, $args)
    {
        $id = $args['id'];
        $parsedBody = $request->getParsedBody();
        
        $user = User::find($id);
        if($user){
            if($user->delete()){
                $datos['datos'] = "Se elimino el usuario correctamente.";
            }
        }
        else{
            $datos['datos'] = "Error. ID no encontrado";
        }
        

        $response->getBody()->write(json_encode($datos));
        return $response;
    }



    public function isEmail($email){
        $email = filter_var($email, FILTER_SANITIZE_EMAIL);
        if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
            return false;
        }
        else{
            return $email;
        }
    }    
}