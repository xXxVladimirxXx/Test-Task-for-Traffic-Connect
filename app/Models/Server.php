<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\{MorphOne, HasMany};
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Server extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'name',
        'ip',
        'port'
    ];

    public function sites(): HasMany
    {
        return $this->hasMany(Site::class);
    }

    public function credential(): MorphOne
    {
        return $this->morphOne(Credential::class, 'credentialable');
    }
}
