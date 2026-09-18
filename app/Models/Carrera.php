<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Carrera extends Model
{
    protected $table = 'carreras';

    protected $primaryKey = 'id_carrera';

    public $timestamps = false;

    protected $fillable = [
        'nombre_carrera'
    ];

    public function investigadores()
    {
        return $this->hasMany(
            Investigador::class,
            'id_carrera',
            'id_carrera'
        );
    }
}