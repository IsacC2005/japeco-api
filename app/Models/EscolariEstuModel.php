<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EscolariEstuModel extends Model
{
    protected $table = 'escolari_estu';
    protected $primaryKey = 'id';

    public function estudiante(): BelongsTo
    {
        // 2. Usamos el método where() para personalizar el JOIN.
        return $this->belongsTo(InscripciModel::class, 'cescolare', 'cescolare');
    }
}
