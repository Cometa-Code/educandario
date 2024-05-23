<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Family extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $guard = "families";

    protected $fillable = [
        'active',
        'responsable_name',
        'responsable_document',
        'email',
        'phone',
        'address',
        'zip',
        'city',
        'state',
    ];

    // hidden
    protected $hidden = [
        'remember_token',
    ];

    // scope methods
    public function scopeIsActive($query)
    {
        return $query->where('active', 1);
    }

    public function members()
    {
        return $this->hasMany(FamilyMember::class);
    }

}
