<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Dashboard extends Model
{
    use HasUuids;

    public $fillable = [
        'nome',
        'valor',
        'categoria',
        'categoria_id',
    ];

    public function categoriaRelacionada(): BelongsTo
    {
        return $this->belongsTo(Categoria::class, 'categoria_id');
    }
}
