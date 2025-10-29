<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\{MorphOne, BelongsTo};
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Site extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'name',
        'url',
        'server_id',
        'cdn_id'
    ];

    public function server(): BelongsTo
    {
        return $this->belongsTo(Server::class);
    }

    public function cdn(): BelongsTo
    {
        return $this->belongsTo(Cdn::class);
    }

    public function credential(): MorphOne
    {
        return $this->morphOne(Credential::class, 'credentialable');
    }
}
