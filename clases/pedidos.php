<?php
namespace Clases;
class Pedidos{
    public $precio;
    // public $tiempo;
    public $detalle;
    public $codigo;

    public function __construct($detalle,$cantidad){
        
        $this->detalle = $detalle;
        $this->codigo = $this->generarCodigo();
        $this->precio = $this->asignarPrecio($cantidad);
    }

    public function generarCodigo(){
        return substr(md5(time()),0,5);
    }
    
    public function asignarPrecio($cantidad){
        if($cantidad>1){
            $precio = 200*$cantidad;
        }
        else{
            $precio = 250*$cantidad;
        }
        return $precio;
    }

}
?>