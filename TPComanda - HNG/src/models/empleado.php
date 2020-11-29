<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Empleado extends Model{
    protected $table = "empleados";
    protected $primaryKey = "id";
    public $timestamps = false; //Anula los campos created_at y updated_at (columnas)
    //protected $fillable = ['email'];    
}