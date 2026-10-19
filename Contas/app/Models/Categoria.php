<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Categoria extends Model
{
    use HasUuids;

    protected $table = 'categorias';

    protected $fillable = [
        'nome',
    ];

    protected $keyType = 'string';

    public $incrementing = false;

    public function dashboards(): HasMany
    {
        return $this->hasMany(Dashboard::class, 'categoria_id');
    }
}
