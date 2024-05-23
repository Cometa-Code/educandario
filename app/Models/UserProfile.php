<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserProfile extends Model
{
    use HasFactory;

    protected $table = 'users_profiles';

    protected $fillable = [
        'user_id',
        'document',
        'birth_date',
        'phone',
        'address',
        'zip',
        'city',
        'state',
        'specialty',
        'avatar',
        'obs',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getFullAddressAttribute()
    {
        return "{$this->address}, {$this->city}, {$this->state}, {$this->country}, {$this->zip}";
    }

    // Scope methods
    public function scopeActive($query)
    {
        return $query->where('active', 1);
    }

}
