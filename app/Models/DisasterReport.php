<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DisasterReport extends Model
{
    protected $fillable = [
        'disaster_id',
        'disaster_type',
        'date',
        'location',
        'damage_status'
    ];

    public function disaster()
    {
        if ($this->disaster_type === 'earthquake') {
            return $this->belongsTo(Earthquake::class, 'disaster_id');
        }

        if ($this->disaster_type === 'wind') {
            return $this->belongsTo(Wind::class, 'disaster_id');
        }

        return null;
    }
}

