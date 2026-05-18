<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;

    const STATUS_LOST = 'lost';
    const STATUS_RECEIVED = 'received';
    const STATUS_CLAIMED = 'claimed';
    const STATUS_STILL_MISSING = 'still missing';

    protected $fillable = [
    'user_id',
    'title',
    'description',
    'category',
    'location',
    'date_found',
    'image',
    'status',

    // NEW (student info)
    'first_name',
    'last_name',
    'student_id',
    'contact_number',

    // optional file
    'attachment',
];

    protected $casts = [
        'date_found' => 'date', 
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getImageUrlAttribute()
    {
        return $this->image ? asset('storage/' . $this->image) : null;
    }

    public function claims()
    {
        return $this->hasMany(\App\Models\Claim::class);
    }


}