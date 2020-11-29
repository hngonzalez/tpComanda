<?php
namespace App\Middlewares;

use Slim\Psr7\Response;
use Clases\Token;

class ClienteMiddleware{
    
    public function __invoke($request, $handler){
        $parsedBody = $request->getParsedBody();
        $token = $request->getHeader('token');

        $response = new Response();
        
        if($token[0] != ""){
            $user = Token::VerificarToken($token[0]);
            if($user->tipo == "cliente" || $user->tipo == "socio"){
                
                $response = $handler->handle($request);
                $existingContent = (string) $response->getBody();
                $resp = new Response();
                $resp->getBody()->write($existingContent);
                return $resp;
            }
            else{
                $rta = array("rta"=> "Error, usted no es cliente para ver esta pagina");
                $response->getBody()->write(json_encode($rta));
                return $response->withStatus(403); //puedo responder un status o lanzar excepcion
            }
        }
        else{
            $rta = array("rta"=> "Token incorrecto.");
            $response->getBody()->write(json_encode($rta));
            return $response->withStatus(403); //puedo responder un status o lanzar excepcion
        }

        $response = $handler->handle($request);
        $existingContent = (string) $response->getBody();
        

        return $response;
    }





}


?>