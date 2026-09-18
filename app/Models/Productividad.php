<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Productividad extends Model
{
    protected $table = 'productividades';

    protected $primaryKey = 'id_productividad';

    public $timestamps = false;

    protected $fillable = [
        'titulo',
        'fecha_p',
        'id_investigador',
        'descripcion',
        'id_tipo'
    ];

    // La productividad pertenece a un investigador
    public function investigador()
    {
        return $this->belongsTo(
            Investigador::class,
            'id_investigador',
            'id_investigador'
        );
    }

    // La productividad pertenece a un tipo
    public function tipo()
    {
        return $this->belongsTo(
            Tipo::class,
            'id_tipo',
            'id_tipo'
        );
    }
}