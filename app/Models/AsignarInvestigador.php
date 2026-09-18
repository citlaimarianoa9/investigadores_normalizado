<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AsignarInvestigador extends Model
{
    protected $table = 'asignainvestigadores';

    protected $primaryKey = 'id_asigna';

    public $timestamps = false;

    protected $fillable = [
        'id_productividad',
        'id_investigador'
    ];


    public function productividad()
    {
        return $this->belongsTo(
            Productividad::class,
            'id_productividad',
            'id_productividad'
        );
    }


    public function investigador()
    {
        return $this->belongsTo(
            Investigador::class,
            'id_investigador',
            'id_investigador'
        );
    }
}