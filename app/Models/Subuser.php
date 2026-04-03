<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Subuser extends Authenticatable
{
    use HasFactory;

    protected $fillable = ['name', 'role_id', 'email', 'password', 'status'];
    
    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'password' => 'hashed',
            'status' => 'boolean',
        ];
    }
    
    public function role()
    {
        return $this->belongsTo(Role::class);
    }
}
