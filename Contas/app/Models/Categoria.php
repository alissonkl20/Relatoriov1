<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Categoria extends Model
{
    use HasUuids;

    public $table = 'categorias';

    public $fillable = [
        'nome',
    ];

    public function dashboards(): HasMany
    {
        return $this->hasMany(Dashboard::class, 'categoria_id');
    }
}
