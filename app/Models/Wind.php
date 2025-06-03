<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Wind extends Model
{
    use HasFactory;

    protected $fillable = ['date', 'location', 'wind_signal'];

    public function disasterReports()
    {
        return $this->hasMany(DisasterReport::class, 'disaster_id')
                    ->where('disaster_type', 'wind');
    }
}

