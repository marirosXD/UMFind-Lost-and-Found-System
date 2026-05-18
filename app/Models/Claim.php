<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Claim extends Model
{
    protected $fillable = [
        'item_id',
        'claimer_first_name',
        'claimer_last_name',
        'claimer_student_id',
        'claimer_contact',
        'returner_first_name',
        'returner_last_name',
        'returner_student_id',
        'returner_contact',
        'claimed_at',
        'status',
    ];

    protected $casts = [
        'claimed_at' => 'datetime',
    ];

    public function item()
    {
        return $this->belongsTo(Item::class);
    }
}