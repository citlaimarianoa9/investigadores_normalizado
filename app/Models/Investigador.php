<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Investigador extends Model
{
    protected $table = 'investigadores';

    protected $primaryKey = 'id_investigador';

    public $timestamps = false;

    protected $fillable = [
        'nombre',
        'apellido_p',
        'apellido_m',
        'id_carrera'
    ];

    public function carrera()
    {
        return $this->belongsTo(
            Carrera::class,
            'id_carrera',
            'id_carrera'
        );
    }
}