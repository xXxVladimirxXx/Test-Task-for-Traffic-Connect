<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Credential extends Model
{
    protected $fillable = [
        'id',
        'login',
        'password',

        'credentialable_type',
        'credentialable_id'
    ];

    protected $casts = [
        'password' => 'encrypted'
    ];

    protected $hidden = ['password'];

    public function credentialable()
    {
        return $this->morphTo();
    }
}
