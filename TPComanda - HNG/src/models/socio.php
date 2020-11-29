<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Socio extends Model{
    protected $table = "socios";
    protected $primaryKey = "id";
    public $timestamps = false; //Anula los campos created_at y updated_at (columnas)
    //protected $fillable = ['email'];   
}