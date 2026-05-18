<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',

        'first_name',
        'last_name',
        'student_id',
        'contact_number',
        ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function items()
    {
        return $this->hasMany(Item::class);
    }

    // Add this method to check if user is admin
    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    // Add this method to check if user can edit/delete items
    public function canManageItem($item)
    {
        return $this->id === $item->user_id || $this->isAdmin();
    }


}