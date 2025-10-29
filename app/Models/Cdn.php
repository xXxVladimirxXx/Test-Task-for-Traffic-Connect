<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\{MorphOne, HasMany};
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Cdn extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'name',
        'provider',
        'api_key'
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
