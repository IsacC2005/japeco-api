<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InscripciModel extends Model
{
    protected $table = 'inscripci';
    protected $primaryKey = 'numero';

    public function escolaridades()
    {
        return $this->hasMany(EscolariEstuModel::class, 'cescolare', 'cescolare');
    }
}
