<?php

namespace App\Models\Catalogo;

use Illuminate\Database\Eloquent\Model;

class Imagen extends Model
{
    //
    protected $table = 'images';

    protected $fillable = [
    	'id', 'nombreArchivo', 'extensionArchivo', 'rutaArchivo', 'tamanioArchivo'
    ];

    protected $hidden = [
    	'created_at', 'updated_at'
    ];
}
